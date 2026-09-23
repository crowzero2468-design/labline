
<?= view('dashboard/layout/head') ?>

<body>

<?php if (session()->getFlashdata('error')): ?>
    <div class="flash-message"
         style="
            position: fixed;
            top: 12px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1200;
            width: min(90vw, 520px);
            opacity: 1;
            transition: opacity 0.5s ease;
         ">
        <div style="
            background: #ffe4e6;
            color: #991b1b;
            border: 1px solid #fecdd3;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
        ">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    </div>
<?php endif; ?>


<?php if (session()->getFlashdata('success')): ?>
    <div class="flash-message"
         style="
            position: fixed;
            top: 12px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1200;
            width: min(90vw, 520px);
            opacity: 1;
            transition: opacity 0.5s ease;
         ">
        <div style="
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
        ">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    </div>
<?php endif; ?>


<?= view('dashboard/layout/sidebar') ?>


<!-- ==========================================================
     MAIN CONTENT
     ========================================================== -->

<div class="main-wrapper">

    <?= view('dashboard/layout/navbar') ?>


    <!-- ======================================================
         DASHBOARD HEADER
         ====================================================== -->

    <div class="page-header">

        <div>
            <h1 class="page-title">
                Dashboard
            </h1>

            <p class="page-subtitle">
                LABLINE INC.
            </p>
        </div>

<!-- ==================================================
     INSTALLED DATE FILTER
     
     IMPORTANT:
     There is NO FORM here.
     
     Flatpickr is attached directly to the button.
     This prevents accidental form submission and
     prevents duplicate calendars.
     ================================================== -->

<div class="d-inline-flex align-items-end gap-2"
     id="installedDateFilterContainer">


    <!-- ==================================================
         DATE FILTER
         ================================================== -->

    <div>

        <!-- Clear label above the date picker -->
        <label class="form-label mb-1 small fw-semibold text-muted">
            Installed Date
        </label>


        <!-- ==================================================
             DATE FILTER VALUES

             These are NOT submitted as a form.

             JavaScript reads these values and builds the
             dashboard URL manually.
             ================================================== -->

        <input type="hidden"
               id="start_date"
               value="<?= esc($start_date ?? '') ?>">

        <input type="hidden"
               id="end_date"
               value="<?= esc($end_date ?? '') ?>">


        <!-- ==================================================
             DATE PICKER BUTTON
             ================================================== -->

        <button type="button"
                class="btn-date-picker"
                id="date-picker-trigger">

            <i class="bi bi-calendar4-event me-1"></i>

            <span id="selected-date-range">

                <?php if (!empty($start_date) && !empty($end_date)): ?>

                    <?= esc(date('F d, Y', strtotime($start_date))) ?>
                    -
                    <?= esc(date('F d, Y', strtotime($end_date))) ?>

                <?php elseif (!empty($start_date)): ?>

                    From
                    <?= esc(date('F d, Y', strtotime($start_date))) ?>

                <?php elseif (!empty($end_date)): ?>

                    Until
                    <?= esc(date('F d, Y', strtotime($end_date))) ?>

                <?php else: ?>

                    Filter Installed Date

                <?php endif; ?>

            </span>

            <i class="bi bi-chevron-down ms-1"></i>

        </button>

    </div>


    <!-- ==================================================
         CLEAR DATE FILTER
         ================================================== -->

    <?php if (!empty($start_date) || !empty($end_date)): ?>

        <div>

            <a href="<?= site_url('dashboard') ?>"
               class="btn btn-sm btn-outline-secondary"
               title="Clear Installed Date Filter">

                <i class="bi bi-x-lg me-1"></i>
                Clear Filter

            </a>

        </div>

    <?php endif; ?>


