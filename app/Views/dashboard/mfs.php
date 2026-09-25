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

    .select2-results__option--highlighted[aria-selected] .mfs-account-address {
        color: #e9ecef;
    }
</style>

<body>

<?php if (session()->getFlashdata('error')): ?>


<div class="flash-message"
     style="position: fixed; top: 12px; left: 50%;
            transform: translateX(-50%);
            z-index: 1200;
            width: min(90vw, 520px);
            opacity: 1;
            transition: opacity 0.5s ease;">

    <div style="background: #ffe4e6;
                color: #991b1b;
                border: 1px solid #fecdd3;
                padding: 12px 16px;
                border-radius: 10px;
                font-weight: 600;">

        <?= esc(session()->getFlashdata('error')) ?>

    </div>
</div>


<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>


<div class="flash-message"
     style="position: fixed; top: 12px; left: 50%;
            transform: translateX(-50%);
            z-index: 1200;
            width: min(90vw, 520px);
            opacity: 1;
            transition: opacity 0.5s ease;">

    <div style="background: #dcfce7;
                color: #166534;
                border: 1px solid #bbf7d0;
                padding: 12px 16px;
                border-radius: 10px;
                font-weight: 600;">

        <?= esc(session()->getFlashdata('success')) ?>

    </div>
</div>


<?php endif; ?>

<?= view('dashboard/layout/sidebar') ?>

<div class="main-wrapper">


<?= view('dashboard/layout/navbar') ?>


<div class="container-fluid mt-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="mb-0">
            MSF Records
        </h4>

        <div>

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
                            <th>Consumable Unit</th>
                            <th>Consumables</th>
                            <th>Lot Number</th>
                            <th>Reason</th>
                            <th>Date Status</th>
                            <th>Personnel</th>
                            <th>Acknowledged</th>
                            <th>Returned</th>
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

                                <!-- CONSUMABLE UNIT -->
                                <td>
                                    <?= esc($r['consumable_unit'] ?? '') ?>
                                </td>

                                <!-- CONSUMABLES -->
                                <td>
                                    <?= esc($r['consumables'] ?? '') ?>
                                </td>

                                <!-- LOT NUMBER -->
                                <td>
                                    <?= esc($r['lot_number'] ?? '') ?>
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

                                <!-- RETURNED -->
                                <td>
                                    <?= (int) ($r['returned'] ?? 0) ?>
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


<!-- ============================
     ADD MFS MODAL
     ============================ -->

<div class="modal fade"
     id="addMfsModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <form method="post"
                  action="<?= site_url('mfs/save') ?>">

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

                            <label class="form-label">
                                MFS Number
                            </label>

                            <input type="text"
                                   name="mfs_number"
                                   class="form-control"
                                   value="<?= esc(
                                       $next_mfs_number
                                   ) ?>"
                                   placeholder="000001">

                        </div>


                        <!-- EMPLOYEE -->
                        <div class="col-md-6">
                                  <label class="form-label">Service Engineer</label>
                                  <select name="service_eng_id" id="service_eng_id" class="form-select" required>
                                    <option value="">-- Select Engineer --</option>
                                    <?php foreach ($users as $u): ?>
                                      <option value="<?= $u['id'] ?>"><?= esc($u['fname'].' '.$u['lname']) ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
