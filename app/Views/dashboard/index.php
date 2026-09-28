
<?= view('dashboard/layout/head') ?>

<style>
    html,
    body {
        min-height: 100%;
        overflow-y: auto !important;
    }

    .main-wrapper {
        min-height: 100vh;
        overflow: visible;
    }

    #btn-more-model + .machine-count-menu {
        height: 150px !important;
        max-height: 150px !important;
        overflow-y: scroll !important;
        overflow-x: hidden !important;
    }

    /* ==========================================================
   DATATABLE PAGINATION — RIGHT ALIGN
   ========================================================== */

    #clinicRecordsTable_wrapper .dataTables_paginate {
        float: right !important;
        text-align: right !important;
        margin-top: 10px;
        margin-right: 10px;
    }

    #clinicRecordsTable_wrapper .dataTables_info {
        float: left;
        margin-top: 10px;
        margin-left: 10px;
    }

    #clinicRecordsTable_wrapper .dataTables_length {
        float: left;
    }

    #clinicRecordsTable_wrapper::after {
        content: "";
        display: table;
        clear: both;
    }

    #clinicRecordsTable_wrapper .dataTables_info {
    margin: 0 !important;
    }

    #clinicRecordsTable_wrapper .dataTables_paginate {
        margin: 0 !important;
        text-align: right !important;
    }
</style>

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


                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom machine-count-menu">

                                        <?php
                                            /*
                                            |--------------------------------------------------------------------------
                                            | MACHINE TYPE MAPPING
                                            |--------------------------------------------------------------------------
                                            | Vu10       -> Urine Analyzer
                                            | utz        -> Ultrasound
                                            | vet monitor -> X-Ray
                                            |--------------------------------------------------------------------------
                                            */

                                            $machineGroupedCounts = [];

                                            foreach ($machine_counts ?? [] as $machine) {

                                                $rawMachine = strtolower(trim((string) ($machine['machine_label'] ?? '')));
                                                $total = (int) ($machine['total'] ?? 0);

                                                switch ($rawMachine) {

                                                    case 'vu10':
                                                        $machineLabel = 'Urine Analyzer';
                                                        break;

                                                    case 'utz':
                                                        $machineLabel = 'Ultrasound';
                                                        break;

                                                    case 'vet monitor':
                                                        $machineLabel = 'X-Ray';
                                                        break;

                                                    default:
                                                        $machineLabel = trim((string) ($machine['machine_label'] ?? ''));
                                                        break;
                                                }

                                                if ($machineLabel === '') {
                                                    continue;
                                                }

                                                if (!isset($machineGroupedCounts[$machineLabel])) {
                                                    $machineGroupedCounts[$machineLabel] = 0;
                                                }

                                                $machineGroupedCounts[$machineLabel] += $total;
                                            }
                                            ?>

                                            <?php foreach ($machineGroupedCounts as $machineLabel => $total): ?>

                                                <li>
                                                    <button
                                                        type="button"
                                                        class="dropdown-item machine-count-item"
                                                        data-machine="<?= esc($machineLabel) ?>"
                                                        data-total="<?= (int) $total ?>">

                                                        <i class="bi bi-box"></i>

                                                        <?= esc($machineLabel) ?>

                                                        (<?= number_format((int) $total) ?>)

                                                    </button>
                                                </li>

                                            <?php endforeach; ?>

                                    </ul>

                                </div>

                            </div>


                            <div
                                class="stat-value"
                                id="all-machine-total"
                                data-default-value="<?= (int) count($machineGroupedCounts ?? []) ?>">

                                <?= number_format(count($machineGroupedCounts ?? [])) ?>

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
             SUPPORT ANALYTICS
             ================================================== -->

        <div class="col-12">
            <div class="row g-4">
                <div class="col-12 col-xl-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h2 class="card-title mb-1">Monthly Service Support</h2>
                            <p class="text-muted small mb-0">Support tickets by month</p>
                        </div>
                        <div class="card-body">
                            <div id="monthlySupportChart" style="min-height: 280px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h2 class="card-title mb-1">Pullout Timeline</h2>
                            <p class="text-muted small mb-0">Pullout tickets by month</p>
                        </div>
                        <div class="card-body">
                            <div id="pulloutTimelineChart" style="min-height: 280px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h2 class="card-title mb-1">Machines Per Year</h2>
                            <p class="text-muted small mb-0">Installed active machines by year</p>
                        </div>
                        <div class="card-body">
                            <div id="machineYearlyChart" style="min-height: 280px;"></div>
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
                            id="clinicRecordsSearchForm"
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
                                id="clinicRecordsSearch"
                                value="<?= esc($search ?? '') ?>"
                                class="form-control"
                                placeholder="Search clinic, machine, model...">


                            <!-- <button
                                type="submit"
                                id="clinicRecordsSearchButton"
                                class="btn btn-primary">

                                Search

                            </button> -->


                            <?php if (!empty($search)): ?>

                                <button
                                    type="button"
                                    id="clinicRecordsReset"
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

                                </button>

                            <?php endif; ?>

                        </form>

                    </div>

                </div>


                <!-- ==================================================
                     TABLE
                     ================================================== -->

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table id="clinicRecordsTable"
                            class="table table-striped table-hover align-middle mb-0">

                            <thead class="table-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Clinic Name</th>
                                    <th>Address</th>
                                    <th>Province</th>
                                    <th>Machine</th>
                                    <th>Model</th>
                                    <th>Installed Date</th>
                                    <th>SN</th>
                                    <th>DR Number</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- DataTables loads the rows through AJAX -->
                            </tbody>

                        </table>


                    </div>


                    <!-- ==================================================
                         PAGINATION
                         ================================================== -->

                </div>

            </div>

        </div>

    </div>



