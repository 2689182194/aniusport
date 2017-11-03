<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace grazio\adminlte\widgets;

use yii\grid\Column;
use yii\helpers\Html;

/**
 * SerialColumn displays a column of row numbers (1-based).
 *
 * To add a SerialColumn to the [[GridView]], add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => 'yii\grid\SerialColumn',
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StatusColumn extends Column
{
    /**
     * @inheritdoc
     */
    public $header = '状态';

    public $attribute;
    public $status;


    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $res = '';

        if (is_array($this->status) && in_array($model->getAttribute($this->attribute), array_keys($this->status))) {
            $data = $this->status[$model->getAttribute($this->attribute)]['name'];
            $class = $this->status[$model->getAttribute($this->attribute)]['htmlClass'];
            $res = Html::tag('span', $data, ['class' => 'label  ' . $class]);
        }
        return $res;


    }
}
