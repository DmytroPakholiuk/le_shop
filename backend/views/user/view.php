<?php

/**
 * @var \common\models\User $model
 * @var \yii\web\View $this
 * @var \yii\rbac\DbManager $auth
 */

use yii\widgets\DetailView;

$this->title = 'User ' . $model->username; ?>


<?php echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id:integer',
        'username',
        'email',
        [
            'label' => 'Status',
            'value' => $model->status . ': ' . \common\models\User::statuses()[$model->status]
        ],
        [
            'label' => 'Roles',
            'value' => function(\common\models\User $model) use ($auth){
                $roles = $auth->getRolesByUser($model->id);
                $value = '';
                foreach ($roles as $role){
                    $value .= "<div class='badge badge-info' style='margin-right: 10px'>{$role->name}</div>";
                }
                return $value;
            },
            'format' => 'html',
        ],
        'created_at:datetime',
        'updated_at:datetime'
    ]
]); ?>