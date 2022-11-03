<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 11/2/2022
 * Time 10:48 AM
 * To change this template use File || Settings || File and Code Templates
 */

namespace frontend\controllers;

use common\models\CartItem;
use common\models\Product;
use common\widgets\Alert;
use Yii;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends \frontend\base\Controller
{
    public function behaviors()
    {
        return [
          [
              'class' => ContentNegotiator::class,
              'only'=> ['add'],
              'formats' => [
                  'application/json' => Response::FORMAT_JSONP
              ]
          ]
        ];
    }

    public function actionIndex(){
        if(\Yii::$app->user->isGuest){
            //Get cart items from session
        }else{
           $cartItems = CartItem::findBySql("
                            SELECT
                                a.product_id as id
                                ,p.image
                                ,p.name
                                ,p.price
                                ,a.quantity
                                ,p.price * a.quantity as totalPrice
                            FROM cart_items a
                            LEFT JOIN products p on p.id = a.product_id 
                            WHERE a.created_by = :userId",
                            ['userId' => \Yii::$app->user->id])
                           ->asArray()
                           ->all();
        }

        return $this->render('index',[
                'items' => $cartItems
            ]);
    }

    public function actionAdd(){
       $id = \Yii::$app->request->post('id');
       $product = Product::find()->id($id)->published()->one();
       if(!$product){
           throw new NotFoundHttpException('Product dose not exist');
       }

       if(\Yii::$app->user->isGuest){
           //TODO Save to session
       }else{
           $userId = \Yii::$app->user->id;
           $cartItem = CartItem::find()->userId($userId)->productId($id)->one();
           if($cartItem){
               $cartItem->quantity++;
           }else{
               $cartItem = new CartItem();
               $cartItem->product_id = $id;
               $cartItem->quantity = 1;
               $cartItem->created_by = $userId;
           }
           if($cartItem->save()){

               return [
                   'success' => true
               ];
           }else{
               return [
                   'success' => false,
                   'errors' => $cartItem->errors
               ];
           }
       }
    }
}