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
                        <img src="img/slider/1.jpg" alt="">
                        <div class="img-holder img-1"></div>
                        <div class="hero-holder text-center right-align">
                            <div class="hero-lines">
                                <h1 class="hero-heading white">Collection 2017</h1>
                                <h4 class="hero-subheading white uppercase">HOT AND FRESH TRENDS OF THIS YEAR</h4>
                            </div>
                            <a href="#" class="btn btn-lg btn-white"><span>Shop Now</span></a>
                        </div>
                    </li>
                    <li>
                        <img src="img/slider/2.jpg" alt="">
                        <div class="img-holder img-2"></div>
                        <div class="hero-holder text-center">
                            <div class="hero-lines">
                                <h1 class="hero-heading white large">Winter Sales</h1>
                            </div>
                            <a href="#" class="btn btn-lg btn-white"><span>Shop Now</span></a>
                        </div>
                    </li>
                    <li>
                        <img src="img/slider/3.jpg" alt="">
                        <div class="img-holder img-3"></div>
                        <div class="hero-holder left-align">
                            <div class="hero-lines">
                                <h1 class="hero-heading white">Autumn 2017</h1>
                                <p class="white">A-ha Theme is the Best E-Commerce solution</p>
                                <p class="white">Packed with tons of features and unique styles</p>
                            </div>
                            <a href="#" class="btn btn-lg btn-white"><span>Shop Now</span></a>
                        </div>
                    </li>
                    <li>
                        <img src="img/slider/4.jpg" alt="">
                        <div class="img-holder img-4"></div>
                        <div class="hero-holder text-center right-align">
                            <div class="hero-lines">
                                <h1 class="hero-heading white">Summer 2017</h1>
                                <p class="white">A-ha Theme is the Best E-Commerce solution</p>
                                <p class="white">Packed with tons of features and unique styles</p>
                            </div>
                            <a href="#" class="btn btn-lg btn-white"><span>Shop Now</span></a>
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
                <div class="col-md-3 col-xs-6">
                    <div class="product-item">
                        <div class="product-img">
                            <a href="/catalog/<?= $product->category->slug?>/<?= $product->id?>" title="<?= $product->title?>">
                                <?php
                                $images = $product->images;
                                ?>
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
            <?php endforeach;?>

        </div> <!-- end row -->
    </div>
</section> <!-- end new arrivals -->
