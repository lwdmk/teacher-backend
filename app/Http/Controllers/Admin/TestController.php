<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Test\Test;
use App\Entity\Test\TestAttempt;
use App\Entity\Test\TestQuestion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tests\TestRequest;
use App\Managers\Tests\TestManager;

class TestController extends Controller
{
    /**
     * @var TestManager
     */
    private $testManager;

    /**
     * TestController constructor.
     * @param TestManager $testManager
     */
    public function __construct(TestManager $testManager)
    {
        $this->middleware('can:admin-panel');
        $this->testManager = $testManager;
    }

    public function index()
    {
        $tests = Test::orderByDesc('id')->paginate(20);;

        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        return view('admin.tests.create');
    }

    public function store(TestRequest $request)
    {
        $test = Test::create(
            [
                'title' => $request['title'],
                'type' => $request['type'],
                'grade' => $request['grade'],
                'duration' => $request['duration'] * 60,
                'short' => $request['short'],
                'description' => $request['description']
            ]
        );

        return redirect()->route('admin.test.show', $test);
    }

    public function show(Test $test)
    {
        $questions = TestQuestion::where('test_id', $test->id)->get();
        return view('admin.tests.show', compact(['test', 'questions']));
    }

    public function edit(Test $test)
    {
        return view('admin.tests.edit', compact('test'));
    }

    /**
     * @param TestRequest $request
     * @param Test $test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TestRequest $request, Test $test)
    {
        $test->update(
            [
                'title' => $request['title'],
                'type' => $request['type'],
                'grade' => $request['grade'],
                'duration' => $request['duration'] * 60,
                'short' => $request['short'],
                'description' => $request['description']
            ]
        );

        return redirect()->route('admin.test.show', $test);
    }

    /**
     * @param Test $test
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Test $test)
    {
        $test->delete();

        return redirect()->route('admin.test.index');
    }

    public function attempts(Test $test)
    {
        $attempts = TestAttempt::byTest($test)->paginate(20);

        return view(
            'admin.tests.attempts',
            compact(
                'test',
                'attempts'
            )
        );
    }

    /**
     * @param Test $test
     * @param TestAttempt $attempt
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\ApplicationLogicException
     */
    public function attempt(Test $test, TestAttempt $attempt)
    {
        if ($attempt->isNotCompleted()) {
            redirect(back())->with('error', 'Тест не завершен');
        }
        if ($attempt->isExpired()) {
            $this->testManager->complete($attempt, $test, json_decode($attempt->data, true));
        }

        $attempt = $attempt->refresh();
        $questionsById = [];
        foreach ($test->questions as $question) {
            $questionsById[$question->id] = $question;
        }
        $resultData = json_decode($attempt->data, true);

        return view(
            'admin.tests.attempt',
            compact(
                'attempt',
                'resultData',
                'questionsById',
                'test'
            )
        );
    }
}
