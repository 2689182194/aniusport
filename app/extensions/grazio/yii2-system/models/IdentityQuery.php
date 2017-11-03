<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace grazio\system\models;

/**
 * This is the ActiveQuery class for [[Identity]].
 *
 * @see Identity
 */
class IdentityQuery extends \yii\db\ActiveQuery
{
    /**
     * Filters only active records.
     * @return $this self reference.
     */
    public function whereActive()
    {
        $this->andWhere(['status_id' => Identity::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * Filters only not deleted records.
     * @return $this self reference.
     */
    public function whereNotDeleted()
    {
        $this->andWhere(['not', ['status_id' => Identity::STATUS_DELETED]]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return Identity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Identity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}