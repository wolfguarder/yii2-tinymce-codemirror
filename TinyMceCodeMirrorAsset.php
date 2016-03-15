<?php
namespace wolfguard\tinymce;

class TinyMceCodeMirrorAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower/codemirror';
    public $depends = [
        'wolfguard\tinymce\TinyMceAsset'
    ];
}