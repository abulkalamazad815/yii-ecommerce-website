<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 11/17/2022
 * Time 10:47 AM
 * To change this template use File || Settings || File and Code Templates
 */
/** @var \common\models\Order $order */
$orderAddress = $order->orderAddress;
?>
<style>
    .row {
        display: flex;
    }
    .col {
        flex: 1;
    }
</style>
<h4>Order #<?php echo $order->id?> Summery:</h4>
<hr>
<div class="row">
    <div class="col">
        <h5>Account Information</h5>
        <table class="table">
            <tbody>
            <tr>
                <th>Firstname</th>
                <td><?php echo $order->firstname?></td>
            </tr>

            <tr>
                <th>Lastname</th>
                <td><?php echo $order->lastname?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?php echo $order->email?></td>
            </tr>
            </tbody>
        </table>

        <h5>Address Information</h5>
        <table class="table">
            <tbody>
            <tr>
                <th>Address</th>
                <td><?php echo $orderAddress->address?></td>
            </tr>

            <tr>
                <th>City</th>
                <td><?php echo $orderAddress->city?></td>
            </tr>

            <tr>
                <th>State</th>
                <td><?php echo $orderAddress->state?></td>
            </tr>

            <tr>
                <th>Country</th>
                <td><?php echo $orderAddress->country?></td>
            </tr>

            <tr>
                <th>Zipcode</th>
                <td><?php echo $orderAddress->zipcode?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col">
        <h5>Products</h5>
        <table class="table table">
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($order->orderItems as $item): ?>
                <tr>
                    <td><?php echo $item->product_name ?></td>
                    <td>
                        <img src="<?php echo $item->product->getImageUrl() ?>" style="width: 50px">
                    </td>
                    <td><?php echo $item->quantity ?></td>
                    <td><?php echo Yii::$app->formatter->asCurrency($item->quantity * $item->unit_price) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <table class="table">
            <tbody>
            <tr>
                <th>Total Items</th>
                <td><?php echo $order->getItemsQuantity() ?></td>
            </tr>

            <tr>
                <th>Total Price</th>
                <td><?php echo Yii::$app->formatter->asCurrency($order->total_price) ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>