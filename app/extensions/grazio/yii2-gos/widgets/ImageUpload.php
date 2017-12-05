<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/24
 * Time: 下午11:18
 */

namespace grazio\gos\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use ReflectionClass;
use yii\helpers\Json;
use yii\helpers\Url;
use \dosamigos\fileupload\FileUploadAsset;
use \dosamigos\fileupload\FileUploadPlusAsset;

class ImageUpload extends \dosamigos\fileupload\BaseUpload
{
    /**
     * @var bool whether to register the js files for the basic +
     */
    public $plus = false;

    /**
     * @var bool whether to render the default button
     */
    public $useDefaultButton = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $url = Url::to($this->url);
        $this->options['data-url'] = $url;
    }

    public function getViewPath()
    {
        $class = new ReflectionClass(\dosamigos\fileupload\FileUpload::className());
        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views';
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $input = $this->hasModel()
            ? Html::activeFileInput($this->model, $this->attribute, $this->options)
            : Html::fileInput($this->name, $this->value, $this->options);

        echo $this->useDefaultButton
            ? $this->render('uploadButton', ['input' => $input])
            : $input;

        echo Html::tag('div', '', ['id' => $this->options['id'], 'class' => $this->options['id']]);

        $this->registerClientScript();
    }

    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        $view = $this->getView();

        if ($this->plus) {
            FileUploadPlusAsset::register($view);
        } else {
            FileUploadAsset::register($view);
        }

        $options = Json::encode($this->clientOptions);
        $id = $this->options['id'];

        $js[] = ";jQuery('#$id').fileupload($options);";
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
        }
        $view->registerJs(implode("\n", $js));
    }
    /*
        public function run()
        {
            parent::run();
            $options = $this->options;
            unset($options['id']);
            $input = $this->hasModel()
                ? Html::activeHiddenInput($this->model, $this->attribute, $options)
                : Html::hiddenInput($this->name, $this->value, $options);

            echo $input;
            $this->registerScript();
        }

        public function getViewPath()
        {
            $class = new ReflectionClass(\dosamigos\fileupload\FileUploadUI::className());
            return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views';
        }

        public function registerScript()
        {

            $view = $this->getView();
            $options = Json::encode($this->clientOptions);
            $id = $this->options['id'];
            $inputId = Html::getInputId($this->model, $this->attribute);

            $clientEvents = [
                'fileuploaddone' => "function (e, data) {

                    var uploadFieldData = jQuery('#$inputId').val();

                    if (uploadFieldData !== ''){
                        uploadFieldDataArray = uploadFieldData.split(',');
                    }else{
                        uploadFieldDataArray = [];
                    }

                    $.each(data.result.files, function (index, file) {
                        uploadFieldDataArray.push(file.id);
                    });

                    jQuery('#$inputId').val(uploadFieldDataArray.join(','));

                }"
            ];

            $js[] = ";jQuery('#$id').fileupload($options);";
            if (!empty($clientEvents)) {
                foreach ($clientEvents as $event => $handler) {
                    $js[] = "jQuery('#$id').on('$event', $handler);";
                }
            }
            $view->registerJs(implode("\n", $js));

            if ($this->loadExistingFiles) {
                $loadExistingFilesUrl = Url::to($this->loadExistingFiles);
                $view->registerJs("
                    var gosFileIds = jQuery('#$inputId').val();
                    $('#$id').addClass('fileupload-processing');
                    if (gosFileIds !== ''){
                        $.ajax({
                            url: '{$loadExistingFilesUrl}',
                            dataType: 'json',
                            data:{ids:gosFileIds},
                            context: $('#$id')[0]
                        }).always(function () {
                            $(this).removeClass('fileupload-processing');
                        }).done(function (result) {
                            $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});
                        });
                    };
                ");
            }
        }*/
}