<?php



$this->registerJsFile('/js/goods_audio.js');
//$this->registerJsFile("https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js");


echo \yii\helpers\Html::button('Record', ['id' => 'btnStart']);
echo '<br>';
echo \yii\helpers\Html::button('Stop recording', ['id' => 'btnStop']);
echo '<audio>';
