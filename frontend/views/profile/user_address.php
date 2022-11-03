<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 10/31/2022
 * Time 6:37 PM
 * To change this template use File || Settings || File and Code Templates
 */
/** @var \common\models\UserAddresse $userAddress */
/** @var \yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

?>

<?php if (isset($success) && $success): ?>
    <div class="alert alert-success">
        Your address was successfully updated.
    </div>
<?php endif ?>

<?php $addressForm = ActiveForm::begin([
    'action' => ['/profile/update-address'],
    'options' => [
        'data-pjax' => 1
    ]
]); ?>
<?= $addressForm->field($userAddress, 'address') ?>
<?= $addressForm->field($userAddress, 'city') ?>
<?= $addressForm->field($userAddress, 'state') ?>
<?= $addressForm->field($userAddress, 'country') ?>
<?= $addressForm->field($userAddress, 'zipcode') ?>
<?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
