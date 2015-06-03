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
Add the widget with corresponding settings in your view. For more insight about settings and restrictions @see FlowJs.php

```php
<?= \leammas\yii2\flowjs\FlowJs::widget([
    'clientOptions' => [],
    'eventHandlers' => [],
    'options' => ['class' => 'btn btn-default', 'id' => 'flow_button'],
    'targetTag' => 'button',
    'targetContent' => 'Upload!'
]); ?>```