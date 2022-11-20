<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 11/14/2022
 * Time 10:28 AM
 * To change this template use File || Settings || File and Code Templates
 */
/** @var \common\models\Order $order */

$orderAddress = $order->orderAddress
?>

<script src="https://www.paypal.com/sdk/js?client-id=<?php echo param('paypalClientId') ?>"> </script>

<h4>Order #<?php echo $order->id?> Summery:</h4>
<hr>
<div class="row">
    <div class="col">
        <h5>Account Information</h5>
        <table class="table">
            <tbody>
                <tr>
                    <th>Firstname</th>
                    <td style="text-align: center;"><?php echo $order->firstname?></td>
                </tr>

                <tr>
                    <th>Lastname</th>
                    <td style="text-align: center;"><?php echo $order->lastname?></td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td style="text-align: center;"><?php echo $order->email?></td>
                </tr>
            </tbody>
        </table>

        <h5>Address Information</h5>
        <table class="table">
            <tbody>
                <tr>
                    <th>Address</th>
                    <td style="text-align: center;"><?php echo $orderAddress->address?></td>
                </tr>

                <tr>
                    <th>City</th>
                    <td style="text-align: center;"><?php echo $orderAddress->city?></td>
                </tr>

                <tr>
                    <th>State</th>
                    <td style="text-align: center;"><?php echo $orderAddress->state?></td>
                </tr>

                <tr>
                    <th>Country</th>
                    <td style="text-align: center;"><?php echo $orderAddress->country?></td>
                </tr>

                <tr>
                    <th>Zipcode</th>
                    <td style="text-align: center;"><?php echo $orderAddress->zipcode?></td>
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
                    <td style="text-align: end;"><?php echo $order->getItemsQuantity() ?></td>
                </tr>

                <tr>
                    <th>Total Price</th>
                    <td style="text-align: end;"><?php echo Yii::$app->formatter->asCurrency($order->total_price) ?></td>
                </tr>
            </tbody>
        </table>

        <div id="paypal-button-container"></div>
    </div>
</div>

<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            // Set up the transaction
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo $order->total_price ?>
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            console.log(data, actions);
            return actions.order.capture().then(function(details) {
                const $form = $('#checkout-form');
                const formData = $form.serializeArray();
                formData.push({
                    name: 'transactionId',
                    value: details.id
                });

                formData.push({
                    name: 'orderId',
                    value: data.orderID
                });

                formData.push({
                    name: 'status',
                    value: details.status
                })

                $.ajax({
                    method: 'post',
                    url: '<?php echo \yii\helpers\Url::to(['/cart/submit-payment', 'orderId' => $order->id])?>',
                    data: formData,
                    success: function (res){
                        // This function shows a transaction success message to your buyer.
                        alert('Thanks' + ' ' + details.payer.name.given_name + ' ' + 'for shopping with us.');
                        window.location.href = '';
                    }
                })
            });
        }
    }).render('#paypal-button-container');
</script>
