
<?php

/*
|--------------------------------------------------------------------------
| ROTOR REPLACEMENT PRINT VIEW
|--------------------------------------------------------------------------
| Groups records by:
| Month-Year
|     Clinic Name
|         Records
|--------------------------------------------------------------------------
*/

$grouped = [];

foreach ($records ?? [] as $record) {

    $date = $record['date'] ?? '';

    if (empty($date)) {
        continue;
    }

    $timestamp = strtotime($date);

    if (!$timestamp) {
        continue;
    }

    $monthYear = date('F Y', $timestamp);

    $clinicName = trim($record['clinic_name'] ?? '');

    if ($clinicName === '') {
        $clinicName = 'Unknown Clinic';
    }

    $grouped[$monthYear][$clinicName][] = $record;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Rotor Replacement Report</title>

    <style>

        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* ==========================================================
           REPORT HEADER
        ========================================================== */

        .report-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .report-header h2 {
            margin: 0 0 4px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .report-header p {
            margin: 2px 0;
            font-size: 9px;
        }

        /* ==========================================================
           FILTER INFORMATION
        ========================================================== */

        .filter-info {
            text-align: center;
            margin-bottom: 12px;
            font-size: 9px;
        }

        /* ==========================================================
           MONTH HEADER
        ========================================================== */

        .month-section {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .month-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 5px;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
        }

        /* ==========================================================
           CLINIC HEADER
        ========================================================== */

        .clinic-section {
            margin-bottom: 14px;
            page-break-inside: avoid;
        }

        .clinic-title {
            font-size: 10px;
            font-weight: bold;
            margin: 5px 0;
            padding: 4px 6px;
            border: 1px solid #000;
            background: #f2f2f2;
        }

        /* ==========================================================
           TABLE
        ========================================================== */

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 3px;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            background: #e9e9e9;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
        }

        td {
            font-size: 8px;
        }

        .text-center {
            text-align: center;
        }

        /* ==========================================================
           COLUMN WIDTHS
        ========================================================== */

        .col-clinic {
            width: 12%;
        }

        .col-address {
            width: 13%;
        }

        .col-model {
            width: 8%;
        }

        .col-rotor {
            width: 8%;
        }

        .col-lot {
            width: 9%;
        }

        .col-product {
            width: 10%;
        }

        .col-concern {
            width: 14%;
        }

        .col-date {
            width: 7%;
        }

        .col-replaceable {
            width: 6%;
        }

        .col-reason {
            width: 8%;
        }

        .col-replaced {
            width: 5%;
        }

        /* ==========================================================
           NO RECORDS
        ========================================================== */

        .no-records {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
        }

        /* ==========================================================
           SIGNATURE / APPROVAL SECTION
        ========================================================== */

        .approval-section {
            margin-top: 50px;
            width: 100%;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .approval-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            table-layout: fixed;
        }

        .approval-table td {
            border: none;
            vertical-align: bottom;
            padding: 0;
            font-size: 9px;
        }

        .submitted-cell {
            width: 50%;
            padding-right: 30px !important;
        }

        .approved-cell {
            width: 50%;
            padding-left: 30px !important;
        }

        .approval-label {
            font-weight: bold;
            margin-bottom: 35px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 80%;
            height: 1px;
            margin-bottom: 4px;
        }

        .signature-position {
            width: 80%;
            text-align: center;
            font-weight: bold;
        }

        /* ==========================================================
           PRINT FOOTER
        ========================================================== */

        .print-footer {
            margin-top: 35px;
            text-align: right;
            font-size: 8px;
        }

        /* ==========================================================
           PRINT SETTINGS
        ========================================================== */

        @media print {

            .no-print {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .month-section,
            .clinic-section,
            .approval-section {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            tr {
                page-break-inside: avoid;
                break-inside: avoid;
            }

        }

        /* ==========================================================
           SCREEN PRINT BUTTON
        ========================================================== */

        .print-button {
            position: fixed;
            top: 15px;
            right: 15px;
            padding: 8px 15px;
            border: 0;
            border-radius: 5px;
            background: #198754;
            color: #fff;
            cursor: pointer;
            font-size: 12px;
        }

    </style>

</head>

<body>


    <!-- ==========================================================
         PRINT BUTTON
         ========================================================== -->

    <button
        type="button"
        class="print-button no-print"
        onclick="window.print()"
    >
        Print
    </button>


    <!-- ==========================================================
         REPORT HEADER
         ========================================================== -->

    <div class="report-header">

        <h2>
            ROTOR REPLACEMENT REPORT
        </h2>

        <p>
            Rotor Replacement Records
        </p>

    </div>


    <!-- ==========================================================
         FILTER INFORMATION
         ========================================================== -->

    <?php if (!empty($startDate) || !empty($endDate)): ?>

        <div class="filter-info">

            <?php if (!empty($startDate) && !empty($endDate)): ?>

                Period:
                <?= date('F d, Y', strtotime($startDate)) ?>
                -
                <?= date('F d, Y', strtotime($endDate)) ?>

            <?php elseif (!empty($startDate)): ?>

                From:
                <?= date('F d, Y', strtotime($startDate)) ?>

            <?php elseif (!empty($endDate)): ?>

                Until:
                <?= date('F d, Y', strtotime($endDate)) ?>

            <?php endif; ?>

        </div>

    <?php endif; ?>


    <!-- ==========================================================
         RECORDS
         ========================================================== -->

    <?php if (!empty($grouped)): ?>


        <?php foreach ($grouped as $monthYear => $clinics): ?>


            <!-- ==================================================
                 MONTH
            ================================================== -->

            <div class="month-section">

                <div class="month-title">
                    <?= esc($monthYear) ?>
                </div>


                <?php foreach ($clinics as $clinicName => $clinicRecords): ?>


                    <!-- ==========================================
                         CLINIC
                    ========================================== -->

                    <div class="clinic-section">


                        <div class="clinic-title">
                            <?= esc($clinicName) ?>
                        </div>


                        <!-- ======================================
                             TABLE
                        ====================================== -->

                        <table>

                            <thead>

                                <tr>

                                    <th class="col-clinic">
                                        CLINIC NAME
                                    </th>

                                    <th class="col-address">
                                        ADDRESS
                                    </th>

                                    <th class="col-model">
                                        MODEL
                                    </th>

                                    <th class="col-rotor">
                                        ROTOR
                                    </th>

                                    <th class="col-lot">
                                        LOT NUMBER
                                    </th>

                                    <th class="col-product">
                                        PRODUCT CODE
                                    </th>

                                    <th class="col-concern">
                                        CONCERN
                                    </th>

                                    <th class="col-date">
                                        DATE
                                    </th>

                                    <th class="col-replaceable">
                                        REPLACEABLE
                                    </th>

                                    <th class="col-reason">
                                        REASON
                                    </th>

                                    <th class="col-replaced">
                                        REPLACED
                                    </th>

                                </tr>

                            </thead>


                            <tbody>


                                <?php foreach ($clinicRecords as $record): ?>


                                    <?php

                                    $replaceable = strtolower(
                                        trim($record['replaceable'] ?? '')
                                    );

                                    $replaced = strtolower(
                                        trim($record['replaced'] ?? '')
                                    );

                                    ?>


                                    <tr>


                                        <!-- CLINIC NAME -->

                                        <td>
                                            <?= esc(
                                                $record['clinic_name'] ?? ''
                                            ) ?>
                                        </td>


                                        <!-- ADDRESS -->

                                        <td>
                                            <?= esc(
                                                $record['address'] ?? ''
                                            ) ?>
                                        </td>


                                        <!-- MODEL -->

                                        <td>
                                            <?= esc(
                                                $record['model'] ?? ''
                                            ) ?>
                                        </td>


                                        <!-- ROTOR -->

                                        <td>
                                            <?= esc(
                                                $record['rotor'] ?? ''
                                            ) ?>
                                        </td>


                                        <!-- LOT NUMBER -->

                                        <td>
                                            <?= esc(
                                                $record['lot_number'] ?? ''
                                            ) ?>
                                        </td>


                                        <!-- PRODUCT CODE -->

                                        <td>
                                            <?= esc(
                                                $record['product_code'] ?? ''
                                            ) ?>
                                        </td>


                                        <!-- CONCERN -->

                                        <td>
                                            <?= nl2br(
                                                esc(
                                                    $record['concern'] ?? ''
                                                )
                                            ) ?>
                                        </td>


                                        <!-- DATE -->

                                        <td class="text-center">

                                            <?php if (!empty($record['date'])): ?>

                                                <?= date(
                                                    'M d, Y',
                                                    strtotime($record['date'])
                                                ) ?>

                                            <?php endif; ?>

                                        </td>


                                        <!-- REPLACEABLE -->

                                        <td class="text-center">

                                            <?php if (
                                                $replaceable === 'yes' ||
                                                $replaceable === '1'
                                            ): ?>

                                                YES

                                            <?php elseif (
                                                $replaceable === 'no' ||
                                                $replaceable === '0'
                                            ): ?>

                                                NO

                                            <?php else: ?>

                                                —

                                            <?php endif; ?>

                                        </td>


                                        <!-- REASON -->

                                        <td>
                                            <?= esc(
                                                $record['reason'] ?? ''
                                            ) ?>
                                        </td>


                                        <!-- REPLACED -->

                                        <td class="text-center">

                                            <?php if (
                                                $replaced === 'yes' ||
                                                $replaced === '1'
                                            ): ?>

                                                YES

                                            <?php elseif (
                                                $replaced === 'no' ||
                                                $replaced === '0'
                                            ): ?>

                                                NO

                                            <?php else: ?>

                                                —

                                            <?php endif; ?>

                                        </td>


                                    </tr>


                                <?php endforeach; ?>


                            </tbody>

                        </table>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php endforeach; ?>


    <?php else: ?>


        <!-- ======================================================
             NO RECORDS
        ====================================================== -->

        <div class="no-records">

            No rotor replacement records found.

        </div>


    <?php endif; ?>


    <!-- ==========================================================
         SIGNATURE / APPROVAL SECTION
    ========================================================== -->

    <?php if (!empty($grouped)): ?>

        <div class="approval-section">

            <table class="approval-table">

                <tr>


                    <!-- ==================================================
                         SUBMITTED BY
                    ================================================== -->

                    <td class="submitted-cell">

                        <div class="approval-label">
                            Submitted By:
                        </div>


                        <div class="signature-line"></div>


                        <div class="signature-position">
                            Service Manager
                        </div>

                    </td>


                    <!-- ==================================================
                         APPROVED BY
                    ================================================== -->

                    <td class="approved-cell">

                        <div class="approval-label">
                            Approved By:
                        </div>


                        <div class="signature-line"></div>


                        <div class="signature-position">
                            President
                        </div>

                    </td>


                </tr>

            </table>

        </div>

    <?php endif; ?>


    <!-- ==========================================================
         PRINT FOOTER
    ========================================================== -->
<!-- 
    <div class="print-footer">

        Generated:
        <?= date('F d, Y h:i A') ?>

    </div> -->


    <!-- ==========================================================
         AUTOMATIC PRINT
    ========================================================== -->


<script>

    let printStarted = false;

    window.addEventListener('load', function () {

        setTimeout(function () {

            printStarted = true;

            window.print();

        }, 500);

    });


    /*
    |--------------------------------------------------------------------------
    | AFTER PRINT
    |--------------------------------------------------------------------------
    | Fires after the browser print dialog is closed.
    |
    | This happens for BOTH:
    | - Print
    | - Cancel
    |--------------------------------------------------------------------------
    */

    window.addEventListener('afterprint', function () {

        setTimeout(function () {

            window.close();

        }, 300);

    });


    /*
    |--------------------------------------------------------------------------
    | FALLBACK
    |--------------------------------------------------------------------------
    | Some Chrome versions do not consistently fire afterprint when
    | the print dialog is cancelled.
    |--------------------------------------------------------------------------
    */

    let printDialogCheck;

    window.addEventListener('load', function () {

        setTimeout(function () {

            const startTime = Date.now();

            printDialogCheck = setInterval(function () {

                /*
                |----------------------------------------------------------
                | If the print dialog is closed, document becomes visible.
                |----------------------------------------------------------
                */

                if (
                    printStarted &&
                    document.visibilityState === 'visible' &&
                    Date.now() - startTime > 1000
                ) {

                    clearInterval(printDialogCheck);

                    setTimeout(function () {

                        window.close();

                    }, 300);

                }

            }, 500);

        }, 1000);

    });

</script>


</body>

</html>

