<?php

use yii\helpers\Html;
use \yii\helpers\Url;

?>

<?= Html::a('Принять', Url::to(['tasks/accept', 'respond_id' => $response->respond_id]), ['class' => "button button--blue button--small"]) ?>
        
<?= Html::a('Отказать', Url::to(['tasks/reject', 'respond_id' => $response->respond_id]), ['class' => "button button--orange button--small"]) ?>