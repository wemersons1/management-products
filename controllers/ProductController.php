<?php

namespace app\controllers;

use app\models\Product;
use app\services\Product\GetProductByIdService;
use app\services\Product\GetProductsService;
use app\services\Product\ProductCreateService;
use app\services\Product\ProductUpdateService;
use Yii;

class ProductController extends \yii\rest\ActiveController
{
    public $enableCsrfValidation = false;
    public $modelClass = 'app\models\Product';

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
        $product = new Product();    
        $product->attributes = $data;

        if ($product->validate()) {
            $productCreateService = new ProductCreateService();
            Yii::$app->response->statusCode = 201;
            return $productCreateService->execute($data);
        } 

        Yii::$app->response->statusCode = 400;
       
        return $product->getErrors();
    }

    public function actionEdit($id)
    {
        $data = Yii::$app->request->getBodyParams();
        $product = new Product();    
        $product->attributes = $data;

        if ($product->validate()) {
            $productUpdateService = new ProductUpdateService();
            return $productUpdateService->execute($id, $data);
        } 

        Yii::$app->response->statusCode = 400;
       
        return $product->getErrors();
    }

    public function actionShow($id)
    {
        $getProductByIdService = new GetProductByIdService();
        $product = $getProductByIdService->execute($id);
        if($product) {
            return $product;
        }

        Yii::$app->response->statusCode = 404;
       
        return [
            "message" => "Produto não encontrado"
        ];
    }

    public function actionList()
    {
        $getProductsService = new GetProductsService();

        return $getProductsService->execute();
    }
}
