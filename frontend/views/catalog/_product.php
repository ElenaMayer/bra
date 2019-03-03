<?php
use yii\helpers\Html;
use yii\helpers\Markdown;
?>
<?php /** @var $model \common\models\Product */ ?>

<?php $images = $product->images; ?>
<?php if(isset($images[0])):?>
    <div class="col-md-4 col-xs-6">
        <div class="product-item">
            <div class="product-img">
                <a href="/catalog/<?= $product->category->slug?>/<?= $product->id?>" title="<?= $product->title?>">
                    <img src="<?=$images[0]->getUrl('medium')?>" alt="<?= $product->title?>">
                    <?php if(isset($images[1])):?>
                        <img src="<?=$images[1]->getUrl('medium')?>" alt="<?= $product->title?>" class="back-img">
                    <?php endif;?>
                </a>
                <?php if(!$product->getIsInStock()):?>
                    <span class="sold-out valign">Нет в наличии</span>
                <?php endif;?>
                <?php if($product->getIsInStock() && $product->new_price):?>
                    <div class="product-label">
                        <span class="sale">-<?= $product->getSale()?>%</span>
                    </div>
                <?php endif;?>
            </div>
            <div class="product-details">
                <h3>
                    <a class="product-title" href="/catalog/<?= $product->category->slug?>/<?= $product->id?>" title="<?= $product->title?>"><?= $product->title?></a>
                </h3>
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
                            <span class="ammount"><?= $product->price?><i class="fa fa-ruble"></i></span>
                        </ins>
                    <?php endif;?>
                </span>
            </div>
        </div>
    </div>
<?php endif;?>