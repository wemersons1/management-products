<?php

namespace app\controllers;

use app\services\City\GetCitiesService;

class CityControllerController extends \yii\rest\ActiveController
{
    public $enableCsrfValidation = false;
    public $modelClass = 'app\models\City';

    public function behaviors() {
        $behaviors = parent::behaviors();
    
        $behaviors['authenticator'] = [
            'class' => \kaabar\jwt\JwtHttpBearerAuth::class,
        ];
    
        return $behaviors;
    }
    
    public function actionList()
    {
        $getCitiesService = new GetCitiesService();
        return $getCitiesService->execute();
    }

}
