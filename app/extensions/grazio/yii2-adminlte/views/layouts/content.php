<?php
use yii\widgets\Breadcrumbs;
use grazio\adminlte\widgets\Alert;
use yii2tech\admin\widgets\ButtonContextMenu;

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
        Breadcrumbs::widget(
            [
                'homeLink' => ['label' => '统计面板', 'url' => ['/admin']],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?php if (isset($this->params['contextMenuItems'])):
            echo \yii\helpers\Html::beginTag('p');
            echo ButtonContextMenu::widget([
                'items' => isset($this->params['contextMenuItems']) ? $this->params['contextMenuItems'] : []
            ]);
            echo \yii\helpers\Html::endTag('p');
        endif; ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Grazio</b> 1.0
    </div>
    <strong>Copyright &copy; 2011-<?= date('Y') ?> <a href="https://www.miinno.com">Miinno</a>.</strong> All rights
    reserved.
</footer>