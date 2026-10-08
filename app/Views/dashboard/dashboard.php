
<?= view('dashboard/layout/head') ?>

<style>
    :root {
        --corp-bg: #edf3fb;
        --corp-bg-strong: #e4edf9;
        --corp-card: #ffffff;
        --corp-card-alt: #f8fbff;
        --corp-border: rgba(15, 23, 42, 0.08);
        --corp-border-strong: rgba(15, 23, 42, 0.12);
        --corp-primary: #0f4c81;
        --corp-primary-strong: #0c3b66;
        --corp-accent: #2e7de1;
        --corp-success: #1b8f73;
        --corp-warning: #e6992a;
        --corp-danger: #d94a41;
        --corp-text: #162033;
        --corp-muted: #64748b;
        --corp-shadow: 0 16px 38px rgba(15, 23, 42, 0.08);
    }

    html,
    body {
        min-height: 100%;
        overflow-y: auto !important;
        background: linear-gradient(180deg, var(--corp-bg-strong) 0%, var(--corp-bg) 100%);
        color: var(--corp-text);
        font-family: "Segoe UI", Inter, Arial, sans-serif;
    }

    .main-wrapper {
        min-height: 100vh;
        overflow: visible;
        padding: 1.5rem 1.5rem 2.5rem;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1.4rem 1.6rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--corp-border);
        border-radius: 20px;
        background: linear-gradient(135deg, #0d1b2a 0%, #183b5c 45%, #1b5f94 100%);
        box-shadow: var(--corp-shadow);
        color: #fff;
    }

    .page-header .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.72rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        opacity: 0.85;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .page-header .eyebrow::before {
        content: "";
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #6ee7b7;
        box-shadow: 0 0 0 6px rgba(110, 231, 183, 0.18);
    }

    .page-title {
        margin: 0;
        font-size: clamp(1.8rem, 2vw + 1rem, 2.7rem);
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .page-subtitle {
        margin: 0.25rem 0 0;
        color: rgba(255, 255, 255, 0.78);
        font-size: 0.88rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .page-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.7rem 1rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .page-header-badge .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #6ee7b7;
        box-shadow: 0 0 0 5px rgba(110, 231, 183, 0.18);
    }

    .card {
        border: 1px solid var(--corp-border);
        border-radius: 18px;
        background: var(--corp-card);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    }

    .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        padding: 1rem 1.1rem 0.9rem;
    }

    .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--corp-text);
    }

    .card-body {
        background: transparent;
    }

    .card-stat {
        position: relative;
        min-height: 220px;
        overflow: hidden;
        border: 1px solid var(--corp-border);
        border-radius: 18px;
        background: linear-gradient(180deg, #fff 0%, #f7fbff 100%);
        box-shadow: var(--corp-shadow);
        padding: 1rem;
    }

    .card-stat::before {
        content: "";
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--corp-primary) 0%, var(--corp-accent) 100%);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
    }

    .stat-label {
        font-size: 0.73rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: var(--corp-muted);
    }

    .card-more-btn {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: var(--corp-card-alt);
        color: var(--corp-primary);
    }

    .stat-value {
        margin-top: 0.75rem;
        font-size: clamp(2rem, 2vw + 1rem, 2.7rem);
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -0.05em;
        color: var(--corp-primary-strong);
    }

    .trend-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        margin-top: 1rem;
        padding: 0.4rem 0.7rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        border: 1px solid rgba(17, 24, 39, 0.06);
    }

    .trend-up {
        background: rgba(27, 143, 115, 0.08);
        color: var(--corp-success);
    }

    .trend-badge i {
        font-size: 0.78rem;
    }

    .badge {
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    .btn-date-picker {
        border: 1px solid rgba(15, 23, 42, 0.1);
        background: rgba(255, 255, 255, 0.9);
        color: var(--corp-text);
        border-radius: 12px;
        padding: 0.72rem 1rem;
        font-weight: 600;
        box-shadow: 0 8px 16px rgba(15, 23, 42, 0.04);
    }

    .btn,
    .dropdown-item {
        transition: all 0.2s ease;
    }

    .btn:hover,
    .dropdown-item:hover {
        transform: translateY(-1px);
    }

    .dropdown-menu-custom {
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 12px;
        box-shadow: 0 16px 28px rgba(15, 23, 42, 0.12);
    }

    #btn-more-model + .machine-count-menu {
        height: 180px !important;
        max-height: 180px !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    #clinicRecordsTable {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    #clinicRecordsTable thead th {
        background: linear-gradient(135deg, #122639 0%, #183d60 100%);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border-bottom: none;
        padding: 0.9rem 0.75rem;
    }

    #clinicRecordsTable tbody td {
        padding: 0.8rem 0.75rem;
        border-color: rgba(15, 23, 42, 0.06);
        vertical-align: middle;
    }

    #clinicRecordsTable tbody tr:hover {
        background: rgba(17, 94, 162, 0.03);
    }

    #clinicRecordsToolbar {
        gap: 0.75rem;
    }

    .dashboard-import-form {
        background: var(--corp-card-alt);
        border: 1px solid var(--corp-border);
        border-radius: 12px;
        padding: 0.4rem 0.55rem;
        align-items: center;
    }

    .dashboard-import-form .form-control {
        min-width: 180px;
        border: 1px solid rgba(15, 23, 42, 0.08);
    }

    #clinicRecordsSearchForm {
        max-width: 420px;
    }

    #clinicRecordsSearch {
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: var(--corp-card-alt);
    }

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

    #installedDateFilterContainer {
        max-width: 100%;
    }

    #clinicRecordsTable tbody td:nth-child(2),
    #clinicRecordsTable tbody td:nth-child(3),
    #clinicRecordsTable tbody td:nth-child(4),
    #clinicRecordsTable tbody td:nth-child(5),
    #clinicRecordsTable tbody td:nth-child(6),
    #clinicRecordsTable tbody td:nth-child(8),
    #clinicRecordsTable tbody td:nth-child(9) {
        white-space: normal !important;
        overflow-wrap: anywhere;
        word-break: normal;
    }

    @media (max-width: 767.98px) {
        .main-wrapper {
            padding: 1rem !important;
        }

        .page-header {
            display: flex;
            flex-direction: column;
            align-items: stretch !important;
            gap: 1rem;
        }

        .page-header > div {
            width: 100%;
        }

        .page-title {
            font-size: 1.6rem;
            word-break: break-word;
        }

        .page-subtitle {
            font-size: 0.8rem;
        }

        .card-stat {
            min-width: 0;
        }

        .card-stat .card-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
        }

        .card-stat .stat-label {
            white-space: normal !important;
            word-break: break-word;
            line-height: 1.35;
            min-width: 0;
        }

        .card-stat .stat-value {
            font-size: clamp(1.5rem, 6vw, 2.1rem);
            word-break: break-word;
            line-height: 1.2;
        }

        .card-stat .badge,
        .card-stat .trend-badge,
        .card-stat .mt-3.d-flex {
            white-space: normal !important;
            word-break: break-word;
        }

        .card-stat .mt-3.d-flex {
            justify-content: center !important;
        }

        .card-stat .trend-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
        }

        #installedDateFilterContainer {
            width: 100%;
            flex-direction: column;
            align-items: stretch !important;
        }

        #installedDateFilterContainer > div,
        #date-picker-trigger {
            width: 100%;
        }

        #clinicRecordsToolbar {
            width: 100%;
            align-items: stretch !important;
        }

        #clinicRecordsToolbar > button,
        #clinicRecordsToolbar form,
        #clinicRecordsToolbar form .btn {
            width: 100%;
        }

        #clinicRecordsToolbar .dashboard-import-form {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr);
        }

        #clinicRecordsToolbar .dashboard-import-form .form-control {
            min-width: 0;
        }

        #clinicRecordsToolbar #clinicRecordsSearchForm {
            max-width: none !important;
        }

        #clinicRecordsTable_wrapper .dataTables_length,
        #clinicRecordsTable_wrapper .dataTables_filter {
            float: none !important;
            width: 100%;
            margin: 0.5rem 0;
            text-align: left !important;
        }

        #clinicRecordsTable_wrapper .dataTables_info,
        #clinicRecordsTable_wrapper .dataTables_paginate {
            float: none !important;
            width: 100%;
            margin: 0.5rem 0 !important;
            text-align: center !important;
        }

        #clinicRecordsTable_wrapper .dataTables_paginate .pagination {
            justify-content: center;
            flex-wrap: wrap;
        }
    }
</style>

<body>

<?php
    $flashError = session()->getFlashdata('error');
    $flashSuccess = session()->getFlashdata('success');
    $loginSuccess = session()->getFlashdata('login_success');
