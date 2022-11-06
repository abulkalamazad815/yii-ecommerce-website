<?php
/**
 * Created By PhpStorm
 * User azad
 * Date 11/3/2022
 * Time 7:39 PM
 * To change this template use File || Settings || File and Code Templates
 */

function isGuest(){
    return Yii::$app->user->isGuest;
}

function currUserId(){
    return Yii::$app->user->id;
}