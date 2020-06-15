<?php

namespace App\Managers\Tests;

use App\Entity\Test\TestQuestion;
use App\Entity\Test\TestQuestionAnswer;
use App\Exceptions\ApplicationLogicException;
use App\Http\Requests\Admin\Tests\TestQuestionAnswerRequest;

/**
 * Class AnswerService
 */
class AnswerManager
{
    /**
     * @param TestQuestionAnswerRequest $testQuestionAnswerRequest
     * @throws ApplicationLogicException
     */
    public function saveOrUpdateByRequest(TestQuestionAnswerRequest $testQuestionAnswerRequest)
    {
        $data = $testQuestionAnswerRequest->all();

        $question = TestQuestion::find($data['question_id']);
        if (!$question) {
            throw new ApplicationLogicException('Question not found');
        }
        foreach ($data['answer'] as $id => $dataAnswer) {
            $answerId = $data['new_value'] == 1 ? null : $id;
            $answerEntity = TestQuestionAnswer::findOrNew($answerId);
            if ($answerEntity->exists && $answerEntity->question_id !== $question->id) {
                throw new ApplicationLogicException('Question and answer mismatch');
            }
            $answerEntity->question_id = $question->id;
            $answerEntity->text = $dataAnswer['title'];
            if ($question->type == TestQuestion::TYPE_RECOVER_AN_ORDER) {
                $answerEntity->is_right = $dataAnswer['is_right'];
            } else {
                $answerEntity->is_right = in_array($id, $data['answer_is_right'] ?? []);
            }

            if (!$answerEntity->save()) {
                throw new ApplicationLogicException('Failed to save answer with text: ' . $dataAnswer['title']);
            }
        }
    }
}
