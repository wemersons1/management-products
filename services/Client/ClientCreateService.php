<?php

namespace app\services\Client;

use app\models\Client;
use yii\helpers\FileHelper;

class ClientCreateService {
    
    public function execute($data)
    {
        $client = new Client();
        $data['image'] = $this->saveImage($data['image']);
        $client->attributes = $data;
        $client->save();
        
        return $client;
    }

    private function saveImage($image)
    {
        $uploadPath = \Yii::getAlias('@webroot/uploads/clients/');

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