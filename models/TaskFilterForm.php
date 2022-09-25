<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for task filter form.
 *
 * @property string|array $categories
 * @property bool $distantWork
 * @property bool $noResponse
 * @property string|int $period
 */
class TaskFilterForm extends Model
{
    public string|array $categories = '';
    public bool $distantWork = false;
    public bool $noResponse = false;
    public string|int $period = '';

    /**
     * {@inheritdoc}
     */
    public function formName()
    {
        return 'taskFilterForm';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'distantWork' => 'Удаленная работа',
            'noResponse' => 'Без откликов',
            'period' => 'Период',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                [
                    'categories',
                    'distantWork',
                    'noResponse',
                    'period'
                ],
                'safe'
            ]
        ];
    }
}
