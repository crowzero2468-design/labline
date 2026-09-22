<?= view('dashboard/layout/head') ?>

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
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (!empty($mfs_records)): ?>

                        <?php foreach ($mfs_records as $r): ?>

                            <tr>

                                <td><?= esc($r['mfs_number'] ?? '') ?></td>

                                <td><?= esc($r['employee'] ?? '') ?></td>

                                <td><?= esc($r['accounts'] ?? '') ?></td>

                                <td><?= esc($r['address'] ?? '') ?></td>

                                <td><?= esc($r['date_fillup'] ?? '') ?></td>

                                <td><?= esc($r['unit'] ?? '') ?></td>

                                <td><?= esc($r['machine'] ?? '') ?></td>

                                <td><?= esc($r['serial_number'] ?? '') ?></td>

                                <td><?= esc($r['consumable_unit'] ?? '') ?></td>

                                <td><?= esc($r['consumables'] ?? '') ?></td>

                                <td><?= esc($r['lot_number'] ?? '') ?></td>

                                <td><?= esc($r['reason'] ?? '') ?></td>

                                <td><?= esc($r['date_status'] ?? '') ?></td>

                                <td><?= esc($r['personnel'] ?? '') ?></td>

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

                                <td><?= (int) ($r['returned'] ?? 0) ?></td>

                                <td><?= esc($r['remarks'] ?? '') ?></td>

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

            if (!isset($clinicMap[$clinicName])) {
                $clinicMap[$clinicName] = [
                    'address'  => $a['Address'] ?? '',
                    'machines' => []
                ];
            }

            $machine = trim($a['Machine'] ?? '');
            $serial  = trim($a['SN'] ?? '');

            if ($machine !== '') {
                $clinicMap[$clinicName]['machines'][$machine] = $serial;
            }
        }
    ?>

    <select name="accounts"
            id="mfs_accounts"
            class="form-select"
            required>

        <option value="">-- Select Account --</option>

        <?php foreach ($clinicMap as $clinicName => $info): ?>

            <?php
                $machinesJson = htmlspecialchars(
                    json_encode($info['machines']),
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>

            <option
                value="<?= esc($clinicName) ?>"
                data-address="<?= esc($info['address']) ?>"
                data-machines="<?= $machinesJson ?>">

                <?= esc($clinicName) ?>

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


<?= view('dashboard/layout/footer') ?>


<script>
$(document).ready(function () {

    $('#mfsTable').DataTable({
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
    /*
     * Automatically hide flash messages
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

document.addEventListener('DOMContentLoaded', function () {

    const accountSelect = document.getElementById('mfs_accounts');
    const addressInput  = document.getElementById('mfs_address');
    const machineSelect = document.getElementById('mfs_machine');
    const serialInput   = document.getElementById('mfs_serial');

    // Stores:
    // Machine => Serial Number
    let currentMachines = {};


    /*
     * ACCOUNT / CLINIC CHANGED
     */
    if (accountSelect) {

        accountSelect.addEventListener('change', function () {

            const selected =
                accountSelect.options[
                    accountSelect.selectedIndex
                ];

            if (!selected || !selected.value) {

                if (addressInput) {
                    addressInput.value = '';
                }

                if (machineSelect) {

                    machineSelect.innerHTML =
                        '<option value="">-- Select Machine --</option>';

                    machineSelect.disabled = true;
                }

                if (serialInput) {
                    serialInput.value = '';
                }

                currentMachines = {};

                return;
            }


            /*
             * GET ADDRESS
             */
            const address =
                selected.getAttribute('data-address') || '';

            if (addressInput) {
                addressInput.value = address;
            }


            /*
             * GET MACHINE => SERIAL MAP
             */
            const machinesJson =
                selected.getAttribute('data-machines') || '{}';

            try {

                currentMachines =
                    JSON.parse(machinesJson);

            } catch (error) {

                console.error(
                    'Invalid machine mapping:',
                    error
                );

                currentMachines = {};
            }


            /*
             * POPULATE MACHINE DROPDOWN
             */
            if (machineSelect) {

                machineSelect.innerHTML =
                    '<option value="">-- Select Machine --</option>';

                const machines =
                    Object.keys(currentMachines);

                if (machines.length > 0) {

                    machines.forEach(function (machine) {

                        const option =
                            document.createElement('option');

                        option.value = machine;
                        option.textContent = machine;

                        machineSelect.appendChild(option);

                    });

                    machineSelect.disabled = false;

                } else {

                    machineSelect.innerHTML =
                        '<option value="">-- No Machine Found --</option>';

                    machineSelect.disabled = true;

                }
            }


            /*
             * CLEAR SERIAL
             */
            if (serialInput) {
                serialInput.value = '';
            }

        });

    }


    /*
     * MACHINE CHANGED
     */
    if (machineSelect) {

        machineSelect.addEventListener('change', function () {

            const selectedMachine =
                (machineSelect.value || '')
                    .toString()
                    .trim()
                    .toLowerCase();

            let serial = '';


            /*
             * Find serial number
             * using case-insensitive machine name
             */
            Object.keys(currentMachines).some(function (machine) {

                if (
                    machine
                        .toString()
                        .trim()
                        .toLowerCase() === selectedMachine
                ) {

                    serial =
                        currentMachines[machine] || '';

                    return true;
                }

                return false;

            });


            /*
             * SET SERIAL NUMBER
             */
            if (serialInput) {
                serialInput.value = serial;
            }

        });

    }

});

</script>

</div>

</body>
</html>
