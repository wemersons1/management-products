<?php

namespace app\controllers;

use app\models\Client;
use app\services\Client\ClientCreateService;
use app\services\Client\ClientUpdateService;
use app\services\Client\GetClientByIdService;
use app\services\Client\GetClientsService;
use app\services\ClientAddress\ClientAddressCreateService;
use Yii;

class ClientController extends \yii\rest\ActiveController
{
    public $enableCsrfValidation = false;
    public $modelClass = 'app\models\Client';

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
        $client = new Client();    
        $client->attributes = $data;

        if ($client->validate()) {
            $clientCreateService = new ClientCreateService();
            Yii::$app->response->statusCode = 201;
            return $clientCreateService->execute($data);
        } 

        Yii::$app->response->statusCode = 400;
       
        return $client->getErrors();
    }

    public function actionEdit($id)
    {
        $data = Yii::$app->request->getBodyParams();
        $client = new Client();    
        $client->attributes = $data;

        if ($client->validate()) {
            $clientCreateService = new ClientUpdateService();
            return $clientCreateService->execute($id, $data);
        } 

        Yii::$app->response->statusCode = 400;
       
        return $client->getErrors();
    }

    public function actionShow($id)
    {
        $getClientByIdService = new GetClientByIdService();
        $client = $getClientByIdService->execute($id);
        if($client) {
            return $client;
        }

        Yii::$app->response->statusCode = 404;
       
        return [
            "message" => "Cliente não encontrado"
        ];
    }

    public function actionList()
    {
        $getClientsService = new GetClientsService();

        return $getClientsService->execute();
    }
}
