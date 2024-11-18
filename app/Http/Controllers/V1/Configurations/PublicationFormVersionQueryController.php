<?php

namespace App\Http\Controllers\V1\Configurations;

use App\Http\Controllers\Controller;
use App\Services\CommonService;
use App\Services\PublicationFormVersionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

class PublicationFormVersionQueryController extends Controller
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

    public function index(): JsonResponse
    {
        $appVersion = $this->router->app->version();
        $this->responseData['info']     = 'success';
        $this->responseData['message']  = 'Success to access the publication form versions configuration API!';
        $this->responseData['data']     = [
            'message'   => 'Welcome to publication form versions configuration API!',
            'date'      => date('Y-m-d'),
        ];

        $this->responseStatusCode = 200;

        $this->commonSvc->setLogger('info', $this->responseData['message']);

        return response()->json($this->responseData, $this->responseStatusCode);
    }

    public function getAll(): JsonResponse
    {
        $this->responseStatusCode = 200;
        $this->responseData['info']     = 'success';
        $this->responseData['message']  = 'Accessing the get of all publication form versions configuration API!';

        try {
            $publicationFormVersions = $this->publicationFormVersionSvc->getAll([], [], ['flag_active', 'create_user', 'created_at', 'update_user', 'updated_at']);
            $publicationFormVersionsCount = $this->publicationFormVersionSvc->getCount();

            $this->responseData['data']     = $publicationFormVersions;
            $this->responseData['count']    = $publicationFormVersionsCount;

            //$this->responseStatusCode = 200;
            //$this->responseData['info']     = 'success';
            $this->responseData['message']  = 'Success on access the publication form versions configuration API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message']);
        } catch (\Exception $e) {
            $this->responseStatusCode = 500;
            $this->responseData['info']     = 'error';
            $this->responseData['message']  = 'Error on access the publication form versions configuration API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message'], [$e->getMessage(), $e->getFile(), $e->getLine()]);
        }

        return response()->json($this->responseData, $this->responseStatusCode);
    }

    public function getFormsByUuid(string $uuid): JsonResponse
    {
        $this->responseStatusCode = 200;
        $this->responseData['info']     = 'success';
        $this->responseData['message']  = 'Accessing the get of all publication forms configuration by form version UUID API!';

        try {
            $publicationForms = $this->publicationFormVersionSvc->getFormsByUuid(
                $uuid, [], ['publicationForms.formParent'],
                [
                    'create_user',
                    'created_at',
                    'update_user',
                    'updated_at'
                ],
                ['flag_active']
            );
            $publicationFormsCount = $this->publicationFormVersionSvc->getCount();

            $this->responseData['data']     = $publicationForms;
            $this->responseData['count']    = $publicationFormsCount;

            //$this->responseStatusCode = 200;
            //$this->responseData['info']     = 'success';
            $this->responseData['message']  = 'Success on access the publication forms configuration by form version UUID API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message']);
        } catch (\Exception $e) {
            $this->responseStatusCode = 500;
            $this->responseData['info']     = 'error';
            $this->responseData['message']  = 'Error on access the publication forms configuration by form version UUID API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message'], [$e->getMessage(), $e->getFile(), $e->getLine()]);
        }

        return response()->json($this->responseData, $this->responseStatusCode);
    }

    public function detail(string $uuid): JsonResponse
    {
        $this->responseStatusCode = 200;
        $this->responseData['info']     = 'success';
        $this->responseData['message']  = 'Accessing the get of all publication form versions configuration API!';

        try {
            $publicationFormVersion        = $this->publicationFormVersionSvc
                ->getOne($uuid, [], ['publicationForms.formParent'], ['create_user', 'created_at', 'update_user', 'updated_at'], ['flag_active']);

            if (!$publicationFormVersion) {
                throw new \Exception("Publication form version configuration is not found!", 404);
            }

            $this->responseData['data']     = $publicationFormVersion;

            $this->responseData['message']  = 'Success on access the publication form versions configuration API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message']);
        } catch (\Exception $e) {
            $this->responseStatusCode = 500;
            $this->responseData['info']     = 'error';
            $this->responseData['message']  = 'Error on access the publication form versions configuration API!';
            $this->commonSvc->setLogger($this->responseData['info'], $this->responseData['message'], [$e->getMessage(), $e->getFile(), $e->getLine()]);
        }

        return response()->json($this->responseData, $this->responseStatusCode);
    }

}
