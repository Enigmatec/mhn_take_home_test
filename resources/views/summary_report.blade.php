<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disease Import Summary Report</title>
</head>
<body style="margin:0; padding:0; background-color:#f2f4f6; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f2f4f6; padding:30px 0;">
        <tr>
            <td align="center">
                
                <!-- Main Container -->
                <table width="650" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#0f766e; padding:25px; text-align:center; color:#ffffff;">
                            <h1 style="margin:0; font-size:22px;">Disease Import Summary Report</h1>
                            <p style="margin:8px 0 0 0; font-size:14px;">
                                File successfully processed
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:14px; line-height:1.6;">
                            
                            <p>Hello {{ 'User' }},</p>

                            <p>
                                The uploaded CSV file has been processed. Below is a detailed summary of the import operation:
                            </p>

                            <!-- Summary Card -->
                            <table width="100%" cellpadding="12" cellspacing="0" style="margin:25px 0; border:1px solid #e5e7eb; border-radius:6px;">
                                <tr style="background-color:#f9fafb;">
                                    <td><strong>Total Records Processed</strong></td>
                                    <td align="right">{{ $totalProcessed }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Successfully Inserted</strong></td>
                                    <td align="right" style="color:#16a34a; font-weight:bold;">
                                        {{ $totalInserted }}
                                    </td>
                                </tr>
                                <tr style="background-color:#f9fafb;">
                                    <td><strong>Failed Records</strong></td>
                                    <td align="right" style="color:#dc2626; font-weight:bold;">
                                        {{ $totalFailed }}
                                    </td>
                                </tr>
                            </table>

                            @if($totalFailed > 0)
                            <!-- Failed Records Section -->
                            <h3 style="margin-top:30px; color:#dc2626;">
                                Failed Record Details
                            </h3>

                            <p style="font-size:13px; color:#555;">
                                The following records could not be inserted due to validation or database errors:
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; font-size:12px;">
                                <thead>
                                    <tr style="background-color:#fee2e2;">
                                        <th align="left" style="border:1px solid #ddd;">Row Data</th>
                                        <th align="left" style="border:1px solid #ddd;">Error Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($failedRows as $row)
                                    <tr>
                                        <td style="border:1px solid #ddd; word-break:break-word;">
                                            {{ json_encode($row['row_data']) }}
                                        </td>
                                        <td style="border:1px solid #ddd; color:#dc2626;">
                                            {{ $row['error'] }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <p style="margin-top:30px;">
                                If you would like to correct the failed records and reprocess the file, please upload a revised version or contact support.
                            </p>

                            @endif

                            <p style="margin-top:30px;">
                                Regards,<br>
                                <strong>{{ config('app.name') }}</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="border-top:1px solid #e5e7eb;"></td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px; text-align:center; font-size:12px; color:#888;">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            <br>
                            This is an automated system-generated email.
                        </td>
                    </tr>

                </table>
                <!-- End Main Container -->

            </td>
        </tr>
    </table>

</body>
</html>