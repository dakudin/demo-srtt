<?php
/**
 * Created by Kudin Dmitry
 * Date: 10.09.2018
 * Time: 9:33
 */

use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;

Modal::begin([
    'id'=>'login-modal',
    'closeButton' => false,
//    'footer' => $this->render('_agreement')
]);
?>

<?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Sign in',
                'content' => $this->render('_signin', ['model' => $signInModel]),
                'options' => ['id' => 'tab_signin'],
            ],
            [
                'label' => 'Register',
                'content' => $this->render('_signup', ['model' => $signUpModel]),
                'options' => ['id' => 'tab_register'],
            ],
        ]
    ])
?>


<?php Modal::end(); ?>