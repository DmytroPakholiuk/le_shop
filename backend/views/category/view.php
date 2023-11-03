<?php
/**
 * @var \common\models\Category $category
 * @var yii\web\View $this
 */

$this->title = Yii::t("app/category", 'Category') . ' #'.$category->id;?>

<?php echo \yii\widgets\DetailView::widget([
    'model' => $category,
    'attributes' => [
        'id',
        [
            "attribute" => 'name',
            "label" => Yii::t("app/category", 'name')
        ],
        [
            "attribute" => 'description',
            "label" => Yii::t("app/category", 'description'),
            "format" => "html"
        ],
        [
            'label' => Yii::t("app/category", 'parent category'),
            'value' => $category->parent->name ?? null,
        ],
        [
            'value' => $category->created_at,
            'label' => Yii::t("app/category", 'created at'),
            'format' => 'datetime'
        ],
        [
            'value' => $category->updated_at,
            'label' => Yii::t("app/category", 'updated at'),
            'format' => 'datetime'
        ],
    ]
]); ?>


<br>
<a href="update"><?= Yii::t("app", "update") ?></a><br>
<a href="delete"><?= Yii::t("app", "delete") ?></a>