<!-- ======================================================
     REUSABLE VIEW CONTRACT MODAL
     
     IMPORTANT:
     This modal is intentionally NOT inside $records foreach.
     
     DataTables is server-side, so rows are loaded through AJAX.
     We use ONE reusable modal for every record.
     ====================================================== -->

<div
    class="modal fade"
    id="viewContractModal"
    tabindex="-1"
    aria-labelledby="viewContractModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="viewContractModalLabel">

                    <i class="bi bi-file-earmark-text me-2"></i>
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

                <!--
                    JavaScript will put the contract preview here.
                -->

                <div
                    id="viewContractContent"
                    class="p-5 text-center">

                    <div class="spinner-border text-primary mb-3"></div>

                    <div>
                        Loading contract...
                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <a
                    href="#"
                    target="_blank"
                    id="viewContractOpenLink"
                    class="btn btn-outline-primary d-none">

                    <i class="bi bi-box-arrow-up-right me-1"></i>

                    Open in New Tab

                </a>

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



<!-- ======================================================
     REUSABLE ATTACH / REPLACE CONTRACT MODAL

     IMPORTANT:
     ONE modal only.

     JavaScript fills the record ID dynamically.
     ====================================================== -->

<div
    class="modal fade"
    id="contractModal"
    tabindex="-1"
    aria-labelledby="contractModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                method="post"
                action="<?= site_url('dashboard/attach-contract') ?>"
                enctype="multipart/form-data"
                id="contractForm">

                <?= csrf_field() ?>


                <!-- ==========================================
                     RECORD ID
                     ========================================== -->

                <input
                    type="hidden"
                    name="id"
                    id="contract_id"
                    value="">


                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="contractModalLabel">

                        <i class="bi bi-paperclip me-2"></i>
                        Attach Contract

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    <!-- ======================================
                         CLINIC
                         ====================================== -->

                    <div class="mb-3">

                        <label class="form-label">
                            Clinic
                        </label>

                        <input
                            type="text"
                            id="contract_clinic"
                            class="form-control"
                            readonly>

                    </div>


                    <!-- ======================================
                         ADDRESS
                         ====================================== -->

                    <div class="mb-3">

                        <label class="form-label">
                            Address
                        </label>

                        <input
                            type="text"
                            id="contract_address"
                            class="form-control"
                            readonly>

                    </div>


                    <!-- ======================================
                         MACHINE / MODEL
                         ====================================== -->

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Machine
                            </label>

                            <input
                                type="text"
                                id="contract_machine"
                                class="form-control"
                                readonly>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Model
                            </label>

                            <input
                                type="text"
                                id="contract_model"
                                class="form-control"
                                readonly>

                        </div>


                        <div class="col-md-12">

                            <label class="form-label">
                                Serial Number
                            </label>

                            <input
                                type="text"
                                id="contract_sn"
                                class="form-control"
                                readonly>

                        </div>

                    </div>


                    <!-- ======================================
                         EXISTING CONTRACT NOTICE
                         ====================================== -->

                    <div
                        id="contractExistingAlert"
                        class="alert alert-info mt-3 d-none">

                        <i class="bi bi-info-circle me-1"></i>

                        This record already has a contract.

                        <br>

                        Uploading a new file will replace the
                        current contract association.

                    </div>


                    <!-- ======================================
                         NO CONTRACT NOTICE
                         ====================================== -->

                    <div
                        id="contractNoExistingAlert"
                        class="alert alert-warning mt-3 d-none">

                        <i class="bi bi-exclamation-triangle me-1"></i>

                        No contract is currently attached.

                    </div>


                    <!-- ======================================
                         FILE
                         ====================================== -->

                    <div class="mb-3 mt-3">

                        <label
                            for="contract_file"
                            class="form-label">

                            Contract File
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="file"
                            name="contract_file"
                            id="contract_file"
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

                        <i class="bi bi-x-circle me-1"></i>

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-success">

                        <i class="bi bi-upload me-1"></i>

                        <span id="contractSubmitText">
                            Upload Contract
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



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

