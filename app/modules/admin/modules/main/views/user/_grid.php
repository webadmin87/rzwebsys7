<?php
use yii\grid\GridView;



?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'username',
        'email:email',
        'role',
        'status',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>