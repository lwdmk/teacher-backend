<?php

namespace App\Managers\Tests;

use App\Entity\Test\Test;
use App\Entity\Test\TestAttempt;
use App\Entity\Test\TestQuestion;
use App\Entity\Test\TestQuestionAnswer;
use App\Entity\User\User;
use App\Exceptions\ApplicationLogicException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TestManager
 */
class TestManager
{
    /**
     * @param string $hash
     * @param Test $test
     * @param $data
     * @throws ApplicationLogicException
     */
    public function start(string $hash, Test $test, $data)
    {
        if (TestAttempt::uncompletedByHash($hash)->exists()) {
            throw new ApplicationLogicException('Started test exists');
        }

        $attempt = new TestAttempt();
        $attempt->test_id = $test->id;
        $attempt->hash = $hash;
        $attempt->name = ($data['name'] ?? '') . ' ' . ($data['surname'] ?? '');
        $attempt->score = 0;
        $attempt->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $attempt->ended_at = Carbon::now()->addSeconds($test->duration);
        $attempt->data = json_encode([]);
        $attempt->save();
    }

    /**
     * @param string $hash
     * @param Test $test
     * @param array $data
     * @throws ApplicationLogicException
     */
    public function autosave(string $hash, Test $test, array $data)
    {
        $attempt = TestAttempt::uncompletedByHash($hash)
            ->where('test_id', $test->id)
            ->first();

        if (!$attempt) {
            throw new ApplicationLogicException('Nothing to save');
        }

        $attempt->data = $data;
        $attempt->save(['data']);
    }

    /**
     * @param string $hash
     * @param Test $test
     * @param array $data
     * @throws ApplicationLogicException
     */
    public function findAndComplete(string $hash, Test $test, array $data)
    {
        /** @var TestAttempt $attempt */
        $attempt = TestAttempt::uncompletedByHash($hash)
            ->where('test_id', $test->id)
            ->first();

        if (!$attempt) {
            throw new ApplicationLogicException('Nothing to complete');
        }
        $this->complete($attempt, $test, $data);
    }

    /**
     * @param TestAttempt $attempt
     * @param Test $test
     * @param array $data
     */
    public function complete(TestAttempt $attempt, Test $test, array $data)
    {
        [$checkedData, $score] = $this->checkTest($test, $data);
        $attempt->data = $checkedData;
        $attempt->score = $score;
        $attempt->completed_at = Carbon::now()->format('Y-m-d H:i:s');
        $attempt->save();
    }

    /**
     * @param string $hash
     * @param Test $test
     * @return mixed
     * @throws ApplicationLogicException
     */
    public function continueAttempt(string $hash, Test $test)
    {
        $attempt = TestAttempt::uncompletedByHash($hash)
            ->where('test_id', $test->id)
            ->first();

        if (!$attempt) {
            throw new ApplicationLogicException('Nothing to complete');
        }

        return $attempt->data;
    }

    /**
     * @param Test $test
     * @param $data
     * @return array
     */
    public function checkTest(Test $test, $data)
    {
        $userResult = $data['questions'] ?? [];
        $checkedResult = [];
        $score = 0;
        $scoreData = ['right' => 0, 'from' => 0];

        /** @var TestQuestion $question */
        foreach ($test->questions as $question) {
            $scoreData['from']++;
            $isCorrect = false;
            /** @var Collection $rightAnswers */
            $rightAnswers = $question->answers->filter(
                function (TestQuestionAnswer $answer) {
                    return $answer->is_right;
                }
            );
            $userAnswer = $userResult[$question->id] ?? null;
            switch ($question->type) {
                case TestQuestion::TYPE_ONE_ANSWER_FROM_ROW:
                case TestQuestion::TYPE_MULTIPLE_ANSWERS_FROM_ROW:
                {
                    $rightAnswersIds = $rightAnswers->map(
                        function ($item) {
                            return $item->id;
                        }
                    )->toArray();
                    if(is_array($userAnswer)) {
                        $isCorrect = empty(array_diff($rightAnswersIds, $userAnswer));
                    }

                    $checkedResult[$question->id] = [
                        'rightAnswers' => $rightAnswersIds,
                        'isQuestionAnswered' => !is_null($userAnswer),
                        'userAnswer' => $userAnswer,
                        'isCorrect' => $isCorrect
                    ];
                    break;
                }
                case TestQuestion::TYPE_WRITE_AN_ANSWER:
                {
                    /** @var TestQuestionAnswer $answer */
                    $answer = $rightAnswers->first(
                        function ($item) {
                            return $item->is_right;
                        }
                    );
                    if (is_string($userAnswer)) {
                        $userAnswerText = mb_strtolower($userAnswer);
                        $userAnswerText = implode(',', array_map(function ($item) {
                            return trim($item);
                        }, explode(',', $userAnswerText)));

                        $answerText = mb_strtolower($answer->text);
                        $answerText = implode(',', array_map(function ($item) {
                            return trim($item);
                        }, explode(',', $answerText)));
                        $isCorrect = $answerText == $userAnswerText;
                    }
                    $checkedResult[$question->id] = [
                        'rightAnswers' => $answer->text,
                        'isQuestionAnswered' => !is_null($userAnswer),
                        'userAnswer' => $userAnswer,
                        'isCorrect' => $isCorrect
                    ];
                    break;
                }
                case TestQuestion::TYPE_RECOVER_AN_ORDER: {
                    $answerArray = [];
                    foreach ($rightAnswers as $rightAnswer) {
                        $answerArray[$rightAnswer->id] = $rightAnswer->is_right;
                    }
                    if (is_array($userAnswer)) {
                        $isEqual = true;
                        if (count($userAnswer) !== count($answerArray)) {
                            $isEqual = false;
                        }
                        foreach ($userAnswer as $key => $value) {
                            if(!array_key_exists($key, $answerArray)
                                || $answerArray[$key] != $value) {
                                $isEqual = false;
                                break;
                            }
                        }
                        $isCorrect = $isEqual;
                    }

                    $checkedResult[$question->id] = [
                        'rightAnswers' => $answerArray,
                        'isQuestionAnswered' => !is_null($userAnswer),
                        'userAnswer' => $userAnswer,
                        'isCorrect' => $isCorrect
                    ];
                }
            }
            if ($isCorrect) {
                $scoreData['right']++;
            }
        }

        if ($scoreData['from'] > 0) {
            $score = round(($scoreData['right'] / $scoreData['from']) * 100);
        }

        $result['questions'] = $userResult;
        $result['checkedResult'] = $checkedResult;
        $result['checkDate'] = Carbon::now()->format('Y-m-d H:i:s');

        return [$result, $score];
    }
}
