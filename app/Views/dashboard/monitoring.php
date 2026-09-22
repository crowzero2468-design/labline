<?= view('dashboard/layout/head') ?>

<style>

    /* Installation - Dark Pink */
    .monthly-status-installation {
        background-color: #c2185b !important;
        color: #ffffff !important;
    }


    /* Light PMS - Black */
    .monthly-status-light {
        background-color: #000000 !important;
        color: #ffffff !important;
    }


    /* Mid PMS - Blue */
    .monthly-status-mid {
        background-color: #0d6efd !important;
        color: #ffffff !important;
    }


    /* Heavy PMS - Violet */
    .monthly-status-heavy {
        background-color: #7b1fa2 !important;
        color: #ffffff !important;
    }


    /* Troubleshooting - Green */
    .monthly-status-troubleshooting {
        background-color: #198754 !important;
        color: #ffffff !important;
    }


    /* Relocation - Dark Green */
    .monthly-status-relocation {
        background-color: #14532d !important;
        color: #ffffff !important;
    }


    /* Unknown status */
    .monthly-status-default {
        background-color: #d100d1 !important;
        color: #ffffff !important;
    }

</style>

<body>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-message"
             style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%);
                    z-index: 1200; width: min(90vw, 520px); opacity: 1;
                    transition: opacity 0.5s ease;">
            <div style="background: #ffe4e6; color: #991b1b; border: 1px solid #fecdd3;
                        padding: 12px 16px; border-radius: 10px; font-weight: 600;">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-message"
             style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%);
                    z-index: 1200; width: min(90vw, 520px); opacity: 1;
                    transition: opacity 0.5s ease;">
            <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;
                        padding: 12px 16px; border-radius: 10px; font-weight: 600;">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= view('dashboard/layout/sidebar') ?>

    <div class="main-wrapper">

        <?= view('dashboard/layout/navbar') ?>

                            <!-- MONTHLY LOG CONTENT -->
                    <div class="container-fluid py-4">

                        <div class="card shadow-sm border-0">

                            <div class="card-body">


                                <!-- HEADER + FILTER -->
                                <div class="row mb-4 align-items-end">

                                    <!-- HEADER -->
                                    <div class="col-md-8">

                                        <h4 class="mb-1">
                                            <i class="bi bi-calendar-check me-2"></i>
                                            Monthly Log
                                        </h4>

                                        <p class="text-muted mb-0">
                                            Monthly PMS records
                                        </p>

                                    </div>


                                    <!-- MACHINE FILTER -->
                                    <div class="col-md-4">

                                        <label for="machineFilter"
                                            class="form-label fw-semibold">

                                            Machine

                                        </label>

                                        <select id="machineFilter" class="form-select">

                                            <option value="">
                                                All Machines
                                            </option>

                                            <?php foreach ($machines as $machine): ?>

                                                <option
                                                    value="<?= esc($machine['machine']) ?>"
                                                    <?= ($selectedMachine === $machine['machine']) ? 'selected' : '' ?>>

                                                    <?= esc($machine['machine']) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </select>

                                    </div>

                                </div>


                                <!-- TABLE -->

                                <div class="table-responsive">

                                    <table id="monthlyTable"
                                        class="table table-bordered table-hover align-middle w-100">

                                        <thead class="table-light">

                                            <tr>

                                                <th class="text-center">
                                                    Clinic Name
                                                </th>

                                                <th class="text-center">
                                                    Address
                                                </th>

                                                <th class="text-center">
                                                    Province
                                                </th>

                                                <th class="text-center">
                                                    January
                                                </th>

                                                <th class="text-center">
                                                    February
                                                </th>

                                                <th class="text-center">
                                                    March
                                                </th>

                                                <th class="text-center">
                                                    April
                                                </th>

                                                <th class="text-center">
                                                    May
                                                </th>

                                                <th class="text-center">
                                                    June
                                                </th>

                                                <th class="text-center">
                                                    July
                                                </th>

                                                <th class="text-center">
                                                    August
                                                </th>

                                                <th class="text-center">
                                                    September
                                                </th>

                                                <th class="text-center">
                                                    October
                                                </th>

                                                <th class="text-center">
                                                    November
                                                </th>

                                                <th class="text-center">
                                                    December
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                        <?php if (!empty($clinics)): ?>

                                            <?php foreach ($clinics as $clinic): ?>

                                                <tr>

                                                    <td>
                                                        <?= esc($clinic['Clinic_name']) ?>
                                                    </td>

                                                    <td>
                                                        <?= esc($clinic['address']) ?>
                                                    </td>

                                                    <td>
                                                        <?= esc($clinic['province']) ?>
                                                    </td>


                                                    <?php for ($month = 1; $month <= 12; $month++): ?>

                                                        <td class="text-center">

                                                            <?php
                                                            $records =
                                                                $clinic['months'][$month] ?? [];
                                                            ?>


                                                            <?php if (!empty($records)): ?>


                                                                <?php foreach ($records as $record): ?>

                                                                    <?php

                                                                        $status = trim($record['status'] ?? '');

                                                                        $badgeClass = 'monthly-status-default';

                                                                        switch (strtolower($status)) {

                                                                            /*
                                                                            |--------------------------------------------------------------------------
                                                                            | Installation
                                                                            |--------------------------------------------------------------------------
                                                                            */

                                                                            case 'installation':

                                                                                $badgeClass = 'monthly-status-installation';

                                                                                break;


                                                                            /*
                                                                            |--------------------------------------------------------------------------
                                                                            | Light PMS
                                                                            |--------------------------------------------------------------------------
                                                                            */

                                                                            case 'light pms':

                                                                                $badgeClass = 'monthly-status-light';

                                                                                break;


                                                                            /*
                                                                            |--------------------------------------------------------------------------
                                                                            | Mid PMS
                                                                            |--------------------------------------------------------------------------
                                                                            */

                                                                            case 'mid pms':

                                                                                $badgeClass = 'monthly-status-mid';

                                                                                break;


                                                                            /*
                                                                            |--------------------------------------------------------------------------
                                                                            | Heavy PMS
                                                                            |--------------------------------------------------------------------------
                                                                            */

                                                                            case 'heavy pms':

                                                                                $badgeClass = 'monthly-status-heavy';

                                                                                break;


                                                                            /*
                                                                            |--------------------------------------------------------------------------
                                                                            | Troubleshooting
                                                                            |--------------------------------------------------------------------------
                                                                            */

                                                                            case 'troubleshooting':

                                                                                $badgeClass = 'monthly-status-troubleshooting';

                                                                                break;


                                                                            /*
                                                                            |--------------------------------------------------------------------------
                                                                            | Relocation
                                                                            |--------------------------------------------------------------------------
                                                                            */

                                                                            case 'relocation':

                                                                                $badgeClass = 'monthly-status-relocation';

                                                                                break;
                                                                                


                                                                            /*
                                                                            |--------------------------------------------------------------------------
                                                                            | Default
                                                                            |--------------------------------------------------------------------------
                                                                            */

                                                                            default:

                                                                                $badgeClass = 'monthly-status-default';

                                                                                break;
                                                                        }

                                                                        ?>

                                                                    <span
                                                                        class="badge <?= $badgeClass ?> mb-1">

                                                                        <?= esc($status) ?>

                                                                    </span>


                                                                <?php endforeach; ?>


                                                            <?php else: ?>

                                                                <span class="text-muted">
                                                                    -
                                                                </span>

                                                            <?php endif; ?>

                                                        </td>

                                                    <?php endfor; ?>


                                                </tr>

                                            <?php endforeach; ?>


                                        <?php else: ?>

                                            <tr>

                                                <td colspan="15"
                                                    class="text-center text-muted py-4">

                                                    No clinic records found.

                                                </td>

                                            </tr>

                                        <?php endif; ?>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

        <?= view('dashboard/layout/footer') ?>

    </div>

  <script>

    /*
    |--------------------------------------------------------------------------
    | Flash Message Auto Hide
    |--------------------------------------------------------------------------
    */

    setTimeout(function () {

        const messages =
            document.querySelectorAll('.flash-message');

        messages.forEach(function (message) {

            message.style.opacity = '0';

            setTimeout(function () {

                message.remove();

            }, 500);

        });

    }, 5000);


    /*
    |--------------------------------------------------------------------------
    | Monthly DataTable
    |--------------------------------------------------------------------------
    */

    $(document).ready(function () {

        $('#monthlyTable').DataTable({

            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],

            order: [[0, 'asc']],

            scrollX: true,

            autoWidth: false,

            responsive: false

        });


        /*
        |--------------------------------------------------------------------------
        | Machine Filter
        |--------------------------------------------------------------------------
        */

        $('#machineFilter').on('change', function () {

            const machine = $(this).val();

            let url = '<?= site_url('monitoring') ?>';


            if (machine !== '') {

                url += '?machine=' +
                    encodeURIComponent(machine);

            }


            window.location.href = url;

        });

    });

</script>

</body>

</html>