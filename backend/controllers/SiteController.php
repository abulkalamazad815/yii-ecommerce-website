<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\Order;
use common\models\OrderItem;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login','forgot-password','error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $totalEarnings = Order::find()->paid()->sum('total_price');
        $totalProducts = OrderItem::find()->
        alias('oi')
            ->innerJoin(Order::tableName(). 'o', 'o.id = oi.order_id')
            ->andWhere(['o.status' => [Order::STATUS_PAID, Order::STATUS_COMPLETED]])
            ->sum('quantity');

        $totalOrders = Order::find()->paid()->count();
        $totalPendingOrders = Order::find()->unPaid()->count();

        $orders = Order::findBySql("
                    SELECT
                        DATE_FORMAT(FROM_UNIXTIME(o.created_at), '%Y-%m-%d') AS 'date'
                        ,SUM(o.total_price) AS 'totalPrice'
                    FROM orders o
                    WHERE o.status  IN(".Order::STATUS_PAID.", ".Order::STATUS_COMPLETED.")
                    GROUP BY DATE_FORMAT(FROM_UNIXTIME(o.created_at), '%Y-%m-%d')
                    ORDER BY o.created_at")
                    ->asArray()
                    ->all();

        //Area chart
        $earningsData = [];
        $labels = [];
        if(!empty($orders)){
            $minDate = $orders[0]['date'];
            $orderByPriceMap = ArrayHelper::map($orders, 'date', 'totalPrice');
            $d = new \DateTime($minDate);
            $nowDate = new \DateTime();
            $dates = [];
            while ($d->getTimestamp() < $nowDate->getTimestamp()){
                $label = $d->format('d/m/y');
                $labels[] = $label;
                $earningsData[] = (float)($orderByPriceMap[$d->format('Y-m-d')] ?? 0);
                $d->setTimestamp($d->getTimestamp() + 86400);
            }
        }

        //Pie chart
        $countriesData = Order::findBySql("
                SELECT country,
                SUM(total_price) as totalPrice
                FROM orders
                INNER JOIN order_addresses oa on orders.id = oa.order_id
                WHERE orders.status IN(".Order::STATUS_PAID.", ".Order::STATUS_COMPLETED.")
                GROUP BY country")
                ->asArray()
                ->all();

        $countryLabels = ArrayHelper::getColumn($countriesData, 'country');
        $colorOptions = ['#4e73df', '#1cc88a', '#36b9cc'];
        $bgColors = [];
        foreach ($countryLabels as $i => $country){
            $bgColors[] = $colorOptions[$i % count($colorOptions)];
        }
        return $this->render('index', [
            'totalEarnings' => $totalEarnings,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalPendingOrders' => $totalPendingOrders,
            'data' => $earningsData,
            'labels' => $labels,
            'countries' => $countryLabels,
            'bgColors' => $bgColors,
            'countriesData' => ArrayHelper::getColumn($countriesData, 'totalPrice'),
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionForgotPassword()
    {
        return 'Forgot Password';
    }
}
