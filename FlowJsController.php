<?php
namespace leammas\yii2\flowjs;

use yii\web\Controller;
use Flow\Uploader;
use Yii;
use Flow\Config;
use Flow\File;
use yii\web\Response;

/**
 * Controller handling file upload operation
 *
 * @author Самойлов Владимир <leammas@gmail.com>
 */
class FlowJsController extends Controller
{

    protected $target;

    protected $temp;

    protected $flowParams;

    protected function getFlowParams()
    {
        if ($this->flowParams === null)
        {
            $request = Yii::$app->request;
            $this->flowParams = [
                'flowChunkNumber' => null,
                'flowChunkSize' => null,
                'flowCurrentChunkSize' => null,
                'flowTotalSize' => null,
                'flowIdentifier' => null,
                'flowFilename' => null,
                'flowRelativePath' => null,
                'flowTotalChunks' => null,
            ];

            foreach ($this->flowParams as $param => &$value)
            {
                $value = $request->getBodyParam($param);
            }
        }

        return $this->flowParams;
    }

    public function init()
    {
        $this->target = Yii::getAlias($this->module->targetDir);
        $this->temp = Yii::getAlias($this->module->tempDir);
        $this->enableCsrfValidation = false;
    }

    public function actionUpload()
    {
        /**
         * Removing old chunks
         */
        if (1 == mt_rand(1, 100)) {
            Uploader::pruneChunks($this->temp);
        }

        $response = Yii::$app->response;
        $request = Yii::$app->request;
        $response->format = Response::FORMAT_RAW;

        if ($this->module->allowCrossDomain)
        {
            $response->headers->add('Access-Control-Allow-Origin', $this->module->allowCORSOrigin);
            $response->headers->add('Access-Control-Allow-Methods', 'GET,HEAD,POST,OPTIONS,TRACE');
            $response->headers->add('Access-Control-Allow-Headers', $this->module->allowCORSHeaders);
        }
        if ($request->isOptions)
        {
            $response->headers->add('Allow', 'GET,HEAD,POST,OPTIONS,TRACE');
            return;
        }
        $config = new Config();
        $config->setTempDir($this->temp);
        $file = new File($config);
        $filename = $this->getFlowParams()['flowFilename'];
        if (is_callable($this->module->fileNameHandler))
        {
            $filename = call_user_func_array($this->module->fileNameHandler, [$filename]);
        }

        if ($request->isGet) {
            if ($file->checkChunk()) {
                $response->statusCode = 200;
            } else {
                $response->statusCode = 204;
                return;
            }
        } else {
            if ($file->validateChunk()) {
                $file->saveChunk();
            } else {
                // error, invalid chunk upload request, retry
                $response->statusCode = 400;
                return;
            }
        }
        if ($file->validateFile() && $file->save($this->target . "/{$filename}")) {
            // File upload was completed
        } else {
            // This is not a final chunk, continue to upload
        }
    }

}
