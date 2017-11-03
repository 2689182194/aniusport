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

class FileUploadUI extends \dosamigos\fileupload\FileUploadUI
{
    /**
     * @var bool load previously uploaded images or not
     */
    public $loadExistingFiles = false;
    public $gallery = false;

    public function init()
    {
        parent::init();

    }

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
            
                $('#$id').addClass('fileupload-processing');
                $.ajax({
                    url: '{$loadExistingFilesUrl}',
                    dataType: 'json',
                    data:{ids:jQuery('#$inputId').val()},
                    context: $('#$id')[0]
                }).always(function () {
                    $(this).removeClass('fileupload-processing');
                }).done(function (result) {
                    $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});
                });
            ");
        }
    }
}