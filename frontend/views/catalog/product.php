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
            <div class="col-sm-7 col-xs-12 mb-60">
                <div class="flickity flickity-slider-wrap mfp-hover" id="gallery-main">
                    <?php $images = $product->images;?>
                    <?php foreach($images as $image):?>
                        <div class="gallery-cell">
                            <a href="<?=$image->getUrl('big')?>" class="lightbox-img">
                                <img src="<?=$image->getUrl('big')?>" alt="<?= $product->title?>" />
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

            <div class="col-sm-5 col-xs-12 product-description-wrap">
                <h1 class="product-title"><?= $product->title?></h1>
                <div class="product-status">
                    <?php if($product->getIsInStock()):?><span class="green">В наличии </span><?php else:?><span class="red">Отсутствует</span><?php endif;?>
                    <span>&nbsp;-&nbsp;</span>
                    <span>Арт: <?= $product->article?></span>
                </div>
                <span class="price">
                    <?php if($product->getIsInStock() && $product->new_price):?>
                        <del>
                            <span><?= (int)$product->price?><i class="fa fa-ruble"></i></span>
                        </del>
                            <ins>
                            <span class="ammount sale"><?= $product->new_price?><i class="fa fa-ruble"></i></span>
                        </ins>
                    <?php else:?>
                        <ins>
                            <span class="ammount"><?= (int)$product->price?><i class="fa fa-ruble"></i></span>
                        </ins>
                    <?php endif;?>
                </span>
                <p class="product-description"><?= $product->description?></p>
                <div class="select-options">
                    <?php if($product->color):?>
                        <div class="row row-20">
                            <div class="col-sm-6">
                                <div class="colors square">
                                    <?php foreach($product->getProductColors() as $key => $color):?>
                                        <?php if(isset($color['id'])):?>
                                            <a href="/catalog/<?= $product->category->slug?>/<?=$color['id']?>" title="<?=$color['title']?>">
                                                <div class="color <?= $key ?>"></div>
                                            </a>
                                        <?php else:?>
                                            <div class="color <?= $product->color ?> active"></div>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if($product->getIsInStock() && $product->size):?>
                        <div class="row row-20">
                            <div class="col-sm-6 size-form">
                                <select name="p_size" id="p_size" class="size-options">
                                    <option value="0">Размер...</option>
                                    <?php foreach($product->getSizesArray() as $size):?>
                                        <option value="<?=$size?>"><?=$size?></option>
                                    <?php endforeach;?>
                                </select>
                                <p class="error-msg">Выберите размер</p>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
                <?php if($product->getIsInStock()):?>
                    <ul class="product-actions clearfix">
                        <li class="cd-customization">
                            <button data-id ="<?=$product->id?>" type="button" class="add-to-cart single_add_to_cart_button btn btn-color btn-lg add-to-cart left">
                                <em>В корзину</em>
                                <svg x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32">
                                    <path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"/>
                                </svg>
                            </button>
                        </li>
                        <li>
                        </li>
                    </ul>
                <?php endif;?>
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