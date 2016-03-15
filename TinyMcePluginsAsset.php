<?php
namespace wolfguard\tinymce;

class TinyMcePluginsAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@vendor/wolfguard/yii2-tinymce-codemirror/plugins';
    public $js = [
        'codemirror/plugin.js',
    ];
    public $depends = [
        'wolfguard\tinymce\TinyMceAsset'
    ];
}