</div>


    <!-- ======================================================
         MAIN DASHBOARD GRID
         ====================================================== -->

    <div class="row g-4">


        <!-- ==================================================
             STAT CARDS
             ================================================== -->

        <div class="col-12">

            <div class="row g-4">


                <!-- ==========================================
                     TOTAL PROVINCE
                     ========================================== -->

                <div class="col-md-4">

                    <div class="card card-stat d-flex flex-column justify-content-between">

                        <div>

                            <div class="card-header">

                                <span class="stat-label">
                                    Total Province
                                </span>

                                <div class="dropdown">

                                    <button
                                        class="card-more-btn"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        aria-label="More Options"
                                        id="btn-more-total-area">

                                        <i class="bi bi-three-dots"></i>

                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">

                                        <li>

                                            <a class="dropdown-item"
                                               href="#">

                                                <i class="bi bi-arrow-repeat"></i>
                                                Refresh

                                            </a>

                                        </li>

                                    </ul>

                                </div>

                            </div>


                            <div class="stat-value">

                                <?= number_format($total_data ?? 0) ?>

                            </div>


                            <div class="trend-badge trend-up">

                                <i class="bi bi-database"></i>

                                <span>
                                    Unique provinces in tb_data.Province
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ==========================================
                     TOTAL CLINICS
                     ========================================== -->

                <div class="col-md-4">

                    <div class="card card-stat d-flex flex-column justify-content-between">

                        <div>

                            <div class="card-header">

                                <span class="stat-label">
                                    Total Clinics
                                </span>

                                <div class="dropdown">

                                    <button
                                        class="card-more-btn"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        aria-label="More Options"
                                        id="btn-more-machine">

                                        <i class="bi bi-three-dots"></i>

                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">

                                        <li>

                                            <a class="dropdown-item"
                                               href="#">

                                                <i class="bi bi-arrow-repeat"></i>
                                                Refresh

                                            </a>

                                        </li>

                                    </ul>

                                </div>

                            </div>


                            <div class="stat-value">

                                <?= number_format($total_machine ?? 0) ?>

                            </div>


                            <div class="trend-badge trend-up">

                                <i class="bi bi-hospital"></i>

                                <span>
                                    Unique clinic names in tb_data.Clinic_name
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ==========================================
                     MACHINE
                     ========================================== -->

                <div class="col-md-4">

                    <div class="card card-stat d-flex flex-column justify-content-between">

                        <div>

                            <div class="card-header">

                                <span class="stat-label">
                                    Machine
                                </span>


                                <div class="dropdown">

                                    <button
                                        class="card-more-btn"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        aria-label="More Options"
                                        id="btn-more-model">

                                        <i class="bi bi-three-dots"></i>

                                    </button>


                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">

                                        <?php foreach ($machine_counts ?? [] as $machine): ?>

                                            <li>

                                                <button
                                                    type="button"
                                                    class="dropdown-item machine-count-item"
                                                    data-machine="<?= esc($machine['Machine']) ?>"
                                                    data-total="<?= (int) $machine['total'] ?>">

                                                    <i class="bi bi-box"></i>

                                                    <?= esc($machine['Machine']) ?>

                                                    (<?= number_format((int) $machine['total']) ?>)

                                                </button>

                                            </li>

                                        <?php endforeach; ?>

                                    </ul>

                                </div>

                            </div>


                            <div
                                class="stat-value"
                                id="all-machine-total"
                                data-default-value="<?= (int) count($machine_counts ?? []) ?>">

                                <?= number_format(count($machine_counts ?? [])) ?>

                            </div>


                            <div
                                class="trend-badge trend-up"
                                id="all-machine-trend">

                                <i class="bi bi-gear"></i>

                                <span>
                                    Machine types in tb_data
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ==================================================
             CLINIC RECORDS
             ================================================== -->

        <div class="col-12">

            <div class="card">


                <!-- ==================================================
                     CARD HEADER
                     ================================================== -->

                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                    <div>

                        <h2 class="card-title mb-0">
                            Clinic Records
                        </h2>

                    </div>


                    <div
                        class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto align-items-md-center justify-content-md-end">


                        <!-- ==========================================
                             CANCEL ACCOUNT
                             ========================================== -->

                        <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#canceledaccoun">

                            Cancel Account

                        </button>


                        <!-- ==========================================
                             ADD MACHINE
                             ========================================== -->

                        <button
                            type="button"
                            class="btn btn-success btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#addRecordModal">

                            Add Machine

                        </button>


                        <!-- ==========================================
                             IMPORT EXCEL
                             ========================================== -->


                            <form 
                                method="post" 
                                action="<?= site_url('dashboard/import') ?>" 
                                enctype="multipart/form-data" 
                                class="d-flex gap-2 align-items-center">

                                <?= csrf_field() ?>

                                <input 
                                    type="file" 
                                    name="excel_file" 
                                    accept=".xlsx,.csv" 
                                    class="form-control form-control-sm" 
                                    required>

                                <button 
                                    type="submit" 
                                    class="btn btn-success btn-sm">
                                    <i class="fas fa-file-import me-1"></i>
                                    Import Excel
                                </button>

                                <a 
                                    href="<?= base_url('templates/clinic_import_template.xlsx') ?>" 
                                    class="btn btn-success btn-sm"
                                    download>
                                    Download Excel Template Here
                                </a>

                            </form>



                        <!-- ==========================================
                             SEARCH
                             ========================================== -->

                        <form
                            method="get"
                            action="<?= site_url('dashboard') ?>"
                            class="d-flex gap-2 w-100 w-md-auto"
                            style="max-width: 420px;">


                            <!-- Preserve installed date -->

                            <input
                                type="hidden"
                                name="start_date"
                                value="<?= esc($start_date ?? '') ?>">


                            <input
                                type="hidden"
                                name="end_date"
                                value="<?= esc($end_date ?? '') ?>">


                            <input
                                type="text"
                                name="search"
                                value="<?= esc($search ?? '') ?>"
                                class="form-control"
                                placeholder="Search clinic, machine, model...">


                            <button
                                type="submit"
                                class="btn btn-primary">

                                Search

                            </button>


                            <?php if (!empty($search)): ?>

                                <a
                                    href="<?= site_url('dashboard') ?><?=

                                        (!empty($start_date) || !empty($end_date))

                                            ? '?' . http_build_query([
                                                'start_date' => $start_date ?? '',
                                                'end_date'   => $end_date ?? ''
                                            ])

                                            : ''

                                    ?>"
                                    class="btn btn-outline-secondary">

                                    Reset

                                </a>

                            <?php endif; ?>

                        </form>

                    </div>

                </div>


                <!-- ==================================================
                     TABLE
                     ================================================== -->

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-striped table-hover align-middle mb-0">

                            <thead class="table-dark">

                                <tr>

                                    <th>ID</th>

                                    <th>Clinic Name</th>

                                    <th>Address</th>

                                    <th>Province</th>

                                    <th>Machine</th>

                                    <th>Model</th>

                                    <th>Installed Date</th>

                                    <th>SN</th>

                                    <th>DR Number</th>

                                    <th class="text-center">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                            <?php if (!empty($records)): ?>

                                <?php foreach ($records as $index => $row): ?>

                                    <?php

                                    $rowNumber =
                                        ((int) ($page ?? 1) - 1) *
                                        (int) ($per_page ?? 10) +
                                        $index +
                                        1;

                                    $recordId =
                                        (int) ($row['id'] ?? 0);

                                    $contractId =
                                        (int) ($row['contract_id'] ?? 0);

                                    $status =
                                        strtoupper(
                                            trim(
                                                (string) ($row['status'] ?? '')
                                            )
                                        );

                                    ?>


                                    <tr class="<?= $status === 'I' ? 'table-danger' : '' ?>">


                                        <td>
                                            <?= esc($rowNumber) ?>
                                        </td>


                                        <td>
                                            <?= esc($row['Clinic_name'] ?? '') ?>
                                        </td>


                                        <td>
                                            <?= esc($row['Address'] ?? '') ?>
                                        </td>


                                        <td>
                                            <?= esc($row['Province'] ?? '') ?>
                                        </td>


                                        <td>
                                            <?= esc($row['Machine'] ?? '') ?>
                                        </td>


                                        <td>
                                            <?= esc($row['Model'] ?? '') ?>
                                        </td>


                                        <td>
                                            <?= esc($row['Installed_date'] ?? '') ?>
                                        </td>


                                        <td>
                                            <?= esc($row['SN'] ?? '') ?>
                                        </td>


                                        <td>
                                            <?= esc($row['DR_Number'] ?? '') ?>
                                        </td>


                                        <!-- ======================================
                                             ACTIONS
                                             ====================================== -->

                                        <td class="text-center">

                                            <div
                                                class="d-flex justify-content-center align-items-center gap-1 flex-wrap">


                                                <!-- ==================================
                                                     VIEW CONTRACT
                                                     ================================== -->

                                                <?php if ($contractId > 0): ?>

                                                    <button
                                                        type="button"
                                                        class="btn btn-outline-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewContractModal<?= $recordId ?>"
                                                        title="View Contract">

                                                        <i class="bi bi-file-earmark-text"></i>
                                                        View

                                                    </button>

                                                <?php else: ?>

                                                    <span
                                                        class="badge bg-warning text-dark"
                                                        title="No contract attached">

                                                        <i class="bi bi-file-earmark-x"></i>

                                                        No Contract Attached

                                                    </span>

                                                <?php endif; ?>


                                                <!-- ==================================
                                                     ATTACH / REPLACE
                                                     ================================== -->

                                                <button
                                                    type="button"
                                                    class="btn btn-outline-success btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#contractModal<?= $recordId ?>"
                                                    title="<?= $contractId > 0 ? 'Replace Contract' : 'Attach Contract' ?>">

                                                    <i class="bi bi-paperclip"></i>

                                                    <?= $contractId > 0 ? 'Replace' : 'Attach' ?>

                                                </button>


                                                <!-- ==================================
                                                     EDIT
                                                     ================================== -->

                                                <button
                                                    type="button"
                                                    class="btn btn-outline-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editRecordModal<?= $recordId ?>">

                                                    <i class="bi bi-pencil"></i>
                                                    Edit

                                                </button>


                                                <!-- ==================================
                                                     DELETE
                                                     ================================== -->

                                                <a
                                                    href="<?= site_url('dashboard') ?>?delete=<?= $recordId ?>"
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Delete this record?');">

                                                    <i class="bi bi-trash"></i>
                                                    Delete

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>


                            <?php else: ?>


                                <tr>

                                    <td
                                        colspan="10"
                                        class="text-center py-4 text-muted">

                                        No records found.

                                    </td>

                                </tr>


                            <?php endif; ?>

                            </tbody>

                        </table>

                    </div>


                    <!-- ==================================================
                         PAGINATION
                         ================================================== -->

                    <?php if (($total_pages ?? 1) > 1): ?>

                        <div class="d-flex align-items-center p-3 border-top">


                            <div class="text-muted small">

                                Showing
                                <?= count($records ?? []) ?>
                                of
                                <?= (int) ($total_rows ?? 0) ?>
                                records

                            </div>


                            <?php

                            /*
                             * Preserve all active filters.
                             */

                            $paginationParams = [];


                            if (!empty($search)) {

                                $paginationParams['search'] =
                                    $search;

                            }


                            if (!empty($start_date)) {

                                $paginationParams['start_date'] =
                                    $start_date;

                            }


                            if (!empty($end_date)) {

                                $paginationParams['end_date'] =
                                    $end_date;

                            }

                            ?>


                            <nav
                                aria-label="Pagination"
                                class="ms-auto">

                                <ul class="pagination pagination-sm mb-0">


                                    <!-- ======================================
                                         PREVIOUS
                                         ====================================== -->

                                    <?php

                                    $previousPage =
                                        max(
                                            1,
                                            ((int) ($page ?? 1)) - 1
                                        );


                                    $previousParams =
                                        array_merge(
                                            $paginationParams,
                                            [
                                                'page' =>
                                                    $previousPage
                                            ]
                                        );

                                    ?>


                                    <li
                                        class="page-item
                                        <?= ($page ?? 1) <= 1
                                            ? 'disabled'
                                            : '' ?>">

                                        <a
                                            class="page-link"
                                            href="<?= site_url('dashboard') ?>?<?= http_build_query($previousParams) ?>">

                                            Previous

                                        </a>

                                    </li>


                                    <!-- ======================================
                                         PAGE NUMBERS
                                         ====================================== -->

                                    <?php

                                    $curPage =
                                        (int) ($page ?? 1);


                                    $totalPages =
                                        (int) ($total_pages ?? 1);


                                    $maxLinks = 5;


                                    $start =
                                        max(
                                            1,
                                            $curPage -
                                            (int) floor(
                                                $maxLinks / 2
                                            )
                                        );


                                    $end =
                                        min(
                                            $totalPages,
                                            $start +
                                            $maxLinks -
                                            1
                                        );


                                    if (
                                        $end -
                                        $start +
                                        1 <
                                        $maxLinks
                                    ) {

                                        $start =
                                            max(
                                                1,
                                                $end -
                                                $maxLinks +
                                                1
                                            );

                                    }

                                    ?>


                                    <?php for (
                                        $i = $start;
                                        $i <= $end;
                                        $i++
                                    ): ?>


                                        <?php

                                        $pageParams =
                                            array_merge(
                                                $paginationParams,
                                                [
                                                    'page' => $i
                                                ]
                                            );

                                        ?>


                                        <li
                                            class="page-item
                                            <?= ($i == $curPage)
                                                ? 'active'
                                                : '' ?>">

                                            <a
                                                class="page-link"
                                                href="<?= site_url('dashboard') ?>?<?= http_build_query($pageParams) ?>">

                                                <?= $i ?>

                                            </a>

                                        </li>


                                    <?php endfor; ?>


                                    <!-- ======================================
                                         NEXT
                                         ====================================== -->

                                    <?php

                                    $nextPage =
                                        min(
                                            $totalPages,
                                            $curPage + 1
                                        );


                                    $nextParams =
                                        array_merge(
                                            $paginationParams,
                                            [
                                                'page' =>
                                                    $nextPage
                                            ]
                                        );

                                    ?>


                                    <li
                                        class="page-item
                                        <?= $curPage >= $totalPages
                                            ? 'disabled'
                                            : '' ?>">

                                        <a
                                            class="page-link"
                                            href="<?= site_url('dashboard') ?>?<?= http_build_query($nextParams) ?>">

                                            Next

                                        </a>

                                    </li>


                                </ul>

                            </nav>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>


    <!-- ======================================================
         CONTRACT MODALS
         ====================================================== -->

    <?php
    $database = db_connect();
    ?>


    <?php if (!empty($records)): ?>

        <?php foreach ($records as $row): ?>

            <?php

            $recordId =
                (int) ($row['id'] ?? 0);

            $contractId =
                (int) ($row['contract_id'] ?? 0);

            $contractLocation = '';
            $contractUrl = '';
            $contractExtension = '';

            ?>


            <?php if ($contractId > 0): ?>

                <?php

                $contractRecord =
                    $database
                        ->table('tb_contract')
                        ->select('id, location')
                        ->where('id', $contractId)
                        ->get()
                        ->getRowArray();


                if ($contractRecord) {

                    $contractLocation =
                        trim(
                            (string)
                            ($contractRecord['location'] ?? '')
                        );


                    if ($contractLocation !== '') {

                        $contractUrl =
                            base_url(
                                ltrim(
                                    $contractLocation,
                                    '/\\'
                                )
                            );


                        $contractExtension =
                            strtolower(
                                pathinfo(
                                    $contractLocation,
                                    PATHINFO_EXTENSION
                                )
                            );

                    }

                }

                ?>


                <!-- ==========================================
                     VIEW CONTRACT MODAL
                     ========================================== -->

                <div
                    class="modal fade"
                    id="viewContractModal<?= $recordId ?>"
                    tabindex="-1"
                    aria-labelledby="viewContractModalLabel<?= $recordId ?>"
                    aria-hidden="true">


                    <div
                        class="modal-dialog modal-xl modal-dialog-centered">


                        <div class="modal-content">


                            <div class="modal-header">

                                <h5
                                    class="modal-title"
                                    id="viewContractModalLabel<?= $recordId ?>">

                                    <i class="bi bi-file-earmark-text"></i>

                                    Contract

                                </h5>


                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                </button>

                            </div>


                            <div class="modal-body p-0">


                                <?php if ($contractUrl !== ''): ?>


                                    <?php if ($contractExtension === 'pdf'): ?>

                                        <iframe
                                            src="<?= esc($contractUrl) ?>"
                                            style="
                                                width:100%;
                                                height:75vh;
                                                border:none;
                                            "
                                            title="Contract PDF">
                                        </iframe>


                                    <?php elseif (
                                        in_array(
                                            $contractExtension,
                                            ['jpg', 'jpeg', 'png'],
                                            true
                                        )
                                    ): ?>


                                        <div
                                            class="d-flex justify-content-center align-items-center p-3"
                                            style="
                                                min-height:70vh;
                                                background:#f8f9fa;
                                            ">


                                            <img
                                                src="<?= esc($contractUrl) ?>"
                                                alt="Contract"
                                                class="img-fluid"
                                                style="
                                                    max-width:100%;
                                                    max-height:70vh;
                                                    object-fit:contain;
                                                ">

                                        </div>


                                    <?php else: ?>


                                        <div
                                            class="p-5 text-center">

                                            <i
                                                class="bi bi-file-earmark-x"
                                                style="font-size:3rem;">
                                            </i>


                                            <h5 class="mt-3">
                                                File cannot be previewed
                                            </h5>


                                            <p class="text-muted">

                                                This file type cannot be
                                                displayed inside the browser.

                                            </p>


                                            <a
                                                href="<?= esc($contractUrl) ?>"
                                                target="_blank"
                                                class="btn btn-primary">

                                                <i class="bi bi-box-arrow-up-right"></i>

                                                Open Contract

                                            </a>

                                        </div>


                                    <?php endif; ?>


                                <?php else: ?>


                                    <div
                                        class="p-5 text-center">

                                        <i
                                            class="bi bi-file-earmark-x text-warning"
                                            style="font-size:3rem;">
                                        </i>


                                        <h5 class="mt-3">
                                            Contract File Not Found
                                        </h5>


                                        <p class="text-muted mb-0">

                                            The contract record exists,
                                            but no file location was found.

                                        </p>

                                    </div>


                                <?php endif; ?>

                            </div>


                            <div class="modal-footer">


                                <?php if ($contractUrl !== ''): ?>

                                    <a
                                        href="<?= esc($contractUrl) ?>"
                                        target="_blank"
                                        class="btn btn-outline-primary">

                                        <i class="bi bi-box-arrow-up-right"></i>

                                        Open in New Tab

                                    </a>

                                <?php endif; ?>


                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">

                                    Close

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

        <?php endforeach; ?>

    <?php endif; ?>


    <!-- ======================================================
         ATTACH / REPLACE CONTRACT MODALS
         ====================================================== -->

    <?php if (!empty($records)): ?>

        <?php foreach ($records as $row): ?>

            <?php

            $recordId =
                (int) ($row['id'] ?? 0);

            $contractId =
                (int) ($row['contract_id'] ?? 0);

            ?>


            <div
                class="modal fade"
                id="contractModal<?= $recordId ?>"
                tabindex="-1"
                aria-labelledby="contractModalLabel<?= $recordId ?>"
                aria-hidden="true">


                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">


                        <form
                            method="post"
                            action="<?= site_url('dashboard/attach-contract') ?>"
                            enctype="multipart/form-data">


                            <?= csrf_field() ?>


                            <input
                                type="hidden"
                                name="id"
                                value="<?= $recordId ?>">


                            <div class="modal-header">

                                <h5
                                    class="modal-title"
                                    id="contractModalLabel<?= $recordId ?>">

                                    <i class="bi bi-file-earmark-text me-2"></i>

                                    <?= $contractId > 0
                                        ? 'Replace Contract'
                                        : 'Attach Contract'
                                    ?>

                                </h5>


                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                </button>

                            </div>


                            <div class="modal-body">


                                <div class="mb-3">

                                    <label class="form-label">
                                        Clinic
                                    </label>


                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?= esc($row['Clinic_name'] ?? '') ?>"
                                        readonly>

                                </div>


                                <?php if ($contractId > 0): ?>

                                    <div class="alert alert-info">

                                        <i class="bi bi-info-circle me-1"></i>

                                        This record already has contract
                                        <strong>#<?= $contractId ?></strong>.

                                        <br>

                                        Uploading a new file will create a new
                                        contract record and update
                                        <code>tb_data.contract_id</code>.

                                    </div>

                                <?php else: ?>

                                    <div class="alert alert-warning">

                                        <i class="bi bi-exclamation-triangle me-1"></i>

                                        No contract is currently attached.

                                        <br>

                                        Upload a contract below to create a new
                                        record in <code>tb_contract</code>.

                                    </div>

                                <?php endif; ?>


                                <div class="mb-3">

                                    <label
                                        for="contract_file<?= $recordId ?>"
                                        class="form-label">

                                        Contract File
                                        <span class="text-danger">*</span>

                                    </label>


                                    <input
                                        type="file"
                                        name="contract_file"
                                        id="contract_file<?= $recordId ?>"
                                        class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        required>


                                    <div class="form-text">

                                        Allowed files:
                                        PDF, JPG, JPEG, PNG.

                                    </div>

                                </div>

                            </div>


                            <div class="modal-footer">

                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">

                                    Cancel

                                </button>


                                <button
                                    type="submit"
                                    class="btn btn-success">

                                    <i class="bi bi-upload me-1"></i>

                                    <?= $contractId > 0
                                        ? 'Replace Contract'
                                        : 'Upload Contract'
                                    ?>

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>


    <!-- ======================================================
         ADD MACHINE MODAL
         ====================================================== -->

    <div
        class="modal fade"
        id="addRecordModal"
        tabindex="-1"
        aria-labelledby="addRecordModalLabel"
        aria-hidden="true">


        <div
            class="modal-dialog modal-lg modal-dialog-centered">


            <div class="modal-content">


                <form
                    method="post"
                    action="<?= site_url('dashboard/save') ?>">


                    <?= csrf_field() ?>


                    <div class="modal-header">

                        <h5
                            class="modal-title"
                            id="addRecordModalLabel">

                            Add Machine

                        </h5>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="row g-3">


                            <div class="col-md-6">

                                <label class="form-label">
                                    Clinic Name
                                </label>

                                <input
                                    type="text"
                                    name="Clinic_name"
                                    class="form-control"
                                    required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Address
                                </label>

                                <input
                                    type="text"
                                    name="Address"
                                    class="form-control"
                                    required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Province
                                </label>

                                <input
                                    type="text"
                                    name="Province"
                                    class="form-control"
                                    required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Machine
                                </label>

                                <input
                                    type="text"
                                    name="Machine"
                                    class="form-control"
                                    required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Model
                                </label>

                                <input
                                    type="text"
                                    name="Model"
                                    class="form-control"
                                    required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Installed Date
                                </label>

                                <input
                                    type="date"
                                    name="Installed_date"
                                    class="form-control"
                                    required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    SN
                                </label>

                                <input
                                    type="text"
                                    name="SN"
                                    class="form-control"
                                    required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    DR Number
                                </label>

                                <input
                                    type="text"
                                    name="DR_Number"
                                    class="form-control"
                                    required>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            Close

                        </button>


                        <button
                            type="submit"
                            class="btn btn-primary">

                            Save Machine

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- ======================================================
         EDIT MACHINE MODALS
         ====================================================== -->

    <?php if (!empty($records)): ?>

        <?php foreach ($records as $row): ?>

            <?php
            $recordId =
                (int) ($row['id'] ?? 0);
            ?>


            <div
                class="modal fade"
                id="editRecordModal<?= $recordId ?>"
                tabindex="-1"
                aria-labelledby="editRecordModalLabel<?= $recordId ?>"
                aria-hidden="true">


                <div
                    class="modal-dialog modal-lg modal-dialog-centered">


                    <div class="modal-content">


                        <form
                            method="post"
                            action="<?= site_url('dashboard/update') ?>">


                            <?= csrf_field() ?>


                            <input
                                type="hidden"
                                name="id"
                                value="<?= $recordId ?>">


                            <div class="modal-header">

                                <h5
                                    class="modal-title"
                                    id="editRecordModalLabel<?= $recordId ?>">

                                    Edit Machine

                                </h5>


                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                </button>

                            </div>


                            <div class="modal-body">

                                <div class="row g-3">


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Clinic Name
                                        </label>

                                        <input
                                            type="text"
                                            name="Clinic_name"
                                            class="form-control"
                                            value="<?= esc($row['Clinic_name'] ?? '') ?>"
                                            required>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Address
                                        </label>

                                        <input
                                            type="text"
                                            name="Address"
                                            class="form-control"
                                            value="<?= esc($row['Address'] ?? '') ?>"
                                            required>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Province
                                        </label>

                                        <input
                                            type="text"
                                            name="Province"
                                            class="form-control"
                                            value="<?= esc($row['Province'] ?? '') ?>"
                                            required>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Machine
                                        </label>

                                        <input
                                            type="text"
                                            name="Machine"
                                            class="form-control"
                                            value="<?= esc($row['Machine'] ?? '') ?>"
                                            required>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Model
                                        </label>

                                        <input
                                            type="text"
                                            name="Model"
                                            class="form-control"
                                            value="<?= esc($row['Model'] ?? '') ?>"
                                            required>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Installed Date
                                        </label>

                                        <input
                                            type="date"
                                            name="Installed_date"
                                            class="form-control"
                                            value="<?= esc($row['Installed_date'] ?? '') ?>"
                                            required>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            SN
                                        </label>

                                        <input
                                            type="text"
                                            name="SN"
                                            class="form-control"
                                            value="<?= esc($row['SN'] ?? '') ?>"
                                            required>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            DR Number
                                        </label>

                                        <input
                                            type="text"
                                            name="DR_Number"
                                            class="form-control"
                                            value="<?= esc($row['DR_Number'] ?? '') ?>"
                                            required>

                                    </div>

                                </div>

                            </div>


                            <div class="modal-footer">

                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">

                                    Close

                                </button>


                                <button
                                    type="submit"
                                    class="btn btn-primary">

                                    Update Machine

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>


    <!-- ======================================================
         CANCEL ACCOUNT MODAL
         ====================================================== -->

    <div
        class="modal fade"
        id="canceledaccoun"
        tabindex="-1"
        aria-labelledby="canceledaccounLabel"
        aria-hidden="true">


        <div class="modal-dialog modal-lg modal-dialog-centered">


            <div class="modal-content">


                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="canceledaccounLabel">

                        <i class="bi bi-x-circle me-2"></i>

                        Cancel Account

                    </h5>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>


                <form
                    action="<?= base_url('cancelled-account/save') ?>"
                    method="post"
                    id="cancelledAccountForm">


                    <?= csrf_field() ?>


                    <input
                        type="hidden"
                        name="id"
                        id="cancelled_account_id"
                        value="">


                    <div class="modal-body">

                        <div class="row g-3">


                            <!-- ACCOUNT -->

                            <div class="col-md-6">

                                <label
                                    for="account"
                                    class="form-label">

                                    Account
                                    <span class="text-danger">*</span>

                                </label>


                                <select
                                    name="account"
                                    id="account"
                                    class="form-select select2-account"
                                    style="width:100%;"
                                    required>


                                    <option value="">
                                        -- Select Account --
                                    </option>


                                    <?php if (!empty($clinicMap)): ?>

                                        <?php foreach ($clinicMap as $clinicName => $info): ?>

                                            <?php

                                            $machinesJson =
                                                htmlspecialchars(
                                                    json_encode(
                                                        $info['machines'] ?? [],
                                                        JSON_UNESCAPED_UNICODE
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                );


                                            $address =
                                                trim(
                                                    (string)
                                                    ($info['address'] ?? '')
                                                );


                                            $province =
                                                trim(
                                                    (string)
                                                    ($info['province'] ?? '')
                                                );

                                            ?>


                                            <option
                                                value="<?= esc($info['id'] ?? '') ?>"
                                                data-clinic="<?= esc($clinicName) ?>"
                                                data-address="<?= esc($address) ?>"
                                                data-province="<?= esc($province) ?>"
                                                data-machines="<?= $machinesJson ?>">

                                                <?= esc($clinicName) ?>

                                            </option>


                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </select>


                                <div class="form-text">

                                    <i class="bi bi-search me-1"></i>

                                    Search and select the clinic account.

                                </div>

                            </div>


                            <!-- ADDRESS -->

                            <div class="col-md-6">

                                <label
                                    for="account_address"
                                    class="form-label">

                                    Address
                                    <span class="text-danger">*</span>

                                </label>


                                <input
                                    type="text"
                                    name="address"
                                    id="account_address"
                                    class="form-control"
                                    placeholder="Address will be filled automatically"
                                    readonly
                                    required>


                                <div class="form-text">

                                    <i class="bi bi-info-circle me-1"></i>

                                    Address is automatically loaded from
                                    the selected account.

                                </div>

                            </div>


                            <!-- MACHINE -->

                            <div class="col-md-6">

                                <label
                                    for="cancelled_machine"
                                    class="form-label">

                                    Machine
                                    <span class="text-danger">*</span>

                                </label>


                                <select
                                    name="machine"
                                    id="cancelled_machine"
                                    class="form-select"
                                    required
                                    disabled>

                                    <option value="">
                                        -- Select Account First --
                                    </option>

                                </select>


                                <div class="form-text">

                                    <i class="bi bi-cpu me-1"></i>

                                    Select the machine belonging to
                                    the selected account.

                                </div>

                            </div>


                            <!-- DATE FOUND OUT -->

                            <div class="col-md-6">

                                <label
                                    for="date_found_out"
                                    class="form-label">

                                    Date Found Out
                                    <span class="text-danger">*</span>

                                </label>


                                <input
                                    type="date"
                                    name="date_found_out"
                                    id="date_found_out"
                                    class="form-control"
                                    required>

                            </div>


                            <!-- DATE CONFIRMED -->

                            <div class="col-md-6">

                                <label
                                    for="date_confirmed"
                                    class="form-label">

                                    Date Confirmed From Manufacturer
                                    <span class="text-danger">*</span>

                                </label>


                                <input
                                    type="date"
                                    name="date_confirmed"
                                    id="date_confirmed"
                                    class="form-control"
                                    required>

                            </div>


                            <!-- PERSONNEL -->

                            <div class="col-md-6">

                                <label
                                    for="cancelled_personnel"
                                    class="form-label">

                                    Personnel
                                    <span class="text-danger">*</span>

                                </label>


                                <input
                                    type="text"
                                    name="personnel"
                                    id="cancelled_personnel"
                                    class="form-control"
                                    placeholder="Enter personnel"
                                    required>

                            </div>


                            <!-- SUPPLIER -->

                            <div class="col-md-6">

                                <label
                                    for="cancelled_supplier"
                                    class="form-label">

                                    Supplier
                                    <span class="text-danger">*</span>

                                </label>


                                <input
                                    type="text"
                                    name="supplier"
                                    id="cancelled_supplier"
                                    class="form-control"
                                    placeholder="Enter supplier"
                                    required>

                            </div>


                            <!-- REASON -->

                            <div class="col-12">

                                <label
                                    for="cancelled_reason"
                                    class="form-label">

                                    Reason
                                    <span class="text-danger">*</span>

                                </label>


                                <textarea
                                    name="reason"
                                    id="cancelled_reason"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Enter reason for account cancellation"
                                    required></textarea>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            <i class="bi bi-x-circle me-1"></i>

                            Cancel

                        </button>


                        <button
                            type="submit"
                            class="btn btn-success">

                            <i class="bi bi-check-circle me-1"></i>

                            Save Cancel Account

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<?= view('dashboard/layout/footer') ?>


<!-- ==========================================================
     INSTALLED DATE FILTER JAVASCRIPT
     
     IMPORTANT:
     This is the ONLY Flatpickr initialization for the
     Installed Date filter.

     DO NOT keep the old:
         installed_date_picker
         installedDateFilterForm
         flatpickr(datePickerInput, ...)
     
     code anywhere else on this page.
     ========================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* ======================================================
       GET ELEMENTS
       ====================================================== */

    const trigger =
        document.getElementById('date-picker-trigger');

    const startInput =
        document.getElementById('start_date');

    const endInput =
        document.getElementById('end_date');

    const display =
        document.getElementById('selected-date-range');


    /* ======================================================
       CHECK REQUIRED ELEMENTS
       ====================================================== */

    if (
        !trigger ||
        !startInput ||
        !endInput ||
        !display
    ) {

        console.error(
            'Installed Date Filter: required elements not found.'
        );

        return;

    }


    /* ======================================================
       CHECK FLATPICKR
       ====================================================== */

    if (typeof flatpickr === 'undefined') {

        console.error(
            'Installed Date Filter: Flatpickr is not loaded.'
        );

        return;

    }


    /* ======================================================
       DESTROY ANY EXISTING FLATPICKR INSTANCE ON TRIGGER
       
       This protects against duplicate initialization.
       ====================================================== */

    if (trigger._flatpickr) {

        try {

            trigger._flatpickr.destroy();

        } catch (error) {

            console.warn(
                'Could not destroy existing Flatpickr instance.',
                error
            );

        }

    }


    /* ======================================================
       REMOVE OLD ORPHANED FLATPICKR CALENDARS
       
       This is especially useful if an older version of the
       page initialized Flatpickr before this script.
       ====================================================== */

    document
        .querySelectorAll('.flatpickr-calendar')
        .forEach(function (calendar) {

            calendar.remove();

        });


    /* ======================================================
       EXISTING DATE VALUES
       ====================================================== */

    const existingStart =
        startInput.value.trim();

    const existingEnd =
        endInput.value.trim();


    /* ======================================================
       INITIAL DATES
       ====================================================== */

    let initialDates = [];


    if (
        existingStart &&
        existingEnd
    ) {

        initialDates = [
            existingStart,
            existingEnd
        ];

    } else if (existingStart) {

        initialDates = [
            existingStart
        ];

    } else if (existingEnd) {

        initialDates = [
            existingEnd
        ];

    }


    /* ======================================================
       FORMAT DATE FOR DISPLAY
       ====================================================== */

    function formatDisplayDate(dateString) {

        if (!dateString) {

            return '';

        }


        const parts =
            dateString.split('-');


        if (parts.length !== 3) {

            return dateString;

        }


        const year =
            Number(parts[0]);


        const month =
            Number(parts[1]) - 1;


        const day =
            Number(parts[2]);


        const date =
            new Date(
                year,
                month,
                day
            );


        if (
            Number.isNaN(
                date.getTime()
            )
        ) {

            return dateString;

        }


        return date.toLocaleDateString(
            'en-US',
            {
                year: 'numeric',
                month: 'long',
                day: '2-digit'
            }
        );

    }


    /* ======================================================
       UPDATE BUTTON TEXT
       ====================================================== */

    function updateDateDisplay() {

        const start =
            startInput.value.trim();

        const end =
            endInput.value.trim();


        /* -----------------------------------------------
           START + END
           ----------------------------------------------- */

        if (
            start &&
            end
        ) {

            display.textContent =
                formatDisplayDate(start) +
                ' - ' +
                formatDisplayDate(end);

            return;

        }


        /* -----------------------------------------------
           START ONLY
           ----------------------------------------------- */

        if (start) {

            display.textContent =
                'From ' +
                formatDisplayDate(start);

            return;

        }


        /* -----------------------------------------------
           END ONLY
           ----------------------------------------------- */

        if (end) {

            display.textContent =
                'Until ' +
                formatDisplayDate(end);

            return;

        }


        /* -----------------------------------------------
           NO FILTER
           ----------------------------------------------- */

        display.textContent =
            'Filter Installed Date';

    }


    /* ======================================================
       INITIAL DISPLAY
       ====================================================== */

    updateDateDisplay();


    /* ======================================================
       CREATE ONE FLATPICKR INSTANCE
       
       ATTACHED DIRECTLY TO THE BUTTON.
       ====================================================== */

    const picker =
        flatpickr(
            trigger,
            {

                /* -----------------------------------------
                   RANGE MODE
                   ----------------------------------------- */

                mode: 'range',


                /* -----------------------------------------
                   IMPORTANT:
                   ONLY ONE MONTH
                   ----------------------------------------- */

                showMonths: 1,


                /* -----------------------------------------
                   DATE FORMAT
                   ----------------------------------------- */

                dateFormat: 'Y-m-d',


                /* -----------------------------------------
                   EXISTING FILTER
                   ----------------------------------------- */

                defaultDate: initialDates,


                /* -----------------------------------------
                   PREVENT TEXT INPUT
                   ----------------------------------------- */

                allowInput: false,


                /* -----------------------------------------
                   WE WILL OPEN IT MANUALLY
                   ----------------------------------------- */

                clickOpens: false,


                /* -----------------------------------------
                   KEEP CALENDAR OPEN AFTER FIRST DATE
                   ----------------------------------------- */

                closeOnSelect: false,


                /* -----------------------------------------
                   USE FLATPICKR EVEN ON MOBILE
                   ----------------------------------------- */

                disableMobile: true,


                /* ==================================================
                   WHEN DATE CHANGES
                   ================================================== */

                onChange:
                    function (
                        selectedDates,
                        dateStr,
                        instance
                    ) {


                        /* ----------------------------------
                           NOTHING SELECTED
                           ---------------------------------- */

                        if (
                            !selectedDates ||
                            selectedDates.length === 0
                        ) {

                            startInput.value = '';
                            endInput.value = '';

                            updateDateDisplay();

                            return;

                        }


                        /* ----------------------------------
                           FIRST DATE
                           ---------------------------------- */

                        const firstDate =
                            instance.formatDate(
                                selectedDates[0],
                                'Y-m-d'
                            );


                        /* ----------------------------------
                           ONLY FIRST DATE SELECTED
                           
                           DO NOT REDIRECT YET.
                           ---------------------------------- */

                        if (
                            selectedDates.length === 1
                        ) {

                            startInput.value =
                                firstDate;

                            endInput.value =
                                '';

                            updateDateDisplay();

                            return;

                        }


                        /* ----------------------------------
                           SECOND DATE
                           ---------------------------------- */

                        const secondDate =
                            instance.formatDate(
                                selectedDates[1],
                                'Y-m-d'
                            );


                        /* ----------------------------------
                           SORT DATES
                           
                           This allows the user to click
                           either the earlier or later date
                           first.
                           ---------------------------------- */

                        if (
                            secondDate < firstDate
                        ) {

                            startInput.value =
                                secondDate;

                            endInput.value =
                                firstDate;

                        } else {

                            startInput.value =
                                firstDate;

                            endInput.value =
                                secondDate;

                        }


                        /* ----------------------------------
                           UPDATE BUTTON
                           ---------------------------------- */

                        updateDateDisplay();


                        /* ----------------------------------
                           CLOSE PICKER
                           ---------------------------------- */

                        setTimeout(
                            function () {

                                instance.close();

                            },
                            100
                        );


                        /* ----------------------------------
                           BUILD DASHBOARD URL
                           
                           Preserve SEARCH if it exists.
                           ---------------------------------- */

                        const currentUrl =
                            new URL(
                                window.location.href
                            );


                        const dashboardUrl =
                            new URL(
                                '<?= site_url('dashboard') ?>',
                                window.location.origin
                            );


                        /* ----------------------------------
                           PRESERVE SEARCH
                           ---------------------------------- */

                        const currentSearch =
                            currentUrl.searchParams.get(
                                'search'
                            );


                        if (currentSearch) {

                            dashboardUrl.searchParams.set(
                                'search',
                                currentSearch
                            );

                        }


                        /* ----------------------------------
                           ADD START DATE
                           ---------------------------------- */

                        dashboardUrl.searchParams.set(
                            'start_date',
                            startInput.value
                        );


                        /* ----------------------------------
                           ADD END DATE
                           ---------------------------------- */

                        dashboardUrl.searchParams.set(
                            'end_date',
                            endInput.value
                        );


                        /* ----------------------------------
                           RESET PAGE TO 1
                           
                           Very important when a date filter
                           is applied.
                           ---------------------------------- */

                        dashboardUrl.searchParams.delete(
                            'page'
                        );


                        /* ----------------------------------
                           REDIRECT AFTER PICKER CLOSES
                           ---------------------------------- */

                        setTimeout(
                            function () {

                                window.location.href =
                                    dashboardUrl.toString();

                            },
                            180
                        );

                    },


                /* ==================================================
                   OPEN
                   ================================================== */

                onOpen:
                    function (
                        selectedDates,
                        dateStr,
                        instance
                    ) {

                        /* ----------------------------------
                           Force exactly one month
                           ---------------------------------- */

                        instance.set(
                            'showMonths',
                            1
                        );


                        updateDateDisplay();

                    },


                /* ==================================================
                   READY
                   ================================================== */

                onReady:
                    function (
                        selectedDates,
                        dateStr,
                        instance
                    ) {

                        /* ----------------------------------
                           Force exactly one month
                           ---------------------------------- */

                        instance.set(
                            'showMonths',
                            1
                        );


                        updateDateDisplay();

                    }

            }
        );


    /* ======================================================
       MANUAL BUTTON CLICK
       
       clickOpens:false means Flatpickr will NOT automatically
       handle the click.

       We open it ourselves.

       stopPropagation() prevents another generic click
       handler from interfering.
       ====================================================== */

    trigger.addEventListener(
        'click',
        function (event) {

            event.preventDefault();

            event.stopPropagation();


            /* -----------------------------------------
               Make sure only one month is displayed.
               ----------------------------------------- */

            picker.set(
                'showMonths',
                1
            );


            /* -----------------------------------------
               Open calendar.
               ----------------------------------------- */

            picker.open();

        }
    );


    /* ======================================================
       EXTRA PROTECTION
       
       If some other script tries to initialize Flatpickr
       on this same button, do not allow this script to
       initialize again.
       ====================================================== */

    trigger.dataset.installedDatePicker =
        'true';


    /* ======================================================
       DEBUG
       ====================================================== */

    console.log(
        'Installed Date Filter initialized successfully.'
    );

    console.log(
        'Single Flatpickr instance:',
        picker
    );

});


/* ==========================================================
   FLASH MESSAGE AUTO HIDE
   ========================================================== */

setTimeout(
    function () {

        document
            .querySelectorAll('.flash-message')
            .forEach(
                function (message) {

                    message.style.opacity =
                        '0';


                    setTimeout(
                        function () {

                            message.remove();

                        },
                        500
                    );

                }
            );

    },
    5000
);

</script>


</body>
</html>

