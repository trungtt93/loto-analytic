<?php

namespace App\Http\Controllers;

use App\Services\CrawlerService;
use Illuminate\Http\Request;

class CrawlerController extends Controller
{
    public function __construct(private readonly CrawlerService $crawlerService)
    {
    }

    public function index(Request $request): mixed
    {
        $days = $request->query('days', 1);
        $data = $this->crawlerService->fetchData($days);
        return $this->responseSuccess($data);
    }
}
