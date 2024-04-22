<?php

namespace app\services\Client;

use app\models\Client;
use Yii;
use yii\data\Pagination;


class GetClientsService {
    
    public function execute()
    {        
        $clients = Client::find();
        $count = $clients->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $currentPage = Yii::$app->request->get('page', 1);
        $perPage = Yii::$app->request->get('per_page', 15);
        
        return [
            "data" => $clients->offset($pagination->offset)
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