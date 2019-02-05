<?php
use yii\helpers\Html;
use common\models\Product;

/* @var $this yii\web\View */
$title = $product->title;
$subcategory = $product->getSubcategory();
$this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['/catalog/' . $category->slug]];
if($subcategory){
    $this->params['breadcrumbs'][] = ['label' => $subcategory->title, 'url' => ['/catalog/' . $subcategory->slug]];
}
$this->params['breadcrumbs'][] = $title;
$this->title = Html::encode($title);
?>

<!-- Single Product -->
<section class="section-wrap single-product">
    <div class="container relative">
        <div class="row">
            <div class="col-sm-6 col-xs-12 mb-60">
                <div class="flickity flickity-slider-wrap mfp-hover" id="gallery-main"><?php
                    $images = $product->images;
                    ?>
                    <?php foreach($images as $image):?>
                        <div class="gallery-cell">
                            <a href="<?=$image->getUrl('origin')?>" class="lightbox-img">
                                <img src="<?=$image->getUrl('origin')?>" alt="<?= $product->title?>" />
                                <i class="icon arrow_expand"></i>
                            </a>
                        </div>
                    <?php endforeach;?>
                </div> <!-- end gallery main -->

                <div class="gallery-thumbs">
                    <?php foreach($images as $image):?>
                        <div class="gallery-cell">
                            <img src="<?=$image->getUrl('medium')?>" alt="<?= $product->title?>" />
                        </div>
                    <?php endforeach;?>
                </div> <!-- end gallery thumbs -->
            </div> <!-- end col img slider -->

            <div class="col-sm-6 col-xs-12 product-description-wrap">
                <h1 class="product-title"><?= $product->title?></h1>
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
                <p class="product-description"><?= $product->description?></p>
                <div class="select-options">
                    <div class="row row-20">
                        <div class="col-sm-6">
                            <select class="color-select">
                                <option value>Цвет</option>
                                <?php foreach($product->getColorsArray() as $color):?>
                                    <option value="<?=$color?>"><?=$color?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <select class="size-options">
                                <option value>Размер</option>
                                <?php foreach($product->getSizesArray() as $size):?>
                                    <option value="<?=$size?>"><?=$size?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
                <ul class="product-actions clearfix">
                    <li>
                        <button type="button" class="add-to-cart single_add_to_cart_button btn btn-color btn-lg add-to-cart left" data-id="<?= $product->id ?>">
                            <span>В корзину</span>
                        </button>
                    </li>
                    <li>
                        <div class="quantity buttons_added">
                            <input type="button" value="-" class="minus" /><input type="number" step="1" min="0" value="1" title="Qty" class="input-text qty text" /><input type="button" value="+" class="plus" />
                        </div>
                    </li>
                </ul>
            </div> <!-- end col product description -->
        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end single product -->


<!-- Related Items -->
<section class="section-wrap related-products pt-0">
    <div class="container">
        <div class="row heading-row">
            <div class="col-md-12 text-center">
                <h2 class="heading uppercase"><small>Новинки</small></h2>
            </div>
        </div>

        <div class="row row-10">

            <div id="owl-related-products" class="owl-carousel owl-theme nopadding">

                <?php foreach (Product::getNovelties(8) as $product):?>
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
                <?php endforeach;?>
            </div> <!-- end owl -->

        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end related products -->