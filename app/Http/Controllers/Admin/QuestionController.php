<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Test\Test;
use App\Entity\Test\TestQuestion;
use App\Entity\Test\TestQuestionAnswer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tests\TestQuestionRequest;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class QuestionController
 * @package App\Http\Controllers\Admin
 */
class QuestionController extends Controller
{
    /**
     * QuestionController constructor.
     */
    public function __construct()
    {
        $this->middleware('can:admin-panel');
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $testQuestions = TestQuestion::orderByDesc('id')->paginate(20);;

        return view('admin.questions.index', compact('testQuestions'));
    }

    /**
     * @param Test $test
     * @return Factory|View
     */
    public function create(Test $test)
    {
        return view('admin.questions.create', compact('test'));
    }

    /**
     * @param TestQuestionRequest $request
     * @param Test $test
     * @return RedirectResponse
     */
    public function store(TestQuestionRequest $request, Test $test)
    {
        $question = TestQuestion::create(
            [
                'test_id' => $request['test_id'],
                'title' => $request['title'],
                'type' => $request['type'],
            ]
        );

        return redirect()->route('admin.test.question.show', [$test, $question]);
    }

    /**
     * @param Test $test
     * @param TestQuestion $question
     * @return View
     */
    public function show(Test $test, TestQuestion $question)
    {
        $answers = TestQuestionAnswer::where('question_id', $question->id)->get();
        return view('admin.questions.show', compact(['question', 'test', 'answers']));
    }

    /**
     * @param Test $test
     * @param TestQuestion $question
     * @return Factory|View
     */
    public function edit(Test $test, TestQuestion $question)
    {
        return view('admin.questions.edit', compact(['test', 'question']));
    }

    /**
     * @param TestQuestionRequest $request
     * @param TestQuestion $question
     * @param Test $test
     * @return RedirectResponse
     */
    public function update(TestQuestionRequest $request, Test $test, TestQuestion $question)
    {
        $question->update(
            [
                'test_id' => $request['test_id'],
                'title' => $request['title'],
                'type' => $request['type'],
            ]
        );


        return redirect()->route('admin.test.question.show', [$test, $question]);
    }

    /**
     * @param Test $test
     * @param TestQuestion $testQuestion
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Test $test, TestQuestion $testQuestion)
    {
        $testQuestion->delete();

        return redirect()->route('admin.test.show', $test);
    }
}
