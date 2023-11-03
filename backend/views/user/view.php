<?php

/**
 * @var \common\models\User $model
 * @var \yii\web\View $this
 * @var \yii\rbac\DbManager $auth
 */

use yii\widgets\DetailView;

$this->title = Yii::t("app/user", "User {username}", [
    "username" => $model->username
]);// 'User ' . $model->username; ?>


<?php echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            "label" => "id",
            "format" => "integer",
            "attribute" => "id"
        ],
        [
            "label" => Yii::t("app/user", "username"),
            "attribute" => "username"
        ],
        [
            "label" => Yii::t("app/user", "email"),
            "attribute" => "email"
        ],
        [
            'label' => Yii::t("app/user", 'status'),
            'value' => $model->status . ': ' . \common\models\User::statuses()[$model->status]
        ],
        [
            'label' => Yii::t("app/user", "roles"),
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
        [
            'value' => $model->created_at,
            'label' => Yii::t("app/user", 'created at'),
            'format' => 'datetime'
        ],
        [
            'value' => $model->updated_at,
            'label' => Yii::t("app/user", 'updated at'),
            'format' => 'datetime'
        ],
    ]
]); ?>