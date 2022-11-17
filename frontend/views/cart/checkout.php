<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 11/7/2022
 * Time 10:04 AM
 * To change this template use File || Settings || File and Code Templates
 */
/** @var \common\models\Order $order */
/** @var \common\models\OrderAddress $orderAddress */
/** @var array $cartItems */
/** @var int $productQuantity */
/** @var float $totalPrice */

use yii\bootstrap5\ActiveForm;


?>

<?php $form = ActiveForm::begin([
    'id' => 'checkout-form',
    'action' => ['/cart/checkout']
]); ?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Account information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($order, 'firstname')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'lastname')->textInput(['autofocus' => true]) ?>
                    </div>
                </div>
                <?= $form->field($order, 'email')->textInput(['autofocus' => true]) ?>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                Address information
            </div>
            <div class="card-body">
                <?= $form->field($orderAddress, 'address') ?>
                <?= $form->field($orderAddress, 'city') ?>
                <?= $form->field($orderAddress, 'state') ?>
                <?= $form->field($orderAddress, 'country') ?>
                <?= $form->field($orderAddress, 'zipcode') ?>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                Order Summary
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>
                            <?php echo $productQuantity?> Products
                        </td>
                    </tr>
                    <tr>
                        <td>Total Price</td>
                        <td class="text-right">
                            <?php echo Yii::$app->formatter->asCurrency($totalPrice)?>
                        </td>
                    </tr>
                </table>
                <p style="float: right; margin-top: 5px">
                    <button class="btn btn-secondary">Checkout</button>
                </p>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

