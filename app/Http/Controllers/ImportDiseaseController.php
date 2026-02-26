<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessDiseaseImport;
use App\Models\SummaryReport;
use Illuminate\Http\Request;

class ImportDiseaseController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['file' => ['required', 'mimes:csv,txt', 'max:2048']]);

        $user = $request->user();

        $path = $request->file('file')->store('disease_imports');
        $report = SummaryReport::create(['file_path' => $path]);

        ProcessDiseaseImport::dispatch($path, $report, $user);
        return response()->json([
            'status' => true, 
            'message' => 'File uploaded successfully. The import process has been started and you will receive an email summary once it is completed and you can use the report ID to track the import process/response.',
            'report_id' => $report->uuid
        ], 202);

    }


    
}
