<?php

namespace App\Entity\Test;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property integer $test_id
 * @property string $title
 * @property integer $type
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Test $test
 * @property Collection $answers
 */
class TestQuestion extends Model
{
    public const TYPE_ONE_ANSWER_FROM_ROW = 1;
    public const TYPE_MULTIPLE_ANSWERS_FROM_ROW = 2;
    public const TYPE_WRITE_AN_ANSWER = 3;
    public const TYPE_RECOVER_AN_ORDER = 4;
    public const TYPE_MAKE_LINKS = 5;
    public const TYPE_WRITE_ESSAY = 6;

    /**
     * @return array
     */
    public static function getTypesList(): array
    {
        return [
            self::TYPE_ONE_ANSWER_FROM_ROW => 'Вопрос с одним вариантом ответа',
            self::TYPE_MULTIPLE_ANSWERS_FROM_ROW => 'Вопрос с несколькими возможными вариантами',
            self::TYPE_WRITE_AN_ANSWER => 'Впишите ответ',
            self::TYPE_RECOVER_AN_ORDER => 'Востановить порядок следования',
        ];
    }

    /**
     * @var array
     */
    public $fillable = ['title', 'type', 'test_id'];

    /**
     * @var string
     */
    protected $table = 'test_question';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(TestQuestionAnswer::class, 'question_id', 'id');
    }

}
