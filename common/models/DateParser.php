<?php

namespace common\models;

use yii\db\Query;

trait DateParser
{
    /**
     * @param $time
     * @return false|string[]
     *
     * takes a range string, returns array. [0] - starting date, [1] - ending date
     */
    public function explodeTime($time)
    {
        $timeArr = explode(' - ', $time);

        return $timeArr;
    }

    /**
     * @param $range - String you receive from DatePicker, dates separated by ' - '
     * @param $colName - name of the column you are filtering
     * @param Query $query - search Query you are altering
     * @return void
     *
     * Method to apply filter of dates from DatePicker`s request string
     */
    public function filterDate($range, $colName, Query $query){
        if ($range){
            $arrRange = $this->explodeTime($range);
            $after = $arrRange[0];
            $before = $arrRange[1];

            $query->andFilterWhere(['>=', $colName, $after]);
            $query->andFilterWhere(['<=', $colName, $before]);
        }
    }
}