<?= view('dashboard/layout/head') ?>

<style>
    .fsr-account-address {
        color: #6c757d;
    }

    .fsr-account-select + .select2-container {
        width: 100% !important;
    }

    .fsr-account-select + .select2-container .select2-selection--single {
        height: 38px;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #212529;
        font-size: 1rem;
    }

    .fsr-account-select + .select2-container .select2-selection__rendered {
        line-height: 24px;
        padding: 0;
        color: #212529;
    }

    .fsr-account-select + .select2-container .select2-selection__arrow {
        height: 36px;
        right: 0.5rem;
    }

    .fsr-account-select + .select2-container--focus .select2-selection--single,
    .fsr-account-select + .select2-container--open .select2-selection--single {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .fsr-account-select + .select2-container .select2-dropdown {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        overflow: hidden;
    }

    .fsr-account-select + .select2-container .select2-search__field {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }

    .fsr-account-select + .select2-container .select2-results__option {
        padding: 0.375rem 0.75rem;
        color: #212529;
        background-color: #fff;
    }

    .fsr-account-select + .select2-container .select2-results__option--highlighted[aria-selected] {
        color: #fff;
        background-color: #0d6efd;
    }

    .select2-results__option--highlighted[aria-selected] .fsr-account-address {
        color: #e9ecef;
    }
</style>

<body>

<?php if (session()->getFlashdata('error')): ?>


<div class="flash-message"
     style="position: fixed;
            top: 12px;
            left: 50%;
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
     style="position: fixed;
            top: 12px;
            left: 50%;
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


<?php
/*
 * ==========================================
 * BUILD CLINIC / MACHINE / SERIAL MAP
 * FROM TB_DATA
 * ==========================================
 */

$clinicMap = [];

foreach (($accounts ?? []) as $a) {

    $clinicName = trim(
        (string) ($a['Clinic_name'] ?? '')
    );

    if ($clinicName === '') {
        continue;
    }

    $address = trim((string) ($a['Address'] ?? ''));
    $clinicKey = $clinicName . '|' . $address;

    if (!isset($clinicMap[$clinicKey])) {

        $clinicMap[$clinicKey] = [
            'clinic' => $clinicName,
            'address' => $address,
            'machines' => []
        ];
    }

    $machine = trim(
        (string) ($a['Machine'] ?? '')
    );

    if ($machine !== '') {

        $clinicMap[$clinicKey]['machines'][$machine] =
            $a['SN'] ?? '';
    }
}
?>


<div class="container-fluid mt-4">

    <!-- ==========================================
         HEADER
         ========================================== -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="mb-0">
            FSR Records
        </h4>

        <div>

            <?php if (!empty($selected_engineer)): ?>

                <a href="<?= site_url('fsr/export') .
                    '?engineer=' .
                    urlencode($selected_engineer) ?>"
                   class="btn btn-success me-2">

                    Export <?= esc($selected_engineer) ?>

                </a>

            <?php endif; ?>


            <a href="<?= site_url('fsr/export') ?>"
               class="btn btn-outline-success me-2">

                Export Excel (All)

            </a>


            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addFsrModal">

                Add FSR

            </button>

        </div>

    </div>


    <div class="row">

        <!-- ==========================================
             SERVICE ENGINEER FILTER
             ========================================== -->

        <div class="col-md-3 mb-3">

            <div class="card">

                <div class="card-body">

                    <h6 class="card-title">
                        Service Engineers
                    </h6>


                    <ul class="list-group list-group-flush">

                        <!-- ALL -->

                        <li class="list-group-item
                            <?= empty($selected_engineer)
                                ? 'active'
                                : '' ?>">

                            <a href="<?= site_url('fsr') ?>"
                               class="stretched-link
                                      text-decoration-none
                                      <?= empty($selected_engineer)
                                        ? 'text-white'
                                        : '' ?>">

                                All

                            </a>

                        </li>


                        <?php foreach ($engineer_list as $e): ?>

                            <?php

                            $engineer =
                                $e['service_engineer'] ?? '';

                            $count =
                                $e['total'] ?? 0;

                            ?>


                            <li class="list-group-item
                                <?= $selected_engineer === $engineer
                                    ? 'active'
                                    : '' ?>">

                                <a href="<?= site_url('fsr') .
                                    '?engineer=' .
                                    urlencode($engineer) ?>"
                                   class="d-flex
                                          justify-content-between
                                          text-decoration-none
                                          <?= $selected_engineer === $engineer
                                            ? 'text-white'
                                            : '' ?>">

                                    <span>
                                        <?= esc($engineer) ?>
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


        <!-- ==========================================
             FSR TABLE
             ========================================== -->

<div class="col-md-9">

    <div class="card">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table id="fsrTable"
                       class="table table-striped table-hover table-sm mb-0">

                    <thead>
                        <tr>
                            <th>FSR Number</th>
                            <th>Service Engineer</th>
                            <th>Account</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Machine</th>
                            <th>Serial Number</th>
                            <th>Technical Concern</th>
                            <th>Remarks</th>
                            <th>Action Made</th>
                            <th>Acknowledge</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (!empty($fsr_records)): ?>

                        <?php foreach ($fsr_records as $r): ?>

                            <?php
                                $ack = strtolower(
                                    trim(
                                        (string) ($r['acknowledge'] ?? '')
                                    )
                                );
                            ?>

                            <tr>

                                <td><?= esc($r['fsr_number'] ?? '') ?></td>

                                <td><?= esc($r['service_engineer'] ?? '') ?></td>

                                <td><?= esc($r['account'] ?? '') ?></td>

                                <td><?= esc($r['address'] ?? '') ?></td>

                                <td><?= esc($r['date'] ?? '') ?></td>

                                <td><?= esc($r['machine'] ?? '') ?></td>

                                <td><?= esc($r['serial_number'] ?? '') ?></td>

                                <td style="min-width: 220px;">
                                    <?= esc($r['technical_concern'] ?? '') ?>
                                </td>

                                <td style="min-width: 180px;">
                                    <?= esc($r['remarks'] ?? '') ?>
                                </td>

                                <td style="min-width: 220px;">
                                    <?= esc($r['action_made'] ?? '') ?>
                                </td>

                                <td>
                                    <?php if (
                                        $ack === 'yes' ||
                                        $ack === '1' ||
                                        $ack === 'acknowledged'
                                    ): ?>

                                        <span class="badge bg-success">
                                            Yes
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-secondary">
                                            No
                                        </span>

                                    <?php endif; ?>
                                </td>

                                <td class="text-nowrap">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-success edit-fsr-btn"
                                            data-id="<?= (int) $r['id'] ?>">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>

                                    <form method="post"
                                          action="<?= site_url('fsr/delete/' . (int) $r['id']) ?>"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this FSR record?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                            Delete
                                        </button>
                                    </form>
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

<!-- ==========================================
     EDIT FSR MODAL
     ========================================== -->

<div class="modal fade" id="editFsrModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form id="editFsrForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit FSR Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="editFsrMessage" class="alert d-none"></div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">FSR Number</label>
                            <input class="form-control" id="edit_fsr_number" name="fsr_number" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Service Engineer</label>
                            <select class="form-select" id="edit_fsr_service_eng_id" name="service_eng_id" required>
                                <option value="">-- Select Service Engineer --</option>
                                <?php foreach (($users ?? []) as $u): ?>
                                    <?php $fullName = trim(($u['fname'] ?? '') . ' ' . ($u['lname'] ?? '')); ?>
                                    <option value="<?= (int) $u['id'] ?>"><?= esc($fullName !== '' ? $fullName : ($u['uname'] ?? '')) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" id="edit_fsr_date" name="date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Account</label>
                            <select class="form-select fsr-account-select" id="edit_fsr_account" name="account" required>
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
                            <label class="form-label">Address</label>
                            <textarea class="form-control" id="edit_fsr_address" name="address" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Machine</label>
                            <select class="form-select" id="edit_fsr_machine" name="machine" required disabled>
                                <option value="">-- Select Machine --</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Serial Number</label>
                            <input class="form-control" id="edit_fsr_serial" name="serial_number">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Acknowledge</label>
                            <select class="form-select" id="edit_fsr_acknowledge" name="acknowledge">
                                <option value="">-- Select --</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Technical Concern</label>
                            <textarea class="form-control" id="edit_fsr_technical_concern" name="technical_concern" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" id="edit_fsr_remarks" name="remarks" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Action Made</label>
                            <textarea class="form-control" id="edit_fsr_action_made" name="action_made" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveEditFsrBtn">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ==========================================
     ADD FSR MODAL
     ========================================== -->

<div class="modal fade"
     id="addFsrModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <form method="post"
                  action="<?= site_url('fsr/save') ?>">

                <?= csrf_field() ?>


                <div class="modal-header">

                    <h5 class="modal-title">
                        Add FSR Record
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="row g-3">


                        <!-- ==================================
                             FSR NUMBER
                             ================================== -->

                        <div class="col-md-4">

                            <label class="form-label">
                                FSR Number
                            </label>

                            <input type="text"
                                   name="fsr_number"
                                   class="form-control"
                                   value="<?= esc(
                                       $next_fsr_number
                                   ) ?>"
                                   placeholder="000001">

                        </div>


                        <!-- ==================================
                             SERVICE ENGINEER
                             ================================== -->

                        <div class="col-md-4">

                            <label class="form-label">
                                Service Engineer
                            </label>

                            <select name="service_eng_id"
                                    id="fsr_service_eng_id"
                                    class="form-select fsr-account-select"
                                    required>

                                <option value="">
                                    -- Select Service Engineer --
                                </option>

                                <?php foreach (($users ?? []) as $u): ?>

                                    <?php

                                    $fullName = trim(
                                        ($u['fname'] ?? '') .
                                        ' ' .
                                        ($u['lname'] ?? '')
                                    );

                                    if ($fullName === '') {
                                        $fullName =
                                            $u['uname'] ?? '';
                                    }

                                    ?>

                                    <option value="<?= esc($u['id']) ?>">

                                        <?= esc($fullName) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- ==================================
                             ACCOUNT
                             ================================== -->

                        <div class="col-md-4">

                            <label class="form-label">
                                Account
                            </label>

                            <select name="account"
                                    id="fsr_account"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Select Account --
                                </option>

                                <?php foreach ($clinicMap as $info): ?>

                                    <?php

                                    $machinesJson = htmlspecialchars(
                                        json_encode(
                                            $info['machines']
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );

                                    ?>

                                        <option value="<?= esc($info['clinic']) ?>"
                                            data-clinic="<?= esc($info['clinic']) ?>"
                                            data-address="<?= esc(
                                                $info['address']
                                            ) ?>"
                                            data-machines="<?= $machinesJson ?>">

                                        <?= esc($info['clinic']) ?> | <?= esc($info['address']) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- ==================================
                             ADDRESS
                             ================================== -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Address
                            </label>

                            <textarea name="address"
                                      id="fsr_address"
                                      class="form-control"
                                      rows="2"
                                      readonly></textarea>

                        </div>


                        <!-- ==================================
                             DATE
                             ================================== -->

                        <div class="col-md-3">

                            <label class="form-label">
                                Date
                            </label>

                            <input type="date"
                                   name="date"
                                   class="form-control"
                                   value="<?= date('Y-m-d') ?>">

                        </div>


                        <!-- ==================================
                             MACHINE
                             ================================== -->

                        <div class="col-md-3">

                            <label class="form-label">
                                Machine
                            </label>

                            <select name="machine"
                                    id="fsr_machine"
                                    class="form-select"
                                    required
                                    disabled>

                                <option value="">
                                    -- Select Machine --
                                </option>

                            </select>

                        </div>


                        <!-- ==================================
                             SERIAL NUMBER
                             ================================== -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Serial Number
                            </label>

                            <input type="text"
                                   name="serial_number"
                                   id="fsr_serial"
                                   class="form-control"
                                   readonly>

                        </div>


                        <!-- ==================================
                             TECHNICAL CONCERN
                             ================================== -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Technical Concern
                            </label>

                            <textarea name="technical_concern"
                                      class="form-control"
                                      rows="3"></textarea>

                        </div>


                        <!-- ==================================
                             REMARKS
                             ================================== -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Remarks
                            </label>

                            <textarea name="remarks"
                                      class="form-control"
                                      rows="3"></textarea>

                        </div>


                        <!-- ==================================
                             ACTION MADE
                             ================================== -->

                        <div class="col-md-6">

                            <label class="form-label">
                                Action Made
                            </label>

                            <textarea name="action_made"
                                      class="form-control"
                                      rows="3"></textarea>

                        </div>


                        <!-- ==================================
                             ACKNOWLEDGE
                             ================================== -->

                        <div class="col-md-4">

                            <label class="form-label">
                                Acknowledge
                            </label>

                            <select name="acknowledge"
                                    class="form-select">

                                <option value="">
                                    -- Select --
                                </option>

                                <option value="Yes">
                                    Yes
                                </option>

                                <option value="No">
                                    No
                                </option>

                            </select>

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

                        Save FSR

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<?= view('dashboard/layout/footer') ?>


