<?php

namespace frontend\controllers;

use common\models\EnquiryCategory;
use common\models\QuoteHistorySearch;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\TravelQuote;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\ProfileForm;
use common\components\AuthHandler;
use yii\helpers;
use common\components\Helper;
use common\components\QuoteHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
/*            'auth' => [
                'class' => 'common\components\SocialAuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],*/
        ];
    }

/*    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }*/

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return self::actionCategories(EnquiryCategory::find()->roots()->all());
    }


    public function actionCategories(array $categories, $category = null, $is_top_level = false)
    {
        return $this->render('categories',
            [
                'showBreadcrumbs' => !$is_top_level,
                'category' => $category,
                'categories' => $categories
            ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionAjaxLogin() {
        if (Yii::$app->request->isAjax) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->login()) {
                    return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
//                    return $this->goBack();
                } else {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return \yii\widgets\ActiveForm::validate($model);
                }
            }
        }

        throw new BadRequestHttpException('The page does not exists');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionAjaxsignup() {
        if (Yii::$app->request->isAjax) {
            $model = new SignupForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($user = $model->signup()) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
//                        return $this->goBack();
                    }
                } else {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return \yii\widgets\ActiveForm::validate($model);
                }
            }
        }

        throw new BadRequestHttpException('The page does not exists');
    }

    /**
     * Validate user profile
     *
     * @return mixed
     */
    public function actionValidateProfile() {
        $request = \Yii::$app->getRequest();
        if ($request->isAjax) {
            $model = new ProfileForm();
            if ($request->isPost && $model->load($request->post())) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return \yii\widgets\ActiveForm::validate($model);
            }
        }

        throw new BadRequestHttpException('The page does not exists');
    }

    /**
     * Save user profile
     *
     * @return mixed
     */
    public function actionSaveProfile() {
        $request = \Yii::$app->getRequest();
        $model = new ProfileForm();
        if ($request->isPost && $model->load($request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => $model->saveProfile(),
                'message' => 'Your profile was successfully stored'
            ];
        }

        return [
            'success' => false
        ];
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['supportEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Display history page for a user with all the quotes sent and showing what rating was set to each  retailer on each quote
     *
     * @return mixed
     */
    public function actionHistoryQuotes()
    {
        $searchModel = new QuoteHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('historyQuotes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRateRetailers($category_alias, $quote_id)
    {
        // need to login if not authorized
        if(Yii::$app->user->isGuest) {
            return $this->render('rateRetailers', ['ratedStatus' => QuoteHelper::QUOTE_NOT_RATED]);
        }

        if(($enquiryCategory = EnquiryCategory::findOne([
                'alias' => $category_alias,
                'is_visible' => 1,
                'is_active' => 1,
                ])) == NULL){
            throw new \yii\web\NotFoundHttpException(404);
        }
        // detect class of enquiry
        if(empty($enquiryCategory->enquiry_class_name)){
            throw new \yii\web\NotFoundHttpException(404);
        }

        //find enquiry by user and its ID
        //detect class of enquiry and find it
        $enquiryClass = 'common\models\\' . $enquiryCategory->enquiry_class_name;
        $enquiry = $enquiryClass::findOne(['id' => $quote_id, 'user_id' => Yii::$app->user->id]);
        if($enquiry == null){
            throw new \yii\web\NotFoundHttpException(404);
        }

        //if quote already rated
        if($enquiry->is_rated == QuoteHelper::QUOTE_RATED){
            Yii::$app->session->setFlash('info', 'Retailer(s) rating has been set for this quote');
        }

        // save retailers rating
        if(QuoteHelper::rateRetailersForEnquiry($enquiry, Yii::$app->request->post('rate_retailer'))){
            $enquiry->refresh();
        }

        return $this->render('rateRetailers', [
            'categoryName' => $enquiry->enquiryCategory->name,
            'ratedStatus' => $enquiry->is_rated,
            'model' => $enquiry
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays Privacy policy page.
     *
     * @return mixed
     */
    public function actionPrivacyPolicy()
    {
        $this->layout = 'static';

        return $this->render('privacyPolicy');
    }

    /**
     * Displays Cookie Policy page.
     *
     * @return mixed
     */
    public function actionCookiePolicy()
    {
        $this->layout = 'static';

        return $this->render('cookiePolicy');
    }

    /**
     * Displays Terms of use page.
     *
     * @return mixed
     */
    public function actionTermsOfUse()
    {
        $this->layout = 'static';

        return $this->render('termsOfUse');
    }

    /**
     * Displays request page.
     *
     * @return mixed
     */
/*    public function actionRequestResult()
    {
        return $this->render('requestResult');
    }*/

    public function actionValidatePasswordResetForm() {
        $request = \Yii::$app->getRequest();
        if ($request->isAjax) {
            $model = new PasswordResetRequestForm();
            if ($request->isPost && $model->load($request->post())) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
        }

        throw new BadRequestHttpException('The page does not exists');
    }

    public function actionAjaxRequestPasswordReset()
    {
        $request = \Yii::$app->getRequest();
        $model = new PasswordResetRequestForm();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($request->isPost && $model->load($request->post())) {
            if ($model->sendEmail()) {
                return [
                    'success' => true,
                    'message' => 'Check your email for further instructions'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Sorry, we are unable to reset password for the provided email address'
                ];
            }
        }

        return [
            'success' => false
        ];
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'static';

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
