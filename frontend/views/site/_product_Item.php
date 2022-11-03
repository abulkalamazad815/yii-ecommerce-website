<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 10/31/2022
 * Time 1:16 PM
 * To change this template use File || Settings || File and Code Templates
 */
/** @var \common\models\Product $model */

use yii\helpers\Url;

?>

<div class="card h-100">
    <!-- Sale badge-->
    <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
    <!-- Product image-->
    <img class="card-img-top"
         src="<?php echo $model->getImageUrl()?>" alt="..." />
    <!-- Product details-->
    <div class="card-body p-4">
        <div class="text-center">
            <!-- Product name-->
            <h5 class="fw-bolder"><?php echo $model->name ?></h5>
            <!-- Product reviews-->
            <div class="d-flex justify-content-center small text-warning mb-2">
                <div class="bi-star-fill"></div>
                <div class="bi-star-fill"></div>
                <div class="bi-star-fill"></div>
                <div class="bi-star-fill"></div>
                <div class="bi-star-fill"></div>
            </div>
            <!-- Product price-->
            <span class="text-muted text-decoration-line-through">$2000</span>
            <?php echo Yii::$app->formatter->asCurrency($model->price) ?>
        </div>
    </div>
    <!-- Product actions-->
    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
        <div class="text-center">
            <a class="btn btn-outline-dark mt-auto btn-add-to-cart"
               href="<?php echo Url::to(['cart/add'])?>">Add to cart
            </a>
        </div>
    </div>
</div>