<div
    class="modal fade"
    id="editRecordModal"
    tabindex="-1"
    aria-labelledby="editRecordModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form
                method="post"
                action="<?= site_url('dashboard/update') ?>"
                id="editRecordForm">

                <?= csrf_field() ?>

                <input
                    type="hidden"
                    name="id"
                    id="edit_id">

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="editRecordModalLabel">

                        <i class="bi bi-pencil-square me-2"></i>
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

                        <!-- CLINIC -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Clinic Name
                            </label>

                            <input
                                type="text"
                                name="Clinic_name"
                                id="edit_Clinic_name"
                                class="form-control"
                                required>

                        </div>


                        <!-- ADDRESS -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Address
                            </label>

                            <input
                                type="text"
                                name="Address"
                                id="edit_Address"
                                class="form-control"
                                required>

                        </div>


                        <!-- PROVINCE -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Province
                            </label>

                            <input
                                type="text"
                                name="Province"
                                id="edit_Province"
                                class="form-control"
                                required>

                        </div>


                        <!-- MACHINE -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Machine
                            </label>

                            <input
                                type="text"
                                name="Machine"
                                id="edit_Machine"
                                class="form-control"
                                required>

                        </div>


                        <!-- MODEL -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Model
                            </label>

                            <input
                                type="text"
                                name="Model"
                                id="edit_Model"
                                class="form-control"
                                required>

                        </div>


                        <!-- INSTALLED DATE -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Installed Date
                            </label>

                            <input
                                type="date"
                                name="Installed_date"
                                id="edit_Installed_date"
                                class="form-control"
                                required>

                        </div>


                        <!-- SERIAL NUMBER -->

                        <div class="col-md-6">

                            <label class="form-label">
                                SN
                            </label>

                            <input
                                type="text"
                                name="SN"
                                id="edit_SN"
                                class="form-control"
                                required>

                        </div>


                        <!-- DR NUMBER -->

                        <div class="col-md-6">

                            <label class="form-label">
                                DR Number
                            </label>

                            <input
                                type="text"
                                name="DR_Number"
                                id="edit_DR_Number"
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

                        <i class="bi bi-x-circle me-1"></i>
                        Close

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle me-1"></i>
                        Update Machine

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

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

