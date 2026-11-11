<?php

namespace App\Http\Controllers;

use App\Services\AIStudentSuccessService;
use Illuminate\Http\Request;

class AIInsightsController extends Controller
{
    public function index(AIStudentSuccessService $aiService)
    {
        $diagnostics = $aiService->getSchoolDiagnostics();
        return view('ai.index', compact('diagnostics'));
    }
}
