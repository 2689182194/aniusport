<?php
/**
 * @copyright Copyright (c) 2015 Yiister
 * @license https://github.com/yiister/yii2-adminlte/blob/master/LICENSE
 * @link http://adminlte.yiister.ru
 */

namespace grazio\adminlte\widgets\grid;

use grazio\adminlte\widgets\Box;
use yii\helpers\Html;

class GridView extends \yii\grid\GridView
{
    /**
     * @inheritdoc
     */
    public $dataColumnClass = 'grazio\adminlte\widgets\grid\DataColumn';

    /**
     * @inheritdoc
     */
    public $tableOptions = ['class' => 'table dataTable'];

    /**
     * @var bool is bordered
     */
    public $bordered = true;

    /**
     * @var bool is condensed
     */
    public $condensed = false;

    /**
     * @var bool is striped
     */
    public $striped = true;

    /**
     * @var bool is row have hover effect
     */
    public $hover = false;

    public $boxOptions = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->bordered) {
            Html::addCssClass($this->tableOptions, 'table-bordered');
        }
        if ($this->condensed) {
            Html::addCssClass($this->tableOptions, 'table-condensed');
        }
        if ($this->striped) {
            Html::addCssClass($this->tableOptions, 'table-striped');
        }
        if ($this->hover) {
            Html::addCssClass($this->tableOptions, 'table-hover');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        // todo confirm adminlte plugin data table
//        GridViewAsset::register($this->getView());

        Box::begin($this->boxOptions);
        parent::run();
        Box::end();
    }

    /**
     * @inheritdoc
     */
    public function renderPager()
    {
        return Html::tag('div', parent::renderPager(), ['class' => 'dataTables_paginate paging_simple_numbers']);
    }
}
