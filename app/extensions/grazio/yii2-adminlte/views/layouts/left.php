<aside class="main-sidebar">
    <section class="sidebar">
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <?= grazio\adminlte\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => Yii::$app->getModule('admin')->getNav()
            ]
        ) ?>
    </section>
</aside>
