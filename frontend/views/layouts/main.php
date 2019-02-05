<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use common\models\Category;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title . ' - ' . Yii::$app->params['domain']) ?></title>
    <?php $this->registerLinkTag(['rel' => 'shortcut icon', 'href' => '/img/favicon.ico']); ?>
    <?php $this->registerLinkTag(['rel' => 'apple-touch-icon', 'href' => '/img/apple-touch-icon.png']); ?>
    <?php $this->registerLinkTag(['rel' => 'apple-touch-icon', 'href' => '/img/apple-touch-icon-72x72.png', 'sizes' => '72x72']); ?>
    <?php $this->registerLinkTag(['rel' => 'apple-touch-icon', 'href' => '/img/apple-touch-icon-114x114.png', 'sizes' => '114x114']); ?>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <!-- Preloader -->
    <div class="loader-mask">
        <div class="loader">
            <div></div>
            <div></div>
        </div>
    </div>

    <main class="content-wrapper oh">

        <!-- Navigation -->
        <header class="nav-type-1">
            <div class="top-bar hidden-sm hidden-xs">
                <div class="container">
                    <div class="top-bar-line">
                        <div class="row">
                            <div class="top-bar-links">
                                <ul class="col-sm-6 top-bar-acc">
                                    <li class="top-bar-link"><a href="<?= Yii::$app->homeUrl ?>">Главная</a></li>
                                    <li class="top-bar-link"><a href="/contact">Контакты</a></li>
                                    <li class="top-bar-link"><a href="#">Новости</a></li>
                                </ul>

                                <ul class="col-sm-6 text-right top-bar-currency-language">
                                    <li>
                                        <div class="social-icons">
                                            <a href="<?=Yii::$app->params['linkInstagram']?>"><i class="fa fa-instagram"></i></a>
                                            <a href="<?=Yii::$app->params['linkVk']?>"><i class="fa fa-vk"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end top bar -->

            <nav class="navbar navbar-static-top">
                <div class="navigation" id="sticky-nav">
                    <div class="container relative">
                        <div class="row">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <!-- Mobile cart -->
                                <div class="nav-cart mobile-cart hidden-lg hidden-md">
                                    <div class="nav-cart-outer">
                                        <div class="nav-cart-inner">
                                            <?php
                                            $cart = Yii::$app->cart;
                                            $itemsInCart = $cart->getCount();
                                            ?>
                                            <a href="/cart" class="nav-cart-icon"><?=$itemsInCart ? " $itemsInCart" : ''?></a>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end navbar-header -->

                            <div class="header-wrap">
                                <div class="header-wrap-holder">

                                    <!-- Search -->
                                    <div class="nav-search hidden-sm hidden-xs">
                                        <form method="get">
                                            <input type="search" class="form-control" placeholder="Поиск">
                                            <button type="submit" class="search-button">
                                                <i class="icon icon_search"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Logo -->
                                    <div class="logo-container">
                                        <div class="logo-wrap text-center">
                                            <a href="<?= Yii::$app->homeUrl ?>">
                                                <img class="logo" src="/img/logo.png" alt="logo">
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Cart -->
                                    <div class="nav-cart-wrap hidden-sm hidden-xs">
                                        <div class="nav-cart right">
                                            <div class="nav-cart-outer">
                                                <div class="nav-cart-inner">
                                                    <a href="/cart" class="nav-cart-icon"><?=$itemsInCart ? " $itemsInCart" : ''?></a>
                                                </div>
                                            </div>
                                            <div class="nav-cart-container">
                                                <div class="nav-cart-items">
                                                    <?php foreach ($cart->getPositions() as $product):?>
                                                        <div class="nav-cart-item clearfix">
                                                        <div class="nav-cart-img">
                                                            <a href="/catalog/<?= $product->category->slug ?>/<?= $product->id ?>">
                                                                <?= Html::img($product->images[0]->getUrl('small'), ['alt'=>$product->title]);?>
                                                            </a>
                                                        </div>
                                                        <div class="nav-cart-title">
                                                            <a href="/catalog/<?= $product->category->slug ?>/<?= $product->id ?>">
                                                                <?= $product->title ?>
                                                            </a>
                                                            <div class="nav-cart-price">
                                                                <span></span><?= $product->getQuantity() ?> x</span>
                                                                <span><?= (int)$product->price ?><i class="fa fa-ruble"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="nav-cart-remove">
                                                            <a href="#"><i class="icon icon_close"></i></a>
                                                        </div>
                                                    </div>
                                                    <?php endforeach;?>

                                                </div> <!-- end cart items -->

                                                <div class="nav-cart-summary">
                                                    <span>Подитог</span>
                                                    <span class="total-price"><?= $cart->getCost() ?><i class="fa fa-ruble"></i></span>
                                                </div>

                                                <div class="nav-cart-actions mt-20">
                                                    <a href="/cart" class="btn btn-md btn-dark"><span>В корзину</span></a>
                                                    <a href="/cart/order" class="btn btn-md btn-color mt-10"><span>Оформить заказ</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu-cart-amount right">
                                            <span>
                                                 Корзина /
                                                <a href="/cart/list"><?= $cart->getCost() ?><i class="fa fa-ruble"></i></a>
                                            </span>
                                        </div>
                                    </div> <!-- end cart -->

                                </div>
                            </div> <!-- end header wrap -->

                            <div class="nav-wrap">
                                <div class="collapse navbar-collapse" id="navbar-collapse">

                                    <ul class="nav navbar-nav">

                                        <li id="mobile-search" class="hidden-lg hidden-md">
                                            <form method="get" class="mobile-search relative">
                                                <input type="search" class="form-control" placeholder="Поиск...">
                                                <button type="submit" class="search-button">
                                                    <i class="icon icon_search"></i>
                                                </button>
                                            </form>
                                        </li>
                                        <?php $categories = Category::find()->where(['parent_id' => null])->all(); ?>
                                        <?php foreach ($categories as $category):?>
                                            <li class="dropdown">
                                                <a href="/catalog/<?= $category->slug ?>"><?= $category->title ?></a>
                                                <i class="fa fa-angle-down dropdown-toggle" data-toggle="dropdown"></i>
                                                <?php $subcategories = Category::find()->where(['parent_id' => $category->id])->all(); ?>
                                                <?php if($subcategories):?>
                                                    <ul class="dropdown-menu">
                                                        <?php foreach ($subcategories as $subcategory):?>
                                                            <li><a href="/catalog/<?= $subcategory->slug ?>"><?= $subcategory->title ?></a></li>
                                                        <?php endforeach;?>
                                                    </ul>
                                                <?php endif;?>
                                            </li>
                                        <?php endforeach;?>
                                        <li><a class="red" href="/catalog/sale">Скидки</a></li>

                                        <li class="mobile-links">
                                            <ul>
                                                <li>
                                                    <a href="#">Login</a>
                                                </li>
                                                <li>
                                                    <a href="#">My Account</a>
                                                </li>
                                                <li>
                                                    <a href="#">My Wishlist</a>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul> <!-- end menu -->
                                </div> <!-- end collapse -->
                            </div> <!-- end col -->

                        </div> <!-- end row -->
                    </div> <!-- end container -->
                </div> <!-- end navigation -->
            </nav> <!-- end navbar -->
        </header> <!-- end navigation -->




        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        </div>
        <?= $content ?>

        <footer class="footer footer-type-1 bg-white">
            <div class="container">
                <div class="footer-widgets top-bottom-dividers pb-mdm-20">
                    <div class="row">

                        <div class="col-md-3 col-sm-3 col-xs-4 col-xxs-12">
                            <div class="widget footer-links">
                                <h5 class="widget-title uppercase">Помощь</h5>
                                <ul class="list-no-dividers">
                                    <li><a href="/contact">Контакты</a></li>
                                    <li><a href="#">Скидки и акции</a></li>
                                    <li><a href="#">Доставка и оплата</a></li>
                                    <li><a href="#">Возврат</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="widget">
                                <h5 class="widget-title uppercase">О нас</h5>
                                <p class="mb-0"><?=Yii::$app->params['footerDesc']?></p>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-s-12">
                            <div class="widget footer-get-in-touch">
                                <h5 class="widget-title uppercase">Контакты</h5>
                                <?php foreach (Yii::$app->params['address'] as $k => $v):?>
                                    <address class="footer-address"><span><?=$k?>: </span><?=$v?></address>
                                <?php endforeach;?>
                                <p>Телефон: <a href="tel:<?=Yii::$app->params['phone']?>"><?=Yii::$app->params['phone']?></a></p>
                                <p>Email: <a href="mailto:<?=Yii::$app->params['email']?>"><?=Yii::$app->params['email']?></a></p>
                                <div class="social-icons rounded mt-10">
                                    <a href="<?=Yii::$app->params['linkInstagram']?>"><i class="fa fa-instagram"></i></a>
                                    <a href="<?=Yii::$app->params['linkVk']?>"><i class="fa fa-vk"></i></a>
                                </div>
                            </div>
                        </div> <!-- end stay in touch -->
                    </div>
                </div>
            </div> <!-- end container -->

            <div class="bottom-footer bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-5 copyright sm-text-center">
                            <span>
                                Copyright &copy; <?= date('Y') ?> <?= Yii::$app->params['domain'] ?>.
                                Developed with <i class="fa fa-heart-o"></i> by <a href="<?= Yii::$app->params['developerSite'] ?>" rel="external"><?= Yii::$app->params['developer'] ?></a>.
                            </span>
                        </div>

                        <div class="col-sm-4 text-center">
                            <div id="back-to-top">
                                <a href="#top">
                                    <i class="fa fa-angle-up"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end bottom footer -->
        </footer> <!-- end footer -->
    </main> <!-- end main container -->
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
