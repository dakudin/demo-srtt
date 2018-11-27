<?php
/**
 * Created by Kudin Dmitry
 * Date: 24.10.2018
 * Time: 14:59
 */

namespace api\models;
use common\models\UserToken;
use common\models\User;
use yii\base\Model;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    /**
     * @return UserToken|null
     */
    public function auth()
    {
        if ($this->validate()) {
            $token = new UserToken();
            $token->user_id = $this->getUser()->id;
            $token->token_type = 'bearer';
            $token->generateToken(time() + 3600 * 24);
            return $token->save() ? $token : null;
        } else {
            return null;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}