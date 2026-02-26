<?php

namespace App\Jobs;

use App\Actions\ProcessDiseaseFile;
use App\Mail\DiseaseImportSummary;
use App\Models\Disease;
use App\Models\SummaryReport;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessDiseaseImport implements ShouldQueue
{
    use Queueable;

    public $tries = 2;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $path, 
        private SummaryReport $report,
        private User $user
    )
    {
        //
    }
    

    /**
     * Execute the job.
     */ 
    public function handle()
    {
        $this->report->update(['status' => 'processing']);
        $result = ProcessDiseaseFile::process($this->path, $this->user);
        $this->report->update([
            'status' => 'completed',
            'response_data' => $result,
            'completed_at' => now(),
        ]);
        $mail_to = config('mail.to.address');
        if (empty($mail_to)) {
            Log::warning('No mail recipient configured for Disease Import Summary email.');
            return;
        }
        Mail::to($mail_to)->send(new DiseaseImportSummary(
            $result['total_processed'], 
            $result['total_inserted'], 
            $result['total_failed'],
            $result['failed_rows']
        ));
    }


    function failed(\Throwable $exception)
    {
        Log::error('Disease import job failed:', [
            'error' => $exception->getMessage(),
            'report_id' => $this->report->id,
        ]);
        $this->report->update(['status' => 'failed', 'failed_at' => now()]);
    }
}