?>

<?php if ($loginSuccess): ?>
    <div id="login-success-message" style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%); z-index: 1200; width: min(90vw, 520px); background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 10px; font-weight: 600; opacity: 1; transition: opacity 0.5s ease;">
        <?= esc($loginSuccess) ?>
    </div>
    <script>
        setTimeout(function () {
            const message = document.getElementById('login-success-message');
            if (message) {
                message.style.opacity = '0';
                setTimeout(function () { message.remove(); }, 500);
            }
        }, 3000);
    </script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const errorMessage = <?= json_encode((string) ($flashError ?? ''), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    const successMessage = <?= json_encode((string) ($flashSuccess ?? ''), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;

    const accountSelect = document.getElementById('account');
    const accountAddress = document.getElementById('account_address');
    const accountMachineSelect = document.getElementById('cancelled_machine');
    if (accountSelect && accountAddress) {
        const updateAccountDetails = function () {
            const selectedOption = accountSelect.options[accountSelect.selectedIndex];
            accountAddress.value = selectedOption?.dataset.address || '';

            if (!accountMachineSelect) return;

            accountMachineSelect.replaceChildren(new Option('-- Select Machine --', ''));

            let machines = [];
            try {
                machines = JSON.parse(selectedOption?.dataset.machines || '[]');
            } catch (error) {
                machines = [];
            }

            const addedMachines = new Set();
            machines.forEach(function (machine) {
                const machineName = String(machine.machine || '').trim();
                const machineKey = machineName.toLowerCase();
                if (!machineName || addedMachines.has(machineKey)) return;

                addedMachines.add(machineKey);
                const details = [
                    machineName,
                    machine.model ? 'Model: ' + machine.model : '',
                    machine.sn ? 'SN: ' + machine.sn : ''
                ].filter(Boolean);
                accountMachineSelect.add(new Option(details.join(' | '), machineName));
            });

            accountMachineSelect.disabled = addedMachines.size === 0;
            if (addedMachines.size === 0) {
                accountMachineSelect.options[0].textContent = selectedOption?.value
                    ? '-- No Machines Available --'
                    : '-- Select Account First --';
            }
        };

        accountSelect.addEventListener('change', updateAccountDetails);
        updateAccountDetails();
    }

    if (errorMessage) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
        return;
    }

    if (successMessage) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: successMessage,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    }
});
</script>

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
            <div class="eyebrow">Operations</div>
            <h1 class="page-title">
                Executive Dashboard
            </h1>

            <p class="page-subtitle">
                LABLINE INC. • Service Performance Overview
            </p>
        </div>

        <div class="page-header-badge">
            <span class="status-dot"></span>
            Live operations
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

                <div class="col-md-3">

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
                                    Provinces
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ==========================================
                     TOTAL CLINICS
                     ========================================== -->

                <div class="col-md-3">

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
                                    Clinic Names
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ==========================================
                     MACHINE
                     ========================================== -->

                <div class="col-md-3">

                    <div class="card card-stat d-flex flex-column justify-content-between">

                        <div>

                            <div class="card-header">

                                <span class="stat-label">
                                    Total Tickets
                                </span>

                                <div class="dropdown">

                                    <button
                                        class="card-more-btn"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        aria-label="More Options"
                                        id="btn-more-ongoing-ticket">

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

                                <?= number_format(
                                    (int) ($ongoing_ticket_count ?? 0)
                                    + (int) ($pullout_ticket_count ?? 0)
                                    + (int) ($on_hold_ticket_count ?? 0)
                                    + (int) ($returned_ticket_count ?? 0)
                                    + (int) ($completed_ticket_count ?? 0)
                                ) ?>

                            </div>

                            <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">

                                <span class="badge bg-primary-subtle text-primary-emphasis px-2 py-1 rounded-pill">
                                    Ongoing: <?= number_format((int) ($ongoing_ticket_count ?? 0)) ?>
                                </span>

                                <span class="badge bg-danger-subtle text-danger-emphasis px-2 py-1 rounded-pill">
                                    Pull Out: <?= number_format((int) ($pullout_ticket_count ?? 0)) ?>
                                </span>

                                <span class="badge bg-secondary-subtle text-secondary-emphasis px-2 py-1 rounded-pill">
                                    On Hold: <?= number_format((int) ($on_hold_ticket_count ?? 0)) ?>
                                </span>

                                <span class="badge bg-success-subtle text-success-emphasis px-2 py-1 rounded-pill">
                                    Returned: <?= number_format((int) ($returned_ticket_count ?? 0)) ?>
                                </span>

                                <span class="badge bg-info-subtle text-info-emphasis px-2 py-1 rounded-pill">
                                    Completed: <?= number_format((int) ($completed_ticket_count ?? 0)) ?>
                                </span>

                            </div>


                            <div class="trend-badge trend-up mt-3">

                                <i class="bi bi-ticket-perforated"></i>

                                <span>
                                    Active support tickets
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

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
                                    Machine types
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-12">
            <div class="row g-4">
                <?php
                    $moduleSummary = [
                        ['label' => 'Users', 'value' => (int) ($user_count ?? 0), 'icon' => 'bi-people-fill', 'tone' => 'primary', 'records' => $module_details['Users'] ?? []],
                        ['label' => 'PMS', 'value' => (int) ($pms_count ?? 0), 'icon' => 'bi-wrench', 'tone' => 'success', 'records' => $module_details['PMS'] ?? []],
                        ['label' => 'MFS', 'value' => (int) ($mfs_count ?? 0), 'icon' => 'bi-clipboard-check', 'tone' => 'warning', 'records' => $module_details['MFS'] ?? []],
                        ['label' => 'FSR', 'value' => (int) ($fsr_count ?? 0), 'icon' => 'bi-file-earmark-text', 'tone' => 'info', 'records' => $module_details['FSR'] ?? []],
                        ['label' => 'Rotor', 'value' => (int) ($rotor_count ?? 0), 'icon' => 'bi-gear-fill', 'tone' => 'danger', 'records' => $module_details['Rotor'] ?? []],
                    ];
                ?>

                <?php foreach ($moduleSummary as $module): ?>
                    <?php $recordsJson = json_encode($module['records'] ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>
                    <div class="col-6 col-md-4 col-xl">
                        <div
                            class="card card-stat h-100 module-summary-card"
                            style="min-height: 160px; cursor: pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#moduleSummaryModal"
                            data-title="<?= esc($module['label']) ?>"
                            data-value="<?= number_format($module['value']) ?>"
                            data-detail="Total <?= esc($module['label']) ?> records currently recorded in the system."
                            data-icon="<?= esc($module['icon']) ?>"
                            data-tone="<?= esc($module['tone']) ?>"
                            data-records='<?= $recordsJson ?>'
                            tabindex="0"
                            role="button"
                            aria-label="View <?= esc($module['label']) ?> details"
                        >
                            <div class="card-header pb-2">
                                <span class="stat-label"><?= esc($module['label']) ?></span>
                                <span class="badge bg-<?= esc($module['tone']) ?>-subtle text-<?= esc($module['tone']) ?>-emphasis rounded-pill px-2 py-1">
                                    <i class="<?= esc($module['icon']) ?>"></i>
                                </span>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-between pt-3">
                                <div class="stat-value" style="font-size: clamp(1.6rem, 1.7vw + 0.8rem, 2.2rem);">
                                    <?= number_format($module['value']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
                        id="clinicRecordsToolbar"
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

                        <button
                            type="button"
                            class="btn btn-outline-danger btn-sm"
                            id="clinicStatusFilter"
                            data-status=""
                            aria-pressed="false">

                            <i class="bi bi-archive me-1"></i>
                            Show Cancelled Accounts

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
                                class="d-flex gap-2 align-items-center dashboard-import-form">

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
                                    <!-- <th class="text-center">Actions</th> -->
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

                                            $isInactive = strtoupper(trim((string) ($info['status'] ?? ''))) === 'I';

                                            ?>


                                            <option
                                                value="<?= esc($info['id'] ?? '') ?>"
                                                style="<?= $isInactive ? 'color: #dc3545;' : '' ?>"
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


<div class="modal fade" id="cancelledReasonModal" tabindex="-1" aria-labelledby="cancelledReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelledReasonModalLabel">Canceled Account Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Clinic</dt>
                    <dd class="col-sm-8" id="cancelledReasonClinic"></dd>
                    <dt class="col-sm-4">Address</dt>
                    <dd class="col-sm-8" id="cancelledReasonAddress"></dd>
                    <dt class="col-sm-4">Machine</dt>
                    <dd class="col-sm-8" id="cancelledReasonMachine"></dd>
                    <dt class="col-sm-4">Date Found Out</dt>
                    <dd class="col-sm-8" id="cancelledReasonDateFoundOut"></dd>
                    <dt class="col-sm-4">Date Confirmed</dt>
                    <dd class="col-sm-8" id="cancelledReasonDateConfirmed"></dd>
                    <dt class="col-sm-4">Personnel</dt>
                    <dd class="col-sm-8" id="cancelledReasonPersonnel"></dd>
                    <dt class="col-sm-4">Reason</dt>
                    <dd class="col-sm-8 text-break" id="cancelledReasonText"></dd>
                    <dt class="col-sm-4">Supplier</dt>
                    <dd class="col-sm-8" id="cancelledReasonSupplier"></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="moduleSummaryModal" tabindex="-1" aria-labelledby="moduleSummaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-2">
                <div class="d-flex align-items-center gap-3">
                    <span id="moduleSummaryIconBadge" class="badge rounded-pill px-3 py-2">
                        <i id="moduleSummaryIcon" class="bi bi-database"></i>
                    </span>
                    <div>
                        <div class="text-uppercase small text-muted fw-semibold">Overview</div>
                        <h5 class="modal-title mb-0" id="moduleSummaryModalLabel">Module</h5>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-1">
                <div class="text-center mb-3">
                    <div class="display-5 fw-bold" id="moduleSummaryValue">0</div>
                </div>
                <p class="text-muted mb-3 text-center" id="moduleSummaryDetail">
                    Summary details.
                </p>
                <div id="moduleSummaryTableWrapper" class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                    <table id="moduleSummaryTable" class="table table-sm table-hover align-middle mb-0 w-100">
                        <thead id="moduleSummaryTableHead">
                        </thead>
                        <tbody id="moduleSummaryTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
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

    function getPreferredTableColumns(record) {
        const preferred = ['id', 'clinic', 'machine', 'service_engineer', 'date', 'status', 'remarks', 'mfs_number', 'fsr_number', 'fname', 'lname'];
        const excluded = ['role', 'uname', 'username', 'pass', 'password', 'created_at', 'updated_at', 'deleted_at'];

        const keys = Object.keys(record || {}).filter(function (key) {
            return !excluded.includes(key);
        });

        if (keys.length === 0) {
            return [];
        }

        const priority = preferred.filter(function (key) {
            return keys.includes(key);
        });

        return priority.length > 0 ? priority : keys.slice(0, 5);
    }

    function renderModuleRecords(records) {
        const wrapper = document.getElementById('moduleSummaryTableWrapper');
        if (!wrapper) {
            return;
        }

        const filteredRecords = (records || []).filter(function (record) {
            const username = (record && (record.uname || record.username)) ? String(record.uname || record.username).trim().toLowerCase() : '';
            return username !== 'admin';
        });

        const firstRecord = filteredRecords.length ? filteredRecords[0] : {};
        const columns = getPreferredTableColumns(firstRecord);

        if ($.fn.DataTable.isDataTable('#moduleSummaryTable')) {
            $('#moduleSummaryTable').DataTable().destroy();
        }

        if (!filteredRecords.length || !columns.length) {
            wrapper.innerHTML = '<table id="moduleSummaryTable" class="table table-sm table-hover align-middle mb-0 w-100"><tbody><tr><td class="text-center text-muted py-4">No records found.</td></tr></tbody></table>';
            return;
        }

        const headHtml = '<thead><tr>' + columns.map(function (column) {
            return '<th class="text-uppercase small text-muted fw-semibold" style="white-space: nowrap;">' + column.replace(/_/g, ' ') + '</th>';
        }).join('') + '</tr></thead>';

        const bodyHtml = '<tbody>' + filteredRecords.map(function (record) {
            return '<tr>' + columns.map(function (column) {
                const value = record[column] ?? '';
                const text = value === '' || value === null ? '—' : String(value);
                return '<td class="align-middle text-break">' + text + '</td>';
            }).join('') + '</tr>';
        }).join('') + '</tbody>';

        wrapper.innerHTML = '<table id="moduleSummaryTable" class="table table-sm table-hover align-middle mb-0 w-100">' + headHtml + bodyHtml + '</table>';

        $('#moduleSummaryTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            pagingType: 'simple_numbers',
            language: {
                search: 'Search records:',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                emptyTable: 'No records found.'
            },
            destroy: true,
            responsive: true,
            scrollX: true
        });
    }

    document.querySelectorAll('.module-summary-card').forEach(function (card) {
        const openDetails = function () {
            const modal = document.getElementById('moduleSummaryModal');
            if (!modal) {
                return;
            }

            const title = card.dataset.title || 'Module';
            const value = card.dataset.value || '0';
            const detail = card.dataset.detail || 'Summary details.';
            const tone = card.dataset.tone || 'primary';
            const icon = card.dataset.icon || 'bi-database';
            const records = card.dataset.records ? JSON.parse(card.dataset.records) : [];

            const titleEl = document.getElementById('moduleSummaryModalLabel');
            const valueEl = document.getElementById('moduleSummaryValue');
            const detailEl = document.getElementById('moduleSummaryDetail');
            const iconBadge = document.getElementById('moduleSummaryIconBadge');
            const iconEl = document.getElementById('moduleSummaryIcon');

            if (titleEl) titleEl.textContent = title;
            if (valueEl) valueEl.textContent = value;
            if (detailEl) detailEl.textContent = detail;
            if (iconEl) {
                iconEl.className = 'bi ' + icon;
            }

            if (iconBadge) {
                const toneClass = {
                    primary: 'bg-primary-subtle text-primary-emphasis',
                    success: 'bg-success-subtle text-success-emphasis',
                    warning: 'bg-warning-subtle text-warning-emphasis',
                    info: 'bg-info-subtle text-info-emphasis',
                    danger: 'bg-danger-subtle text-danger-emphasis',
                };

                iconBadge.className = 'badge rounded-pill px-3 py-2 ' + (toneClass[tone] || 'bg-primary-subtle text-primary-emphasis');
            }

            renderModuleRecords(records);

            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();
        };

        card.addEventListener('click', openDetails);
        card.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openDetails();
            }
        });
    });

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

    } else if (typeof flatpickr === 'undefined') {

        console.error(
            'Installed Date Filter: Flatpickr is not loaded.'
        );

    } else {

        /* ======================================================
           DESTROY EXISTING FLATPICKR INSTANCE
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
           REMOVE ORPHANED FLATPICKR CALENDARS
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


            if (start) {

                display.textContent =
                    'From ' +
                    formatDisplayDate(start);

                return;

            }


            if (end) {

                display.textContent =
                    'Until ' +
                    formatDisplayDate(end);

                return;

            }


            display.textContent =
                'Filter Installed Date';

        }


        /* ======================================================
           INITIAL DISPLAY
           ====================================================== */

        updateDateDisplay();


        /* ======================================================
           CREATE FLATPICKR
           ====================================================== */

        const picker =
            flatpickr(
                trigger,
                {

                    mode: 'range',

                    showMonths: 1,

                    dateFormat: 'Y-m-d',

                    defaultDate: initialDates,

                    allowInput: false,

                    clickOpens: false,

                    closeOnSelect: false,

                    disableMobile: true,


                    /* ==================================================
                       DATE CHANGE
                       ================================================== */

                    onChange:
                        function (
                            selectedDates,
                            dateStr,
                            instance
                        ) {

                            if (
                                !selectedDates ||
                                selectedDates.length === 0
                            ) {

                                startInput.value = '';
                                endInput.value = '';

                                updateDateDisplay();

                                return;

                            }


                            /* ------------------------------------------
                               FIRST DATE
                               ------------------------------------------ */

                            const firstDate =
                                instance.formatDate(
                                    selectedDates[0],
                                    'Y-m-d'
                                );


                            /* ------------------------------------------
                               ONLY FIRST DATE
                               ------------------------------------------ */

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


                            /* ------------------------------------------
                               SECOND DATE
                               ------------------------------------------ */

                            const secondDate =
                                instance.formatDate(
                                    selectedDates[1],
                                    'Y-m-d'
                                );


                            /* ------------------------------------------
                               SORT DATES
                               ------------------------------------------ */

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


                            updateDateDisplay();


                            /* ------------------------------------------
                               CLOSE PICKER
                               ------------------------------------------ */

                            setTimeout(
                                function () {

                                    instance.close();

                                },
                                100
                            );


                            /* ------------------------------------------
                               BUILD DASHBOARD URL
                               ------------------------------------------ */

                            const currentUrl =
                                new URL(
                                    window.location.href
                                );


                            const dashboardUrl =
                                new URL(
                                    '<?= site_url('dashboard') ?>',
                                    window.location.origin
                                );


                            /* ------------------------------------------
                               PRESERVE SEARCH
                               ------------------------------------------ */

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


                            /* ------------------------------------------
                               ADD START DATE
                               ------------------------------------------ */

                            dashboardUrl.searchParams.set(
                                'start_date',
                                startInput.value
                            );


                            /* ------------------------------------------
                               ADD END DATE
                               ------------------------------------------ */

                            dashboardUrl.searchParams.set(
                                'end_date',
                                endInput.value
                            );


                            /* ------------------------------------------
                               REMOVE PAGE
                               ------------------------------------------ */

                            dashboardUrl.searchParams.delete(
                                'page'
                            );


                            /* ------------------------------------------
                               REDIRECT
                               ------------------------------------------ */

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
           ====================================================== */

        trigger.addEventListener(
            'click',
            function (event) {

                event.preventDefault();

                event.stopPropagation();

                picker.set(
                    'showMonths',
                    1
                );

                picker.open();

            }
        );


        /* ======================================================
           PROTECTION FLAG
           ====================================================== */

        trigger.dataset.installedDatePicker =
            'true';


        console.log(
            'Installed Date Filter initialized successfully.'
        );

        console.log(
            'Single Flatpickr instance:',
            picker
        );

    }

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


/* ==========================================================
   SWEETALERT HELPER
   ========================================================== */

function showSwalError(title, text) {

    if (typeof Swal !== 'undefined') {

        Swal.fire({
            icon: 'error',
            title: title || 'Error',
            text: text || 'Something went wrong.',
            confirmButtonText: 'OK'
        });

    } else {

        alert(text || 'Something went wrong.');

    }

}


/* ==========================================================
   ESCAPE HTML
   Prevents DataTables values from being injected into
   SweetAlert HTML.
   ========================================================== */

function escapeHtml(value) {

    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

}


$(document).ready(function () {

    /* ======================================================
       CHECK DATATABLES
       ====================================================== */

    if (
        typeof $.fn.DataTable === 'undefined' ||
        !$('#clinicRecordsTable').length
    ) {

        console.error(
            'DataTables is not loaded or #clinicRecordsTable was not found.'
        );

        return;

    }


    /* ======================================================
       DATATABLE
       ====================================================== */

    const table =
        $('#clinicRecordsTable').DataTable({

            processing: true,

            serverSide: true,

            searching: true,

            ordering: true,

            paging: true,

            pageLength: 10,

            createdRow: function (row, data) {
                if (String(data.status || '').toUpperCase() === 'I') {
                    row.classList.add('table-danger');
                }
            },

            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],

            ajax: {

                url:
                    "<?= site_url('dashboard/search') ?>",

                type: "GET",

                data: function (d) {

                    d.start_date =
                        $('#start_date').val() || '';

                    d.end_date =
                        $('#end_date').val() || '';

                    d.status =
                        $('#clinicStatusFilter').attr('data-status') || '';

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

                /* ----------------------------------------------
                   NUMBER
                   ---------------------------------------------- */

                {
                    data: null,

                    className: 'text-center',

                    orderable: false,

                    searchable: false,

                    render:
                        function (
                            data,
                            type,
                            row,
                            meta
                        ) {

                            return (
                                meta.settings._iDisplayStart +
                                meta.row +
                                1
                            );

                        }

                },


                /* ----------------------------------------------
                   CLINIC
                   ---------------------------------------------- */

                {
                    data: 'Clinic_name'
                },


                /* ----------------------------------------------
                   ADDRESS
                   ---------------------------------------------- */

                {
                    data: 'Address'
                },


                /* ----------------------------------------------
                   PROVINCE
                   ---------------------------------------------- */

                {
                    data: 'Province'
                },


                /* ----------------------------------------------
                   MACHINE
                   ---------------------------------------------- */

                {
                    data: 'Machine'
                },


                /* ----------------------------------------------
                   MODEL
                   ---------------------------------------------- */

                {
                    data: 'Model'
                },


                /* ----------------------------------------------
                   INSTALLED DATE
                   ---------------------------------------------- */

                {
                    data: 'Installed_date'
                },


                /* ----------------------------------------------
                   SERIAL NUMBER
                   ---------------------------------------------- */

                {
                    data: 'SN'
                },


                /* ----------------------------------------------
                   DR NUMBER
                   ---------------------------------------------- */

                {
                    data: 'DR_Number'
                },


                /* ==================================================
                   ACTIONS
                   ================================================== */

                {
                    data: null,

                    orderable: false,

                    searchable: false,

                    className: 'text-center',

                    render:
                        function (
                            data,
                            type,
                            row
                        ) {

                            const id =
                                Number(
                                    row.id || 0
                                );

                            const contractId =
                                Number(
                                    row.contract_id || 0
                                );


                            return `

                            `;

                        }

                }

            ],


            /* ==================================================
               DEFAULT ORDER
               ================================================== */

            order: [
                [1, 'asc']
            ],


            /* ==================================================
               TABLE OPTIONS
               ================================================== */

            autoWidth: false,

            scrollX: true,

            dom:
                'lt<"d-flex justify-content-between align-items-center px-3 py-2"ip>'

        });


    /* ======================================================
       CUSTOM SEARCH FORM
       ====================================================== */

    $('#clinicStatusFilter').on('click', function () {
        const showingCancelled = this.dataset.status !== 'I';
        this.dataset.status = showingCancelled ? 'I' : '';
        this.setAttribute('aria-pressed', String(showingCancelled));
        this.classList.toggle('btn-danger', showingCancelled);
        this.classList.toggle('btn-outline-danger', !showingCancelled);
        this.innerHTML = showingCancelled
            ? '<i class="bi bi-list-ul me-1"></i> Show All Clinics'
            : '<i class="bi bi-archive me-1"></i> Show Cancelled Accounts';

        table.ajax.reload(null, true);
    });

    $(document).on('click', '.dt-cancel-reason', function () {
        const row = table.row($(this).closest('tr')).data();
        if (!row) return;

        document.getElementById('cancelledReasonClinic').textContent = row.Clinic_name || '-';
        document.getElementById('cancelledReasonAddress').textContent = row.Address || '-';
        document.getElementById('cancelledReasonMachine').textContent = row.Machine || '-';
        document.getElementById('cancelledReasonDateFoundOut').textContent = row.cancelled_date_found_out || '-';
        document.getElementById('cancelledReasonDateConfirmed').textContent = row.cancelled_date_confirmed || '-';
        document.getElementById('cancelledReasonPersonnel').textContent = row.cancelled_personnel || '-';
        document.getElementById('cancelledReasonText').textContent = row.cancelled_reason || 'No cancellation reason was recorded.';
        document.getElementById('cancelledReasonSupplier').textContent = row.cancelled_supplier || '-';

        bootstrap.Modal
            .getOrCreateInstance(document.getElementById('cancelledReasonModal'))
            .show();
    });

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
       ====================================================== */

    let searchTimer = null;

    $('#clinicRecordsSearch').on(
        'input',
        function () {

            const value =
                this.value;

            clearTimeout(searchTimer);

            searchTimer =
                setTimeout(
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

            $('#clinicRecordsSearch')
                .val('');

            table
                .search('')
                .draw();

        }
    );


    /* ======================================================
       DATE FILTER
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
       EXPOSE DATATABLE INSTANCE
       ====================================================== */

    window.clinicRecordsTable =
        table;


    /* ======================================================
       OPEN EDIT MODAL
       SERVER-SIDE DATATABLES SAFE
       ====================================================== */

    $(document).on(
        'click',
        '.dt-edit-record',
        function (event) {

            event.preventDefault();

            event.stopPropagation();

            const button =
                $(this);

            const id =
                Number(
                    button.attr('data-id')
                );


            if (!id) {

                showSwalError(
                    'Invalid Record',
                    'The machine record ID is missing.'
                );

                return;

            }


            const dataTable =
                $('#clinicRecordsTable')
                    .DataTable();


            const rowData =
                dataTable
                    .row(
                        button.closest('tr')
                    )
                    .data();


            if (!rowData) {

                console.error(
                    'Edit: Could not retrieve row data.',
                    id
                );

                showSwalError(
                    'Unable to Load',
                    'Unable to load this machine record. Please try again.'
                );

                return;

            }


            console.log(
                'Edit record:',
                rowData
            );


            const modalElement =
                document.getElementById(
                    'editRecordModal'
                );


            if (!modalElement) {

                console.error(
                    'Edit modal not found: #editRecordModal'
                );

                showSwalError(
                    'Edit Modal Missing',
                    'The Edit Machine modal is missing from the page.'
                );

                return;

            }


            /* ==================================================
               FILL EDIT FORM
               ================================================== */

            const fields = {

                '#edit_id':
                    rowData.id || id,

                '#edit_Clinic_name':
                    rowData.Clinic_name || '',

                '#edit_Address':
                    rowData.Address || '',

                '#edit_Province':
                    rowData.Province || '',

                '#edit_Machine':
                    rowData.Machine || '',

                '#edit_Model':
                    rowData.Model || '',

                '#edit_Installed_date':
                    rowData.Installed_date || '',

                '#edit_SN':
                    rowData.SN || '',

                '#edit_DR_Number':
                    rowData.DR_Number || ''

            };


            Object.keys(fields)
                .forEach(
                    function (selector) {

                        const element =
                            document.querySelector(
                                selector
                            );

                        if (element) {

                            element.value =
                                fields[selector];

                        }

                    }
                );


            $(modalElement)
                .attr(
                    'data-record-id',
                    rowData.id || id
                );


            /* ==================================================
               SHOW EDIT MODAL
               ================================================== */

            const modal =
                bootstrap.Modal
                    .getOrCreateInstance(
                        modalElement
                    );


            modal.show();

        }
    );


    /* ======================================================
       EDIT FORM SUBMIT
       SWEETALERT SUCCESS
       ====================================================== */

    $(document).on(
        'submit',
        '#editRecordForm',
        function (event) {

            event.preventDefault();

            const form =
                $(this);

            const submitButton =
                form.find(
                    'button[type="submit"]'
                );


            if (
                this.checkValidity &&
                !this.checkValidity()
            ) {

                this.reportValidity();

                return;

            }


            const originalButtonHtml =
                submitButton.html();


            submitButton
                .prop(
                    'disabled',
                    true
                )
                .html(
                    '<span class="spinner-border spinner-border-sm me-1"></span> Updating...'
                );


            /* ==================================================
               SHOW LOADING
               ================================================== */

            if (typeof Swal !== 'undefined') {

                Swal.fire({

                    title:
                        'Updating Machine...',

                    text:
                        'Please wait while the record is being updated.',

                    allowOutsideClick:
                        false,

                    allowEscapeKey:
                        false,

                    showConfirmButton:
                        false,

                    didOpen:
                        function () {

                            Swal.showLoading();

                        }

                });

            }


            /* ==================================================
               AJAX UPDATE
               ================================================== */

            $.ajax({

                url:
                    form.attr('action'),

                type:
                    'POST',

                data:
                    form.serialize(),

                dataType:
                    'html',


                success:
                    function (response) {

                        console.log(
                            'Update response:',
                            response
                        );


                        /* ------------------------------------------
                           CLOSE EDIT MODAL
                           ------------------------------------------ */

                        const modalElement =
                            document.getElementById(
                                'editRecordModal'
                            );


                        if (modalElement) {

                            const modal =
                                bootstrap.Modal
                                    .getInstance(
                                        modalElement
                                    );

                            if (modal) {

                                modal.hide();

                            }

                        }


                        /* ------------------------------------------
                           SUCCESS SWEETALERT
                           ------------------------------------------ */

                        if (
                            typeof Swal !== 'undefined'
                        ) {

                            Swal.fire({

                                icon:
                                    'success',

                                title:
                                    'Updated Successfully!',

                                text:
                                    'The machine record has been updated successfully.',

                                timer:
                                    1800,

                                showConfirmButton:
                                    false,

                                timerProgressBar:
                                    true

                            });

                        }


                        /* ------------------------------------------
                           RELOAD DATATABLE
                           ------------------------------------------ */

                        table.ajax.reload(
                            null,
                            false
                        );

                    },


                error:
                    function (xhr) {

                        console.error(
                            'Update Error:',
                            xhr.responseText
                        );


                        if (
                            typeof Swal !== 'undefined'
                        ) {

                            Swal.fire({

                                icon:
                                    'error',

                                title:
                                    'Update Failed',

                                text:
                                    'Unable to update the machine record. Please try again.',

                                confirmButtonText:
                                    'OK'

                            });

                        }

                    },


                complete:
                    function () {

                        submitButton
                            .prop(
                                'disabled',
                                false
                            )
                            .html(
                                originalButtonHtml
                            );

                    }

            });

        }
    );


    /* ======================================================
       DELETE RECORD
       SWEETALERT CONFIRMATION + SUCCESS
       ====================================================== */

    $(document).on(
        'click',
        '.dt-delete-record',
        function (event) {

            event.preventDefault();

            event.stopPropagation();


            const button =
                $(this);


            const id =
                Number(
                    button.attr('data-id')
                );


            if (!id) {

                showSwalError(
                    'Invalid Record',
                    'The machine record ID is missing.'
                );

                return;

            }


            const dataTable =
                $('#clinicRecordsTable')
                    .DataTable();


            const rowData =
                dataTable
                    .row(
                        button.closest('tr')
                    )
                    .data();


            const clinic =
                rowData?.Clinic_name ||
                'This machine';


            const machine =
                rowData?.Machine ||
                '';


            const sn =
                rowData?.SN ||
                '';


            /* ==================================================
               DELETE CONFIRMATION
               ================================================== */

            Swal.fire({

                icon:
                    'warning',

                title:
                    'Delete Machine?',

                html:
                    `
                    <div class="text-muted">
                        Are you sure you want to delete this record?
                    </div>

                    <div class="mt-3">

                        <strong>
                            ${escapeHtml(clinic)}
                        </strong>

                        ${
                            machine
                            ? `<br>${escapeHtml(machine)}`
                            : ''
                        }

                        ${
                            sn
                            ? `<br>SN: ${escapeHtml(sn)}`
                            : ''
                        }

                    </div>

                    <div class="text-danger small mt-3">

                        <i class="bi bi-exclamation-triangle me-1"></i>

                        This action cannot be undone.

                    </div>
                    `,

                showCancelButton:
                    true,

                confirmButtonText:
                    '<i class="bi bi-trash me-1"></i> Yes, Delete',

                cancelButtonText:
                    '<i class="bi bi-x-circle me-1"></i> Cancel',

                confirmButtonColor:
                    '#dc3545',

                cancelButtonColor:
                    '#6c757d',

                reverseButtons:
                    true,

                focusCancel:
                    true

            }).then(
                function (result) {

                    if (
                        !result.isConfirmed
                    ) {

                        return;

                    }


                    /* ==================================================
                       DELETE LOADING
                       ================================================== */

                    Swal.fire({

                        title:
                            'Deleting...',

                        text:
                            'Please wait while the record is being deleted.',

                        allowOutsideClick:
                            false,

                        allowEscapeKey:
                            false,

                        showConfirmButton:
                            false,

                        didOpen:
                            function () {

                                Swal.showLoading();

                            }

                    });


                    /* ==================================================
                       AJAX DELETE
                       ================================================== */

                    $.ajax({

                        url:
                            "<?= site_url('dashboard') ?>",

                        type:
                            'GET',

                        data:
                            {
                                delete: id
                            },

                        dataType:
                            'html',


                        success:
                            function (response) {

                                console.log(
                                    'Delete response:',
                                    response
                                );


                                /* --------------------------------------
                                   SWEETALERT SUCCESS
                                   -------------------------------------- */

                                Swal.fire({

                                    icon:
                                        'success',

                                    title:
                                        'Deleted Successfully!',

                                    text:
                                        'The machine record has been deleted.',

                                    timer:
                                        1800,

                                    showConfirmButton:
                                        false,

                                    timerProgressBar:
                                        true

                                });


                                /* --------------------------------------
                                   RELOAD DATATABLE
                                   -------------------------------------- */

                                setTimeout(
                                    function () {

                                        table.ajax.reload(
                                            null,
                                            false
                                        );

                                    },
                                    300
                                );

                            },


                        error:
                            function (xhr) {

                                console.error(
                                    'Delete Error:',
                                    xhr.responseText
                                );


                                Swal.fire({

                                    icon:
                                        'error',

                                    title:
                                        'Delete Failed',

                                    text:
                                        'Unable to delete the machine record. Please try again.',

                                    confirmButtonText:
                                        'OK'

                                });

                            }

                    });

                }
            );

        }
    );



/* ======================================================
   OPEN ATTACH / REPLACE CONTRACT MODAL
   ====================================================== */

$(document).on(
    'click',
    '.dt-contract',
    function (event) {

        event.preventDefault();
        event.stopPropagation();

        const button = $(this);

        const id = Number(
            button.attr('data-id') || 0
        );

        const contractId = Number(
            button.attr('data-contract-id') || 0
        );

        if (!id) {

            showSwalError(
                'Invalid Record',
                'The machine record ID is missing.'
            );

            return;
        }


        /* ==================================================
           GET DATATABLE ROW
           ================================================== */

        const dataTable =
            $('#clinicRecordsTable').DataTable();

        const rowData =
            dataTable
                .row(button.closest('tr'))
                .data();

        if (!rowData) {

            showSwalError(
                'Unable to Load',
                'Unable to load this machine record. Please try again.'
            );

            return;
        }


        /* ==================================================
           GET MODAL
           ================================================== */

        const modalElement =
            document.getElementById('contractModal');

        if (!modalElement) {

            showSwalError(
                'Contract Modal Missing',
                'The Contract modal is missing from the page.'
            );

            return;
        }


        /* ==================================================
           RECORD ID
           ================================================== */

        $('#contract_id').val(
            rowData.id || id
        );


        /* ==================================================
           FILL MACHINE INFORMATION
           ================================================== */

        $('#contract_clinic').val(
            rowData.Clinic_name || ''
        );

        $('#contract_address').val(
            rowData.Address || ''
        );

        $('#contract_machine').val(
            rowData.Machine || ''
        );

        $('#contract_model').val(
            rowData.Model || ''
        );

        $('#contract_sn').val(
            rowData.SN || ''
        );


        /* ==================================================
           RESET FILE INPUT
           ================================================== */

        $('#contract_file').val('');


        /* ==================================================
           CONTRACT STATUS
           ================================================== */

        const hasContract =
            contractId > 0 ||
            Number(rowData.contract_id || 0) > 0;


        if (hasContract) {

            $('#contractExistingAlert')
                .removeClass('d-none');

            $('#contractNoExistingAlert')
                .addClass('d-none');

        } else {

            $('#contractExistingAlert')
                .addClass('d-none');

            $('#contractNoExistingAlert')
                .removeClass('d-none');

        }


        /* ==================================================
           UPDATE TITLE
           ================================================== */

        $('#contractModalLabel').html(
            hasContract
                ? '<i class="bi bi-arrow-repeat me-2"></i>Replace Contract'
                : '<i class="bi bi-paperclip me-2"></i>Attach Contract'
        );


        /* ==================================================
           UPDATE SUBMIT BUTTON
           ================================================== */

        $('#contractSubmitText').text(
            hasContract
                ? 'Replace Contract'
                : 'Upload Contract'
        );


        /* ==================================================
           STORE DATA ON MODAL
           ================================================== */

        $(modalElement)
            .attr(
                'data-record-id',
                rowData.id || id
            )
            .attr(
                'data-contract-id',
                rowData.contract_id || contractId || 0
            );


        /* ==================================================
           SHOW MODAL
           ================================================== */

        bootstrap.Modal
            .getOrCreateInstance(modalElement)
            .show();

    }
);



/* ======================================================
   CONTRACT FORM SUBMIT
   SWEETALERT + AJAX UPLOAD
   ====================================================== */

$(document).on(
    'submit',
    '#contractForm',
    function (event) {

        event.preventDefault();

        const form =
            document.getElementById('contractForm');

        const $form =
            $(form);

        const submitButton =
            $form.find('button[type="submit"]');

        const fileInput =
            document.getElementById('contract_file');

        const id =
            $('#contract_id').val();

        const contractModal =
            document.getElementById('contractModal');

        const existingContract =
            Number(
                $(contractModal)
                    .attr('data-contract-id') || 0
            ) > 0;


        /* ==================================================
           VALIDATE RECORD ID
           ================================================== */

        if (!id) {

            showSwalError(
                'Invalid Record',
                'The machine record ID is missing.'
            );

            return;
        }


        /* ==================================================
           VALIDATE FILE
           ================================================== */

        if (
            !fileInput ||
            !fileInput.files ||
            !fileInput.files.length
        ) {

            showSwalError(
                'Contract File Required',
                'Please select a contract file.'
            );

            return;
        }


        const file =
            fileInput.files[0];


        /* ==================================================
           VALIDATE FILE TYPE
           ================================================== */

        const allowedTypes = [
            'application/pdf',
            'image/jpeg',
            'image/png'
        ];

        const allowedExtensions = [
            'pdf',
            'jpg',
            'jpeg',
            'png'
        ];

        const fileName =
            file.name.toLowerCase();

        const extension =
            fileName
                .split('.')
                .pop();


        if (
            !allowedExtensions.includes(extension) &&
            !allowedTypes.includes(file.type)
        ) {

            showSwalError(
                'Invalid File',
                'Only PDF, JPG, JPEG, and PNG files are allowed.'
            );

            return;
        }


        /* ==================================================
           FILE SIZE
           5 MB MAXIMUM
           ================================================== */

        const maxSize =
            5 * 1024 * 1024;


        if (file.size > maxSize) {

            showSwalError(
                'File Too Large',
                'The contract file must not exceed 5 MB.'
            );

            return;
        }


        /* ==================================================
           CONFIRMATION
           ================================================== */

        const actionText =
            existingContract
                ? 'replace the existing contract'
                : 'attach this contract';


        Swal.fire({

            icon:
                existingContract
                    ? 'warning'
                    : 'question',

            title:
                existingContract
                    ? 'Replace Contract?'
                    : 'Attach Contract?',

            html:
                `
                <div class="text-muted">
                    Are you sure you want to ${actionText}?
                </div>

                <div class="mt-3">
                    <strong>${escapeHtml(file.name)}</strong>
                </div>

                ${
                    existingContract
                        ? `
                            <div class="text-danger small mt-3">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                The current contract will be replaced.
                            </div>
                        `
                        : ''
                }
                `,

            showCancelButton:
                true,

            confirmButtonText:
                existingContract
                    ? '<i class="bi bi-arrow-repeat me-1"></i> Yes, Replace'
                    : '<i class="bi bi-paperclip me-1"></i> Yes, Attach',

            cancelButtonText:
                '<i class="bi bi-x-circle me-1"></i> Cancel',

            confirmButtonColor:
                existingContract
                    ? '#fd7e14'
                    : '#198754',

            cancelButtonColor:
                '#6c757d',

            reverseButtons:
                true,

            focusCancel:
                true

        }).then(
            function (result) {

                if (!result.isConfirmed) {

                    return;
                }


                /* ==================================================
                   BUTTON LOADING
                   ================================================== */

                const originalButtonHtml =
                    submitButton.html();

                submitButton
                    .prop(
                        'disabled',
                        true
                    )
                    .html(
                        '<span class="spinner-border spinner-border-sm me-1"></span> Uploading...'
                    );


                /* ==================================================
                   SWEETALERT LOADING
                   ================================================== */

                Swal.fire({

                    title:
                        existingContract
                            ? 'Replacing Contract...'
                            : 'Attaching Contract...',

                    text:
                        'Please wait while the contract is being uploaded.',

                    allowOutsideClick:
                        false,

                    allowEscapeKey:
                        false,

                    showConfirmButton:
                        false,

                    didOpen:
                        function () {

                            Swal.showLoading();

                        }

                });


                /* ==================================================
                   FORM DATA
                   ================================================== */

                const formData =
                    new FormData(form);


                /* ==================================================
                   AJAX UPLOAD
                   ================================================== */

                $.ajax({

                    url:
                        $form.attr('action'),

                    type:
                        'POST',

                    data:
                        formData,

                    processData:
                        false,

                    contentType:
                        false,

                    dataType:
                        'html',


                    /* ==============================================
                       SUCCESS
                       ============================================== */

                    success:
                        function (response) {

                            console.log(
                                'Contract upload response:',
                                response
                            );


                            /*
                             * We treat a successful HTTP response
                             * as a successful upload.
                             *
                             * The controller should redirect or
                             * return normally after saving.
                             */


                            /* ======================================
                               CLOSE MODAL
                               ====================================== */

                            const modal =
                                bootstrap.Modal
                                    .getInstance(
                                        contractModal
                                    );

                            if (modal) {

                                modal.hide();

                            }


                            /* ======================================
                               SUCCESS ALERT
                               ====================================== */

                            Swal.fire({

                                icon:
                                    'success',

                                title:
                                    existingContract
                                        ? 'Contract Replaced!'
                                        : 'Contract Attached!',

                                text:
                                    existingContract
                                        ? 'The contract has been replaced successfully.'
                                        : 'The contract has been attached successfully.',

                                timer:
                                    1800,

                                showConfirmButton:
                                    false,

                                timerProgressBar:
                                    true

                            });


                            /* ======================================
                               RESET FORM
                               ====================================== */

                            form.reset();


                            $('#contractExistingAlert')
                                .addClass('d-none');

                            $('#contractNoExistingAlert')
                                .addClass('d-none');


                            /* ======================================
                               RELOAD DATATABLE
                               ====================================== */

                            setTimeout(
                                function () {

                                    table.ajax.reload(
                                        null,
                                        false
                                    );

                                },
                                300
                            );

                        },


                    /* ==============================================
                       ERROR
                       ============================================== */

                    error:
                        function (xhr) {

                            console.error(
                                'Contract upload error:',
                                xhr.responseText
                            );


                            let errorMessage =
                                'Unable to upload the contract. Please try again.';


                            /*
                             * Try to extract JSON error message
                             * if the controller returns JSON.
                             */

                            if (
                                xhr.responseJSON &&
                                xhr.responseJSON.message
                            ) {

                                errorMessage =
                                    xhr.responseJSON.message;

                            }


                            Swal.fire({

                                icon:
                                    'error',

                                title:
                                    'Contract Upload Failed',

                                text:
                                    errorMessage,

                                confirmButtonText:
                                    'OK'

                            });

                        },


                    /* ==============================================
                       COMPLETE
                       ============================================== */

                    complete:
                        function () {

                            submitButton
                                .prop(
                                    'disabled',
                                    false
                                )
                                .html(
                                    originalButtonHtml
                                );

                        }

                });

            }
        );

    }
);



/* ======================================================
   OPEN VIEW CONTRACT MODAL
   ====================================================== */

$(document).on(
    'click',
    '.dt-view-contract',
    function (event) {

        event.preventDefault();
        event.stopPropagation();

        const button = $(this);

        /* ==================================================
           IMPORTANT ID DIFFERENCE
           
           id           = tb_data.id
           contractId   = tb_contract.id
           
           viewContract() expects tb_data.id
           ================================================== */

        const id = Number(
            button.attr('data-id') || 0
        );

        const contractId = Number(
            button.attr('data-contract-id') || 0
        );


        /* ==================================================
           DEBUG
           ================================================== */

        console.log('VIEW CONTRACT');
        console.log('Machine / tb_data ID:', id);
        console.log('Contract / tb_contract ID:', contractId);


        /* ==================================================
           VALIDATE MACHINE ID
           ================================================== */

        if (!id) {

            showSwalError(
                'Invalid Record',
                'The machine record ID is missing.'
            );

            return;
        }


        /* ==================================================
           VALIDATE CONTRACT ID
           ================================================== */

        if (!contractId) {

            showSwalError(
                'No Contract',
                'There is no contract attached to this machine.'
            );

            return;
        }


        /* ==================================================
           GET DATATABLE ROW
           ================================================== */

        const dataTable =
            $('#clinicRecordsTable').DataTable();

        const rowData =
            dataTable
                .row(button.closest('tr'))
                .data();


        if (!rowData) {

            showSwalError(
                'Unable to Load',
                'Unable to load this machine record. Please try again.'
            );

            return;
        }


        console.log(
            'View contract row:',
            rowData
        );


        /* ==================================================
           GET VIEW CONTRACT MODAL
           ================================================== */

        const modalElement =
            document.getElementById(
                'viewContractModal'
            );


        if (!modalElement) {

            showSwalError(
                'View Contract Modal Missing',
                'The View Contract modal is missing from the page.'
            );

            return;
        }


        /* ==================================================
           GET CONTENT
           ================================================== */

        const content =
            document.getElementById(
                'viewContractContent'
            );


        if (!content) {

            showSwalError(
                'Preview Area Missing',
                'The contract preview area is missing from the page.'
            );

            return;
        }


        /* ==================================================
           OPEN LINK
           ================================================== */

        const openLink =
            $('#viewContractOpenLink');


        /* ==================================================
           STORE IDs ON MODAL
           ================================================== */

        $(modalElement)
            .attr(
                'data-record-id',
                id
            )
            .attr(
                'data-contract-id',
                contractId
            );


        /* ==================================================
           RESET CONTENT
           ================================================== */

        content.innerHTML = `
            <div class="p-5 text-center">

                <div
                    class="spinner-border text-primary mb-3"
                    role="status">
                </div>

                <div>
                    Loading contract...
                </div>

            </div>
        `;


        /* ==================================================
           RESET OPEN BUTTON
           ================================================== */

        if (openLink.length) {

            openLink
                .attr('href', '#')
                .addClass('d-none');

        }


        /* ==================================================
           SHOW MODAL
           ================================================== */

        bootstrap.Modal
            .getOrCreateInstance(
                modalElement
            )
            .show();


        /* ==================================================
           IMPORTANT:
           SEND tb_data.id TO viewContract()
           
           NOT contractId
           ================================================== */

        const contractUrl =
            "<?= site_url('dashboard/view-contract') ?>/" +
            encodeURIComponent(id);


        console.log(
            'View Contract URL:',
            contractUrl
        );


        /* ==================================================
           LOAD CONTRACT
           ================================================== */

        $.ajax({

            url:
                contractUrl,

            type:
                'GET',

            dataType:
                'json',


            /* ==================================================
               SUCCESS
               ================================================== */

            success:
                function (response) {

                    console.log(
                        'Contract view response:',
                        response
                    );


                    /* ------------------------------------------
                       CHECK RESPONSE
                       ------------------------------------------ */

                    if (
                        !response ||
                        response.success === false
                    ) {

                        content.innerHTML = `
                            <div class="p-5 text-center text-danger">

                                <i
                                    class="bi bi-exclamation-triangle fs-1">
                                </i>

                                <div class="mt-3 fw-semibold">
                                    Unable to load contract.
                                </div>

                                <div class="small text-muted mt-2">
                                    ${escapeHtml(
                                        response?.message ||
                                        'The contract file could not be found.'
                                    )}
                                </div>

                            </div>
                        `;

                        return;
                    }


                    /* ------------------------------------------
                       GET FILE URL
                       ------------------------------------------ */

                    const fileUrl =
                        response.url ||
                        response.file_url ||
                        response.contract_url ||
                        '';


                    if (!fileUrl) {

                        content.innerHTML = `
                            <div class="p-5 text-center text-danger">

                                <i
                                    class="bi bi-file-earmark-x fs-1">
                                </i>

                                <div class="mt-3 fw-semibold">
                                    Contract file URL is missing.
                                </div>

                            </div>
                        `;

                        return;
                    }


                    /* ------------------------------------------
                       SET OPEN LINK
                       ------------------------------------------ */

                    if (openLink.length) {

                        openLink
                            .attr(
                                'href',
                                fileUrl
                            )
                            .attr(
                                'target',
                                '_blank'
                            )
                            .attr(
                                'rel',
                                'noopener noreferrer'
                            )
                            .removeClass('d-none');

                    }


                    /* ------------------------------------------
                       FILE TYPE
                       ------------------------------------------ */

                    const responseType =
                        String(
                            response.type || ''
                        ).toLowerCase();


                    const lowerUrl =
                        String(fileUrl)
                            .toLowerCase();


                    const isPdf =
                        responseType.includes('pdf') ||
                        /\.pdf(\?|$)/i.test(
                            lowerUrl
                        );


                    const isImage =
                        responseType.includes('image') ||
                        /\.(jpg|jpeg|png|webp)(\?|$)/i.test(
                            lowerUrl
                        );


                    /* ==================================================
                       PDF PREVIEW
                       ================================================== */

                    if (isPdf) {

                        content.innerHTML = `
                            <iframe
                                src="${escapeHtml(fileUrl)}"
                                style="
                                    width:100%;
                                    height:75vh;
                                    min-height:600px;
                                    border:0;
                                "
                                title="Contract PDF">
                            </iframe>
                        `;

                        return;
                    }


                    /* ==================================================
                       IMAGE PREVIEW
                       ================================================== */

                    if (isImage) {

                        content.innerHTML = `
                            <div
                                class="p-3 text-center"
                                style="
                                    background:#f8f9fa;
                                    min-height:300px;
                                ">

                                <img
                                    src="${escapeHtml(fileUrl)}"
                                    alt="Contract"
                                    class="img-fluid"
                                    style="
                                        max-width:100%;
                                        max-height:75vh;
                                        object-fit:contain;
                                    "
                                >

                            </div>
                        `;

                        return;
                    }


                    /* ==================================================
                       OTHER FILE TYPE
                       ================================================== */

                    content.innerHTML = `
                        <div class="p-5 text-center">

                            <i
                                class="bi bi-file-earmark fs-1 text-primary">
                            </i>

                            <div class="mt-3 fw-semibold">
                                Contract file loaded.
                            </div>

                            <div class="mt-3">

                                <a
                                    href="${escapeHtml(fileUrl)}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-primary">

                                    <i
                                        class="bi bi-box-arrow-up-right me-1">
                                    </i>

                                    Open Contract

                                </a>

                            </div>

                        </div>
                    `;

                },


            /* ==================================================
               AJAX ERROR
               ================================================== */

            error:
                function (xhr) {

                    console.error(
                        'Contract view AJAX error:',
                        xhr.status,
                        xhr.responseText
                    );


                    let message =
                        'Unable to load the contract.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    content.innerHTML = `
                        <div class="p-5 text-center text-danger">

                            <i
                                class="bi bi-exclamation-triangle fs-1">
                            </i>

                            <div class="mt-3 fw-semibold">
                                Unable to load contract.
                            </div>

                            <div class="small text-muted mt-2">
                                ${escapeHtml(message)}
                            </div>

                        </div>
                    `;

                }

        });

    }
);


    /* ======================================================
       END DATATABLE READY
       ====================================================== */

});


/* ==========================================================
   SUPPORT ANALYTICS CHARTS
   ========================================================== */

if (
    typeof ApexCharts !== 'undefined'
) {

    const monthlySupport =
        <?= json_encode(
            $monthly_support ?? [],
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_HEX_AMP
        ) ?>;


    const pulloutTimeline =
        <?= json_encode(
            $pullout_timeline ?? [],
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_HEX_AMP
        ) ?>;


    <?php

    /* ======================================================
       NORMALIZE MACHINE YEARLY DATA
       ====================================================== */

    $machineYearlyGrouped = [];


    foreach (
        $machine_yearly ?? [] as $row
    ) {

        $rawMachine =
            strtolower(
                trim(
                    (string) (
                        $row['machine'] ?? ''
                    )
                )
            );


        $year =
            (string) (
                $row['year'] ?? ''
            );


        $total =
            (int) (
                $row['total'] ?? 0
            );


        switch ($rawMachine) {

            case 'vu10':

                $machineLabel =
                    'Urine Analyzer';

                break;


            case 'utz':

                $machineLabel =
                    'Ultrasound';

                break;


            case 'vet monitor':
            case 'x-ray':
            case 'xray':

                $machineLabel =
                    'X-Ray';

                break;


            default:

                $machineLabel =
                    trim(
                        (string) (
                            $row['machine'] ?? ''
                        )
                    );

                break;

        }


        if (
            $machineLabel === '' ||
            $year === ''
        ) {

            continue;

        }


        $key =
            $year .
            '|' .
            $machineLabel;


        if (
            !isset(
                $machineYearlyGrouped[$key]
            )
        ) {

            $machineYearlyGrouped[$key] = [

                'year' =>
                    $year,

                'machine' =>
                    $machineLabel,

                'total' =>
                    0

            ];

        }


        $machineYearlyGrouped[$key]['total']
            += $total;

    }


    $machineYearly =
        array_values(
            $machineYearlyGrouped
        );


    /* ======================================================
       SORT BY YEAR AND MACHINE
       ====================================================== */

    usort(
        $machineYearly,
        function ($a, $b) {

            if (
                $a['year'] ===
                $b['year']
            ) {

                return strcmp(
                    $a['machine'],
                    $b['machine']
                );

            }


            return strcmp(
                $a['year'],
                $b['year']
            );

        }
    );

    ?>


    const machineYearly =
        <?= json_encode(
            $machineYearly,
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_HEX_AMP
        ) ?>;


    /* ======================================================
       CHART HELPERS
       ====================================================== */

    function chartCategories(rows) {

        return rows.map(
            function (row) {

                return row.period || '';

            }
        );

    }


    function chartValues(rows) {

        return rows.map(
            function (row) {

                return Number(
                    row.total || 0
                );

            }
        );

    }


    function renderEmptyChart(
        selector,
        message
    ) {

        const element =
            document.querySelector(
                selector
            );


        if (element) {

            element.innerHTML =
                '<div class="text-center text-muted py-5">' +
                message +
                '</div>';

        }

    }


    /* ======================================================
       MONTHLY SUPPORT CHART
       ====================================================== */

    if (
        monthlySupport.length
    ) {

        new ApexCharts(
            document.querySelector(
                '#monthlySupportChart'
            ),
            {

                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    background: '#ffffff',
                    foreColor: '#1f2937'
                },

                series: [
                    {
                        name:
                            'Support Tickets',
                        data:
                            chartValues(
                                monthlySupport
                            )
                    }
                ],

                xaxis: {
                    categories:
                        chartCategories(
                            monthlySupport
                        ),
                    labels: {
                        style: {
                            colors: '#475569',
                            fontSize: '11px'
                        }
                    }
                },

                yaxis: {
                    labels: {
                        style: {
                            colors: '#475569',
                            fontSize: '11px'
                        }
                    }
                },

                colors: ['#0f4c81'],

                plotOptions: {
                    bar: {
                        borderRadius: 7,
                        columnWidth: '56%',
                        distributed: false
                    }
                },

                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.2,
                        opacityFrom: 0.9,
                        opacityTo: 0.7,
                        stops: [0, 100]
                    }
                },

                dataLabels: {
                    enabled: false
                },

                grid: {
                    borderColor: '#e2e8f0',
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },

                tooltip: {
                    theme: 'light'
                },

                legend: {
                    show: false
                }

            }
        ).render();

    } else {

        renderEmptyChart(
            '#monthlySupportChart',
            'No support data available.'
        );

    }


    /* ======================================================
       PULLOUT TIMELINE CHART
       ====================================================== */

    if (
        pulloutTimeline.length
    ) {

        new ApexCharts(
            document.querySelector(
                '#pulloutTimelineChart'
            ),
            {

                chart: {
                    type: 'donut',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    background: '#ffffff'
                },

                series:
                    chartValues(
                        pulloutTimeline
                    ),

                labels:
                    chartCategories(
                        pulloutTimeline
                    ),

                colors: [
                    '#0f4c81',
                    '#2e7de1',
                    '#6bb7ff',
                    '#7dd3fc',
                    '#dbeafe',
                    '#c7d2fe'
                ],

                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    labels: {
                        colors: '#475569'
                    }
                },

                plotOptions: {
                    pie: {
                        donut: {
                            size: '68%'
                        }
                    }
                },

                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val ? val.toFixed(0) + '%' : '';
                    },
                    style: {
                        fontSize: '11px',
                        colors: ['#ffffff']
                    }
                },

                tooltip: {
                    theme: 'light'
                }

            }
        ).render();

    } else {

        renderEmptyChart(
            '#pulloutTimelineChart',
            'No pullout data available.'
        );

    }


    /* ======================================================
       MACHINE YEARLY CHART
       ====================================================== */

    if (
        machineYearly.length
    ) {

        const years =
            [
                ...new Set(
                    machineYearly.map(
                        function (row) {

                            return String(
                                row.year
                            );

                        }
                    )
                )
            ];


        const machineNames =
            [
                ...new Set(
                    machineYearly.map(
                        function (row) {

                            return row.machine;

                        }
                    )
                )
            ];


        const machineSeries =
            machineNames.map(
                function (machine) {

                    return {

                        name:
                            machine,

                        data:
                            years.map(
                                function (year) {

                                    const row =
                                        machineYearly.find(
                                            function (item) {

                                                return (
                                                    String(
                                                        item.year
                                                    ) === year &&
                                                    item.machine === machine
                                                );

                                            }
                                        );


                                    return Number(
                                        row?.total || 0
                                    );

                                }
                            )

                    };

                }
            );


        new ApexCharts(
            document.querySelector(
                '#machineYearlyChart'
            ),
            {

                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    background: '#ffffff'
                },

                series:
                    machineSeries,

                xaxis: {
                    categories:
                        years,
                    labels: {
                        style: {
                            colors: '#475569',
                            fontSize: '11px'
                        }
                    }
                },

                yaxis: {
                    labels: {
                        style: {
                            colors: '#475569',
                            fontSize: '11px'
                        }
                    }
                },

                stroke: {
                    curve: 'smooth',
                    width: 3,
                    dashArray: [0, 0]
                },

                markers: {
                    size: 4,
                    strokeWidth: 0,
                    hover: {
                        size: 7
                    }
                },

                dataLabels: {
                    enabled: false
                },

                legend: {
                    position: 'bottom',
                    labels: {
                        colors: '#475569'
                    }
                },

                grid: {
                    borderColor: '#e2e8f0',
                    strokeDashArray: 4
                },

                tooltip: {
                    theme: 'light'
                },

                colors: ['#0f4c81', '#2e7de1', '#4cc9f0', '#94c5ff', '#a78bfa', '#1b8f73']

            }
        ).render();

    } else {

        renderEmptyChart(
            '#machineYearlyChart',
            'No machine data available.'
        );

    }

}

</script>

</body>
</html>

