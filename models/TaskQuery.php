<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Task]].
 *
 * @see Task
 */
class TaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * Функция выборки заданий, выполненных конкретным исполнителем
     * @param int $id - executor_id (id исполнителя)
     * 
     * @return array - результат выборки
     */
    public static function selectExecutorTasks(int $id, string $taskStatus = '')
    {
        return Task::find()
            ->filterWhere([
                'executor_id' => $id,
                'task_status' => $taskStatus,
            ])
            ->all();
    }

    /**
     * Функция выборки параметров нового задания
     * 
     * @return array - результат выборки
     */
    public function selectNewTasks(): array
    {
        $query = Task::find()
            ->filterWhere([
                'task_status' => Task::STATUS_NEW,
                'category_id' => $this->categories,
            ]);

        if ($this->distantWork) {
            $query->andWhere(
                ['task_latitude' => null],
            );
        }

        if ($this->noResponse) {
            $query->andWhere(
                ['executor_id' => null],
            );
        }

        if ($this->period) {
            $query->andWhere(
                'task_date_create >= NOW() - INTERVAL :period  HOUR',
                [':period' => $this->period],
            );
        }

        return $query->orderBy(
            ['task_date_create' => SORT_DESC],
        )
            ->all();
    }

    /**
     * {@inheritdoc}
     * @return Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
