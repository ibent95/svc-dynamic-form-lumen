<?php

/**
 * Controller for query of Main context
 */

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\CommonService;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Router;

class MainQueryController extends Controller
{
    private $router;
    private $commonSvc;

    private $responseData;
    private $responseStatusCode;
    private $log;

    public function __construct(Router $router, CommonService $commonSvc)
    {
        $this->router       = $router;
        $this->commonSvc    = $commonSvc;
        $this->responseData = [
            'info'      => '',
            'message'   => '',
            'data'      => [],
        ];
        $this->responseStatusCode = 400;
        $this->log          = [
            'message' => 'Info',
            'context' => []
        ];
    }

    public function index() : JsonResponse
    {
        $appVersion = $this->router->app->version();
        $this->responseData['info']     = 'success';
        $this->responseData['message']  = 'Welcome to Dynamic Form service with Laravel Lumen ' . $appVersion . '.';
        $this->responseData['data']     = [
            'message'   => 'Welcome to Dynamic Form service with Laravel Lumen ' . $appVersion . '.',
            'date'      => date('Y-m-d'),
        ];

        $this->responseStatusCode = 200;

        $this->commonSvc->setLogger('info', $this->responseData['message']);

        return response()->json($this->responseData, $this->responseStatusCode);
    }

}