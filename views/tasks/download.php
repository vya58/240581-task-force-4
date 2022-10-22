<?php

echo Yii::$app->response->sendFile('../web/uploads/' . $path)->send();

?>
