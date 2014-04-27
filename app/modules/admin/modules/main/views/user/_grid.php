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
        ['attribute' => 'role'],
        'active',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>