<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 11/3/2022
 * Time 9:50 AM
 * To change this template use File || Settings || File and Code Templates
 */

namespace frontend\base;

use common\models\CartItem;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->view->params['cartItemCount'] = CartItem::getTotalQuantityForUser(currUserId());
        return parent::beforeAction($action);
    }
}