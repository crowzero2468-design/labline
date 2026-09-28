<?php
$monthNames = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
];

$statusColors = [
    'installation' => '#c2185b',
    'light pms' => '#000000',
    'mid pms' => '#0d6efd',
    'heavy pms' => '#7b1fa2',
    'troubleshooting' => '#198754',
    'relocation' => '#14532d',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Monitoring Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #172033;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8px;
        }

        .print-toolbar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
        }

        .print-toolbar button {
            padding: 7px 12px;
            border: 1px solid #143e7a;
            border-radius: 4px;
            background: #143e7a;
            color: #fff;
            font-size: 12px;
            cursor: pointer;
        }

        h1 {
            margin: 0 0 5px;
            text-align: center;
            font-size: 17px;
        }

        .report-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            padding: 4px 3px;
            border: 1px solid #687386;
            overflow-wrap: anywhere;
            vertical-align: middle;
        }

        th {
            background: #e8edf5;
            font-size: 7px;
            text-align: center;
        }

        td:first-child,
        td:nth-child(2),
        td:nth-child(3) {
            font-size: 7px;
        }

        td.month-cell {
            text-align: center;
        }

        .status {
            display: inline-block;
            margin: 1px;
            padding: 2px 3px;
            border-radius: 2px;
            color: #fff;
            font-size: 6px;
            line-height: 1.2;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        .empty {
            padding: 18px;
            text-align: center;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            tr {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="print-toolbar no-print">
        <button type="button" onclick="window.print()">Print</button>
    </div>

    <h1>Monthly Monitoring Report</h1>
    <div class="report-meta">
        <span>Machine: <?= esc($selectedMachine !== '' ? $selectedMachine : 'All Machines') ?></span>
        <span>Generated: <?= date('F d, Y h:i A') ?></span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Clinic Name</th>
                <th>Address</th>
                <th>Province</th>
                <?php foreach ($monthNames as $monthName): ?>
                    <th><?= esc($monthName) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($clinics)): ?>
                <?php foreach ($clinics as $clinic): ?>
                    <tr>
                        <td><?= esc($clinic['Clinic_name'] ?? '') ?></td>
                        <td><?= esc($clinic['address'] ?? '') ?></td>
                        <td><?= esc($clinic['province'] ?? '') ?></td>
                        <?php foreach ($monthNames as $month => $monthName): ?>
                            <td class="month-cell">
                                <?php foreach (($clinic['months'][$month] ?? []) as $record): ?>
                                    <?php
                                        $status = trim((string) ($record['status'] ?? ''));
                                        $color = $statusColors[strtolower($status)] ?? '#d100d1';
                                    ?>
                                    <?php if ($status !== ''): ?>
                                        <span class="status" style="background-color: <?= esc($color) ?>;">
                                            <?= esc($status) ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="empty" colspan="15">No clinic records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        window.addEventListener('load', function () {
            window.setTimeout(function () {
                window.print();
            }, 400);
        });

        window.addEventListener('afterprint', function () {
            window.close();
        });
    </script>
</body>
</html>
