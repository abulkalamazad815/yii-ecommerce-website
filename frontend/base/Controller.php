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
        if(\Yii::$app->user->isGuest){
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY, []);
            $sum = 0;
            foreach ($cartItems as $cartItem){
                $sum += $cartItem['quantity'];
            }
        }else{
            $sum = CartItem::findBySql("
                            SELECT 
                                SUM(quantity) 
                            FROM cart_items 
                            WHERE created_by = :userId",
                ['userId' => \Yii::$app->user->id]
            )->scalar();
        }
        $this->view->params['cartItemCount'] = $sum;
        return parent::beforeAction($action);
    }

    public function actionDelete($id)
    {
        if(isGuest()){
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY, []);
            foreach ($cartItems as $i => $cartItem){
                if($cartItem['id'] == $id){
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            \Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
        }else{
            CartItem::deleteAll(['product_id' =>$id, 'created_by' => currUserId()]);
        }
            return $this->redirect(['cart/index']);
    }
}