<?php

namespace App\Http\Controllers\Api;

use App\Entity\Test\Test;
use App\Entity\User\User;
use App\Exceptions\ApplicationLogicException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Tests\AutosaveTestRequest;
use App\Http\Requests\Api\Tests\StartTestRequest;
use App\Http\Resources\TestDetails;
use App\Http\Resources\TestListItem;
use App\Managers\Tests\TestManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class TestController
 * @package App\Http\Controllers\Api
 */
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
        $this->testManager = $testManager;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $tests = Test::query()->paginate((int)$request->get('perPage', 20));

        return TestListItem::collection($tests);
    }

    /**
     * @param string $hash
     * @param Test $test
     * @return JsonResponse
     */
    public function continue(string $hash, Test $test)
    {
        try {
            $attemptData = $this->testManager->continueAttempt($hash, $test);
        } catch (ApplicationLogicException $applicationLogicException) {
            abort(400, $applicationLogicException->getMessage());
        }
        return new JsonResponse($attemptData ?? []);
    }

    /**
     * @param StartTestRequest $startTestRequest
     * @param Test $test
     * @return JsonResponse
     */
    public function start(StartTestRequest $startTestRequest, Test $test)
    {
        try {
            /** @var User $user */
            $this->testManager->start(
                $startTestRequest->get('hash'),
                $test,
                [
                    'name' => $startTestRequest->get('name'),
                    'surname' => $startTestRequest->get('surname')
                ]
            );
            return (new TestDetails($test))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (ApplicationLogicException $applicationLogicException) {
            abort(400, $applicationLogicException->getMessage());
        }
    }

    /**
     * @param string $hash
     * @param AutosaveTestRequest $autosaveTestRequest
     * @param Test $test
     * @return JsonResponse
     */
    public function autosave(string $hash, AutosaveTestRequest $autosaveTestRequest, Test $test)
    {
        try {
            /** @var User $user */
            $this->testManager->autosave($hash, $test, json_decode($autosaveTestRequest->get('data'), true));
            return (new JsonResponse(null, Response::HTTP_CREATED));
        } catch (ApplicationLogicException $applicationLogicException) {
            abort(400, $applicationLogicException->getMessage());
        }
    }

    /**
     * @param string $hash
     * @param AutosaveTestRequest $autosaveTestRequest
     * @param Test $test
     * @return JsonResponse
     */
    public function complete(string $hash, AutosaveTestRequest $autosaveTestRequest, Test $test)
    {
        try {
            /** @var User $user */
            $this->testManager->findAndComplete($hash, $test, json_decode($autosaveTestRequest->get('data'), true));
            return (new JsonResponse(null, Response::HTTP_CREATED));
        } catch (ApplicationLogicException $applicationLogicException) {
            abort(400, $applicationLogicException->getMessage());
        }
    }
}
