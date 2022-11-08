<?php

use \yii\helpers\Url;
use app\widgets\ActiveMenuWidget;

?>

<h3 class="head-main head-task">Настройки</h3>
<ul class="side-menu-list">
    <li class="side-menu-item <?= ActiveMenuWidget::widget(['links' => [Url::to('/user/edit/' . Yii::$app->user->identity->id), Url::to('/user/edit')], 'active' =>  'side-menu-item--active']) ?>">
        <a href="<?= Url::to('user/edit/' . Yii::$app->user->identity->id) ?>" class="link link--nav">Мой профиль</a>
    </li>
    <li class="side-menu-item <?= ActiveMenuWidget::widget(['links' => [Url::to('/user/set/' . Yii::$app->user->identity->id)], 'active' =>  'side-menu-item--active']) ?>">
        <a href="<?= Url::to('user/set/' . Yii::$app->user->identity->id) ?>" class="link link--nav">Безопасность</a>
    </li>
</ul>