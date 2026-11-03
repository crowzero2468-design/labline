<?= view('dashboard/layout/head') ?>

<style>
    .mfs-account-select + .select2-container {
        width: 100% !important;
    }

    .mfs-account-select + .select2-container .select2-selection--single {
        height: 38px;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #212529;
        font-size: 1rem;
    }

    .mfs-account-select + .select2-container .select2-selection__rendered {
        line-height: 24px;
        padding: 0;
        color: #212529;
    }

    .mfs-account-select + .select2-container .select2-selection__arrow {
        height: 36px;
        right: 0.5rem;
    }

    .mfs-account-select + .select2-container--focus .select2-selection--single,
    .mfs-account-select + .select2-container--open .select2-selection--single {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .mfs-account-select + .select2-container .select2-dropdown {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        overflow: hidden;
    }

    .mfs-account-select + .select2-container .select2-search__field {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }

    .mfs-account-select + .select2-container .select2-results__option {
        padding: 0.375rem 0.75rem;
        color: #212529;
        background-color: #fff;
    }

    .mfs-account-select + .select2-container .select2-results__option--highlighted[aria-selected] {
        color: #fff;
        background-color: #0d6efd;
    }

    .mfs-account-address {
        color: #6c757d;
    }

    #addMfsModal .modal-content > form,
    #editMfsModal .modal-content > form {
        display: flex;
        flex: 1 1 auto;
        flex-direction: column;
        min-height: 0;
    }

    #addMfsModal .modal-body,
    #editMfsModal .modal-body {
        flex: 1 1 auto;
        min-height: 0;
        overflow-y: auto;
    }

    .select2-results__option--highlighted[aria-selected] .mfs-account-address {
        color: #e9ecef;
    }

    .mfs-view-switch {
        display: inline-flex;
        background: #f3f4f6;
        border-radius: 10px;
        padding: 4px;
        border: 1px solid #e5e7eb;
    }

    .mfs-view-switch .btn {
        border-radius: 8px;
        border: 0;
        font-weight: 600;
        padding: 0.45rem 0.9rem;
    }

    .mfs-calendar-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }

    .mfs-month-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        padding: 0.9rem;
        min-height: 220px;
    }

    .mfs-month-card h6 {
        margin: 0 0 0.75rem;
        font-weight: 700;
        color: #1f2937;
    }

    .mfs-month-records {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .mfs-record-item {
        border: 1px solid #eef2f7;
        border-radius: 10px;
        background: #f8fafc;
        padding: 0.6rem 0.7rem;
    }

    .mfs-record-header {
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
        align-items: center;
        margin-bottom: 0.35rem;
    }

    .mfs-record-number {
        font-size: 0.8rem;
        font-weight: 700;
        color: #1f2937;
    }

    .mfs-record-meta {
        font-size: 0.75rem;
        color: #4b5563;
        line-height: 1.5;
    }
</style>

<body>

<?php
    $mfsError = session()->getFlashdata('error');
    $mfsSuccess = session()->getFlashdata('success');
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const errorMessage = <?= json_encode((string) ($mfsError ?? ''), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    const successMessage = <?= json_encode((string) ($mfsSuccess ?? ''), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;

    if (errorMessage && window.Swal) {
        Swal.fire({ icon: 'error', title: 'MFS Failed', text: errorMessage });
    } else if (successMessage && window.Swal) {
        Swal.fire({ icon: 'success', title: 'Success', text: successMessage, timer: 3000, timerProgressBar: true, showConfirmButton: false });
    }

    const mfsImportForm = document.querySelector('form[action="<?= site_url('mfs/import') ?>"]');
    const mfsImportInput = document.querySelector('input[name="excel_file"]');

    if (mfsImportForm && mfsImportInput) {
        mfsImportForm.addEventListener('submit', function (event) {
            const file = mfsImportInput.files && mfsImportInput.files[0];

            if (!file) {
                event.preventDefault();
                if (window.Swal) {
                    Swal.fire({ icon: 'error', title: 'Invalid file', text: 'Please choose a file to import.' });
                } else {
                    alert('Please choose a file to import.');
                }
                return;
            }

            const fileName = (file.name || '').toLowerCase().trim();
            const mimeType = (file.type || '').toLowerCase();
            const isAllowedByName = fileName.endsWith('.xlsx') || fileName.endsWith('.csv');
            const isAllowedByMime = [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/csv',
                'application/csv'
            ].includes(mimeType);

            if (!isAllowedByName && !isAllowedByMime) {
                event.preventDefault();
                if (window.Swal) {
                    Swal.fire({ icon: 'error', title: 'Invalid file type', text: 'Only .xlsx and .csv files are allowed.' });
                } else {
                    alert('Only .xlsx and .csv files are allowed.');
                }
            }
        });
    }
});
</script>

<?= view('dashboard/layout/sidebar') ?>

<div class="main-wrapper">


<?= view('dashboard/layout/navbar') ?>


<div class="container-fluid mt-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="mb-0">
            MSF Records
        </h4>

        <div class="d-flex align-items-center gap-2 flex-wrap">

            <form method="post" action="<?= site_url('mfs/import') ?>" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mb-0">

                <?= csrf_field() ?>

                <input type="file" name="excel_file" accept=".xlsx,.csv" class="form-control form-control-sm" style="width: 220px;" required>

                <button type="submit" class="btn btn-success btn-sm text-nowrap">
                    <i class="fas fa-file-import me-1"></i>
                    Import MFS Excel
                </button>

                <a href="<?= base_url('templates/mfs_import_template.xlsx') ?>" class="btn btn-success btn-sm text-nowrap" download>
                    <i class="fas fa-download me-1"></i>
                    Download Excel Template Here
                </a>

            </form>

            <?php if (!empty($selected_employee)): ?>

                <a href="<?= site_url('mfs/export') .
                    '?employee=' .
                    urlencode($selected_employee) ?>"
                   class="btn btn-success me-2">

                    Export <?= esc($selected_employee) ?>

                </a>

            <?php endif; ?>


            <a href="<?= site_url('mfs/export') ?>"
               class="btn btn-outline-success me-2">

                Export Excel (All)

            </a>


            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addMfsModal">

                Add MFS

            </button>

        </div>

    </div>


    <div class="d-flex justify-content-end mb-3">
        <div class="mfs-view-switch" role="tablist" aria-label="MFS view switch">
            <button type="button" class="btn btn-primary" data-view="table">Table View</button>
            <button type="button" class="btn btn-light" data-view="calendar">Calendar View</button>
        </div>
    </div>

    <div class="row">

        <!-- EMPLOYEE FILTER -->
        <div class="col-md-3 mb-3">

            <div class="card">

                <div class="card-body">

                    <h6 class="card-title">
                        Employees
                    </h6>


                    <ul class="list-group list-group-flush">

                        <!-- ALL -->
                        <li class="list-group-item
                            <?= empty($selected_employee)
                                ? 'active'
                                : '' ?>">

                            <a href="<?= site_url('mfs') ?>"
                               class="stretched-link
                               text-decoration-none
                               <?= empty($selected_employee)
                                    ? 'text-white'
                                    : '' ?>">

                                All

                            </a>

                        </li>


                        <?php foreach ($employee_list as $e): ?>

                            <?php
                                $employee =
                                    $e['employee'] ?? '';

                                $count =
                                    $e['total'] ?? 0;
                            ?>

                            <li class="list-group-item
                                <?= $selected_employee === $employee
                                    ? 'active'
                                    : '' ?>">

                                <a href="<?= site_url('mfs') .
                                    '?employee=' .
                                    urlencode($employee) ?>"
                                   class="d-flex
                                   justify-content-between
                                   text-decoration-none
                                   <?= $selected_employee === $employee
                                        ? 'text-white'
                                        : '' ?>">

                                    <span>
                                        <?= esc($employee) ?>
                                    </span>

                                    <span class="badge bg-secondary">
                                        <?= (int) $count ?>
                                    </span>

                                </a>

                            </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            </div>

        </div>


       <!-- MFS TABLE -->
<div class="col-md-9">

    <div class="card">

        <div class="card-body p-0">

            <div id="mfsTableView" class="mfs-view-panel">

            <div class="table-responsive">

                <table id="mfsTable"
                    class="table table-striped table-hover table-sm mb-0">

                    <thead>
                        <tr>
                            <th>MFS Number</th>
                            <th>Employee</th>
                            <th>Account</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Unit</th>
                            <th>Machine</th>
                            <th>Serial Number</th>
                            <th>Accessories</th>
                            <th>Consumables</th>
                            <th>Reason</th>
                            <th>Date Status</th>
                            <th>Personnel</th>
                            <th>Acknowledged</th>
                            <th>Receipt</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (!empty($mfs_records)): ?>

                        <?php foreach ($mfs_records as $r): ?>

                            <tr>

                                <!-- MFS NUMBER -->
                                <td>
                                    <?= esc($r['mfs_number'] ?? '') ?>
                                </td>

                                <!-- EMPLOYEE -->
                                <td>
                                    <?= esc($r['employee'] ?? '') ?>
                                </td>

                                <!-- ACCOUNT -->
                                <td>
                                    <?= esc($r['accounts'] ?? '') ?>
                                </td>

                                <!-- ADDRESS -->
                                <td>
                                    <?= esc($r['address'] ?? '') ?>
                                </td>

                                <!-- DATE -->
                                <td>
                                    <?= esc($r['date_fillup'] ?? '') ?>
                                </td>

                                <!-- UNIT -->
                                <td>
                                    <?= esc($r['unit'] ?? '') ?>
                                </td>

                                <!-- MACHINE -->
                                <td>
                                    <?= esc($r['machine'] ?? '') ?>
                                </td>

                                <!-- SERIAL NUMBER -->
                                <td>
                                    <?= esc($r['serial_number'] ?? '') ?>
                                </td>

                                <!-- ACCESSORIES -->
                                <td>
                                    <?php
                                        $accessoryRows = [];
                                        $accessoryRaw = trim((string) ($r['accessories'] ?? ''));

                                        if ($accessoryRaw !== '') {
                                            foreach (explode(';', $accessoryRaw) as $entry) {
                                                $entry = trim((string) $entry);
                                                if ($entry === '') {
                                                    continue;
                                                }

                                                $parts = array_map('trim', explode('|', $entry));
                                                $name = $parts[0] ?? '';
                                                $quantity = $parts[1] ?? '';

                                                if ($name !== '' || $quantity !== '') {
                                                    $accessoryRows[] = trim($name . ' | ' . ($quantity !== '' ? $quantity : '1'));
                                                }
                                            }
                                        }

                                        if (!empty($accessoryRows)) {
                                            echo '<div><strong>Accessory Name | Quantity</strong></div>';
                                            foreach ($accessoryRows as $accessoryRow) {
                                                echo '<div>' . esc($accessoryRow) . '</div>';
                                            }
                                        } else {
                                            echo '—';
                                        }
                                    ?>
                                </td>

                                <!-- CONSUMABLES -->
                                <td>
                                    <?php
                                        $consumableRows = [];
                                        $consumableRaw = trim((string) ($r['consumables'] ?? ''));
                                        $unitValue = trim((string) ($r['consumable_unit'] ?? ''));
                                        $lotValue = trim((string) ($r['lot_number'] ?? ''));

                                        if ($consumableRaw !== '' || $unitValue !== '' || $lotValue !== '') {
                                            foreach (explode(';', $consumableRaw !== '' ? $consumableRaw : '') as $entry) {
                                                $entry = trim((string) $entry);
                                                if ($entry === '') {
                                                    continue;
                                                }

                                                $parts = array_map('trim', explode('|', $entry));
                                                $name = $parts[0] ?? '';
                                                $unitEntry = $parts[1] ?? '';
                                                $lotEntry = $parts[2] ?? '';

                                                if ($name !== '' || $unitEntry !== '' || $lotEntry !== '') {
                                                    $consumableRows[] = trim(
                                                        implode(' | ', array_filter([
                                                            $name,
                                                            $unitEntry !== '' ? $unitEntry : $unitValue,
                                                            $lotEntry !== '' ? $lotEntry : $lotValue,
                                                        ], fn($value) => $value !== ''))
                                                    );
                                                }
                                            }
                                        }

                                        if (empty($consumableRows)) {
                                            $consumableRows[] = trim(implode(' | ', array_filter([$consumableRaw, $unitValue, $lotValue], fn($value) => $value !== '')));
                                        }

                                        if (!empty($consumableRows)) {
                                            echo '<div><strong>Consumable | Unit | Lot Number</strong></div>';
                                            foreach ($consumableRows as $consumableRow) {
                                                echo '<div>' . esc($consumableRow) . '</div>';
                                            }
                                        } else {
                                            echo '—';
                                        }
                                    ?>
                                </td>

                                <!-- REASON -->
                                <td>
                                    <?= esc($r['reason'] ?? '') ?>
                                </td>

                                <!-- DATE STATUS -->
                                <td>
                                    <?= esc($r['date_status'] ?? '') ?>
                                </td>

                                <!-- PERSONNEL -->
                                <td>
                                    <?= esc($r['personnel'] ?? '') ?>
                                </td>

                                <!-- ACKNOWLEDGED -->
                                <td>

                                    <?php if ((int) ($r['acknowledged'] ?? 0) === 1): ?>

                                        <span class="badge bg-success">
                                            Yes
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-secondary">
                                            No
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- RECEIPT -->
                                <td>
                                    <?php $receiptId = (int) ($r['receipt'] ?? 0); ?>
                                    <?php if ($receiptId > 0): ?>
                                        <a href="<?= site_url('pms/receipt/' . $receiptId) ?>"
                                           target="_blank"
                                           class="btn btn-sm btn-success">
                                            <i class="bi bi-eye me-1"></i>
                                            View
                                        </a>
                                    <?php else: ?>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary edit-mfs-btn"
                                                data-id="<?= (int) ($r['id'] ?? 0) ?>">
                                            <i class="bi bi-upload me-1"></i>
                                            Upload
                                        </button>
                                    <?php endif; ?>
                                </td>

                                <!-- REMARKS -->
                                <td>
                                    <?= esc($r['remarks'] ?? '') ?>
                                </td>

                                <!-- ACTION -->
                                <td class="text-center text-nowrap">

                                    <!-- EDIT -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-success edit-mfs-btn"
                                        data-id="<?= (int) ($r['id'] ?? 0) ?>"
                                    >
                                        <i class="bi bi-pencil-square me-1"></i>
                                        Edit
                                    </button>

                                    <!-- DELETE -->
                                   <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger delete-mfs-btn"
                                        data-id="<?= (int) ($r['id'] ?? 0) ?>"
                                        data-mfs="<?= esc($r['mfs_number'] ?? '') ?>"
                                    >
                                        <i class="bi bi-trash me-1"></i>
                                        Delete
                                    </button>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

            </div>

        </div>

    </div>

</div>

    </div>

    <div id="mfsCalendarView" class="mfs-view-panel d-none">
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
        ?>

        <div class="card">
            <div class="card-body">
                <div class="mfs-calendar-grid">
                    <?php for ($month = 1; $month <= 12; $month++): ?>
                        <div class="mfs-month-card">
                            <h6><?= esc($monthNames[$month]) ?></h6>
                            <div class="mfs-month-records">
                                <?php $monthHasRecords = false; ?>
                                <?php foreach (($mfs_records ?? []) as $record): ?>
                                    <?php
                                        $recordDate = trim((string) ($record['date_fillup'] ?? ''));
                                        $monthValue = $recordDate !== '' ? (int) date('n', strtotime($recordDate)) : 0;
                                    ?>
                                    <?php if ($monthValue === $month): ?>
                                        <?php $monthHasRecords = true; ?>
                                        <div class="mfs-record-item">
                                            <div class="mfs-record-header">
                                                <span class="mfs-record-number"><?= esc($record['mfs_number'] ?? '') ?></span>
                                                <span class="badge bg-secondary"><?= esc($record['employee'] ?? '') ?></span>
                                            </div>
                                            <div class="mfs-record-meta">
                                                <div><strong>Account:</strong> <?= esc($record['accounts'] ?? '') ?></div>
                                                <div><strong>Machine:</strong> <?= esc($record['machine'] ?? '') ?></div>
                                                <div><strong>Date:</strong> <?= esc($record['date_fillup'] ?? '') ?></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if (!$monthHasRecords): ?>
                                    <div class="text-muted small">No records</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- ============================
     ADD MFS MODAL
     ============================ -->

<div class="modal fade"
     id="addMfsModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <form method="post"
                  action="<?= site_url('mfs/save') ?>"
                  enctype="multipart/form-data">

                <?= csrf_field() ?>


                <div class="modal-header">

                    <h5 class="modal-title">
                        Add MFS Record
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="row g-3">

                        <!-- MFS NUMBER -->
                        <div class="col-md-4">
                            <label class="form-label">MFS Number</label>
                            <input type="text"
                                   name="mfs_number"
                                   class="form-control"
                                   value="<?= esc($next_mfs_number) ?>"
                                   placeholder="000001">
                        </div>

                        <!-- PULL OUT PERSONNEL -->
                        <div class="col-md-4">
                            <label class="form-label">Pull Out Personnel</label>
                            <input type="text"
                                   name="pull_out_personnel"
                                   class="form-control"
                                   placeholder="Fullname">
                        </div>

                        <!-- EMPLOYEE -->
                        <div class="col-md-4">
                            <label class="form-label">Service Engineer</label>
                            <select name="service_eng_id"
                                    id="service_eng_id"
                                    class="form-select"
                                    required>
                                <option value="">-- Select Engineer --</option>
                                <?php foreach ($users as $u): ?>
                                    <option value="<?= $u['id'] ?>"><?= esc($u['fname'] . ' ' . $u['lname']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ACCOUNT -->
                        <div class="col-md-6">
                            <label class="form-label">Clinic</label>

                            <?php
                                $clinicMap = [];

                                foreach ($accounts as $a) {
                                    $clinicName = trim($a['Clinic_name'] ?? '');

                                    if ($clinicName === '') {
                                        continue;
                                    }

                                    $address = trim($a['Address'] ?? '');
                                    $clinicKey = $clinicName . '|' . $address;

                                    if (!isset($clinicMap[$clinicKey])) {
                                        $clinicMap[$clinicKey] = [
                                            'clinic' => $clinicName,
                                            'address' => $a['Address'] ?? '',
                                            'machines' => []
                                        ];
                                    }

                                    $machine = trim($a['Machine'] ?? '');
                                    $serial = trim($a['SN'] ?? '');

                                    if ($machine !== '') {
                                        $clinicMap[$clinicKey]['machines'][$machine] = $serial;
                                    }
                                }
                            ?>

                            <select name="accounts"
                                    id="mfs_accounts"
                                    class="form-select mfs-account-select"
                                    required>
                                <option value="">-- Select Clinic --</option>
                                <?php foreach ($clinicMap as $info): ?>
                                    <?php $machinesJson = htmlspecialchars(json_encode($info['machines']), ENT_QUOTES, 'UTF-8'); ?>
                                    <option value="<?= esc($info['clinic']) ?>"
                                            data-clinic="<?= esc($info['clinic']) ?>"
                                            data-address="<?= esc($info['address']) ?>"
                                            data-machines="<?= $machinesJson ?>">
                                        <?= esc($info['clinic']) ?> | <?= esc($info['address']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ADDRESS -->
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text"
                                   name="address"
                                   id="mfs_address"
                                   class="form-control"
                                   readonly>
                        </div>

                        <!-- DATE FILL-UP -->
                        <div class="col-md-3">
                            <label class="form-label">Date Fill Up</label>
                            <input type="date"
                                   name="date_fillup"
                                   class="form-control"
                                   value="<?= date('Y-m-d') ?>">
                        </div>

                        <!-- MACHINE -->
                        <div class="col-md-3">
                            <label class="form-label">Machine</label>
                            <select name="machine"
                                    id="mfs_machine"
                                    class="form-select"
                                    disabled
                                    required>
                                <option value="">-- Select Machine --</option>
                            </select>
                        </div>

                        <!-- SERIAL NUMBER -->
                        <div class="col-md-3">
                            <label class="form-label">Serial Number</label>
                            <input type="text"
                                   name="serial_number"
                                   id="mfs_serial"
                                   class="form-control"
                                   readonly>
                        </div>

                        <!-- UNIT -->
                        <div class="col-md-3">
                            <label class="form-label">Unit</label>
                            <input type="text"
                                   name="unit"
                                   id="mfs_unit"
                                   class="form-control">
                        </div>

                        <!-- ACCESSORIES -->
                        <div class="col-12">
                            <div class="border rounded p-3 bg-light-subtle">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Accessories</strong>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            id="addMfsAccessoryRow">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Add Accessory
                                    </button>
                                </div>

                                <div id="mfsAccessoryRows">
                                    <div class="row g-2 accessory-row align-items-end">
                                        <div class="col-md-6">
                                            <label class="form-label small mb-1">Accessory</label>
                                            <input type="text"
                                                   name="accessories[0][name]"
                                                   class="form-control"
                                                   placeholder="Accessory">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small mb-1">Quantity</label>
                                            <input type="number"
                                                   name="accessories[0][quantity]"
                                                   class="form-control"
                                                   min="1"
                                                   value="1">
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button"
                                                    class="btn btn-outline-danger remove-mfs-accessory"
                                                    title="Remove Accessory">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CONSUMABLES -->
                        <div class="col-12">
                            <div class="border rounded p-3 bg-light-subtle">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Consumables</strong>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            id="addMfsConsumableRow">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Add Consumable
                                    </button>
                                </div>

                                <div id="mfsConsumableRows">
                                    <div class="row g-2 consumable-row align-items-end">
                                        <div class="col-md-5">
                                            <label class="form-label small mb-1">Consumable</label>
                                            <input type="text"
                                                   name="consumables_rows[0][name]"
                                                   class="form-control"
                                                   placeholder="Consumable">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small mb-1">Unit</label>
                                            <input type="text"
                                                   name="consumables_rows[0][unit]"
                                                   class="form-control"
                                                   placeholder="Unit">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small mb-1">Lot Number</label>
                                            <input type="text"
                                                   name="consumables_rows[0][lot_number]"
                                                   class="form-control"
                                                   placeholder="Lot Number">
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button"
                                                    class="btn btn-outline-danger remove-mfs-consumable"
                                                    title="Remove Consumable">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- REASON -->
                        <div class="col-md-4">
                            <label class="form-label">Reason</label>
                            <input type="text"
                                   name="reason"
                                   class="form-control">
                        </div>

                        <!-- DATE STATUS -->
                        <div class="col-md-3">
                            <label class="form-label">Date Status</label>
                            <input type="date"
                                   name="date_status"
                                   class="form-control">
                        </div>

                        <!-- RETURNED PERSONNEL -->
                        <div class="col-md-3">
                            <label class="form-label">Returned Personnel</label>
                            <input type="text"
                                   name="returned_personnel"
                                   class="form-control"
                                   placeholder="Fullname">
                        </div>

                        <!-- ACKNOWLEDGED -->
                        <div class="col-md-2">
                            <label class="form-label">Acknowledged</label>
                            <select name="acknowledged" class="form-select">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <!-- RETURNED -->
                        <!-- <div class="col-md-3">
                            <label class="form-label">Returned</label>
                            <input type="number"
                                   name="returned"
                                   class="form-control"
                                   value="0"
                                   min="0">
                        </div> -->

                        <!-- RECEIPT -->
                        <div class="col-md-6">
                            <label class="form-label">Receipt</label>
                            <div class="border rounded p-2 bg-light-subtle receipt-upload-box">
                                <div id="mfsReceiptPreview" class="d-flex align-items-center justify-content-center text-center"
                                     style="min-height: 110px; border: 1px dashed #cbd5e1; border-radius: 0.5rem; background: #fff;">
                                    <div class="text-muted small">
                                        <i class="bi bi-cloud-upload fs-3 d-block mb-2"></i>
                                        Upload Receipt
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2 gap-2">
                                    <label for="mfs_receipt" class="btn btn-sm btn-outline-primary mb-0">
                                        <i class="bi bi-upload me-1"></i>
                                        Upload
                                    </label>
                                    <a id="mfsReceiptView" href="#" target="_blank" class="btn btn-sm btn-success d-none">
                                        <i class="bi bi-eye me-1"></i>
                                        View
                                    </a>
                                    <input type="file"
                                           name="receipt"
                                           id="mfs_receipt"
                                           class="d-none"
                                           accept=".jpg,.jpeg,.png,.pdf">
                                </div>
                            </div>
                        </div>

                        <!-- REMARKS -->
                        <div class="col-md-6">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks"
                                      class="form-control"
                                      rows="3"></textarea>
                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Close

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        Save MFS

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- ============================================================
     EDIT MFS MODAL
     ============================================================ -->
<div class="modal fade"
     id="editMfsModal"
     tabindex="-1"
     aria-labelledby="editMfsModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="editMfsModalLabel">
                    Edit MFS Record
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <form id="editMfsForm"
                  method="POST"
                  enctype="multipart/form-data">

                <?= csrf_field() ?>

                <div class="modal-body">

                    <input type="hidden"
                           id="edit_mfs_id"
                           name="id">

                    <div class="row g-3">

                        <!-- MFS NUMBER -->
                        <div class="col-md-4">
                            <label class="form-label">MFS Number</label>
                            <input type="text"
                                   id="edit_mfs_number"
                                   name="mfs_number"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- PULL OUT PERSONNEL -->
                        <div class="col-md-4">
                            <label class="form-label">Pull Out Personnel</label>
                            <input type="text"
                                   id="edit_pull_out_personnel"
                                   name="pull_out_personnel"
                                   class="form-control"
                                   placeholder="Fullname">
                        </div>

                        <!-- EMPLOYEE -->
                        <div class="col-md-4">
                            <label class="form-label">Service Engineer</label>
                            <select name="service_eng_id"
                                    id="edit_service_eng_id"
                                    class="form-select"
                                    required>
                                <option value="">-- Select Engineer --</option>
                                <?php foreach (($users ?? []) as $u): ?>
                                    <?php $fullName = trim(($u['fname'] ?? '') . ' ' . ($u['lname'] ?? '')); ?>
                                    <option value="<?= (int) $u['id'] ?>">
                                        <?= esc($fullName !== '' ? $fullName : ($u['uname'] ?? '')) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ACCOUNT -->
                        <div class="col-md-6">
                            <label class="form-label">Clinic</label>

                            <select class="form-select mfs-account-select"
                                    id="edit_accounts"
                                    name="accounts"
                                    required>
                                <option value="">-- Select Clinic --</option>
                                <?php foreach ($clinicMap as $info): ?>
                                    <?php $machinesJson = htmlspecialchars(json_encode($info['machines']), ENT_QUOTES, 'UTF-8'); ?>
                                    <option value="<?= esc($info['clinic']) ?>"
                                            data-clinic="<?= esc($info['clinic']) ?>"
                                            data-address="<?= esc($info['address']) ?>"
                                            data-machines="<?= $machinesJson ?>">
                                        <?= esc($info['clinic']) ?> | <?= esc($info['address']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ADDRESS -->
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text"
                                   id="edit_address"
                                   name="address"
                                   class="form-control"
                                   readonly>
                        </div>

                        <!-- DATE FILL-UP -->
                        <div class="col-md-3">
                            <label class="form-label">Date Fill Up</label>
                            <input type="date"
                                   id="edit_date_fillup"
                                   name="date_fillup"
                                   class="form-control">
                        </div>

                        <!-- MACHINE -->
                        <div class="col-md-3">
                            <label class="form-label">Machine</label>
                            <select class="form-select"
                                    id="edit_machine"
                                    name="machine"
                                    required
                                    disabled>
                                <option value="">-- Select Machine --</option>
                            </select>
                        </div>

                        <!-- SERIAL NUMBER -->
                        <div class="col-md-3">
                            <label class="form-label">Serial Number</label>
                            <input type="text"
                                   id="edit_serial_number"
                                   name="serial_number"
                                   class="form-control"
                                   readonly>
                        </div>

                        <!-- UNIT -->
                        <div class="col-md-3">
                            <label class="form-label">Unit</label>
                            <input type="text"
                                   id="edit_unit"
                                   name="unit"
                                   class="form-control">
                        </div>

                        <!-- ACCESSORIES -->
                        <div class="col-12">
                            <div class="border rounded p-3 bg-light-subtle">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Accessories</strong>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            id="editMfsAccessoryRow">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Add Accessory
                                    </button>
                                </div>

                                <div id="editMfsAccessoryRows"></div>
                            </div>
                        </div>

                        <!-- CONSUMABLES -->
                        <div class="col-12">
                            <div class="border rounded p-3 bg-light-subtle">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Consumables</strong>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            id="editMfsConsumableRow">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Add Consumable
                                    </button>
                                </div>

                                <div id="editMfsConsumableRows"></div>
                            </div>
                        </div>

                        <!-- REASON -->
                        <div class="col-md-4">
                            <label class="form-label">Reason</label>
                            <input type="text"
                                   id="edit_reason"
                                   name="reason"
                                   class="form-control">
                        </div>

                        <!-- DATE STATUS -->
                        <div class="col-md-3">
                            <label class="form-label">Date Status</label>
                            <input type="date"
                                   id="edit_date_status"
                                   name="date_status"
                                   class="form-control">
                        </div>

                        <!-- RETURNED PERSONNEL -->
                        <div class="col-md-3">
                            <label class="form-label">Returned Personnel</label>
                            <input type="text"
                                   id="edit_returned_personnel"
                                   name="returned_personnel"
                                   class="form-control"
                                   placeholder="Fullname">
                        </div>

                        <!-- ACKNOWLEDGED -->
                        <div class="col-md-2">
                            <label class="form-label">Acknowledged</label>
                            <select id="edit_acknowledged"
                                    name="acknowledged"
                                    class="form-select">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <!-- RECEIPT -->
                        <div class="col-md-6">
                            <label class="form-label">Receipt</label>
                            <div class="border rounded p-2 bg-light-subtle receipt-upload-box">
                                <div id="editMfsReceiptPreview" class="d-flex align-items-center justify-content-center text-center"
                                     style="min-height: 110px; border: 1px dashed #cbd5e1; border-radius: 0.5rem; background: #fff;">
                                    <div class="text-muted small">
                                        <i class="bi bi-cloud-upload fs-3 d-block mb-2"></i>
                                        Upload Receipt
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2 gap-2">
                                    <label for="edit_mfs_receipt" class="btn btn-sm btn-outline-primary mb-0">
                                        <i class="bi bi-upload me-1"></i>
                                        Upload
                                    </label>
                                    <a id="editMfsReceiptView" href="#" target="_blank" class="btn btn-sm btn-success d-none">
                                        <i class="bi bi-eye me-1"></i>
                                        View
                                    </a>
                                    <input type="file"
                                           id="edit_mfs_receipt"
                                           name="receipt"
                                           class="d-none"
                                           accept=".jpg,.jpeg,.png,.pdf">
                                </div>
                            </div>
                        </div>

                        <!-- REMARKS -->
                        <div class="col-md-6">
                            <label class="form-label">Remarks</label>
                            <textarea id="edit_remarks"
                                      name="remarks"
                                      class="form-control"
                                      rows="3"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Close

                    </button>

                    <button type="submit"
                            class="btn btn-primary"
                            id="updateMfsBtn">

                        Save MFS

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
    function setMfsView(view) {
        const tableView = document.getElementById('mfsTableView');
        const calendarView = document.getElementById('mfsCalendarView');
        const buttons = document.querySelectorAll('.mfs-view-switch [data-view]');

        if (!tableView || !calendarView || !buttons.length) {
            return;
        }

        const isCalendar = view === 'calendar';

        tableView.classList.toggle('d-none', isCalendar);
        calendarView.classList.toggle('d-none', !isCalendar);

        buttons.forEach(function (button) {
            const isSelected = button.dataset.view === view;
            button.classList.toggle('btn-primary', isSelected);
            button.classList.toggle('btn-light', !isSelected);
            button.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const switchButtons = document.querySelectorAll('.mfs-view-switch [data-view]');

        switchButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                setMfsView(this.dataset.view);
            });
        });

        setMfsView('table');
    });
</script>

<?= view('dashboard/layout/footer') ?>


<?= view('dashboard/script/mfs') ?>

</div>

</body>
</html>
