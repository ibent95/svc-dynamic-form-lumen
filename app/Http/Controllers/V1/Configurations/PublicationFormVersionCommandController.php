<?php

namespace App\Http\Controllers\V1\Configurations;

use App\Http\Controllers\Controller;
use App\Services\CommonService;
use App\Services\PublicationFormVersionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

class PublicationFormVersionCommandController extends Controller
{
    private $router;
    private $request;
    private $commonSvc;
    private $publicationFormVersionSvc;

    private $responseData;
    private $responseStatusCode;
    private $log;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Router $router, Request $request, CommonService $commonSvc, PublicationFormVersionService $publicationFormVersionSvc)
    {
        $this->router       = $router;
        $this->request      = $request;
        $this->commonSvc    = $commonSvc;
        $this->publicationFormVersionSvc = $publicationFormVersionSvc;
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
        $this->responseStatusCode = 200;
        $this->responseData['info']     = 'success';
        $this->responseData['message']  = 'Accessing the get of all publication forms configuration by form version UUID API!';

        try {
            $uuid = $this->request->input('uuid');
            $data = $this->request->all();

            /**
             * Create command
             */
            //if (!$uuid) {
            //    $publicationFormVersion = $this->publicationFormVersionSvc->create($data);
            //}

            /**
             * Update command
             */
            //if ($uuid) {
            //    $publicationFormVersion = $this->publicationFormVersionSvc->update($uuid, $data);
            //}

            $publicationFormVersion = $this->publicationFormVersionSvc->upsert([$data]);

            $this->responseData['data']     = $publicationFormVersion;

            //$this->responseStatusCode = 200;
            //$this->responseData['info']     = 'success';
            $this->responseData['message']  = 'Success on save the publication form version configurations API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message']);
        } catch (\Exception $e) {
            $this->responseStatusCode = 500;
            $this->responseData['info']     = 'error';
            $this->responseData['message']  = 'Error on save the publication form version configurations API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message'], [$e->getMessage(), $e->getFile(), $e->getLine()]);
        }

        return response()->json($this->responseData, $this->responseStatusCode);
    }

    public function disable(string $uuid): JsonResponse
    {
        return response()->json($this->responseData, $this->responseStatusCode);
    }

}
