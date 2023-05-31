<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\JsonResponseService;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
