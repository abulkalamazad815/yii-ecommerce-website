<?php

namespace common\i18n;
use common\models\Order;
use yii\bootstrap5\Html;

/**
 * Created By PhpStorm
 * User azad
 * Date 11/21/2022
 * Time 12:17 PM
 * To change this template use File || Settings || File and Code Templates
 */
class Formatter extends \yii\i18n\Formatter
{
    public function asOrderStatus($status){
        if($status === Order::STATUS_COMPLETED){
            return Html::tag('span', 'Paid',[
                'class' => 'badge badge-success'
            ]);
        }elseif ($status === Order::STATUS_DRAFT){
            return Html::tag('span', 'Unpaid',[
                'class' => 'badge badge-secondary'
            ]);
        }else{
            return Html::tag('span', 'Failured',[
                'class' => 'badge badge-danger'
            ]);
        }
    }
}