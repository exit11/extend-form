<?php

namespace Exit11\ExtendForm;

use Encore\Admin\Extension;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class ExtendForm extends Extension
{
    public $name = 'extend-form';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';
    
    
    public static function attachmentPreview($models, $deleteUrl = null)
    {
        $fileUrl = Storage::disk(config('admin.upload.disk'))->url('/');
        $filePath = Storage::disk(config('admin.upload.disk'))->path('/');
        
        $initialPreview = [];
        $initialPreviewConfig = [];
        foreach($models as $model){
            
            $curentFileUrl = $fileUrl.$model->file_url;
            $curentFilePathInfo = pathinfo($filePath.$model->file_url);
            
            $curentFileExtension = strtolower($curentFilePathInfo['extension']);
            
            $image_extensions = ['jpg', 'png', 'gif', 'jpeg', 'wepp'];
            $pdf_extensions = ['pdf'];
        
            if(in_array($curentFileExtension, $image_extensions)){
                $type = "image";
            }
            else if(in_array($curentFileExtension, $pdf_extensions)){
                $type = "pdf";
            } 
            else {
                $type = "other";
            }
            
            $config = [
                'key' => $model->id,
                'extra' => [
                    '_token' => csrf_token(),
                ],
                'caption' => $model->caption,
                'size' => $model->size,
                'type' => $type,
                'downloadUrl' => $curentFileUrl,
                'url' => $deleteUrl,
            ];
            array_push($initialPreview, $fileUrl.$model->file_url);
            array_push($initialPreviewConfig, $config);
        }
        
        $result = [
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
            //'hideThumbnailContent' => true, //썸네일 감춤여부
        ];
        
        return $result;
    }
    
}