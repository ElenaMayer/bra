<?php
use yii\helpers\Html;
use common\models\StaticFunction;
use yii\widgets\LinkPager;
use common\models\Product;

/* @var $this yii\web\View */
$title = $category->title;
$this->title = Html::encode($title);
if($category->parent){
    $this->params['breadcrumbs'][] = ['label' => $category->parent->title, 'url' => ['/catalog/' . $category->parent->slug]];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Catalogue -->
<section class="section-wrap pt-70 pb-40 catalogue">
    <div class="container relative">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-3 sidebar left-sidebar">
                <?= $this->render('_sidebar', [
                    'category' => $category,
                    'menuItems' => $menuItems,
                    'noveltyProducts' => Product::getNovelties()
                ]); ?>
            </aside> <!-- end sidebar -->
            <div class="col-md-9 catalogue-col right mb-50">
                <div class="shop-filter">
                    <?php
                    $begin = $pagination->getPage() * $pagination->pageSize + 1;
                    $end = $begin + $pageCount - 1;
                    ?>
                    <p class="result-count">Товары <?= $begin ?>-<?= $end ?> из <?= $pagination->totalCount ?></p>

                    <form class="ecommerce-ordering">
                        <select name="orderby" class="orderby" id="p_sort_by" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option value="<?= StaticFunction::addGetParamToCurrentUrl('order', 'popular') ?>" <?php if(!Yii::$app->request->get('order') || Yii::$app->request->get('order') == 'popular'):?>selected="selected"<?php endif;?>>По новинкам</option>
                            <option value="<?= StaticFunction::addGetParamToCurrentUrl('order', 'price_lh') ?>" <?php if(Yii::$app->request->get('order') && Yii::$app->request->get('order') == 'price_lh'):?>selected="selected"<?php endif;?>>По возрастанию цены</option>
                            <option value="<?= StaticFunction::addGetParamToCurrentUrl('order', 'price_hl') ?>" <?php if(Yii::$app->request->get('order') && Yii::$app->request->get('order') == 'price_hl'):?>selected="selected"<?php endif;?>>По убыванию цены</option>
                            <option value="<?= StaticFunction::addGetParamToCurrentUrl('order', 'sale') ?>" <?php if(Yii::$app->request->get('order') && Yii::$app->request->get('order') == 'sale'):?>selected="selected"<?php endif;?>>По скидке</option>
                        </select>
                    </form>
                </div>

                <div class="shop-catalogue grid-view">
                    <div class="row row-10 items-grid">
                        <?php foreach (array_values($models) as $index => $model) :?>
                            <?= $this->render('_product', ['product'=>$model]); ?>
                        <?php endforeach;?>
                    </div> <!-- end row -->
                </div> <!-- end grid mode -->
                <div class="clear"></div>

                <!-- Pagination -->
                <div class="pagination-wrap">
                    <p class="result-count">Товары <?= $begin ?>-<?= $end ?> из <?= $pagination->totalCount ?></p>

                    <?php echo LinkPager::widget([
                        'pagination' => $pagination,
                        'options' => [
                            'class' => 'pagination right clear',
                        ],
                        'pageCssClass' => 'page-numbers',
                        'firstPageLabel' => false,
                        'firstPageCssClass' => 'page-numbers',
                        'lastPageLabel' => false,
                        'lastPageCssClass' => 'page-numbers',
                        'activePageCssClass' => 'current',
                        'prevPageCssClass' => 'page-numbers',
                        'nextPageCssClass' => 'page-numbers next',
                        'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
                        'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
                        'maxButtonCount' => 6
                    ]); ?>
                </div>


            </div> <!-- end col -->
            <aside class="col-md-3 sidebar left-sidebar">
                <!-- Bestsellers -->
                <div class="widget bestsellers">
                    <div class="products-widget">
                        <h3 class="widget-title uppercase">Новинки</h3>
                        <ul class="product-list-widget">
                            <?php $products = Product::getNovelties(2);?>
                            <?php foreach ($products as $product):?>
                                <?php $images = $product->images; ?>
                                <?php if(isset($images[0])):?>
                                    <li class="clearfix">
                                        <a href="/catalog/<?= $product->category->slug?>/<?= $product->id?>">
                                            <img src="<?=$images[0]->getUrl('small')?>" alt="<?= $product->title?>">
                                            <span class="product-title"><?=$product->title?></span>
                                        </a>
                                        <span class="price">
                              <ins>
                                <span class="ammount"><?=$product->new_price ? $product->new_price : (int)$product->price?><i class="fa fa-ruble"></i></span>
                              </ins>
                            </span>
                                    </li>
                                <?php endif;?>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </aside>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end catalogue -->