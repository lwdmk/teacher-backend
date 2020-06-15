<?php

namespace App\Http\Resources;

use App\Entity\Test\Test;
use App\Entity\Test\TestQuestion;
use App\Entity\Test\TestQuestionAnswer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TestDetails
 * @package App\Http\Resources
 */
class TestDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Test $test */
        $test = $this;
        return [
            'id' => $test->id,
            'title' => $test->title,
            'type' => $test->type,
            'grade' => $test->grade,
            'duration' => $test->duration,
            'questions' => $test->questions->map(
                function (TestQuestion $testQuestion) {
                    return [
                        'id' => $testQuestion['id'],
                        'title' => $testQuestion['title'],
                        'type' => $testQuestion['type'],
                        'answers' => $testQuestion->answers->map(
                            function (TestQuestionAnswer $answer) {
                                return [
                                    'id' => $answer->id,
                                    'type' => $answer->type,
                                    'text' => $answer->text,
                                ];
                            }
                        )
                    ];
                }
            ),
        ];
    }
}