$(document).ready(function () {

    if (
        typeof $.fn.DataTable === 'undefined' ||
        !$('#clinicRecordsTable').length
    ) {
        return;
    }


    /* ======================================================
       DATATABLE
       ====================================================== */

    const table = $('#clinicRecordsTable').DataTable({

        processing: true,

        serverSide: true,

        searching: true,

        ordering: true,

        paging: true,

        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],

        ajax: {

            url: "<?= site_url('dashboard/search') ?>",

            type: "GET",

            data: function (d) {

                /*
                 * Send Installed Date filters
                 */

                d.start_date =
                    $('#start_date').val() || '';

                d.end_date =
                    $('#end_date').val() || '';

            },

            error: function (xhr) {

                console.error(
                    'DataTables AJAX Error:',
                    xhr.responseText
                );

            }

        },


        /* ==================================================
           COLUMNS
           ================================================== */

        columns: [


                {
                    data: null,

                    className: 'text-center',

                    orderable: false,

                    searchable: false,

                    render: function (data, type, row, meta) {

                        return meta.settings._iDisplayStart + meta.row + 1;

                    }

                },


            /*
             * CLINIC
             */

            {
                data: 'Clinic_name'
            },


            /*
             * ADDRESS
             */

            {
                data: 'Address'
            },


            /*
             * PROVINCE
             */

            {
                data: 'Province'
            },


            /*
             * MACHINE
             */

            {
                data: 'Machine'
            },


            /*
             * MODEL
             */

            {
                data: 'Model'
            },


            /*
             * INSTALLED DATE
             */

            {
                data: 'Installed_date'
            },


            /*
             * SN
             */

            {
                data: 'SN'
            },


            /*
             * DR NUMBER
             */

            {
                data: 'DR_Number'
            },


            /*
             * ACTIONS
             */

           {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',

                render: function (data, type, row) {

                    const id = Number(row.id || 0);
                    const contractId = Number(row.contract_id || 0);

                    return `
                        <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">

                            <!-- ==========================================
                                VIEW CONTRACT
                                ========================================== -->

                            ${
                                contractId > 0
                                ? `
                                    <button
                                        type="button"
                                        class="btn btn-outline-success btn-sm dt-view-contract"
                                        data-id="${id}"
                                        data-contract-id="${contractId}"
                                        title="View Contract">

                                        <i class="bi bi-file-earmark-text"></i>
                                        View

                                    </button>
                                `
                                : `
                                    <span
                                        class="badge bg-warning text-dark"
                                        title="No contract attached">

                                        <i class="bi bi-file-earmark-x"></i>
                                        No Contract Attached

                                    </span>
                                `
                            }


                            <!-- ==========================================
                                ATTACH / REPLACE CONTRACT
                                ========================================== -->

                            <button
                                type="button"
                                class="btn btn-outline-success btn-sm dt-contract"
                                data-id="${id}"
                                data-contract-id="${contractId}"
                                title="${contractId > 0 ? 'Replace Contract' : 'Attach Contract'}">

                                <i class="bi bi-paperclip"></i>

                                ${contractId > 0 ? 'Replace' : 'Attach'}

                            </button>


                            <!-- ==========================================
                                EDIT
                                ========================================== -->

                            <button
                                type="button"
                                class="btn btn-outline-primary btn-sm dt-edit-record"
                                data-id="${id}"
                                title="Edit Machine">

                                <i class="bi bi-pencil"></i>
                                Edit

                            </button>


                            <!-- ==========================================
                                DELETE
                                ========================================== -->

                            <a
                                href="<?= site_url('dashboard') ?>?delete=${id}"
                                class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Delete this record?');"
                                title="Delete Machine">

                                <i class="bi bi-trash"></i>
                                Delete

                            </a>

                        </div>
                    `;
                }
            }

        ],


        /*
        |--------------------------------------------------------------------------
        | DEFAULT ORDER
        |--------------------------------------------------------------------------
        */

        order: [
            [1, 'asc']
        ],


        /*
        |--------------------------------------------------------------------------
        | TABLE OPTIONS
        |--------------------------------------------------------------------------
        */

        autoWidth: false,

        scrollX: true,

        dom: 'lt<"d-flex justify-content-between align-items-center px-3 py-2"ip>'


    });


    /* ======================================================
       CUSTOM SEARCH INPUT
       ====================================================== */

    $('#clinicRecordsSearchForm').on(
        'submit',
        function (event) {

            event.preventDefault();

            table
                .search(
                    $('#clinicRecordsSearch').val()
                )
                .draw();

        }
    );


    /* ======================================================
       SEARCH WHILE TYPING
       
       THIS DOES NOT REFRESH THE PAGE.
       
       ONLY DATATABLES REQUESTS NEW DATA.
       ====================================================== */

    let searchTimer = null;

    $('#clinicRecordsSearch').on(
        'input',
        function () {

            const value = this.value;

            clearTimeout(searchTimer);

            searchTimer = setTimeout(
                function () {

                    table
                        .search(value)
                        .draw();

                },
                300
            );

        }
    );


    /* ======================================================
       RESET SEARCH
       ====================================================== */

    $(document).on(
        'click',
        '#clinicRecordsReset',
        function (event) {

            event.preventDefault();

            $('#clinicRecordsSearch').val('');

            table
                .search('')
                .draw();

        }
    );


    /* ======================================================
       DATE FILTER
       
       ONLY RELOAD DATATABLE.
       NO PAGE REFRESH.
       ====================================================== */

    $('#start_date, #end_date').on(
        'change',
        function () {

            table.ajax.reload(
                null,
                true
            );

        }
    );


    /* ======================================================
       OPTIONAL:
       EXPOSE DATATABLE INSTANCE
       ====================================================== */

    window.clinicRecordsTable = table;

    /* ======================================================
   OPEN EDIT MODAL

   SERVER-SIDE DATATABLES FIX
   DataTables only renders the current page, so do NOT look
   for editRecordModal + id. Read the clicked row directly
   from DataTables and use ONE reusable edit modal.
   ====================================================== */

$(document).on(
    'click',
    '.dt-edit-record',
    function (event) {

        event.preventDefault();

        const button = $(this);
        const id = Number(button.attr('data-id'));

        if (!id) {
            console.error('Edit: Invalid record ID.');
            return;
        }

        const dataTable = $('#clinicRecordsTable').DataTable();

        const rowData = dataTable
            .row(button.closest('tr'))
            .data();

        if (!rowData) {
            console.error('Edit: Could not retrieve row data.', id);
            alert('Unable to load this machine record. Please try again.');
            return;
        }

        console.log('Edit record:', rowData);

        const modalElement = document.getElementById('editRecordModal');

        if (!modalElement) {
            console.error('Edit modal not found: #editRecordModal');
            alert('The Edit Machine modal is missing from the page.');
            return;
        }

        const fields = {
            '#edit_id': rowData.id || id,
            '#edit_Clinic_name': rowData.Clinic_name || '',
            '#edit_Address': rowData.Address || '',
            '#edit_Province': rowData.Province || '',
            '#edit_Machine': rowData.Machine || '',
            '#edit_Model': rowData.Model || '',
            '#edit_Installed_date': rowData.Installed_date || '',
            '#edit_SN': rowData.SN || '',
            '#edit_DR_Number': rowData.DR_Number || ''
        };

        Object.keys(fields).forEach(function (selector) {
            const element = document.querySelector(selector);
            if (element) {
                element.value = fields[selector];
            }
        });

        $(modalElement).attr('data-record-id', rowData.id || id);

        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        modal.show();
    }
);


/* ======================================================
   OPEN ATTACH / REPLACE CONTRACT MODAL
   SERVER-SIDE DATATABLES FIX
   ====================================================== */

$(document).on(
    'click',
    '.dt-contract',
    function (event) {

        event.preventDefault();

        const button = $(this);
        const id = Number(button.attr('data-id'));
        const contractId = Number(button.attr('data-contract-id') || 0);

        if (!id) {
            console.error('Contract: Invalid record ID.');
            return;
        }

        const dataTable = $('#clinicRecordsTable').DataTable();
        const rowData = dataTable.row(button.closest('tr')).data();

        if (!rowData) {
            console.error('Contract: Could not retrieve DataTables row.', id);
            alert('Unable to load this machine record. Please try again.');
            return;
        }

        const modalElement = document.getElementById('contractModal');

        if (!modalElement) {
            console.error('Reusable contract modal not found: #contractModal');
            alert('The Contract modal is missing from the page.');
            return;
        }

        const fields = {
            '#contract_id': rowData.id || id,
            '#contract_contract_id': rowData.contract_id || contractId || '',
            '#contract_clinic': rowData.Clinic_name || '',
            '#contract_address': rowData.Address || '',
            '#contract_machine': rowData.Machine || '',
            '#contract_model': rowData.Model || '',
            '#contract_sn': rowData.SN || ''
        };

        Object.keys(fields).forEach(function (selector) {
            const element = document.querySelector(selector);
            if (element) {
                element.value = fields[selector];
            }
        });

        $(modalElement)
            .attr('data-record-id', rowData.id || id)
            .attr('data-contract-id', rowData.contract_id || contractId || 0);

        const title = modalElement.querySelector('.modal-title');

        if (title) {
            title.innerHTML =
                contractId > 0
                    ? '<i class="bi bi-paperclip me-2"></i>Replace Contract'
                    : '<i class="bi bi-paperclip me-2"></i>Attach Contract';
        }

        bootstrap.Modal
            .getOrCreateInstance(modalElement)
            .show();
    }
);


/* ======================================================
   OPEN VIEW CONTRACT MODAL
   SERVER-SIDE DATATABLES FIX
   ====================================================== */

$(document).on(
    'click',
    '.dt-view-contract',
    function (event) {

        event.preventDefault();

        const button = $(this);
        const id = Number(button.attr('data-id'));
        const contractId = Number(button.attr('data-contract-id') || 0);

        if (!id) {
            console.error('View Contract: Invalid record ID.');
            return;
        }

        const dataTable = $('#clinicRecordsTable').DataTable();
        const rowData = dataTable.row(button.closest('tr')).data();

        if (!rowData) {
            console.error('View Contract: Could not retrieve DataTables row.', id);
            alert('Unable to load this machine record. Please try again.');
            return;
        }

        const modalElement = document.getElementById('viewContractModal');

        if (!modalElement) {
            console.error('Reusable view contract modal not found: #viewContractModal');
            alert('The View Contract modal is missing from the page.');
            return;
        }

        const fields = {
            '#view_contract_id': rowData.id || id,
            '#view_contract_contract_id': rowData.contract_id || contractId || '',
            '#view_contract_clinic': rowData.Clinic_name || '',
            '#view_contract_address': rowData.Address || '',
            '#view_contract_machine': rowData.Machine || '',
            '#view_contract_model': rowData.Model || '',
            '#view_contract_sn': rowData.SN || ''
        };

        Object.keys(fields).forEach(function (selector) {
            const element = document.querySelector(selector);
            if (element) {
                element.value = fields[selector];
            }
        });

        $(modalElement)
            .attr('data-record-id', rowData.id || id)
            .attr('data-contract-id', rowData.contract_id || contractId || 0);

        bootstrap.Modal
            .getOrCreateInstance(modalElement)
            .show();
    }
);


/* ======================================================
   END CONTRACT HANDLERS
   ====================================================== */

/* ======================================================
   OPEN VIEW CONTRACT MODAL
   ====================================================== */

$(document).on(
    'click',
    '.dt-view-contract',
    function (event) {

        event.preventDefault();

        const id = Number(
            $(this).data('id')
        );

        if (!id) {
            console.error('View Contract: Invalid record ID.');
            return;
        }

        const modalElement =
            document.getElementById(
                'viewContractModal' + id
            );

        if (!modalElement) {

            console.error(
                'View contract modal not found:',
                'viewContractModal' + id
            );

            alert(
                'View contract modal for this record was not found.'
            );

            return;
        }

        const modal =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );

        modal.show();

    }
);

});

