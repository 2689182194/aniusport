<?php
/**
 * Created by PhpStorm.
 * User: ez
 * Date: 2017/11/15
 * Time: 下午3:32
 */

namespace grazio\adminlte\widgets;

use yii\helpers\Html;
class ActiveField extends \yii\widgets\ActiveField
{

    /**
     * Renders an static tag.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @return $this the field object itself.
     */
    public function text($options = ['class'=>'form-control-static'])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::tag('p',Html::getAttributeValue($this->model, $this->attribute),$options);
        return $this;
    }
}