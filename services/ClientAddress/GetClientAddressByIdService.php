<?php

namespace app\services\ClientAddress;

use app\models\ClientAddress;

class GetClientAddressByIdService {
    
    public function execute($id)
    {
        return ClientAddress::findOne($id);
    }
}