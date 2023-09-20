<?php

namespace backend\controllers;

use common\models\FrontendUser;
use yii\db\Query;
use yii\filters\AccessControl;

class FrontendUserController extends \yii\web\Controller
{
    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'actions' => ['index', 'view', 'user-list'],
//                        'allow' => true,
//                        'roles' => ['frontend_users_read'],
//                    ],
//                    [
//                        'actions' => ['create', 'update'],
//                        'allow' => true,
//                        'roles' => ['frontend_users_write']
//                    ],
//                ],
//            ],
        ];
    }


    public function actionUserList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('frontend_users')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => FrontendUser::find($id)->name];
        }

        return $out;
    }
}