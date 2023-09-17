<?php

namespace common\tests\unit\models;

use common\fixtures\CategoryFixture;
use common\models\Category;

class CategoryTest extends \Codeception\Test\Unit
{
    public function _fixtures()
    {
        return [
            'category' => [
                'class' => CategoryFixture::class
            ],
        ];
    }

    public function testGetChildren()
    {
        $parentCat = Category::findOne(1);
        $childCat = $parentCat->children;

        verify($childCat)->arrayContainsEquals(Category::findOne(2));
    }

    public function testGetParent()
    {
        $childCat = Category::findOne(2);
        $parentCat = $childCat->parent;

        verify($parentCat)->equals(Category::findOne(1));
    }

    public function testInsertIncorrectName()
    {
        $model = new Category();
        $model->id = 100;
        $model->name = ['foo'];
        $model->description = 'asdasdasd';
        $model->status = 1;
        $model->parent_id = 1;

        verify($model->save())->false();
    }

    public function testInsertIncorrectDescription()
    {
        $model = new Category();
        $model->id = 101;
        $model->name = 'foo';
        $model->description = ['asdasdasd'];
        $model->status = 1;
        $model->parent_id = 1;

        verify($model->save())->false();
    }

    public function testInsertInexistingParentId()
    {
        $model = new Category();
        $model->id = 102;
        $model->name = 'foo';
        $model->description = 'asdasdasd';
        $model->status = 1;
        $model->parent_id = 100;

        verify($model->save())->false();
    }

    public function testInsertCorrect()
    {
        $model = new Category();
        $model->id = 103;
        $model->name = 'foo';
        $model->description = 'asdasdasd';
        $model->status = 1;
        $model->parent_id = 1;

        verify($model->save())->true();
    }
}