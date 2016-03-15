<?php
namespace wolfguard\tinymce;

class TinyMceLangAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@vendor/wolfguard/yii2-tinymce-codemirror/assets';
    public $depends = [
        'wolfguard\tinymce\TinyMceAsset'
    ];
}
