<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/5/19
 * Time: 上午12:34
 */

namespace grazio\seo\widgets;


use dosamigos\selectize\SelectizeTextInput;
use grazio\adminlte\widgets\Box;
use grazio\seo\models\SeoMetaModel;
use yii\base\Widget;

class SeoInputGroup extends Widget
{
    public $form;
    public $model;

    public function run()
    {
        parent::run();
        $form = $this->form;
        $model = $this->model;
        $robotsAccess =  (new SeoMetaModel())->getRobotAccess();
        $field[] = $form->field($model, 'seoTitle')->textInput(['maxlength' => true])->label('SEO 标题');
        $field[] = $form->field($model, 'seoKeywords')->widget(SelectizeTextInput::className([]), [
            'clientOptions' => [
                'create' => 'function(input){
                    return {
                        value: input,
                        text: input
                    }
            }'
            ]
        ])->label('SEO 关键词');
        $field[] = $form->field($model, 'seoDescription')->textarea(['rows' => 6])->label('SEO 页面描述');
        $field[] = $form->field($model, 'seoRobots')->dropDownList($robotsAccess, ['prompt' => '默认'])->label('蜘蛛授权');
        $config = [
            'header' => "SEO 设置",
            'expandable' => true,
            'filled' => true
        ];
        if (!empty($model->seoTitle) || !empty($model->seoKeywords) || !empty($model->seoDescription) || !empty($model->seoRobots)) {
            $config = array_merge($config, ['type' => Box::TYPE_WARNING]);
        }
        Box::begin($config);
        echo implode("\n", $field);
        Box::end();
    }

}