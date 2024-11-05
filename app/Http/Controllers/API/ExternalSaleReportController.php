<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ExternalSaleReport\GetExternalSaleReportService;
use Illuminate\Http\Request;

class ExternalSaleReportController extends Controller
{

    protected $service;

    public function __construct(GetExternalSaleReportService $service)
    {
        $this->service = $service;
    }

    public function getReport(Request $request)
    {

        return $this->service->process($request->all());
    }
}