<!-- ==========================================
     FSR ACCOUNT / MACHINE MAPPING
     ========================================== -->

<script>
    $(document).ready(function () {

        function formatFsrAccount(account) {
            if (!account.id) {
                return account.text;
            }

            const option = account.element;
            const clinic = option?.dataset.clinic || account.text;
            const address = option?.dataset.address || '';
            const result = $('<span>');

            result.append($('<span>').text(clinic));
            result.append($('<span class="fsr-account-address">').text(address ? ' | ' + address : ''));

            return result;
        }

        if ($.fn.select2) {
            $('#fsr_account').select2({
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 0,
                dropdownParent: $('#addFsrModal'),
                templateResult: formatFsrAccount,
                templateSelection: formatFsrAccount
            });

            $('#edit_fsr_account').select2({
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 0,
                dropdownParent: $('#editFsrModal'),
                templateResult: formatFsrAccount,
                templateSelection: formatFsrAccount
            });
        }

    $('#fsrTable').DataTable({
        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],

        order: [[4, 'desc']],

        responsive: true,

        autoWidth: false
    });

});

document.addEventListener('DOMContentLoaded', function () {

    const editFsrModal = document.getElementById('editFsrModal');
    const editFsrForm = document.getElementById('editFsrForm');
    const editFsrMessage = document.getElementById('editFsrMessage');

    function showEditFsrMessage(message, type) {
        editFsrMessage.className = 'alert alert-' + type;
        editFsrMessage.textContent = message;
    }

    document.querySelectorAll('.edit-fsr-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = button.dataset.id;
            editFsrForm.reset();
            editFsrForm.dataset.id = id;
            editFsrMessage.className = 'alert d-none';

            fetch('<?= site_url('fsr/edit/') ?>' + id, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (response) { return response.json(); })
            .then(function (result) {
                if (!result.success) {
                    throw new Error(result.message || 'Unable to load FSR.');
                }

                const data = result.data || {};
                document.getElementById('edit_fsr_number').value = data.fsr_number || '';
                document.getElementById('edit_fsr_service_eng_id').value = data.service_eng_id || '';
                document.getElementById('edit_fsr_date').value = data.date || '';
                document.getElementById('edit_fsr_account').value = data.account || '';
                populateEditMachines(data.machine || '', data.serial_number || '');
                document.getElementById('edit_fsr_acknowledge').value = data.acknowledge || '';
                document.getElementById('edit_fsr_technical_concern').value = data.technical_concern || '';
                document.getElementById('edit_fsr_remarks').value = data.remarks || '';
                document.getElementById('edit_fsr_action_made').value = data.action_made || '';
                bootstrap.Modal.getOrCreateInstance(editFsrModal).show();
            })
            .catch(function (error) {
                showEditFsrMessage(error.message, 'danger');
                bootstrap.Modal.getOrCreateInstance(editFsrModal).show();
            });
        });
    });

    editFsrForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const button = document.getElementById('saveEditFsrBtn');
        button.disabled = true;

        fetch('<?= site_url('fsr/update/') ?>' + editFsrForm.dataset.id, {
            method: 'POST',
            body: new FormData(editFsrForm),
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function (response) { return response.json(); })
        .then(function (result) {
            if (!result.success) {
                throw new Error(result.message || 'Unable to update FSR.');
            }

            bootstrap.Modal.getInstance(editFsrModal).hide();
            window.location.reload();
        })
        .catch(function (error) {
            showEditFsrMessage(error.message, 'danger');
            button.disabled = false;
        });
    });

    const accountSelect =
        document.getElementById('fsr_account');

    const addressInput =
        document.getElementById('fsr_address');

    const machineSelect =
        document.getElementById('fsr_machine');

    const serialInput =
        document.getElementById('fsr_serial');

    const editAccountSelect =
        document.getElementById('edit_fsr_account');

    const editAddressInput =
        document.getElementById('edit_fsr_address');

    const editMachineSelect =
        document.getElementById('edit_fsr_machine');

    const editSerialInput =
        document.getElementById('edit_fsr_serial');

    function populateEditMachines(selectedMachine, selectedSerial) {
        if (!editAccountSelect || !editMachineSelect) {
            return;
        }

        const selectedOption = editAccountSelect.options[editAccountSelect.selectedIndex];
        const address = selectedOption?.dataset.address || '';
        let machines = {};

        try {
            machines = JSON.parse(selectedOption?.dataset.machines || '{}');
        }
        catch (error) {
            machines = {};
        }

        if (editAddressInput) {
            editAddressInput.value = address;
        }

        editMachineSelect.innerHTML = '<option value="">-- Select Machine --</option>';

        Object.keys(machines).forEach(function (machine) {
            const option = document.createElement('option');
            option.value = machine;
            option.textContent = machine;
            editMachineSelect.appendChild(option);
        });

        editMachineSelect.disabled = Object.keys(machines).length === 0;
        editMachineSelect.value = selectedMachine || '';

        if (editSerialInput) {
            editSerialInput.value = selectedMachine && machines[selectedMachine]
                ? machines[selectedMachine]
                : (selectedSerial || '');
        }
    }

    if (editAccountSelect) {
        editAccountSelect.addEventListener('change', function () {
            populateEditMachines('', '');
        });
    }

    if (editMachineSelect) {
        editMachineSelect.addEventListener('change', function () {
            const selectedOption = editAccountSelect?.options[editAccountSelect.selectedIndex];
            let machines = {};

            try {
                machines = JSON.parse(selectedOption?.dataset.machines || '{}');
            }
            catch (error) {
                machines = {};
            }

            if (editSerialInput) {
                editSerialInput.value = machines[this.value] || '';
            }
        });
    }


    let currentMachines = {};


    if (!accountSelect) {
        return;
    }


    /*
     * ==========================================
     * ACCOUNT CHANGE
     * ==========================================
     */

    accountSelect.addEventListener(
        'change',
        function () {

            const selectedOption =
                this.options[this.selectedIndex];


            /*
             * Get address
             */
            const address =
                selectedOption.dataset.address || '';

            addressInput.value =
                address;


            /*
             * Reset machine
             */
            machineSelect.innerHTML =
                '<option value="">-- Select Machine --</option>';


            /*
             * Reset serial
             */
            serialInput.value = '';


            /*
             * Reset machine map
             */
            currentMachines = {};


            /*
             * No account selected
             */
            if (!this.value) {

                machineSelect.disabled = true;

                return;
            }


            /*
             * Get machines
             */
            try {

                currentMachines =
                    JSON.parse(
                        selectedOption.dataset.machines || '{}'
                    );

            } catch (error) {

                console.error(
                    'Invalid machine data:',
                    error
                );

                currentMachines = {};
            }


            /*
             * Populate machine dropdown
             */
            Object.keys(currentMachines)
                .forEach(function (machine) {

                    const option =
                        document.createElement('option');

                    option.value =
                        machine;

                    option.textContent =
                        machine;

                    machineSelect.appendChild(
                        option
                    );

                });


            /*
             * Enable machine
             */
            machineSelect.disabled =
                Object.keys(currentMachines).length === 0;

        }
    );


    /*
     * ==========================================
     * MACHINE CHANGE
     * ==========================================
     */

    machineSelect.addEventListener(
        'change',
        function () {

            const selectedMachine =
                this.value;


            /*
             * Reset serial
             */
            serialInput.value = '';


            if (!selectedMachine) {
                return;
            }


            /*
             * Find machine
             * Case insensitive
             */
            const machineKey =
                Object.keys(currentMachines)
                    .find(function (key) {

                        return key.toLowerCase() ===
                            selectedMachine.toLowerCase();

                    });


            /*
             * Set serial
             */
            if (machineKey) {

                serialInput.value =
                    currentMachines[machineKey] || '';

            }

        }
    );

});


/*
 * ==========================================
 * AUTO HIDE FLASH MESSAGE
 * ==========================================
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

</script>


</div>

</body>
</html>
