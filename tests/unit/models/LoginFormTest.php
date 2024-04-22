<?php

namespace tests\unit\models;

use app\models\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {

    }

    public function testLoginWrongPassword()
    {
     
    }

    public function testLoginCorrect()
    {
       
    }

}
