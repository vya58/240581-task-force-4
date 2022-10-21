<?php

$this->title = 'Скачать';

echo Yii::$app->response->sendFile('../web/uploads/' . $path)->send();

?>
