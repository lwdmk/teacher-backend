<?php

namespace App\Entity\Test;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property integer $question_id
 * @property string $text
 * @property integer $type
 * @property boolean $is_right
 * @property integer $link_to_right
 *
 * @property TestQuestion $question
 * @property TestQuestionAnswer $linkedAnswer
 */
class TestQuestionAnswer extends Model
{
    protected $table = 'test_question_answer';
}
