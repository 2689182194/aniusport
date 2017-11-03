<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2016/11/20
 * Time: 上午1:35
 */

namespace grazio\image\helpers;

use grazio\image\models\ImageModel;
use Yii;

class ImageHelper
{
	public static function src($hash)
	{
		if (empty($hash)) {
			return;
		}

		$model = ImageModel::findOne($hash);

		if(empty($model)){
			return ;
		}

		$imageUrl = Yii::getAlias('@uploadsUrl/' . $model->local_path);

		if (isset(Yii::$app->params['storage']) && Yii::$app->params['storage'] == 'qiniu') {
			// todo remove start
			/* $filePath = Yii::getAlias('@uploadsPath/' . $model->local_path);

			 if (empty($model->upload_code) && file_exists($filePath) ) {
				 $qiniuImage = Yii::$app->getModule('image')->qiniu->uploadFile($filePath);
				 $model->url = Yii::$app->getModule('image')->qiniu->getLink($qiniuImage['key']);
				 $model->upload_code = $qiniuImage['key'];
				 $model->save();
			 }*/
			// todo remove end

			$imageUrl = !empty($model->url) ? $model->url : $imageUrl;
		}

		return $imageUrl;
	}
}