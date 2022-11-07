<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\Task;
use app\models\exceptions\DataSaveException;

class CompleteForm extends Model
{
    public $taskId;
    public $review;
    public $grade;

    private const MIN_GRADE = 0;
    private const MAX_GRADE = 5;

    public function rules()
    {
        return [
            [['taskId', 'review', 'grade'], 'required'],
            [['taskId'], 'exist', 'targetClass' => Task::class, 'targetAttribute' => ['taskId' => 'task_id']],
            [['grade'], 'compare', 'compareValue' => self::MIN_GRADE, 'operator' => '>', 'type' => 'number'],
            [['grade'], 'compare', 'compareValue' => self::MAX_GRADE, 'operator' => '<=', 'type' => 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'review' => 'Ваш комментарий',
            'grade' => 'Оценка работы',
        ];
    }

    public function createComplete()
    {
        $review = Task::findOne(['task_id' => $this->taskId]);
        $review->review = $this->review;
        $review->grade = $this->grade;
        $review->date_completion = date("Y-m-d H:i:s");
        $review->task_status = Task::STATUS_PERFORMED;

        if (!$review->save()) {
            throw new DataSaveException('Ошибка сохранения отзыва');
        }
        return  $review;
    }
}
