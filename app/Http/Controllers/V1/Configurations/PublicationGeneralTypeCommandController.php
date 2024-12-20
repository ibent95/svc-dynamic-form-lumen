<?php

namespace App\Http\Controllers\V1\Configurations;

use App\Http\Controllers\Controller;
use App\Services\CommonService;
use App\Services\PublicationGeneralTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

class PublicationGeneralTypeCommandController extends Controller
{
    private $router;
    private $request;
    private $commonSvc;
    private $publicationGeneralTypeSvc;

    private $responseData;
    private $responseStatusCode;
    private $log;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Router $router, Request $request, CommonService $commonSvc, PublicationGeneralTypeService $publicationGeneralTypeSvc)
    {
        $this->router       = $router;
        $this->request      = $request;
        $this->commonSvc    = $commonSvc;
        $this->publicationGeneralTypeSvc = $publicationGeneralTypeSvc;
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
        $this->responseData['message']  = 'Accessing the get of all publication forms configuration by general type UUID API!';

        try {
            $uuid = $this->request->input('uuid');
            $data = $this->request->all();

            /**
             * Create command
             */
            //if (!$uuid) {
            //    $publicationGeneralType = $this->publicationGeneralTypeSvc->create($data);
            //}

            /**
             * Update command
             */
            //if ($uuid) {
            //    $publicationGeneralType = $this->publicationGeneralTypeSvc->update($uuid, $data);
            //}

            $publicationGeneralType = $this->publicationGeneralTypeSvc->upsert([$data]);

            $this->responseData['data']     = $publicationGeneralType;

            //$this->responseStatusCode = 200;
            //$this->responseData['info']     = 'success';
            $this->responseData['message']  = 'Success on save the publication general type configurations API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message']);
        } catch (\Exception $e) {
            $this->responseStatusCode = 500;
            $this->responseData['info']     = 'error';
            $this->responseData['message']  = 'Error on save the publication general type configurations API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message'], [$e->getMessage(), $e->getFile(), $e->getLine()]);
        }

        return response()->json($this->responseData, $this->responseStatusCode);
    }

    public function disable(string $uuid): JsonResponse
    {
        return response()->json($this->responseData, $this->responseStatusCode);
    }

}
