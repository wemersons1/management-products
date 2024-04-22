<?php

namespace app\services\Product;

use app\models\Product;
use yii\helpers\FileHelper;

class ProductUpdateService {
    
    public function execute($id, $data)
    {
        $product = Product::findOne($id);
        $data['image'] = $this->saveImage($data['image']);

        if (file_exists($product->image)) {
            unlink($product->image);
        }
      
        $product->attributes = $data;
        $product->save();
        
        return $product;
    }

    private function saveImage($image)
    {
        $uploadPath = \Yii::getAlias('@webroot/uploads/products/');
        // Verifica se o diretório existe, senão cria
        if (!is_dir($uploadPath)) {
            FileHelper::createDirectory($uploadPath);
        }

        $dataImage = $this->getCodeImage($image);

        $fileName = uniqid() . '.' . $dataImage['extension']; // Generate a unique filename
        $savePath = $uploadPath . $fileName; // Replace with your desired save path

        if (file_put_contents($savePath, $dataImage['code'])) {
            return $savePath;
        } 

        return '';
    }

    private function getCodeImage($base64_image)
    {
        [$type, $data] = explode(';', $base64_image);
        [, $data] = explode(',', $data);
        [, $extension] = explode('/', $type);

        return [
            "code" => base64_decode($data),
            "extension" => $extension
        ];
    }
}