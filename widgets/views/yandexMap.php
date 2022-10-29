<?php

use yii\helpers\Html;

?>

<div id='map' class='username' style='width: 725px; height: 346px' data-latitude='<?= Html::encode($task->task_latitude) ?>' , data-longitude='<?= Html::encode($task->task_longitude) ?>'></div>

<p class='map-address town'><?= Html::encode($location['city']) ?></p>
<p class='map-address'><?= Html::encode($location['adress']) ?></p>