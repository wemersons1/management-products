<?php

namespace app\services\Product;

use app\models\Product;

class GetProductByIdService {
    
    public function execute($id)
    {           
        return Product::findOne($id);
    }
}