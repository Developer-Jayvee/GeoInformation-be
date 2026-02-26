<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\APIService;

class APIController extends Controller
{

    protected $apiService;
    public function __construct(APIService $apiService) {
        $this->apiService = $apiService;
    }

    public function index(Request $request)
    {
        try {
            return $this->apiService->fetchGeoInfo();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
