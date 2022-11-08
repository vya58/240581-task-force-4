<?php

use yii\widgets\ListView;

?>

<div class="pagination-wrapper">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_task',
        'pager' => [
            'prevPageLabel' => '',
            'nextPageLabel' => '',
            'pageCssClass' => 'pagination-item',
            'prevPageCssClass' => 'pagination-item mark',
            'nextPageCssClass' => 'pagination-item mark',
            'activePageCssClass' => 'pagination-item--active',
            'options' => ['class' => 'pagination-list'],
            'linkOptions' => ['class' => 'link link--page'],
            'options' => [
                'class' => 'pagination-list',
            ],
        ],
    ]) ?>
</div>