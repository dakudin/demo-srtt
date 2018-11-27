<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'body' => 'Your message',
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'contactUs-html', 'text' => 'contactUs-text'],
                [
                    'user' => $this->name,
                    'subject' => $this->subject,
                    'email' => $this->email,
                    'body' => $this->body,
                ]
            )
            ->setFrom([Yii::$app->params['dummySupportEmail'] => Yii::$app->name])
            ->setTo($email)
            ->setSubject("Sent from 'Contact Us' form by " . $this->name . ' <' . $this->email .'>')
            ->send();
    }
}
