Yii2 FlowJs Extension
=====================
Easy to use widget and controller for adding HTML5 fully customizable file upload to your app

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist leammas/yii2-flowjs "*"
```

or add

```
"leammas/yii2-flowjs": "*"
```

to the require section of your `composer.json` file.


Usage
-----

### Widget
Add the widget with corresponding settings in your view. For more insight about settings and restrictions @see FlowJsWidget.php.
Don't forget to add `target` setting containing url to FlowJsController Upload action (see below).

```php
<?= \leammas\yii2\flowjs\FlowJsWidget::widget([
    'clientOptions' => ['target' => "'" . Url::to(['/upload']) . "'"],
    'eventHandlers' => [],
    'options' => ['class' => 'btn btn-default', 'id' => 'flow_button'],
    'targetTag' => 'button',
    'targetContent' => 'Upload!'
]); ?>```

### Module
To save files uploaded by the widget, you should register this extension as an application module in your web.php:

```php
'modules' => [
    ...
    'flowjs' => 'leammas\yii2\flowjs\FlowJs'
],
```

After that you may check that the handler runs properly by accessing `http://your.app/flowjs/flow-js/upload` (this url suitable for activated `enablePrettyUrl` and deactivated `showScriptName` options, adjust to your needs). It should return `204 No Content` response.

Also you may specify your own url in UrlManager

```php
'urlManager' => [
    ...
    'rules' => [
        ...
        'upload' => 'flowjs/flow-js/upload'
    ]
],
```

Known issues
------------

1. CSRF validation for upload disabled.
2. You can't pass `attributes` parameter to `assign` methods. @see https://github.com/flowjs/flow.js#methods
3. Passing files with drag-n-drop is not working.