/* ==========================================================
   SUPPORT ANALYTICS CHARTS
   ========================================================== */

if (typeof ApexCharts !== 'undefined') {
    const monthlySupport = <?= json_encode($monthly_support ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    const pulloutTimeline = <?= json_encode($pullout_timeline ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
   <?php
        /*
        |--------------------------------------------------------------------------
        | NORMALIZE MACHINE YEARLY DATA
        |--------------------------------------------------------------------------
        */

        $machineYearlyGrouped = [];

        foreach ($machine_yearly ?? [] as $row) {

            $rawMachine = strtolower(trim((string) ($row['machine'] ?? '')));
            $year = (string) ($row['year'] ?? '');
            $total = (int) ($row['total'] ?? 0);

            switch ($rawMachine) {

                case 'vu10':
                    $machineLabel = 'Urine Analyzer';
                    break;

                case 'utz':
                    $machineLabel = 'Ultrasound';
                    break;

                 case 'vet monitor':
                case 'x-ray':
                case 'xray':
                    $machineLabel = 'X-Ray';
                    break;

                default:
                    $machineLabel = trim((string) ($row['machine'] ?? ''));
                    break;
            }

            if ($machineLabel === '' || $year === '') {
                continue;
            }

            $key = $year . '|' . $machineLabel;

            if (!isset($machineYearlyGrouped[$key])) {
                $machineYearlyGrouped[$key] = [
                    'year' => $year,
                    'machine' => $machineLabel,
                    'total' => 0
                ];
            }

            $machineYearlyGrouped[$key]['total'] += $total;
        }

        $machineYearly = array_values($machineYearlyGrouped);

        /*
        |--------------------------------------------------------------------------
        | Sort by year and machine name
        |--------------------------------------------------------------------------
        */

        usort($machineYearly, function ($a, $b) {

            if ($a['year'] === $b['year']) {
                return strcmp($a['machine'], $b['machine']);
            }

            return strcmp($a['year'], $b['year']);
        });
        ?>

        const machineYearly = <?= json_encode(
            $machineYearly,
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
        ) ?>;

    function chartCategories(rows) {
        return rows.map(function (row) {
            return row.period || '';
        });
    }

    function chartValues(rows) {
        return rows.map(function (row) {
            return Number(row.total || 0);
        });
    }

    function renderEmptyChart(selector, message) {
        const element = document.querySelector(selector);
        if (element) {
            element.innerHTML = '<div class="text-center text-muted py-5">' + message + '</div>';
        }
    }

    if (monthlySupport.length) {
        new ApexCharts(document.querySelector('#monthlySupportChart'), {
            chart: { type: 'bar', height: 280, toolbar: { show: false } },
            series: [{ name: 'Support Tickets', data: chartValues(monthlySupport) }],
            xaxis: { categories: chartCategories(monthlySupport) },
            colors: ['#0d6efd'],
            plotOptions: { bar: { borderRadius: 4, columnWidth: '55%' } },
            dataLabels: { enabled: false },
            grid: { borderColor: '#e9ecef' }
        }).render();
    } else {
        renderEmptyChart('#monthlySupportChart', 'No support data available.');
    }

    if (pulloutTimeline.length) {
        new ApexCharts(document.querySelector('#pulloutTimelineChart'), {
            chart: { type: 'pie', height: 280, toolbar: { show: false } },
            series: chartValues(pulloutTimeline),
            labels: chartCategories(pulloutTimeline),
            colors: ['#dc3545', '#fd7e14', '#ffc107', '#198754', '#0d6efd', '#6f42c1'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: true }
        }).render();
    } else {
        renderEmptyChart('#pulloutTimelineChart', 'No pullout data available.');
    }

    if (machineYearly.length) {
        const years = [...new Set(machineYearly.map(function (row) { return String(row.year); }))];
        const machineNames = [...new Set(machineYearly.map(function (row) { return row.machine; }))];
        const machineSeries = machineNames.map(function (machine) {
            return {
                name: machine,
                data: years.map(function (year) {
                    const row = machineYearly.find(function (item) {
                        return String(item.year) === year && item.machine === machine;
                    });
                    return Number(row?.total || 0);
                })
            };
        });

        new ApexCharts(document.querySelector('#machineYearlyChart'), {
            chart: { type: 'line', height: 280, toolbar: { show: false } },
            series: machineSeries,
            xaxis: { categories: years },
            stroke: { curve: 'smooth', width: 3 },
            dataLabels: { enabled: false },
            legend: { position: 'bottom' },
            grid: { borderColor: '#e9ecef' }
        }).render();
    } else {
        renderEmptyChart('#machineYearlyChart', 'No machine data available.');
    }
}

</script>

</body>
</html>

