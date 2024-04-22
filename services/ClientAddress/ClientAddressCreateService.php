<?php

namespace app\services\ClientAddress;

use app\models\ClientAddress;

class ClientAddressCreateService {
    
    public function execute($data)
    {
        $clientAddress = new ClientAddress();
        $clientAddress->attributes = $data;
        $clientAddress->save();
        
        return $clientAddress;
    }
}