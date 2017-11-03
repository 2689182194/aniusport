<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2016/11/4
 * Time: 上午1:48
 */

namespace grazio\spotlights\widgets;

use grazio\image\helpers\ImageHelper;
use grazio\spotlights\models\SpotlightsSlice;
use yii\base\Widget;
use yii\bootstrap\Carousel;
use yii\db\Query;
use yii\db\QueryBuilder;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CarouselWidget extends Widget
{
    public $group = 0;
    public $imageOptions;
    public $titleOptions;
    public $descriptionOptions;
    public $configs = [];
    private $items;

    public function init()
    {
        SpotlightsSlice::updateAll([
            'status' => SpotlightsSlice::STATUS_OFFLINE],
            ['AND',
                ['group_id' => $this->group],
                ['status' => SpotlightsSlice::STATUS_POSTED],
                ['<', 'end_at', time()],
                ['!=', 'end_at', 0]
            ]
        );
        $models = SpotlightsSlice::find()
            ->where(['group_id' => $this->group])
            ->andWhere(['status' => SpotlightsSlice::STATUS_POSTED])
            ->orderBy('weight ASC')
            ->all();

        $this->items = ArrayHelper::getColumn($models, function ($element) {
            return [
                'content' => $element->link ? Html::a(Html::img(ImageHelper::src($element->file), $this->imageOptions), $element->link, ['target' => '_blank']) : Html::img(ImageHelper::src($element->file), $this->imageOptions),
                'caption' => Html::tag('h1', $element->title, $this->titleOptions) . Html::tag('p', $element->description, $this->descriptionOptions)
            ];
        });
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        return Carousel::widget(ArrayHelper::merge($this->configs, ['items' => $this->items]));
    }
}