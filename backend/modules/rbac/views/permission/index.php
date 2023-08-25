<?php


/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\modules\rbac\models\ItemSearch $searchModel
 * @var yii\web\View $this
 */

use kartik\daterange\DateRangePicker;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Permission list'; ?>


<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'name',
        'rule_name',
        [
            'attribute' => 'created_at',
            'format' => 'datetime', //todo
            'filter' => false
        ],
        [
            'attribute' => 'updated_at',
            'format' => 'datetime', //todo
            'filter' => false
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{update} {delete}'
        ]
    ],

]); ?>
<br>
<a href = <?php echo \yii\helpers\Url::to(['/rbac/role/create']); ?>>Create a new role</a>

