<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>ITpu3316</p>

                <a href="#"><i class="fa fa-circle text-success"></i>嘻嘻</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="搜索..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [

                    ['label' => '菜单', 'options' => ['class' => 'header']],
                    [
                        'label' => '商品',
                        'icon' => 'shopping-bag',
                        'url' => '#',
                        'items' => [
                            ['label' => '商品列表', 'icon' => 'bars', 'url' => ['/goods/index'],],
                            ['label' => '商品添加', 'icon' => 'cloud-download', 'url' => ['/goods/add'],],

                        ],
                    ],
                    [
                        'label' => '品牌',
                        'icon' => 'shopping-bag',
                        'url' => '#',
                        'items' => [
                            ['label' => '品牌列表', 'icon' => 'bars', 'url' => ['/brand/index'],],
                            ['label' => '品牌添加', 'icon' => 'cloud-download', 'url' => ['/brand/add'],],

                        ],
                    ],
                    [
                        'label' => '分类',
                        'icon' => 'shopping-bag',
                        'url' => '#',
                        'items' => [
                            ['label' => '分类列表', 'icon' => 'bars', 'url' => ['/category/index'],],
                            ['label' => '分类添加', 'icon' => 'cloud-download', 'url' => ['/category/add'],],

                        ],
                    ],
                    [
                        'label' => '文章管理',
                        'icon' => 'shopping-bag',
                        'url' => '#',
                        'items' => [
                            ['label' => '文章列表', 'icon' => 'bars', 'url' => ['/article/index'],],
                            ['label' => '文章添加', 'icon' => 'cloud-download', 'url' => ['/article/add'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
