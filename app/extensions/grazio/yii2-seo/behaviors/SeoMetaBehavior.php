<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/5/19
 * Time: 上午3:26
 */

namespace grazio\seo\behaviors;


use grazio\seo\models\SeoMetaModel;
use yii\base\Behavior;
use yii\base\ErrorException;
use yii\db\BaseActiveRecord;

class SeoMetaBehavior extends Behavior
{
    public $seoRoute = '';
    public $seoTitle = '';
    public $seoKeywords = '';
    public $seoDescription = '';
    public $seoRobots = '';
    private $_seoMetaModel = '';

    /**
     * Creates string representation of owner model primary key value,
     * handles case when primary key is complex and consist of several fields.
     * @return string representation of owner model primary key value.
     */
    protected function getPrimaryKeyStringValue()
    {
        $owner = $this->owner;
        $primaryKey = $owner->getPrimaryKey();
        if (is_array($primaryKey)) {
            return implode('_', $primaryKey);
        }

        return $primaryKey;
    }

    /**
     * 获取当前seo所对应的model类
     * @return mixed
     */
    protected function getOwnerClassName()
    {
        return call_user_func([$this->owner, 'className']);
    }

    /**
     * 获取_seoMetaModel的值
     * @return string
     */
    public function getSeoMetaModel()
    {
        if ($this->_seoMetaModel == '' && $this->_seoMetaModel !== null) {
            $this->setSeoMetaModel();
        }

        return $this->_seoMetaModel;
    }

    /**
     * 给当前_seoMetaModel 赋值
     */
    public function setSeoMetaModel()
    {
        $this->_seoMetaModel = SeoMetaModel::find()
            ->where(['entity' => $this->getPrimaryKeyStringValue()])
            ->andWhere(['model' => $this->getOwnerClassName()])
            ->andWhere(['route' => $this->seoRoute])
            ->one();
    }

    /**
     * Declares events and the corresponding event handler methods.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function afterFind()
    {
        if (($seoMetaModel = $this->getSeoMetaModel()) !== null) {
            $this->seoTitle = $seoMetaModel->title;
            $this->seoKeywords = $seoMetaModel->keywords;
            $this->seoDescription = $seoMetaModel->description;
            $this->seoRobots = $seoMetaModel->robots;
        }
    }

    public function afterSave()
    {
        $model = $this->owner;
        if ($model->getIsNewRecord() || ($seoMetaModel = $this->getSeoMetaModel()) === null) {
            $seoMetaModel = new SeoMetaModel();
        }
        $seoMetaModel->route = $model->seoRoute;
        $seoMetaModel->entity = $this->getPrimaryKeyStringValue();
        $seoMetaModel->model = $this->getOwnerClassName();
        $seoMetaModel->seoTitle = $this->seoTitle;
        $seoMetaModel->seoKeywords = $this->seoKeywords;
        $seoMetaModel->seoDescription = $this->seoDescription;
        $seoMetaModel->seoRobots = $this->seoRobots;

        if ($seoMetaModel->save(false) === false) {
            \Yii::error($seoMetaModel->errors);
            throw new ErrorException('保存失败');
        }
    }

    public function afterDelete()
    {
        if (($seoMetaModel = $this->getSeoMetaModel()) !== null) {
            $seoMetaModel->delete(); //todo  确认是否与softDelete冲突
        }
    }
}