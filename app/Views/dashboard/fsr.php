<?= view('dashboard/layout/head') ?>

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

    if (!isset($clinicMap[$clinicName])) {

        $clinicMap[$clinicName] = [
            'address' => $a['Address'] ?? '',
            'machines' => []
        ];
    }

    $machine = trim(
        (string) ($a['Machine'] ?? '')
    );

    if ($machine !== '') {

        $clinicMap[$clinicName]['machines'][$machine] =
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
                                    class="form-select"
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

                                <?php foreach ($clinicMap as $clinicName => $info): ?>

                                    <?php

                                    $machinesJson = htmlspecialchars(
                                        json_encode(
                                            $info['machines']
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );

                                    ?>

                                    <option value="<?= esc($clinicName) ?>"
                                            data-address="<?= esc(
                                                $info['address']
                                            ) ?>"
                                            data-machines="<?= $machinesJson ?>">

                                        <?= esc($clinicName) ?>

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

    const accountSelect =
        document.getElementById('fsr_account');

    const addressInput =
        document.getElementById('fsr_address');

    const machineSelect =
        document.getElementById('fsr_machine');

    const serialInput =
        document.getElementById('fsr_serial');


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
