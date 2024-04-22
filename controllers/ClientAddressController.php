<?php

namespace app\controllers;

use app\models\ClientAddress;
use app\services\ClientAddress\ClientAddressCreateService;
use app\services\ClientAddress\GetClientAddressByIdService;
use app\services\ClientAddress\ClientAddressUpdateService;
use Yii;

class ClientAddressController extends \yii\rest\ActiveController
{
    public $enableCsrfValidation = false;
    public $modelClass = 'app\models\ClientAddress';

    public function behaviors() {
        $behaviors = parent::behaviors();
    
        $behaviors['authenticator'] = [
            'class' => \kaabar\jwt\JwtHttpBearerAuth::class,
        ];
    
        return $behaviors;
    }

    public function actionStore()
    {
        $data = Yii::$app->request->getBodyParams();
        $clientAddress = new ClientAddress();    
        $clientAddress->attributes = $data;

        if ($clientAddress->validate()) {
            $clientAddressCreateService = new ClientAddressCreateService();
            Yii::$app->response->statusCode = 201;
            return $clientAddressCreateService->execute($data);
        } 

        Yii::$app->response->statusCode = 400;
       
        return $clientAddress->getErrors();
    }

    public function actionEdit($id)
    {
        $data = Yii::$app->request->getBodyParams();
        $clientAddress = new ClientAddress();    
        $clientAddress->attributes = $data;

        if ($clientAddress->validate()) {
            $clientAddressUpdateService = new ClientAddressUpdateService();
            return $clientAddressUpdateService->execute($id, $data);
        } 

        Yii::$app->response->statusCode = 400;
       
        return $clientAddress->getErrors();
    }

    public function actionShow($id)
    {
        $clientAddressByIdService = new GetClientAddressByIdService();
        $clientAddress = $clientAddressByIdService->execute($id);
        if($clientAddress) {
            return $clientAddress;
        }

        Yii::$app->response->statusCode = 404;
       
        return [
            "message" => "Endereço não encontrado"
        ];
    }
}
