<?php

namespace app\services\Client;

use app\models\Client;

class GetClientByIdService {
    
    public function execute($id)
    {           
        return Client::findOne($id);
    }
}