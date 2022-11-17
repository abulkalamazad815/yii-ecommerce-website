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
Order #<?php echo $order->id?> Summery:

Account Information
    Firstname: <?php echo $order->firstname?>
    Lastname: <?php echo $order->lastname?>
    Email: <?php echo $order->email?>

Address Information
    Address: <?php echo $orderAddress->address?>
    City: <?php echo $orderAddress->city?>
    State: <?php echo $orderAddress->state?>
    Country: <?php echo $orderAddress->country?>
    Zipcode: <?php echo $orderAddress->zipcode?>

Products
    Product Name     Quantity      Price
    <?php foreach ($order->orderItems as $item): ?>
        <?php echo $item->product_name ?>  <?php echo $item->quantity ?>  <?php echo Yii::$app->formatter->asCurrency($item->quantity * $item->unit_price) ?>
    <?php endforeach; ?>

Total Items: <?php echo $order->getItemsQuantity() ?>
Total Price: <?php echo Yii::$app->formatter->asCurrency($order->total_price) ?>