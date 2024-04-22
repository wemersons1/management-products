<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CreateUserController extends Controller
{

    public $login, $password, $name;

    public function options($actionID)
    {
        return ['login', 'password', 'name'];
    }
    
    public function optionAliases()
    {
        return [
            'l' => 'login',
            's' => 'password',
            'n' => 'name'
        ];
    }

    
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $user = new User();
        $user->name = $this->name;
        $user->login = $this->login;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);

        if(!$user->validate()) {
            $errors = $user->getErrors();
    
            $this->stdout($this->getFirstError($errors)."\n", Console::BG_RED); 
            return ExitCode::UNSPECIFIED_ERROR;
        } 

        try {
            $user->save();
        }catch(\Exception $e) {
            $this->stdout($e->getMessage(), Console::BG_RED);
            return ExitCode::OK;
        }
        
        $this->stdout("Usuário cadastrado com sucesso\n", Console::BG_GREEN);
        return ExitCode::OK;
    }

    private function getFirstError($errors)
    {
        foreach($errors as $error) {
            return $error[0];
        }

        return "";
    }
}
