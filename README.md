TinyMCE integration for Yii2
============================
Yii2 extension to simplify TinyMCE WYSIWYG editor usage in your application.

Provides:

* widget;
* compressor action;
* integration with file managers like elFinder;
* integration with spelling services like Yandex.
* TinyMCE gone to npm package to always have the latest version;
* Added integration with great [elFinder extension](https://github.com/MihailDev/yii2-elfinder);
* (TODO) Icon to insert many images at once;
* Few bugs resolved. It's all working now.

Fork of [another extension](https://github.com/NecroMan/yii2-tinymce) with some additional features:
* CodeMirror plugin integration for source code mode.

CodeMirror plugin was taken from Christiaan Baartse [repository](https://github.com/christiaan/tinymce-codemirror)

Installation
------------
The preferred way to install this extension is through [composer](https://getcomposer.org/).

Either run

`php composer.phar require --prefer-dist wolfguard/yii2-tinymce-codemirror "*"`

or add

`"wolfguard/yii2-tinymce-codemirror": "*"`

to the require section of your `composer.json` file.

Usage
-----

### Widget basic usage

```php
$form->field($model, 'content')->widget(\wolfguard\tinymce\TinyMce::className())
```

### Scripts compressor

This can be used to optimize widget loading time.

At fist setup controller map:

```php
'controllerMap' => [
    'tinyMce' => [
        'class' => 'wolfguard\tinymce\TinyMceController',
    ]
],
```

Next add route to configured action to widget options:

```php
$form->field($model, 'content')->widget(\wolfguard\tinymce\TinyMce::className(), [
    'compressorRoute' => 'tinyMce/tinyMceCompressor'
])
```

### ElFinder file manager 
Install [mihaildev/yii2-elfinder](https://github.com/MihailDev/yii2-elfinder) extension. You can just include

```php
"mihaildev/yii2-elfinder": "*"
```
to the require section of your `composer.json` file.

Configure elFinder (more info [here](https://github.com/MihailDev/yii2-elfinder)).:

```php
'controllerMap' => [
    'elfinder' => [
        'class' => 'mihaildev\elfinder\Controller',
        'access' => ['@'],
        'disabledCommands' => ['netmount'],
        'roots' => [
            [
                'baseUrl'=>'@web',
                'basePath'=>'@webroot',
                'path' => 'files/global',
                'name' => 'Global'
            ],
        ],
        'watermark' => [
                'source'         => __DIR__.'/logo.png',
                 'marginRight'    => 5,
                 'marginBottom'   => 5,
                 'quality'        => 95,
                 'transparency'   => 70,
                 'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP,
                 'targetMinPixel' => 200
        ]
    ]
],
```

Then select file manager provider in the widget:

```php
$form->field($model, 'content')->widget(\wolfguard\tinymce\TinyMce::className(), [
    'fileManager' => [
        'class' => \wolfguard\tinymce\fm\MihaildevElFinder::className()
    ],
])
```

You can customize some window (width and height) and manager (language, filter, path and multiple) properties. If you want to use different access, watermark and roots setting just prepare controllers:

```php
'controllerMap' => [
    'elf1' => [
        'class' => 'mihaildev\elfinder\Controller',
        'access' => ['@'],
        'roots' => [
            [
                'baseUrl'=>'@web',
                'basePath'=>'@webroot',
                'path' => 'files/global',
                'name' => 'Global'
            ],
        ],
        'watermark' => [
                'source'         => __DIR__.'/logo.png',
                 'marginRight'    => 5,
                 'marginBottom'   => 5,
                 'quality'        => 95,
                 'transparency'   => 70,
                 'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP,
                 'targetMinPixel' => 200
        ]
    ],
    'elf2' => [
        'class' => 'mihaildev\elfinder\Controller',
        'access' => ['*'],
        'roots' => [
            [
                'path' => 'files/some1',
                'name' => ['category' => 'my','message' => 'Some Name']
            ],
            [
                'path'   => 'files/some2',
                'name'   => ['category' => 'my','message' => 'Some Name'],
                'access' => ['read' => '*', 'write' => 'UserFilesAccess']
            ]
        ]
    ]
],
```

and then point to required controller in the widget:

```php
$form->field($model, 'content2')->widget(\wolfguard\tinymce\TinyMce::className(), [
    'fileManager' => [
        'class' => \wolfguard\tinymce\fm\MihaildevElFinder::className(),
        'controller' => 'elf2'
    ]
])
```

### Any file manager

You can write your own file manager provider.
Just inherit it from `\wolfguard\tinymce\fm\FileManager` class and realize `getFileBrowserCallback` and `registerAsset` functions.

### Spellchecker 
TinyMce has bundled plugin for spellchecking but it requires backed to work.

You can use Yandex spellchecker service.

```php
$form->field($model, 'content')->widget(\wolfguard\tinymce\TinyMce::className(), [
    'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell'
])
```

More info about it here: 
[http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml](http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml)

Or you can build own spellcheking service using code provided by moxicode:
[http://www.tinymce.com/download/download.php](http://www.tinymce.com/download/download.php)

### Combined features

```php
<?= $form->field($model, 'content')->widget(\wolfguard\tinymce\TinyMce::className(), [
    'compressorRoute' => 'site/tinyMceCompressor',
    'fileManager' => [
        'class' => \wolfguard\tinymce\fm\MihaildevElFinder::className()
    ],
    'spellcheckerUrl'=>'http://speller.yandex.net/services/tinyspell',
    'options' => ['rows' => 6]
]) ?>
```

CodeMirror configuration
-------------
Additional configuration options

You can modify the behaviour of the codemirror plugin, by adding a codemirror
object to the TinyMCE configuration.

**indentOnInit**: boolean (false) CodeMirror automatically indents code. With
the indentOnInit option, you tell the Source Code editor to indent all code when
the editor opens. This might be slow for large documents.

**path**: string (codemirror) You might already have CodeMirror hosted elsewhere
(outside TinyMCE). In that case, you can reuse that CodeMirror instance, by
overriding the default path. For example:

    path: 'http://www.mysite.com/tools/codemirror-4.8'

**config**: Object CodeMirror configuration object, which is passed on to the
CodeMirror instance. Check http://codemirror.net/doc/manual.html for available
configuration options.

**jsFiles**: Array Array of CodeMirror Javascript files you want to
(additionally) load. For example:

    jsFiles: [
       'mode/clike/clike.js',
       'mode/php/php.js'
    ]

The following Javascript files are always loaded: lib/codemirror.js,
addon/edit/matchbrackets.js, mode/xml/xml.js, mode/javascript/javascript.js,
mode/css/css.js, mode/htmlmixed/htmlmixed.js, addon/dialog/dialog.js,
addon/search/searchcursor.js, addon/search/search.js,
addon/selection/active-line.js.


**cssFiles**: Array Array of CodeMirror CSS files you want to (additionally)
load. For example:

    cssFiles: [
       'theme/neat.css',
       'theme/elegant.css'
    ]

The following CSS files are always loaded: lib/codemirror.css,
addon/dialog/dialog.css.

Config example

```js
tinymce.init({
  selector: '#html',
  plugins: 'codemirror',
  toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code',
  codemirror: {
    indentOnInit: true, // Whether or not to indent code on init.
    path: 'CodeMirror', // Path to CodeMirror distribution
    config: {           // CodeMirror config object
       mode: 'application/x-httpd-php',
       lineNumbers: false
    },
    jsFiles: [          // Additional JS files to load
       'mode/clike/clike.js',
       'mode/php/php.js'
    ]
  }
});
```