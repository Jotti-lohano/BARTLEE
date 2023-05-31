<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\JsonResponseService;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MainController
 * @package App\Http\Controllers
 */
class MainApiController extends Controller
{
    /**
     * @var \App\Services\JsonResponseService
     */
    protected $response;

    /**
     * number of pagination
     * @var int
     */
    protected $pagination;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->response = new JsonResponseService;
        $requestPerPage = request('per_page', config('app.pagination'));
        app()->setLocale(request('lang') ? request('lang') : 'en');
        $this->pagination = $requestPerPage > 100 ? 100 : $requestPerPage;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        return $this->response->fail([], 400, Response::HTTP_NOT_FOUND);
    }
}
