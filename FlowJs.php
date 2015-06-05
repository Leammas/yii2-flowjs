<?php
namespace leammas\yii2\flowjs;

use Yii;
use yii\base\Module;

/**
 * Main module class
 *
 * @author Самойлов Владимир <leammas@gmail.com>
 */
class FlowJs extends Module
{

    public $controllerNamespace = 'leammas\yii2\flowjs';

    /**
     * Completely uploaded files folder
     * @var string
     */
    public $targetDir = '@runtime/flowjs';

    /**
     * Chunks folder
     * @var string
     */
    public $tempDir = '@runtime/flowjs-temp';

    /**
     * A callable to process the name of the uploaded file . May be used to avoid collisions.
     * @var callable
     */
    public $fileNameHandler;

    /**
     * Pass TRUE in config if you'd like to allow accepting upload requests from another domain.
     * This could be a security issue if enabled!
     * @var bool
     */
    public $allowCrossDomain = false;

    /**
     * With $allowCrossDomain enabled allows client to pass headers listed in this variable.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS#Access-Control-Allow-Headers
     * @var array
     */
    public $allowCORSHeaders = '';

    /**
     * @var string
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS#Access-Control-Allow-Origin
     */
    public $allowCORSOrigin = '*';

    /**
     * Checks whether dir exists if not, tries to create it
     * @param $path
     * @throws \RuntimeException
     * @return void
     */
    protected function checkDir($path)
    {
        if (!is_dir(realpath($path)))
        {
            if (!mkdir($path, 0666))
            {
                throw new \RuntimeException("FlowJs can't create {$path} folder.");
            }
        }
    }

    public function init()
    {
        $this->checkDir(Yii::getAlias($this->tempDir));
        $this->checkDir(Yii::getAlias($this->targetDir));
    }

}
