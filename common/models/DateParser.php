<?php

namespace common\models;

trait DateParser
{
    public function parseTime($time)
    {
        $timeArr = explode(' - ', $time);

        return $timeArr;
    }
}