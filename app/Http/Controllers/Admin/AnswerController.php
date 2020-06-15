<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Test\Test;
use App\Entity\Test\TestQuestion;
use App\Exceptions\ApplicationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tests\TestQuestionAnswerRequest;
use App\Managers\Tests\AnswerManager;
use Illuminate\Http\RedirectResponse;

class AnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-panel');
    }

    /**
     * @param TestQuestionAnswerRequest $request
     * @param Test $test
     * @param TestQuestion $question
     * @param AnswerManager $answerService
     * @return RedirectResponse
     */
    public function store(
        TestQuestionAnswerRequest $request,
        Test $test,
        TestQuestion $question,
        AnswerManager $answerService
    ) {
        try {
            $answerService->saveOrUpdateByRequest($request);
        } catch (ApplicationException $exception) {
            return redirect(route('admin.test.question.show', [$test, $question]))
                ->withErrors(['general_error', $exception->getMessage()]);
        }
        return redirect()->route('admin.test.question.show', [$test, $question]);
    }
}
