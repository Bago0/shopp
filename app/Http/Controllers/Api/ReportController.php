<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\services\ReportServiceInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportServiceInterface $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        $summary = $this->reportService->index();

        return response()->json($summary);
    }
}
