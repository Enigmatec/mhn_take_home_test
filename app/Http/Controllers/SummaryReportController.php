<?php

namespace App\Http\Controllers;

use App\Models\SummaryReport;
use Illuminate\Http\Request;

class SummaryReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, SummaryReport $summaryReport)
    {
        return response()->json([
            'status' => true, 
            'message' => 'Summary report retrieved successfully.',
            'data' => $summaryReport->only('uuid', 'response_data', 'status', 'completed_at')
        ]);
    }
}
