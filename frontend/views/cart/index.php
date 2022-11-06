<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 11/2/2022
 * Time 11:54 AM
 * To change this template use File || Settings || File and Code Templates
 */
/** @var array $items */

use yii\helpers\Url;

$this->title = 'Cart';
?>

<div class="card">
    <div class="card-header">
        <h2>Your cart items</h2>
    </div>
    <div class="card-body p-0">
        <?php if(!empty($items)): ?>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Image</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item):?>
                <tr data-id="<?php echo $item['id'] ?>" data-url="<?php echo Url::to(['/cart/change-quantity'])?>">
                    <td><?php echo $item['name']?></td>
                    <td>
                        <img src="<?php echo \common\models\Product::formatImageUrl($item['image']) ?>"
                             alt="<?php echo $item['image']?>" width="50px">
                    </td>
                    <td><?php echo $item['price']?></td>
                    <td>
                        <input type="number" min="1" class="form-control item-quantity" style="width: 80px" value="<?php echo $item['quantity']?>">
                    </td>
                    <td><?php echo $item['totalPrice']?></td>
                    <td>
                        <?php echo \yii\helpers\Html::a('Delete', ['cart/delete', 'id'=>$item['id']],[
                            'class'=>'btn btn-outline-danger btn-sm',
                            'data-method' => 'post',
                            'data-confirm' => 'Are you sure to remove this item from cart?'
                        ])?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <div class="card-body text-end">
            <a href="<?php echo \yii\helpers\Url::to(['cart/checkout'])?>" class="btn btn-primary">Checkout</a>
        </div>
        <?php else: ?>
            <p class="text-muted text-center p-5">
                There are no items in the cart
            </p>
        <?php endif; ?>
    </div>
</div>
