<?php

namespace app\services\ClientAddress;

use app\models\ClientAddress;

class ClientAddressUpdateService {
    
    public function execute($id, $data)
    {
        $clientAddress = ClientAddress::findOne($id);
        $clientAddress->attributes = $data;
        $clientAddress->save();
        
        return $clientAddress;
    }
}