<?php

namespace app\services\City;

use app\models\City;
use app\models\Client;
use Yii;
use yii\data\Pagination;


class GetCitiesService {
    
    public function execute()
    {        
        $request = Yii::$app->request;
        $stateId = $request->get('state_id');

        $cities = City::find();

        if($stateId) {
            $cities = $cities->where(['estado_id' => $stateId]);    
        }

        return $cities->orderBy('nome')
                        ->all();
    }
}