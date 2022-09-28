<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for task filter form.
 * 
 * @property array TASK_PERIOD
 * @property string|array $categories
 * @property bool $distantWork
 * @property bool $noResponse
 * @property string|int $period
 */
class TaskFilterForm extends Model
{
    // Параметры фильтра отображения заданий в 'index.search-form' по прошедшему времени с момента объявления 
    public const TASK_PERIOD = [
        '1' => '1 час',
        '12' => '12 часов',
        '24' => '24 часа',
        '' => 'Все задания',
    ];

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

    /**
     * @param object TaskFilterForm - экземпляр класса TaskFilterForm
     * 
     * @return array $tasks - результат выборки
     */
    public function selectTasks(TaskFilterForm $tasksFilter): array
    {
        if (Yii::$app->request->getIsPost()) {
            $tasksFilter->load(Yii::$app->request->post());
        }

        $query = Task::find()
            ->filterWhere([
                'task_status' => Task::STATUS_NEW,
                'category_id' => $tasksFilter->categories,
            ]);

        if ($tasksFilter->distantWork) {
            $query->andWhere(
                ['task_latitude' => null]
            );
        }

        if ($tasksFilter->noResponse) {
            $query->andWhere(
                ['executor_id' => null]
            );
        }

        if ($tasksFilter->period) {
            $query->andWhere(
                'task_date_create >= NOW() - INTERVAL :period  HOUR',
                [':period' => $tasksFilter->period]
            );
        }

        $tasks = $query->orderBy(
            ['task_date_create' => SORT_DESC]
        )
            ->all();

        return $tasks;
    }
}