<!-- ACCOUNT -->
<div class="col-md-4">
    <label class="form-label">Account / Clinic</label>

    <?php
        // Build:
        // Clinic => Address + Machines => Serial Number
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
                    'clinic'   => $clinicName,
                    'address'  => $a['Address'] ?? '',
                    'machines' => []
                ];
            }

            $machine = trim($a['Machine'] ?? '');
            $serial  = trim($a['SN'] ?? '');

            if ($machine !== '') {
                $clinicMap[$clinicKey]['machines'][$machine] = $serial;
            }
        }
    ?>

    <select name="accounts"
            id="mfs_accounts"
            class="form-select mfs-account-select"
            required>

        <option value="">-- Select Account --</option>

        <?php foreach ($clinicMap as $info): ?>

            <?php
                $machinesJson = htmlspecialchars(
                    json_encode($info['machines']),
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>

            <option
                value="<?= esc($info['clinic']) ?>"
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

                    <label class="form-label">
                        Address
                    </label>

                    <input type="text"
                        name="address"
                        id="mfs_address"
                        class="form-control"
                        readonly>

                </div>


                <!-- DATE -->
                <div class="col-md-3">

                    <label class="form-label">
                        Date Fill-up
                    </label>

                    <input type="date"
                        name="date_fillup"
                        class="form-control"
                        value="<?= date('Y-m-d') ?>">

                </div>


                <!-- UNIT -->
                <div class="col-md-3">

                    <label class="form-label">
                        Unit
                    </label>

                    <input type="text"
                        name="unit"
                        id="mfs_unit"
                        class="form-control">

                </div>


                <!-- MACHINE -->
                <div class="col-md-6">

                    <label class="form-label">
                        Machine
                    </label>

                    <select name="machine"
                            id="mfs_machine"
                            class="form-select"
                            disabled
                            required>

                        <option value="">
                            -- Select Machine --
                        </option>

                    </select>

                </div>


                <!-- SERIAL NUMBER -->
                <div class="col-md-6">

                    <label class="form-label">
                        Serial Number
                    </label>

                    <input type="text"
                        name="serial_number"
                        id="mfs_serial"
                        class="form-control"
                        readonly>

                </div>


                        <!-- CONSUMABLE UNIT -->
                        <div class="col-md-4">

                            <label class="form-label">
                                Consumable Unit
                            </label>

                            <input type="text"
                                   name="consumable_unit"
                                   class="form-control">

                        </div>


                        <!-- CONSUMABLES -->
                        <div class="col-md-4">

                            <label class="form-label">
                                Consumables
                            </label>

                            <input type="text"
                                   name="consumables"
                                   class="form-control">

                        </div>


                        <!-- LOT -->
                        <div class="col-md-4">

                            <label class="form-label">
                                Lot Number
                            </label>

                            <input type="text"
                                   name="lot_number"
                                   class="form-control">

                        </div>


                        <!-- REASON -->
                        <div class="col-md-6">

                            <label class="form-label">
                                Reason
                            </label>

                            <input type="text"
                                   name="reason"
                                   class="form-control">

                        </div>


                        <!-- DATE STATUS -->
                        <div class="col-md-3">

                            <label class="form-label">
                                Date Status
                            </label>

                            <input type="date"
                                   name="date_status"
                                   class="form-control">

                        </div>


                        <!-- RETURNED -->
                        <div class="col-md-3">

                            <label class="form-label">
                                Returned
                            </label>

                            <input type="number"
                                   name="returned"
                                   class="form-control"
                                   value="0"
                                   min="0">

                        </div>


                        <!-- PERSONNEL -->
                        <div class="col-md-6">

                            <label class="form-label">
                                Personnel
                            </label>

                            <input type="text"
                                   name="personnel"
                                   class="form-control">

                        </div>


                        <!-- ACKNOWLEDGED -->
                        <div class="col-md-6">

                            <label class="form-label">
                                Acknowledged
                            </label>

                            <select name="acknowledged"
                                    class="form-select">

                                <option value="0">
                                    No
                                </option>

                                <option value="1">
                                    Yes
                                </option>

                            </select>

                        </div>


                        <!-- REMARKS -->
                        <div class="col-12">

                            <label class="form-label">
                                Remarks
                            </label>

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
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit MFS Record
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <form id="editMfsForm" method="POST">

                <?= csrf_field() ?>

                <div class="modal-body">

                    <input type="hidden"
                           id="edit_mfs_id"
                           name="id">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                MFS Number
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="edit_mfs_number"
                                   name="mfs_number"
                                   required>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Service Engineer
                            </label>

                            <select class="form-select"
                                    id="edit_service_eng_id"
                                    name="service_eng_id"
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


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Date
                            </label>

                            <input type="date"
                                   class="form-control"
                                   id="edit_date_fillup"
                                   name="date_fillup">
                        </div>


                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Account
                            </label>

                                <select class="form-select mfs-account-select"
                                    id="edit_accounts"
                                    name="accounts"
                                    required>
                                <option value="">-- Select Account --</option>
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


                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Address
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="edit_address"
                                   name="address">
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Unit
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="edit_unit"
                                   name="unit">
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Machine
                            </label>

                            <select class="form-select"
                                    id="edit_machine"
                                    name="machine"
                                    required
                                    disabled>
                                <option value="">-- Select Machine --</option>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Serial Number
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="edit_serial_number"
                                   name="serial_number">
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Consumable Unit
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="edit_consumable_unit"
                                   name="consumable_unit">
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Consumables
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="edit_consumables"
                                   name="consumables">
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Lot Number
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="edit_lot_number"
                                   name="lot_number">
                        </div>


                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Reason
                            </label>

                            <textarea class="form-control"
                                      id="edit_reason"
                                      name="reason"
                                      rows="2"></textarea>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Date Status
                            </label>

                            <input type="date"
                                   class="form-control"
                                   id="edit_date_status"
                                   name="date_status">
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Personnel
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="edit_personnel"
                                   name="personnel">
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Acknowledged
                            </label>

                            <select class="form-select"
                                    id="edit_acknowledged"
                                    name="acknowledged">

                                <option value="0">No</option>
                                <option value="1">Yes</option>

                            </select>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Returned
                            </label>

                            <select class="form-select"
                                    id="edit_returned"
                                    name="returned">

                                <option value="0">No</option>
                                <option value="1">Yes</option>

                            </select>
                        </div>


                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Remarks
                            </label>

                            <textarea class="form-control"
                                      id="edit_remarks"
                                      name="remarks"
                                      rows="3"></textarea>
                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        <i class="bi bi-x-circle me-1"></i>
                        Cancel

                    </button>

                    <button type="submit"
                            class="btn btn-primary"
                            id="updateMfsBtn">

                        <i class="bi bi-save me-1"></i>
                        Update MFS

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<?= view('dashboard/layout/footer') ?>


<?= view('dashboard/script/mfs') ?>

</div>

</body>
</html>
