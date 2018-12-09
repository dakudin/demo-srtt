<?php
/**
 * Created by Kudin Dmitry.
 * Date: 06.09.2018
 * Time: 14:36
 */

namespace common\components;

use common\models\Auth;
use common\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        Yii::error($attributes);

        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $username = ArrayHelper::getValue($attributes, 'name');

        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();

        if ($auth) { // login
            /* @var User $user */
            $user = $auth->user;
            if($this->updateUserInfo($user)) {
                Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
            }else{
                Yii::$app->getSession()->setFlash('error',
                    Yii::t('app', 'Unable to log in the user')
                );
            }
        } else { // signup
            // if user login by Facebook and account with same email already exists than link it with Facebook account
            if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                $user = User::find()->where(['email' => $email])->one();
                $user->status = User::STATUS_ACTIVE;
            } else {
                $password = Yii::$app->security->generateRandomString(12);
                $user = new User([
                    'username' => $username,
                    'email' => $email,
                    'status' => User::STATUS_ACTIVE,
                    'password' => $password,
                ]);
                $user->generateAuthKey();
                $user->generatePasswordResetToken();
            }

            $transaction = User::getDb()->beginTransaction();

            if ($user->save()) {
                $auth = new Auth([
                    'user_id' => $user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string)$id,
                ]);
                if ($auth->save()) {
                    $transaction->commit();
                    Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                } else {
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('error',
                        Yii::t('app', 'Unable to save {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ])
                    );
                }
            } else {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('error',
                    Yii::t('app', 'Unable to save user: {errors}', [
                        'client' => $this->client->getTitle(),
                        'errors' => json_encode($user->getErrors()),
                    ])
                );
            }
        }
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        return $user->status !== User::STATUS_DELETED;
    }

}