<?php
use yii\helpers\Html;

$this->title = Yii::$app->params['indexTitle'];
?>

<!-- Hero Slider -->
<section class="section-wrap nopadding-wide">
    <div class="container index">
        <div class="entry-slider">
            <div class="flexslider" id="flexslider-hero">
                <ul class="slides clearfix">
                    <li>
                        <img src="/img/slider/13.png?2" alt="В стиле Glam">
                    </li>
                    <li>
                        <img src="/img/slider/9.png?1" alt="New новинки">
                    </li>
                    <li>
                        <img src="/img/slider/10.png?1" alt="Онлайн и офлайн магазины">
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
