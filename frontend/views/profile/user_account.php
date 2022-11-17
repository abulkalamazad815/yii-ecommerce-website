<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 10/31/2022
 * Time 7:34 PM
 * To change this template use File || Settings || File and Code Templates
 */
/** @var \common\models\User $user */
/** @var \yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

?>

<?php if (isset($success) && $success): ?>
    <div class="alert alert-success">
        Your account was successfully updated.
    </div>
<?php endif ?>

<?php $form = ActiveForm::begin([
    'action' => ['/profile/update-account'],
    'options' => [
        'data-pjax' => 1
    ]
]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($user, 'firstname')->textInput(['autofocus' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($user, 'lastname')->textInput(['autofocus' => true]) ?>
    </div>
</div>
<?= $form->field($user, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($user, 'email') ?>

<div class="row">
    <div class="col">
        <?= $form->field($user, 'password')->passwordInput() ?>
    </div>
    <div class="col">
        <?= $form->field($user, 'password_repeat')->passwordInput() ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
