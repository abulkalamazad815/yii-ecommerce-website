<?php

use common\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
         'id' => 'orderTable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class
        ],
        'columns' => [
            [   'attribute' => 'id',
                'contentOptions' => ['style' => 'width:80px']
            ],
            [
                'attribute' => 'fullname',
                'content' => function ($model) {
                    return "{$model->firstname} {$model->lastname}";
                },
            ],
            'total_price:currency',
            [
                    'attribute' => 'status',
                    'filter' => Html::activeDropDownList($searchModel, 'status', Order::getStatusLabels(), [
                            'class' => 'form-control',
                            'prompt' => 'All'
                    ]),
                    'format' => ['orderStatus']
            ],
            //'email:email',
            //'transaction_id',
            //'paypal_orderId',
            'created_at:DateTime',
            //'created_by',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
                'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
