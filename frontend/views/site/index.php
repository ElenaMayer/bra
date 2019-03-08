<?php
use yii\helpers\Html;

$this->title = Yii::$app->params['indexTitle'];
?>

<!-- Hero Slider -->
<section class="section-wrap nopadding">
    <div class="container">
        <div class="entry-slider">
            <div class="flexslider" id="flexslider-hero">
                <ul class="slides clearfix">
                    <li>
                        <img src="/img/slider/2.jpg?1" alt="Лето 2019">
                        <div class="img-holder img-2"></div>
                        <div class="hero-holder text-center right-align">
                            <div class="hero-lines">
                                <h1 class="hero-heading white">Lady In White</h1>
                                <h4 class="hero-subheading white uppercase">Топы от 880 рублей</h4>
                            </div>
                            <a href="/catalog/top" class="btn btn-lg btn-white"><span>Купить</span></a>
                        </div>
                    </li>
                    <li>
                        <img src="/img/slider/4.jpg?4" alt="Коллекция 2019">
                        <div class="img-holder img-4"></div>
                        <div class="hero-holder text-center right-align">
                            <div class="hero-lines">
                                <h1 class="hero-heading white">Lady In Red</h1>
                                <p class="white">Новая коллекция белья и аксессуаров</p>
                            </div>
                            <a href="/catalog/underwear" class="btn btn-lg btn-white"><span>Купить</span></a>
                        </div>
                    </li>
                    <li>
                        <img src="/img/slider/7.jpg?7" alt="Порадуй друзей">
                        <div class="img-holder img-7"></div>
                        <div class="hero-holder left-align">
                            <div class="hero-lines">
                                <h1 class="hero-heading white">Подари билет </br>в кружевной рай</h1>
                                <p class="white">Подарочные сертификаты на любую сумму</p>
                            </div>
                            <a href="/certificate" class="btn btn-lg btn-white"><span>Подробнее</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div> <!-- end slider -->
    </div>
</section> <!-- end hero slider -->

<!-- New Arrivals -->
<section class="section-wrap new-arrivals pb-40">
    <div class="container">
        <div class="row heading-row">
            <div class="col-md-12 text-center">
                <h2 class="heading uppercase"><small>Новинки</small></h2>
            </div>
        </div>

        <div class="row row-10">
            <?php foreach ($products as $product):?>
                <?php $images = $product->images; ?>
                <?php if(isset($images[0])):?>
                    <div class="col-md-3 col-xs-6">
                        <div class="product-item">
                            <div class="product-img">
                                <a href="/catalog/<?= $product->category->slug?>/<?= $product->id?>" title="<?= $product->title?>">

                                    <img src="<?=$images[0]->getUrl('medium')?>" alt="<?= $product->title?>">
                                    <?php if(isset($images[1])):?>
                                        <img src="<?=$images[1]->getUrl('medium')?>" alt="<?= $product->title?>" class="back-img">
                                    <?php endif;?>
                                </a>
                                <?php if($product->is_in_stock && $product->new_price):?>
                                    <div class="product-label">
                                        <span class="sale">sale</span>
                                    </div>
                                <?php endif;?>
                            </div>
                            <div class="product-details">
                                <h3>
                                    <a class="product-title" href="/catalog/<?= $product->category->slug?>/<?= $product->id?>"><?= $product->title?></a>
                                </h3>
                                <span class="price">
                                    <?php if($product->new_price):?>
                                        <del>
                                            <span><?= (int)$product->price?><i class="fa fa-ruble"></i></span>
                                        </del>
                                        <ins>
                                            <span class="ammount"><?= $product->new_price?><i class="fa fa-ruble"></i></span>
                                        </ins>
                                    <?php else:?>
                                        <ins>
                                            <span class="ammount"><?= (int)$product->price?><i class="fa fa-ruble"></i></span>
                                        </ins>
                                    <?php endif;?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            <?php endforeach;?>

        </div> <!-- end row -->
    </div>
</section> <!-- end new arrivals -->
