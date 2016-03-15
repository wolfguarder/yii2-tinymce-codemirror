<?php
namespace wolfguard\tinymce;

use yii\web\Controller;

class TinyMceController extends Controller
{

    public function actions()
    {
        return [
            'tinyMceCompressor' => [
                'class' => TinyMceCompressorAction::className()
            ]
        ];
    }
}