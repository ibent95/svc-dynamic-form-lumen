<?php

namespace App\Http\Controllers\V1\Configurations;

use App\Http\Controllers\Controller;
use App\Services\CommonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

class PublicationFormVersionCommandController extends Controller
{
    private $router;
    private $request;
    private $commonSvc;

    private $responseData;
    private $responseStatusCode;
    private $log;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Router $router, Request $request, CommonService $commonSvc)
    {
        $this->router       = $router;
        $this->request      = $request;
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

    public function save(): JsonResponse
    {
        return response()->json($this->responseData, $this->responseStatusCode);
    }

    public function disable(string $uuid): JsonResponse
    {
        return response()->json($this->responseData, $this->responseStatusCode);
    }

}
