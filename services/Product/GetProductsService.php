<?php

namespace app\services\Product;

use app\models\Product;
use Yii;
use yii\data\Pagination;


class GetProductsService {
    
    public function execute()
    {        
        $products = Product::find();

        $request = Yii::$app->request;
        $clientId = $request->get('client_id');

        if($clientId) {
            $products = $products->where(['client_id' => $clientId]);
        }

        $count = $products->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $currentPage = Yii::$app->request->get('page', 1);
        $perPage = Yii::$app->request->get('per_page', 15);
        
        return [
            "data" => $products->offset($pagination->offset)
                ->limit($perPage)
                ->all(),
            "total" => $count,
            "previous_page" => (int)$currentPage > 1 ? (int)$currentPage - 1 : 1,
            "current_page" => (int)$currentPage,
            "next_page" => (int)$currentPage + 1,
            "per_page" => $perPage,
        ];
    }
}