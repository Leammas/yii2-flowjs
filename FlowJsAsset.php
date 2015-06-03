<?php
namespace leammas\yii2\flowjs;

use yii\web\AssetBundle;

/**
 * %ClassDescription%
 *
 * @author Самойлов Владимир <leammas@gmail.com>
 */
class FlowJsAsset extends AssetBundle
{
    public $sourcePath = '@bower/flow-js/dist';
    public $js = [
        'flow.js'
    ];
}
