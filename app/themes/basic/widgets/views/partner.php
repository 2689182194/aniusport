<?php

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/5/19
 * Time: 15:00
 */
?>

<div class="footer-friendlink">
<?php foreach ($partner as $k => $v) : ?>
    <div class="col-md-2">
        <ul>
            <li><a href="<?= Html::encode($v->partner_url) ?>"
                   class="text-blue-light"><?= Html::encode($v->partner_name) ?></a></li>
        </ul>
    </div>
<?php endforeach; ?>
</div>

