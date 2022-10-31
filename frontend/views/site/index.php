<?php

/** @var yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */

use yii\widgets\ListView;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
                </div>
            </div>
        </header>
            <?php echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '{summary}<div class="row container px-4 px-lg-5 mt-5container px-4 px-lg-5 mt-5 gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">{items}</div>{pager}',
                    'itemView' => '_product_Item',
                    'itemOptions' => [
                            'class' => 'col mb-5'
                    ],
                    'pager' => [
                            'class' => \yii\bootstrap5\LinkPager::class
                    ],
                    'summary'=>''
            ])?>
    </div>
</div>
