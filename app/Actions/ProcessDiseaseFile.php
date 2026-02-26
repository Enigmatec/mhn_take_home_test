<?php

namespace App\Actions;

use App\Models\Disease;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProcessDiseaseFile
{
    
    static function process(string $path): array{
        $full_path = storage_path('app/private/' . $path);

        $file = fopen($full_path, 'r');

        // Get header row
        $headers = fgetcsv($file);

        $inserted = 0;
        $failed = [];
        $row_number = 1;

        while (($row = fgetcsv($file)) !== false) {

            $row_number++;
            
            // Combine header with row values
            $row_data = array_combine($headers, $row);
            if ($row_data === false) {
                $failed[] = [
                    'row_number' => $row_number,
                    'row_data' => $row,
                    'error' => 'Header and row column count mismatch'
                ];
                Log::error("Row $row_number skipped due to header and row column count mismatch:", [
                    'row_number' => $row_number,
                    'headers_count' => count($headers),
                    'row_columns_count' => count($row),
                    'row_data' => $row
                ]);
                continue;
            }

            $expected_columns = ['name', 'description', 'category', 'catId', 'gradeCode', 'diseaseCode'];
            $missing_columns = array_diff($expected_columns, array_keys($row_data));

            if (!empty($missing_columns)) {
                $failed[] = [
                    'row_number' => $row_number,
                    'row_data' => $row_data,
                    'error' => 'Missing columns: ' . implode(', ', $missing_columns)
                ];
                Log::error("Row $row_number skipped due to missing columns:", [
                    'row_number' => $row_number,
                    'missing_columns' => $missing_columns,
                    'row_data' => $row_data
                ]);
                continue;
            }

            try {

                Disease::updateOrCreate(
                    [
                        'disease_code' => $row_data['diseaseCode'] ?? null,
                        'cat_id' => $row_data['catId'] ?? null,
                        'grade_code' => $row_data['gradeCode'] ?? null,
                    ],
                    [
                        'user_id' => User::first()->id,
                        'name' => $row_data['name'] ?? null,
                        'description' => $row_data['description'] ?? null,
                        'category' => $row_data['category'] ?? null,
                        'cat_id' => $row_data['catId'] ?? null,
                        'grade_code' => $row_data['gradeCode'] ?? null,
                        'disease_code' => $row_data['diseaseCode'] ?? null,
                    ]
                );

                $inserted++;

            } catch (\Exception $e) {

                $failed[] = [
                    'row_number' => $row_number,
                    'row_data' => $row_data,
                    'error' => $e->getMessage()
                ];
            }
        }

        fclose($file);
        
        Log::info("Summary Report of the Disease Import Process", [
            'total_processed' => $inserted + count($failed),
            'inserted' => $inserted,
            'failed_count' => count($failed),
            'failed_rows' => $failed
        ]);

        $total_processed = $inserted + count($failed);
        $total_inserted = $inserted;
        $total_failed = count($failed);
        $failed_rows = $failed;

        return [
            'total_processed' => $total_processed,
            'total_inserted' => $total_inserted,
            'total_failed' => $total_failed,
            'failed_rows' => $failed_rows
        ];

    }
}