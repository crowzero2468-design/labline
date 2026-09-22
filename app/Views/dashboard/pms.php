<?= view('dashboard/layout/head') ?>

<body>

<?php if (session()->getFlashdata('error')): ?>


<div
    class="flash-message"
    style="
        position: fixed;
        top: 12px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1200;
        width: min(90vw, 520px);
        opacity: 1;
        transition: opacity 0.5s ease;
    "
>
    <div
        style="
            background: #ffe4e6;
            color: #991b1b;
            border: 1px solid #fecdd3;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
        "
    >
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
</div>


<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>


<div
    class="flash-message"
    style="
        position: fixed;
        top: 12px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1200;
        width: min(90vw, 520px);
        opacity: 1;
        transition: opacity 0.5s ease;
    "
>
    <div
        style="
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
        "
    >
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
</div>


<?php endif; ?>

<?= view('dashboard/layout/sidebar') ?>

<div class="main-wrapper">


<?= view('dashboard/layout/navbar') ?>


<!-- =========================================================
     PAGE HEADER
     ========================================================= -->

<div class="d-flex justify-content-between align-items-center mb-3">

    <h4 class="mb-0">
        PMS Records
    </h4>

    <div>

        <a
            href="<?= site_url('pms/export') ?>"
            class="btn btn-outline-success me-2"
        >
            <i class="bi bi-file-earmark-excel"></i>
            Export Excel (All)
        </a>


        <?php if (!empty($selected_tech)): ?>

            <a
                href="<?= site_url('pms/export') . '?tech=' . urlencode($selected_tech) ?>"
                class="btn btn-success me-2"
            >
                <i class="bi bi-file-earmark-excel"></i>
                Export <?= esc($selected_tech) ?>
            </a>

        <?php endif; ?>


        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addPmsModal"
        >
            <i class="bi bi-plus-circle"></i>
            Add PMS
        </button>

    </div>

</div>


<!-- =========================================================
     MAIN ROW
     ========================================================= -->

<div class="row">


    <!-- =====================================================
         TECHNICIAN SIDEBAR
         ===================================================== -->

    <div class="col-md-3 mb-3">

        <div class="card">

            <div class="card-body">

                <h6 class="card-title mb-3">
                    Technicians
                </h6>


                <ul class="list-group list-group-flush">


                    <!-- ALL -->

                    <li
                        class="list-group-item <?= empty($selected_tech) ? 'active' : '' ?>"
                    >

                        <a
                            href="<?= site_url('pms') ?>"
                            class="
                                stretched-link
                                text-decoration-none
                                <?= empty($selected_tech) ? 'text-white' : '' ?>
                            "
                        >
                            All
                        </a>

                    </li>


                    <!-- TECHNICIANS -->

                    <?php foreach ($tech_list as $t): ?>

                        <?php

                        $name =
                            $t['service_tech'] ?? '';

                        $count =
                            $t['total'] ?? 0;

                        $isActive =
                            ($selected_tech === $name);

                        ?>

                        <li
                            class="
                                list-group-item
                                <?= $isActive ? 'active' : '' ?>
                            "
                        >

                            <a
                                href="<?= site_url('pms') . '?tech=' . urlencode($name) ?>"
                                class="
                                    d-flex
                                    justify-content-between
                                    text-decoration-none
                                    <?= $isActive ? 'text-white' : '' ?>
                                "
                            >

                                <span>
                                    <?= esc($name) ?>
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


    <!-- =====================================================
         PMS TABLE
         ===================================================== -->

    <div class="col-md-9">

        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table
                        id="pmsTable"
                        class="table table-striped table-hover table-sm table-bordered align-middle w-100"
                    >

                        <thead>

                            <tr>

                                <th>PMS Number</th>
                                <th>Service Engr</th>
                                <th>Account</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Machine Type</th>
                                <th>Serial Number</th>
                                <th>Technical Done</th>
                                <th>MSF</th>
                                <th>FSR</th>
                                <th>Receipt</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($pms_records)): ?>

                                <?php foreach ($pms_records as $r): ?>

                                    <tr>

                                        <td>
                                            <?= esc($r['pms_number'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= esc($r['service_tech'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= esc($r['clinic'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= esc($r['address'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= esc($r['date'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= esc($r['machine'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= esc($r['sn'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= esc($r['status'] ?? '') ?>
                                        </td>



                                            <!-- MFS -->

                                               <td class="text-center">
                                                    <?php if (!empty($r['mfs']) && (int)$r['mfs'] > 0): ?>

                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-success view-mfs-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#mfsViewModal"
                                                            data-mfs-id="<?= (int)$r['mfs'] ?>"
                                                        >
                                                            <i class="bi bi-check-circle me-1"></i>
                                                            MSF
                                                        </button>

                                                    <?php else: ?>

                                                        <span class="badge bg-secondary">
                                                            No MSF
                                                        </span>

                                                    <?php endif; ?>
                                                </td>


                                                <!-- FSR -->

                                               <td class="text-center">
                                                    <?php if (!empty($r['fsr']) && (int)$r['fsr'] > 0): ?>

                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-success view-fsr-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#fsrViewModal"
                                                            data-fsr-id="<?= (int)$r['fsr'] ?>"
                                                        >
                                                            <i class="bi bi-check-circle me-1"></i>
                                                            FSR
                                                        </button>

                                                    <?php else: ?>

                                                        <span class="badge bg-secondary">
                                                            No FSR
                                                        </span>

                                                    <?php endif; ?>
                                                </td>

                                        
                                        <!-- RECEIPT -->

                                        <td class="text-center">

                                            <?php if (!empty($r['receipt'])): ?>

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#receiptModal<?= (int)$r['id'] ?>"
                                                >

                                                    <i class="bi bi-eye me-1"></i>

                                                    View

                                                </button>

                                            <?php else: ?>

                                                <span class="badge bg-secondary">
                                                    No Receipt
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



<!-- ============================================================
     MFS VIEW MODAL
============================================================ -->
<div class="modal fade" id="mfsViewModal" tabindex="-1" aria-labelledby="mfsViewModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="mfsViewModalLabel">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    MFS Record
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <div class="modal-body">

                <div id="mfsViewContent">

                    <div class="text-center py-4">

                        <div class="spinner-border" role="status"></div>

                        <div class="mt-2">
                            Loading MFS record...
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ============================================================
     FSR VIEW MODAL
============================================================ -->
<div class="modal fade" id="fsrViewModal" tabindex="-1" aria-labelledby="fsrViewModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="fsrViewModalLabel">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    FSR Record
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <div class="modal-body">

                <div id="fsrViewContent">

                    <div class="text-center py-4">

                        <div class="spinner-border" role="status"></div>

                        <div class="mt-2">
                            Loading FSR record...
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?= view('dashboard/layout/footer') ?>
</div>





<!-- ==========================================================
     ADD PMS MODAL
     ========================================================== -->

<style>
/* PMS MODAL */
#addPmsModal .modal-dialog {
    height: calc(100vh - 2rem);
    max-height: calc(100vh - 2rem);
    margin: 1rem auto;
}

#addPmsModal .modal-content {
    height: 100%;
    max-height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

#addPmsModal form {
    height: 100%;
    display: flex;
    flex-direction: column;
    min-height: 0;
}

#addPmsModal .modal-header {
    flex-shrink: 0;
}

#addPmsModal .modal-body {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    overflow-x: hidden;
}

#addPmsModal .modal-footer {
    flex-shrink: 0;
}

/* Scrollbar */
#addPmsModal .modal-body::-webkit-scrollbar {
    width: 8px;
}

#addPmsModal .modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#addPmsModal .modal-body::-webkit-scrollbar-thumb {
    background: #adb5bd;
    border-radius: 10px;
}

#addPmsModal .modal-body::-webkit-scrollbar-thumb:hover {
    background: #6c757d;
}

/* Mobile */
@media (max-width: 576px) {

    #addPmsModal .modal-dialog {
        height: calc(100vh - 1rem);
        max-height: calc(100vh - 1rem);
        margin: 0.5rem auto;
    }

}
</style>

<div
    class="modal fade"
    id="addPmsModal"
    tabindex="-1"
    aria-labelledby="addPmsModalLabel"
    aria-hidden="true"
>


<div class="modal-dialog modal-xl modal-dialog-scrollable">

    <div class="modal-content">

        <form
            method="post"
            action="<?= site_url('pms/save') ?>"
            enctype="multipart/form-data"
            id="addPmsForm"
        >

            <?= csrf_field() ?>


            <!-- HEADER -->

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="addPmsModalLabel"
                >

                    <i class="bi bi-clipboard-plus"></i>

                    Add PMS Record

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <!-- BODY -->

            <div class="modal-body">

                <div class="row g-3">


                    <!-- PMS NUMBER -->

                    <div class="col-md-6">

                        <label
                            for="pms_number"
                            class="form-label"
                        >
                            PMS Number
                        </label>

                        <input
                            type="text"
                            name="pms_number"
                            id="pms_number"
                            class="form-control"
                            required
                            placeholder="0000"
                            value="0000"
                        >

                    </div>


                    <!-- SERVICE ENGINEER -->

                    <div class="col-md-6">

                        <label
                            for="service_eng_id"
                            class="form-label"
                        >
                            Service Engineer
                        </label>

                        <select
                            name="service_eng_id"
                            id="service_eng_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Select Engineer --
                            </option>


                            <?php foreach ($users as $u): ?>

                                <option
                                    value="<?= esc($u['id']) ?>"
                                >

                                    <?= esc(
                                        trim(
                                            ($u['fname'] ?? '') .
                                            ' ' .
                                            ($u['lname'] ?? '')
                                        )
                                    ) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

<style>

.select2-container {
    width: 100% !important;
}

.select2-container--default
.select2-selection--single {
    height: 38px !important;
    border: 1px solid #dee2e6 !important;
    border-radius: 0 0.375rem 0.375rem 0 !important;
    background-color: #fff !important;
}

.select2-container--default
.select2-selection--single
.select2-selection__rendered {
    line-height: 36px !important;
    padding-left: 12px !important;
    color: #212529 !important;
}

.select2-container--default
.select2-selection--single
.select2-selection__arrow {
    height: 36px !important;
}

.select2-dropdown {
    border: 1px solid #dee2e6 !important;
    border-radius: 0.375rem !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    z-index: 99999 !important;
}

.select2-search--dropdown {
    padding: 8px !important;
}

.select2-search--dropdown .select2-search__field {
    width: 100% !important;
    height: 38px !important;
    padding: 6px 10px !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
    outline: none !important;
}

.select2-search--dropdown .select2-search__field:focus {
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

.select2-results__option {
    padding: 8px 12px !important;
}

.select2-container--default
.select2-results__option--highlighted[aria-selected] {
    background-color: #0d6efd !important;
    color: #fff !important;
}

</style>
                   <!-- ACCOUNT -->

                    <div class="col-md-6">

                        <label
                            for="data_id"
                            class="form-label fw-semibold"
                        >
                            Account
                        </label>

                        <?php

                        $clinicMap = [];

                        foreach ($accounts as $a) {

                            $clinicName = trim(
                                $a['Clinic_name'] ?? ''
                            );

                            if ($clinicName === '') {
                                continue;
                            }

                            if (!isset($clinicMap[$clinicName])) {

                                $clinicMap[$clinicName] = [

                                    'id' =>
                                        $a['id']
                                        ?? $a['ID']
                                        ?? $a['data_id']
                                        ?? '',

                                    'address' =>
                                        $a['Address']
                                        ?? '',

                                    'machines' => []

                                ];

                            }

                            $machine = trim(
                                $a['Machine'] ?? ''
                            );

                            if ($machine !== '') {

                                $clinicMap[$clinicName]['machines'][$machine] =
                                    $a['SN'] ?? '';

                            }

                        }

                        ?>

                        <div class="input-group">

                            <select
                                name="data_id"
                                id="data_id"
                                class="form-select select2-account"
                                required
                            >

                                <option value="">
                                    -- Select Account --
                                </option>

                                <?php foreach ($clinicMap as $clinicName => $info): ?>

                                    <?php

                                    $machinesJson = htmlspecialchars(
                                        json_encode(
                                            $info['machines'],
                                            JSON_UNESCAPED_UNICODE
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );

                                    ?>

                                    <option
                                        value="<?= esc($info['id']) ?>"
                                        data-clinic="<?= esc($clinicName) ?>"
                                        data-address="<?= esc($info['address']) ?>"
                                        data-machines="<?= $machinesJson ?>"
                                    >
                                        <?= esc($clinicName) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="form-text">
                            <i class="bi bi-search me-1"></i>
                            Search and select the clinic account.
                        </div>

                    </div>
                    <!-- ADDRESS -->

                    <div class="col-md-6">

                        <label
                            for="address"
                            class="form-label"
                        >
                            Address
                        </label>

                        <input
                            type="text"
                            name="address"
                            id="address"
                            class="form-control"
                            readonly
                        >

                    </div>


                    <!-- DATE -->

                    <div class="col-md-4">

                        <label
                            for="pms_date"
                            class="form-label"
                        >
                            Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            id="pms_date"
                            class="form-control"
                            value="<?= date('Y-m-d') ?>"
                            required
                        >

                    </div>


                    <!-- =================================================
                         MULTIPLE MACHINES
                         ================================================= -->

                    <div class="col-12">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <label class="form-label fw-bold mb-0">

                                <i class="bi bi-cpu me-1"></i>

                                Machines

                            </label>


                            <button
                                type="button"
                                class="btn btn-sm btn-outline-primary"
                                id="addMachineBtn"
                                disabled
                            >

                                <i class="bi bi-plus-circle me-1"></i>

                                Add Machine

                            </button>

                        </div>


                        <div
                            id="machineRows"
                            class="border rounded p-3"
                            style="background:#f8f9fa;"
                        >

                            <!-- FIRST MACHINE ROW WILL BE CREATED BY JS -->

                        </div>


                        <div class="form-text mt-2">

                            You can select multiple machines.
                            Each machine can have a different
                            Technical Done, while all records
                            use the same PMS Number.

                        </div>

                    </div>


                    <!-- RECEIPT -->

                    <div class="col-md-6">

                        <label
                            for="receipt"
                            class="form-label"
                        >
                            Receipt
                        </label>


                        <input
                            type="file"
                            name="receipt"
                            id="receipt"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        >


                        <small class="text-muted">

                            JPG, JPEG, PNG or WEBP.
                            Maximum 5 MB.

                        </small>

                    </div>


                </div>


                <!-- ADDITIONAL RECORDS -->

                <hr class="my-4">


                <div class="card border-0 bg-light">

                    <div class="card-body">

                        <h6 class="fw-bold mb-3">

                            <i class="bi bi-files"></i>

                            Create Additional Records

                        </h6>


                        <div class="row g-3">


                            <!-- MFS -->

                            <div class="col-md-6">

                                <div
                                    class="
                                        form-check
                                        p-3
                                        border
                                        rounded
                                        bg-white
                                    "
                                >

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="mfs"
                                        id="mfs_check"
                                        value="1"
                                    >


                                    <label
                                        class="
                                            form-check-label
                                            fw-semibold
                                        "
                                        for="mfs_check"
                                    >

                                        Create MSF after saving PMS

                                    </label>


                                    <div class="small text-muted mt-1">

                                        Automatically opens the
                                        MFS form after saving PMS.

                                    </div>

                                </div>

                            </div>


                            <!-- FSR -->

                            <div class="col-md-6">

                                <div
                                    class="
                                        form-check
                                        p-3
                                        border
                                        rounded
                                        bg-white
                                    "
                                >

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="fsr"
                                        id="fsr_check"
                                        value="1"
                                    >


                                    <label
                                        class="
                                            form-check-label
                                            fw-semibold
                                        "
                                        for="fsr_check"
                                    >

                                        Create FSR after saving PMS

                                    </label>


                                    <div class="small text-muted mt-1">

                                        Automatically opens the
                                        FSR form after saving PMS.

                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>


            <!-- FOOTER -->

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>


                <button
                    type="submit"
                    class="btn btn-primary"
                    id="savePmsButton"
                >

                    <i class="bi bi-save"></i>

                    Save PMS

                </button>

            </div>


        </form>

    </div>

</div>


</div>

<!-- ==========================================================
     MFS MODAL
     ========================================================== -->

<div
    class="modal fade"
    id="mfsModal"
    tabindex="-1"
    aria-hidden="true"
>


<div class="modal-dialog modal-lg modal-dialog-scrollable">

    <div class="modal-content">

        <form
            method="post"
            action="<?= site_url('pms/save_mfs') ?>"
            id="mfsForm"
            enctype="multipart/form-data"
        >

            <?= csrf_field() ?>


            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="bi bi-file-earmark-text"></i>

                    MFS

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <div class="row g-3">


                    <!-- MFS NUMBER -->

                    <div class="col-md-6">

                        <label class="form-label">
                            MFS Number
                        </label>

                        <input
                            type="text"
                            name="mfs_number"
                            id="mfs_number"
                            class="form-control"
                            required
                            placeholder="0000"
                            value="0000"
                        >

                    </div>


                    <!-- EMPLOYEE -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Employee
                        </label>

                        <input
                            type="text"
                            name="employee"
                            id="mfs_employee"
                            class="form-control"
                        >

                    </div>


                    <!-- ACCOUNT -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Account
                        </label>

                        <input
                            type="text"
                            name="accounts"
                            id="mfs_accounts"
                            class="form-control"
                        >

                    </div>


                    <!-- ADDRESS -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Address
                        </label>

                        <input
                            type="text"
                            name="address"
                            id="mfs_address"
                            class="form-control"
                        >

                    </div>


                    <!-- MACHINE -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Machine
                        </label>

                        <input
                            type="text"
                            name="machine"
                            id="mfs_machine"
                            class="form-control"
                        >

                    </div>


                    <!-- SERIAL -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Serial Number
                        </label>

                        <input
                            type="text"
                            name="serial_number"
                            id="mfs_serial"
                            class="form-control"
                        >

                    </div>


                    <!-- UNIT -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Unit
                        </label>

                        <input
                            type="text"
                            name="unit"
                            id="mfs_unit"
                            class="form-control"
                        >

                    </div>


                    <!-- CONSUMABLE UNIT -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Consumable Unit
                        </label>

                        <input
                            type="text"
                            name="consumable_unit"
                            id="mfs_consumable_unit"
                            class="form-control"
                        >

                    </div>


                    <!-- CONSUMABLES -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Consumables
                        </label>

                        <input
                            type="text"
                            name="consumables"
                            id="mfs_consumables"
                            class="form-control"
                        >

                    </div>


                    <!-- LOT NUMBER -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Lot Number
                        </label>

                        <input
                            type="text"
                            name="lot_number"
                            id="mfs_lot_number"
                            class="form-control"
                        >

                    </div>


                    <!-- REASON -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Reason
                        </label>

                        <input
                            type="text"
                            name="reason"
                            id="mfs_reason"
                            class="form-control"
                        >

                    </div>


                    <!-- DATE STATUS -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Date Status
                        </label>

                        <input
                            type="date"
                            name="date_status"
                            id="mfs_date_status"
                            class="form-control"
                        >

                    </div>


                    <!-- PERSONNEL -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Personnel
                        </label>

                        <input
                            type="text"
                            name="personnel"
                            id="mfs_personnel"
                            class="form-control"
                        >

                    </div>


                    <!-- ACKNOWLEDGED -->

                    <div class="col-md-3">

                        <label class="form-label">
                            Acknowledged
                        </label>

                        <select
                            name="acknowledged"
                            id="mfs_acknowledged"
                            class="form-select"
                        >

                            <option value="0">
                                No
                            </option>

                            <option value="1">
                                Yes
                            </option>

                        </select>

                    </div>


                    <!-- RETURNED -->

                    <div class="col-md-3">

                        <label class="form-label">
                            Returned
                        </label>

                        <input
                            type="number"
                            name="returned"
                            id="mfs_returned"
                            class="form-control"
                            value="0"
                            min="0"
                        >

                    </div>


                    <!-- RECEIPT -->

                    <div class="col-12">

                        <label class="form-label">
                            Receipt
                        </label>

                        <input
                            type="file"
                            name="receipt"
                            id="mfs_receipt"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp,.pdf"
                        >

                        <div class="form-text">
                            Allowed: JPG, JPEG, PNG, WEBP, PDF. Maximum file size: 5MB.
                        </div>

                    </div>


                    <!-- REMARKS -->

                    <div class="col-12">

                        <label class="form-label">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            id="mfs_remarks"
                            class="form-control"
                            rows="3"
                        ></textarea>

                    </div>


                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>


                <button
                    type="submit"
                    class="btn btn-primary"
                    id="saveMfsButton"
                >

                    <i class="bi bi-save"></i>

                    Save MFS

                </button>

            </div>


        </form>

    </div>

</div>

</div>

<!-- ==========================================================
     FSR MODAL
     ========================================================== -->

<div
    class="modal fade"
    id="fsrModal"
    tabindex="-1"
    aria-hidden="true"
>


<div class="modal-dialog modal-lg modal-dialog-scrollable">

    <div class="modal-content">

        <form
            method="post"
            action="<?= site_url('pms/save_fsr') ?>"
            id="fsrForm"
            enctype="multipart/form-data"
        >

            <?= csrf_field() ?>


            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="bi bi-file-earmark-text"></i>

                    FSR

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <div class="row g-3">


                    <!-- FSR NUMBER -->

                    <div class="col-md-6">

                        <label class="form-label">
                            FSR Number
                        </label>

                        <input
                            type="text"
                            name="fsr_number"
                            id="fsr_number"
                            class="form-control"
                            required
                            placeholder="0000"
                            value="0000"
                        >

                    </div>


                    <!-- SERVICE ENGINEER -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Service Engineer
                        </label>

                        <input
                            type="text"
                            name="service_engineer"
                            id="fsr_service_engineer"
                            class="form-control"
                        >

                    </div>


                    <!-- ACCOUNT -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Account
                        </label>

                        <input
                            type="text"
                            name="account"
                            id="fsr_account"
                            class="form-control"
                        >

                    </div>


                    <!-- ADDRESS -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Address
                        </label>

                        <input
                            type="text"
                            name="address"
                            id="fsr_address"
                            class="form-control"
                        >

                    </div>


                    <!-- MACHINE -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Machine
                        </label>

                        <input
                            type="text"
                            name="machine"
                            id="fsr_machine"
                            class="form-control"
                        >

                    </div>


                    <!-- SERIAL -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Serial Number
                        </label>

                        <input
                            type="text"
                            name="serial_number"
                            id="fsr_serial"
                            class="form-control"
                        >

                    </div>


                    <!-- TECHNICAL CONCERN -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Technical Concern
                        </label>

                        <textarea
                            name="technical_concern"
                            id="fsr_technical_concern"
                            class="form-control"
                            rows="3"
                        ></textarea>

                    </div>


                    <!-- REMARKS -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            id="fsr_remarks"
                            class="form-control"
                            rows="3"
                        ></textarea>

                    </div>


                    <!-- ACTION MADE -->

                    <div class="col-12">

                        <label class="form-label">
                            Action Made
                        </label>

                        <textarea
                            name="action_made"
                            id="fsr_action_made"
                            class="form-control"
                            rows="3"
                        ></textarea>

                    </div>


                    <!-- ACKNOWLEDGE -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Acknowledge
                        </label>

                        <select
                            name="acknowledge"
                            id="fsr_acknowledge"
                            class="form-select"
                        >

                            <option value="0">
                                No
                            </option>

                            <option value="1">
                                Yes
                            </option>

                        </select>

                    </div>


                    <!-- RECEIPT -->

                    <div class="col-md-8">

                        <label class="form-label">
                            Receipt
                        </label>

                        <input
                            type="file"
                            name="receipt"
                            id="fsr_receipt"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp,.pdf"
                        >

                        <div class="form-text">
                            Allowed: JPG, JPEG, PNG, WEBP, PDF. Maximum file size: 5MB.
                        </div>

                    </div>


                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>


                <button
                    type="submit"
                    class="btn btn-primary"
                    id="saveFsrButton"
                >

                    <i class="bi bi-save"></i>

                    Save FSR

                </button>

            </div>


        </form>

    </div>

</div>


</div>

<!-- ==========================================================
     RECEIPT MODALS
     ========================================================== -->

<?php if (!empty($pms_records)): ?>


<?php foreach ($pms_records as $r): ?>

    <?php if (!empty($r['receipt'])): ?>

        <div
            class="modal fade"
            id="receiptModal<?= (int)$r['id'] ?>"
            tabindex="-1"
            aria-hidden="true"
        >

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">

                            <i class="bi bi-receipt me-2"></i>

                            PMS Receipt

                        </h5>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>


                    <div class="modal-body text-center">

                        <div class="mb-2 text-muted">

                            PMS Number:

                            <strong>
                                <?= esc($r['pms_number'] ?? '') ?>
                            </strong>

                        </div>


                        <div class="receipt-image-wrapper">

                            <img
                                src="<?= site_url('pms/receipt/' . (int)$r['receipt']) ?>"
                                class="img-fluid rounded border"
                                style="
                                    max-height: 70vh;
                                    object-fit: contain;
                                "
                                alt="PMS Receipt"
                                loading="lazy"
                            >

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>

                    </div>

                </div>

            </div>

        </div>

    <?php endif; ?>

<?php endforeach; ?>


<?php endif; ?>



<!-- ==========================================================
     JAVASCRIPT
     ========================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================
       SELECT2 ACCOUNT
       ========================================================== */

    if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {

        $('#data_id').select2({
            placeholder: '-- Select Account --',
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0,
            dropdownParent: $('#addPmsModal')
        });

    }


    /* ==========================================================
       FLASH MESSAGES
       ========================================================== */

    function escapeFlashMessage(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;

    }


    function showFlashMessage(message, type = 'success') {

        document
            .querySelectorAll('.js-flash-message')
            .forEach(function (element) {
                element.remove();
            });


        let icon = 'check-circle';

        if (type === 'danger') {
            icon = 'exclamation-triangle';
        }
        else if (type === 'warning') {
            icon = 'exclamation-circle';
        }
        else if (type === 'info') {
            icon = 'info-circle';
        }


        const flash = document.createElement('div');

        flash.className =
            'alert alert-' +
            type +
            ' alert-dismissible fade show js-flash-message';

        flash.style.position = 'fixed';
        flash.style.top = '12px';
        flash.style.left = '50%';
        flash.style.transform = 'translateX(-50%)';
        flash.style.zIndex = '99999';
        flash.style.width = 'min(90vw, 520px)';
        flash.style.boxShadow = '0 4px 15px rgba(0,0,0,0.15)';
        flash.style.transition = 'opacity 0.5s ease';


        flash.innerHTML = `
            <i class="bi bi-${icon} me-2"></i>

            <strong>
                ${type === 'success' ? 'Success!' : 'Notice!'}
            </strong>

            <span class="ms-1">
                ${escapeFlashMessage(message)}
            </span>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>
        `;


        document.body.appendChild(flash);


        setTimeout(function () {

            if (!flash.parentNode) {
                return;
            }

            flash.style.opacity = '0';

            setTimeout(function () {

                if (flash.parentNode) {
                    flash.remove();
                }

            }, 500);

        }, 5000);

    }


    setTimeout(function () {

        document
            .querySelectorAll('.flash-message')
            .forEach(function (message) {

                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease';

                setTimeout(function () {
                    message.remove();
                }, 500);

            });

    }, 5000);


    /* ==========================================================
       ELEMENTS
       ========================================================== */

    const dataSelect =
        document.getElementById('data_id');

    const addressInput =
        document.getElementById('address');

    const machineRows =
        document.getElementById('machineRows');

    const addMachineBtn =
        document.getElementById('addMachineBtn');

    const pmsForm =
        document.getElementById('addPmsForm');

    const mfsForm =
        document.getElementById('mfsForm');

    const fsrForm =
        document.getElementById('fsrForm');


    /* ==========================================================
       STATE
       ========================================================== */

    let currentClinicMachines = {};

    let machineRowIndex = 0;

    let pendingMfs = false;

    let pendingFsr = false;

    let savedPmsData = null;

    let savedPmsRecords = [];


    /* ==========================================================
       TECHNICAL DONE OPTIONS
       ========================================================== */

    function getTechnicalOptions(machine) {

        const m =
            (machine || '')
                .toString()
                .toLowerCase()
                .trim();


        if (m.indexOf('hematology') !== -1) {

            return [
                'Light PMS',
                'Mid PMS',
                'Heavy PMS',
                'Troubleshooting',
                'Quality Control',
                'Installation',
                'Relocation'
            ];

        }


        if (m.indexOf('chemistry') !== -1) {

            return [
                'Manual Checking',
                'For Release',
                'New Accessed',
                'Cancelled Service'
            ];

        }


        if (m !== '') {

            return [
                'Manual Checking',
                'For Release',
                'New Accessed',
                'Cancelled Service'
            ];

        }


        return [];

    }


    /* ==========================================================
       CREATE MACHINE ROW
       ========================================================== */

    function createMachineRow() {

        const index = machineRowIndex++;


        const row = document.createElement('div');

        row.className =
            'machine-row border rounded p-3 mb-3 bg-white';

        row.dataset.index = index;


        row.innerHTML = `

            <div class="row g-3 align-items-end">

                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Machine Type
                    </label>

                    <select
                        name="machines[${index}][machine]"
                        class="form-select machine-select"
                        required>

                        <option value="">
                            -- Select Machine --
                        </option>

                    </select>

                </div>


                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Serial Number
                    </label>

                    <input
                        type="text"
                        name="machines[${index}][sn]"
                        class="form-control machine-sn"
                        readonly>

                </div>


                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Technical Done
                    </label>

                    <select
                        name="machines[${index}][technical_done]"
                        class="form-select technical-done"
                        required>

                        <option value="">
                            -- Select Technical Done --
                        </option>

                    </select>

                </div>


                <div class="col-md-1 text-end">

                    <button
                        type="button"
                        class="btn btn-outline-danger remove-machine"
                        title="Remove Machine">

                        <i class="bi bi-trash"></i>

                    </button>

                </div>

            </div>
        `;


        if (!machineRows) {
            return row;
        }


        machineRows.appendChild(row);


        const machineSelect =
            row.querySelector('.machine-select');

        const serialInput =
            row.querySelector('.machine-sn');

        const technicalSelect =
            row.querySelector('.technical-done');

        const removeButton =
            row.querySelector('.remove-machine');


        populateMachineSelect(machineSelect);


        machineSelect.addEventListener('change', function () {

            const machine = this.value;

            serialInput.value =
                currentClinicMachines[machine] || '';

            populateTechnicalDone(
                technicalSelect,
                machine
            );

        });


        removeButton.addEventListener('click', function () {

            row.remove();

            updateRemoveButtons();

        });


        updateRemoveButtons();


        return row;

    }


    /* ==========================================================
       POPULATE MACHINE SELECT
       ========================================================== */

    function populateMachineSelect(select) {

        if (!select) {
            return;
        }


        select.innerHTML = `
            <option value="">
                -- Select Machine --
            </option>
        `;


        Object.keys(currentClinicMachines).forEach(function (machine) {

            const option =
                document.createElement('option');

            option.value = machine;
            option.textContent = machine;

            select.appendChild(option);

        });


        select.disabled =
            Object.keys(currentClinicMachines).length === 0;

    }


    /* ==========================================================
       POPULATE TECHNICAL DONE
       ========================================================== */

    function populateTechnicalDone(select, machine) {

        if (!select) {
            return;
        }


        select.innerHTML = `
            <option value="">
                -- Select Technical Done --
            </option>
        `;


        getTechnicalOptions(machine).forEach(function (text) {

            const option =
                document.createElement('option');

            option.value = text;
            option.textContent = text;

            select.appendChild(option);

        });

    }


    /* ==========================================================
       UPDATE REMOVE BUTTONS
       ========================================================== */

    function updateRemoveButtons() {

        if (!machineRows) {
            return;
        }


        const rows =
            machineRows.querySelectorAll('.machine-row');


        rows.forEach(function (row) {

            const button =
                row.querySelector('.remove-machine');

            if (button) {
                button.disabled = rows.length === 1;
            }

        });

    }


    /* ==========================================================
       RESET MACHINE ROWS
       ========================================================== */

    function resetMachineRows() {

        if (!machineRows) {
            return;
        }


        machineRows.innerHTML = '';

        machineRowIndex = 0;

        createMachineRow();

    }


    /* ==========================================================
       LOAD SELECTED CLINIC
       ========================================================== */

    function loadSelectedClinic() {

        if (!dataSelect) {
            return;
        }


        const selected =
            dataSelect.options[dataSelect.selectedIndex];


        if (!selected || !selected.value) {

            if (addressInput) {
                addressInput.value = '';
            }

            currentClinicMachines = {};

            if (addMachineBtn) {
                addMachineBtn.disabled = true;
            }

            resetMachineRows();

            return;
        }


        const clinic =
            selected.getAttribute('data-clinic') || '';

        const address =
            selected.getAttribute('data-address') || '';

        const machinesJson =
            selected.getAttribute('data-machines') || '';


        console.log('Selected Clinic:', clinic);
        console.log('Selected Address:', address);
        console.log('Machine JSON:', machinesJson);


        if (addressInput) {
            addressInput.value = address;
        }


        try {

            currentClinicMachines =
                machinesJson
                    ? JSON.parse(machinesJson)
                    : {};

        }
        catch (error) {

            console.error(
                'Unable to read machine data:',
                error
            );

            currentClinicMachines = {};

        }


        console.log(
            'Clinic Machines:',
            currentClinicMachines
        );


        if (addMachineBtn) {

            addMachineBtn.disabled =
                Object.keys(currentClinicMachines).length === 0;

        }


        resetMachineRows();


        const firstRow =
            machineRows
                ? machineRows.querySelector('.machine-row')
                : null;


        if (!firstRow) {
            return;
        }


        const select =
            firstRow.querySelector('.machine-select');

        const serial =
            firstRow.querySelector('.machine-sn');

        const technical =
            firstRow.querySelector('.technical-done');


        const machines =
            Object.keys(currentClinicMachines);


        if (machines.length === 0) {
            return;
        }


        const firstMachine = machines[0];


        select.value = firstMachine;

        serial.value =
            currentClinicMachines[firstMachine] || '';


        populateTechnicalDone(
            technical,
            firstMachine
        );

    }


    /* ==========================================================
       ACCOUNT CHANGE
       ========================================================== */

    if (
        typeof $ !== 'undefined' &&
        typeof $.fn.select2 !== 'undefined'
    ) {

        $('#data_id').on(
            'change',
            loadSelectedClinic
        );

    }
    else if (dataSelect) {

        dataSelect.addEventListener(
            'change',
            loadSelectedClinic
        );

    }


    /* ==========================================================
       ADD MACHINE
       ========================================================== */

    if (addMachineBtn) {

        addMachineBtn.addEventListener(
            'click',
            function () {

                if (
                    Object.keys(currentClinicMachines).length === 0
                ) {
                    return;
                }

                createMachineRow();

            }
        );

    }


    /* ==========================================================
       INITIAL MACHINE ROW
       ========================================================== */

    resetMachineRows();


    /* ==========================================================
       GET PMS DATA
       ========================================================== */

    function getPmsDataFromForm() {

        const selectedAccount =
            dataSelect
                ? dataSelect.options[dataSelect.selectedIndex]
                : null;


        const engineerSelect =
            document.getElementById('service_eng_id');


        let serviceEngineer = '';


        if (
            engineerSelect &&
            engineerSelect.selectedIndex >= 0
        ) {

            serviceEngineer =
                engineerSelect.options[
                    engineerSelect.selectedIndex
                ].textContent.trim();

        }


        const rows =
            machineRows
                ? machineRows.querySelectorAll('.machine-row')
                : [];


        const machines = [];


        rows.forEach(function (row) {

            machines.push({

                machine:
                    row.querySelector('.machine-select')?.value || '',

                sn:
                    row.querySelector('.machine-sn')?.value || '',

                technical_done:
                    row.querySelector('.technical-done')?.value || ''

            });

        });


        const firstMachine =
            machines.length > 0
                ? machines[0]
                : {};


        return {

            pms_number:
                document.getElementById('pms_number')?.value || '',

            service_tech:
                serviceEngineer,

            clinic:
                selectedAccount
                    ? (
                        selectedAccount.getAttribute('data-clinic') || ''
                    )
                    : '',

            address:
                addressInput?.value || '',

            date:
                document.getElementById('pms_date')?.value || '',

            machine:
                firstMachine.machine || '',

            sn:
                firstMachine.sn || '',

            technical_done:
                firstMachine.technical_done || '',

            machines:
                machines

        };

    }


    /* ==========================================================
       SHOW MFS MODAL
       ========================================================== */

    function showMfsModal() {

        populateMfsFromPms(savedPmsData);


        const element =
            document.getElementById('mfsModal');


        if (!element) {

            console.error('MFS modal not found.');

            return;

        }


        bootstrap.Modal
            .getOrCreateInstance(element)
            .show();

    }


    /* ==========================================================
       SHOW FSR MODAL
       ========================================================== */

    function showFsrModal() {

        populateFsrFromPms(savedPmsData);


        const element =
            document.getElementById('fsrModal');


        if (!element) {

            console.error('FSR modal not found.');

            return;

        }


        bootstrap.Modal
            .getOrCreateInstance(element)
            .show();

    }


    /* ==========================================================
       POPULATE MFS FROM PMS
       ========================================================== */

    function populateMfsFromPms(pms) {

        if (!pms) {
            return;
        }


        const employee =
            document.getElementById('mfs_employee');

        const accounts =
            document.getElementById('mfs_accounts');

        const address =
            document.getElementById('mfs_address');

        const machine =
            document.getElementById('mfs_machine');

        const serial =
            document.getElementById('mfs_serial');

        const date =
            document.getElementById('mfs_date_status');


        if (employee) {
            employee.value = pms.service_tech || '';
        }

        if (accounts) {
            accounts.value = pms.clinic || '';
        }

        if (address) {
            address.value = pms.address || '';
        }

        if (machine) {
            machine.value = pms.machine || '';
        }

        if (serial) {
            serial.value = pms.sn || '';
        }

        if (date) {
            date.value = pms.date || '';
        }

    }


    /* ==========================================================
       POPULATE FSR FROM PMS
       ========================================================== */

    function populateFsrFromPms(pms) {

        if (!pms) {
            return;
        }


        const engineer =
            document.getElementById('fsr_service_engineer');

        const account =
            document.getElementById('fsr_account');

        const address =
            document.getElementById('fsr_address');

        const machine =
            document.getElementById('fsr_machine');

        const serial =
            document.getElementById('fsr_serial');


        if (engineer) {
            engineer.value = pms.service_tech || '';
        }

        if (account) {
            account.value = pms.clinic || '';
        }

        if (address) {
            address.value = pms.address || '';
        }

        if (machine) {
            machine.value = pms.machine || '';
        }

        if (serial) {
            serial.value = pms.sn || '';
        }

    }


    /* ==========================================================
       GET PMS ID
       ========================================================== */

    function getPmsId() {

        if (
            savedPmsData &&
            savedPmsData.id
        ) {

            return savedPmsData.id;

        }


        if (
            Array.isArray(savedPmsRecords) &&
            savedPmsRecords.length > 0
        ) {

            const first =
                savedPmsRecords[0];

            return (
                first.id ||
                first.pms_id ||
                ''
            );

        }


        return '';

    }


    /* ==========================================================
       UPDATE SAVED PMS MFS ID
       ========================================================== */

    function updateSavedPmsMfsId(mfsId) {

        if (!mfsId) {
            return;
        }


        if (!savedPmsData) {
            savedPmsData = {};
        }


        savedPmsData.mfs = mfsId;
        savedPmsData.mfs_id = mfsId;


        if (
            Array.isArray(savedPmsRecords) &&
            savedPmsRecords.length > 0
        ) {

            savedPmsRecords[0].mfs = mfsId;
            savedPmsRecords[0].mfs_id = mfsId;

        }


        console.log('Saved MFS ID:', mfsId);

    }


    /* ==========================================================
       UPDATE SAVED PMS FSR ID
       ========================================================== */

    function updateSavedPmsFsrId(fsrId) {

        if (!fsrId) {
            return;
        }


        if (!savedPmsData) {
            savedPmsData = {};
        }


        savedPmsData.fsr = fsrId;
        savedPmsData.fsr_id = fsrId;


        if (
            Array.isArray(savedPmsRecords) &&
            savedPmsRecords.length > 0
        ) {

            savedPmsRecords[0].fsr = fsrId;
            savedPmsRecords[0].fsr_id = fsrId;

        }


        console.log('Saved FSR ID:', fsrId);

    }


    /* ==========================================================
       PMS SUBMIT
       ========================================================== */

    if (pmsForm) {

        pmsForm.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                console.log(
                    'PMS SUBMIT HANDLER RUNNING'
                );


                if (!machineRows) {

                    showFlashMessage(
                        'Machine rows container was not found.',
                        'danger'
                    );

                    return;

                }


                const rows =
                    machineRows.querySelectorAll('.machine-row');


                if (rows.length === 0) {

                    alert(
                        'Please add at least one machine.'
                    );

                    return;

                }


                let valid = true;


                rows.forEach(function (row) {

                    const machine =
                        row.querySelector(
                            '.machine-select'
                        )?.value || '';


                    const technical =
                        row.querySelector(
                            '.technical-done'
                        )?.value || '';


                    if (!machine || !technical) {
                        valid = false;
                    }

                });


                if (!valid) {

                    alert(
                        'Please select a Machine and Technical Done for every machine.'
                    );

                    return;

                }


                pendingMfs =
                    document.getElementById(
                        'mfs_check'
                    )?.checked || false;


                pendingFsr =
                    document.getElementById(
                        'fsr_check'
                    )?.checked || false;


                savedPmsData =
                    getPmsDataFromForm();


                savedPmsRecords = [];


                const saveButton =
                    document.getElementById(
                        'savePmsButton'
                    );


                if (saveButton) {

                    saveButton.disabled = true;

                    saveButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

                }


                const formData =
                    new FormData(pmsForm);


                if (pendingMfs) {
                    formData.set('mfs', '1');
                }
                else {
                    formData.delete('mfs');
                }


                if (pendingFsr) {
                    formData.set('fsr', '1');
                }
                else {
                    formData.delete('fsr');
                }


                fetch(
                    pmsForm.action,
                    {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }
                )

                .then(async function (response) {

                    const text =
                        await response.text();


                    console.log(
                        'PMS response:',
                        text
                    );


                    if (!response.ok) {

                        throw new Error(
                            'HTTP ' +
                            response.status +
                            ': ' +
                            text.substring(0, 500)
                        );

                    }


                    try {

                        return JSON.parse(text);

                    }
                    catch (error) {

                        throw new Error(
                            'PMS server did not return valid JSON.'
                        );

                    }

                })

                .then(function (data) {

                    console.log(
                        'PMS save response:',
                        data
                    );


                    if (!data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to save PMS record.'
                        );

                    }


                    if (Array.isArray(data.records)) {

                        savedPmsRecords =
                            data.records;

                    }
                    else if (
                        Array.isArray(data.pms_records)
                    ) {

                        savedPmsRecords =
                            data.pms_records;

                    }


                    if (data.pms) {

                        savedPmsData =
                            Object.assign(
                                {},
                                savedPmsData,
                                data.pms
                            );

                    }


                    if (
                        data.id &&
                        !savedPmsData.id
                    ) {

                        savedPmsData.id =
                            data.id;

                    }


                    console.log(
                        'Final PMS data:',
                        savedPmsData
                    );


                    showFlashMessage(
                        data.message ||
                        'PMS saved successfully.',
                        'success'
                    );


                    const modalElement =
                        document.getElementById(
                            'addPmsModal'
                        );


                    const modalInstance =
                        modalElement
                            ? bootstrap.Modal.getInstance(
                                modalElement
                            )
                            : null;


                    if (modalInstance) {
                        modalInstance.hide();
                    }


                    setTimeout(function () {

                        if (pendingMfs) {

                            showMfsModal();

                        }
                        else if (pendingFsr) {

                            showFsrModal();

                        }
                        else {

                            setTimeout(function () {
                                location.reload();
                            }, 1500);

                        }

                    }, 500);

                })

                .catch(function (error) {

                    console.error(
                        'PMS save error:',
                        error
                    );


                    showFlashMessage(
                        error.message ||
                        'An error occurred while saving PMS.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save PMS';

                    }

                });

            }
        );

    }


    /* ==========================================================
       MFS SUBMIT
       ========================================================== */

    if (mfsForm) {

        mfsForm.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                console.log(
                    'MFS SUBMIT HANDLER RUNNING'
                );


                const saveButton =
                    document.getElementById(
                        'saveMfsButton'
                    );


                if (saveButton) {

                    saveButton.disabled = true;

                    saveButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

                }


                const formData =
                    new FormData(mfsForm);


                const pmsId =
                    getPmsId();


                if (!pmsId) {

                    showFlashMessage(
                        'PMS ID was not found. MFS cannot be linked to PMS.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save MFS';

                    }


                    return;

                }


                /*
                 * Send PMS ID.
                 *
                 * Controller:
                 *
                 * INSERT tb_mfs
                 * GET tb_mfs.id
                 * UPDATE tb_pms.mfs = tb_mfs.id
                 */

                formData.set(
                    'pms_id',
                    pmsId
                );


                console.log(
                    'MFS PMS ID:',
                    pmsId
                );


                fetch(
                    mfsForm.action,
                    {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }
                )

                .then(async function (response) {

                    const text =
                        await response.text();


                    console.log(
                        'MFS response:',
                        text
                    );


                    if (!response.ok) {

                        throw new Error(
                            'HTTP ' +
                            response.status +
                            ': ' +
                            text.substring(0, 500)
                        );

                    }


                    try {

                        return JSON.parse(text);

                    }
                    catch (error) {

                        throw new Error(
                            'MFS server did not return valid JSON.'
                        );

                    }

                })

                .then(function (data) {

                    console.log(
                        'MFS save response:',
                        data
                    );


                    if (!data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to save MFS.'
                        );

                    }


                    /*
                     * IMPORTANT:
                     *
                     * This must be tb_mfs.id.
                     */

                    const mfsId =
                        data.mfs_id ||
                        data.id ||
                        data.mfs?.id ||
                        '';


                    if (mfsId) {

                        updateSavedPmsMfsId(
                            mfsId
                        );

                    }


                    console.log(
                        'MFS ID returned:',
                        mfsId
                    );


                    showFlashMessage(
                        data.message ||
                        'MFS saved successfully.',
                        'success'
                    );


                    const modalElement =
                        document.getElementById(
                            'mfsModal'
                        );


                    const modal =
                        modalElement
                            ? bootstrap.Modal.getInstance(
                                modalElement
                            )
                            : null;


                    if (modal) {
                        modal.hide();
                    }


                    setTimeout(function () {

                        if (pendingFsr) {

                            showFsrModal();

                        }
                        else {

                            setTimeout(function () {
                                location.reload();
                            }, 1500);

                        }

                    }, 500);

                })

                .catch(function (error) {

                    console.error(
                        'MFS save error:',
                        error
                    );


                    showFlashMessage(
                        error.message ||
                        'An error occurred while saving MFS.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save MFS';

                    }

                });

            }
        );

    }


    /* ==========================================================
       FSR SUBMIT
       ========================================================== */

    if (fsrForm) {

        fsrForm.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                console.log(
                    'FSR SUBMIT HANDLER RUNNING'
                );


                const saveButton =
                    document.getElementById(
                        'saveFsrButton'
                    );


                if (saveButton) {

                    saveButton.disabled = true;

                    saveButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

                }


                const formData =
                    new FormData(fsrForm);


                const pmsId =
                    getPmsId();


                if (!pmsId) {

                    showFlashMessage(
                        'PMS ID was not found. FSR cannot be linked to PMS.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save FSR';

                    }


                    return;

                }


                /*
                 * Send PMS ID.
                 *
                 * Controller:
                 *
                 * INSERT tb_fsr
                 * GET tb_fsr.id
                 * UPDATE tb_pms.fsr = tb_fsr.id
                 */

                formData.set(
                    'pms_id',
                    pmsId
                );


                console.log(
                    'FSR PMS ID:',
                    pmsId
                );


                fetch(
                    fsrForm.action,
                    {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }
                )

                .then(async function (response) {

                    const text =
                        await response.text();


                    console.log(
                        'FSR response:',
                        text
                    );


                    if (!response.ok) {

                        throw new Error(
                            'HTTP ' +
                            response.status +
                            ': ' +
                            text.substring(0, 500)
                        );

                    }


                    try {

                        return JSON.parse(text);

                    }
                    catch (error) {

                        throw new Error(
                            'FSR server did not return valid JSON.'
                        );

                    }

                })

                .then(function (data) {

                    console.log(
                        'FSR save response:',
                        data
                    );


                    if (!data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to save FSR.'
                        );

                    }


                    /*
                     * IMPORTANT:
                     *
                     * This must be tb_fsr.id.
                     */

                    const fsrId =
                        data.fsr_id ||
                        data.id ||
                        data.fsr?.id ||
                        '';


                    if (fsrId) {

                        updateSavedPmsFsrId(
                            fsrId
                        );

                    }


                    console.log(
                        'FSR ID returned:',
                        fsrId
                    );


                    showFlashMessage(
                        data.message ||
                        'FSR saved successfully.',
                        'success'
                    );


                    const modalElement =
                        document.getElementById(
                            'fsrModal'
                        );


                    const modal =
                        modalElement
                            ? bootstrap.Modal.getInstance(
                                modalElement
                            )
                            : null;


                    if (modal) {
                        modal.hide();
                    }


                    setTimeout(function () {

                        location.reload();

                    }, 1200);

                })

                .catch(function (error) {

                    console.error(
                        'FSR save error:',
                        error
                    );


                    showFlashMessage(
                        error.message ||
                        'An error occurred while saving FSR.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save FSR';

                    }

                });

            }
        );

    }


    /* ==========================================================
       RESET BUTTONS WHEN MODALS CLOSE
       ========================================================== */

    [
        {
            modal: 'addPmsModal',
            button: 'savePmsButton',
            html: '<i class="bi bi-save"></i> Save PMS'
        },
        {
            modal: 'mfsModal',
            button: 'saveMfsButton',
            html: '<i class="bi bi-save"></i> Save MFS'
        },
        {
            modal: 'fsrModal',
            button: 'saveFsrButton',
            html: '<i class="bi bi-save"></i> Save FSR'
        }
    ].forEach(function (item) {

        const modal =
            document.getElementById(item.modal);


        if (!modal) {
            return;
        }


        modal.addEventListener(
            'hidden.bs.modal',
            function () {

                const button =
                    document.getElementById(
                        item.button
                    );


                if (button) {

                    button.disabled = false;

                    button.innerHTML =
                        item.html;

                }

            }
        );

    });


    /* ==========================================================
       ESCAPE HTML
       ========================================================== */

    function escapeHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {
            return '';
        }


        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    /* ==========================================================
       DISPLAY VALUE
       ========================================================== */

    function displayValue(value) {

        if (
            value === null ||
            value === undefined ||
            value === ''
        ) {

            return '<span class="text-muted">N/A</span>';

        }


        return escapeHtml(value);

    }


    /* ==========================================================
       LOAD MFS RECORD
       ========================================================== */

/* ==========================================================
   LOAD MFS RECORD
   ========================================================== */

document.addEventListener(
    'click',
    function (event) {

        const button =
            event.target.closest('.view-mfs-btn');

        if (!button) {
            return;
        }

        const mfsId =
            button.getAttribute('data-mfs-id');

        const content =
            document.getElementById('mfsViewContent');

        console.log('MFS BUTTON CLICKED');
        console.log('MFS ID:', mfsId);

        if (!content) {
            console.error('mfsViewContent not found.');
            return;
        }

        if (!mfsId || mfsId === '0') {

            content.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    MFS ID is missing.
                </div>
            `;

            return;
        }

        content.innerHTML = `
            <div class="text-center py-5">

                <div
                    class="spinner-border text-primary"
                    role="status">
                </div>

                <div class="mt-3">
                    Loading MFS record...
                </div>

            </div>
        `;

        const url =
            `<?= site_url('pms/view-mfs/') ?>${encodeURIComponent(mfsId)}`;

        console.log('MFS REQUEST URL:', url);

        fetch(
            url,
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        )

        .then(async function (response) {

            const text =
                await response.text();

            console.log(
                'MFS HTTP STATUS:',
                response.status
            );

            console.log(
                'MFS SERVER RESPONSE:',
                text
            );

            if (!response.ok) {

                throw new Error(
                    'HTTP ' +
                    response.status +
                    ': ' +
                    text.substring(0, 500)
                );

            }

            try {

                return JSON.parse(text);

            }
            catch (error) {

                throw new Error(
                    'Server did not return valid JSON.'
                );

            }

        })

        .then(function (result) {

            console.log('MFS RESULT:', result);

            if (
                !result ||
                !result.success
            ) {

                throw new Error(
                    result?.message ||
                    'MFS record not found.'
                );

            }

            const mfs =
                result.data || {};


            /* ==================================================
               RECEIPT
               ================================================== */

            let receiptHtml = '';


            if (
                mfs.receipt &&
                Number(mfs.receipt) > 0
            ) {

                const receiptUrl =
                    `<?= site_url('pms/receipt/') ?>${encodeURIComponent(mfs.receipt)}`;


                receiptHtml = `

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header bg-success text-white">

                            <h5 class="mb-0">
                                <i class="bi bi-receipt me-2"></i>
                                Receipt
                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="text-center">

                                <div class="mb-3">

                                    <span class="badge bg-success">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Receipt Attached

                                    </span>

                                </div>


                                <div
                                    class="border rounded p-3 bg-light">

                                    <img
                                        src="${receiptUrl}"
                                        class="img-fluid rounded shadow-sm"
                                        style="
                                            max-height: 650px;
                                            max-width: 100%;
                                            object-fit: contain;
                                        "
                                        alt="MFS Receipt"
                                        onerror="
                                            this.style.display='none';
                                            this.nextElementSibling.style.display='block';
                                        "
                                    >


                                    <div
                                        style="display:none;"
                                        class="alert alert-danger mb-0">

                                        <i class="bi bi-exclamation-triangle me-2"></i>

                                        Unable to display the receipt image.

                                    </div>

                                </div>


                                <div class="mt-3">

                                    <a
                                        href="${receiptUrl}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-box-arrow-up-right me-1"></i>

                                        Open Receipt

                                    </a>

                                </div>


                                ${
                                    mfs.receipt_date
                                    ? `
                                        <div class="text-muted small mt-2">

                                            Uploaded:
                                            ${displayValue(mfs.receipt_date)}

                                        </div>
                                      `
                                    : ''
                                }

                            </div>

                        </div>

                    </div>

                `;

            }
            else {

                receiptHtml = `

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header">

                            <h5 class="mb-0">
                                <i class="bi bi-receipt me-2"></i>
                                Receipt
                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="alert alert-secondary mb-0">

                                <i class="bi bi-info-circle me-2"></i>

                                No receipt attached to this MFS record.

                            </div>

                        </div>

                    </div>

                `;

            }


            /* ==================================================
               MFS INFORMATION
               ================================================== */

            content.innerHTML = `

                <div class="container-fluid">


                    <!-- MFS INFORMATION -->

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header bg-primary text-white">

                            <h5 class="mb-0">

                                <i class="bi bi-file-earmark-text me-2"></i>

                                MFS Information

                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        MFS Number
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.mfs_number)}
                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Employee
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.employee)}
                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Account
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.accounts)}
                                    </div>

                                </div>


                                <div class="col-md-3">

                                    <label class="form-label fw-bold">
                                        Date Fill-up
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.date_fillup)}
                                    </div>

                                </div>


                                <div class="col-md-3">

                                    <label class="form-label fw-bold">
                                        Date Status
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.date_status)}
                                    </div>

                                </div>


                                <div class="col-12">

                                    <label class="form-label fw-bold">
                                        Address
                                    </label>

                                    <div
                                        class="form-control bg-light"
                                        style="min-height:60px;">

                                        ${displayValue(mfs.address)}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- MACHINE INFORMATION -->

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header bg-secondary text-white">

                            <h5 class="mb-0">

                                <i class="bi bi-cpu me-2"></i>

                                Machine Information

                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="row g-3">


                                <div class="col-md-4">

                                    <label class="form-label fw-bold">
                                        Unit
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.unit)}
                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label fw-bold">
                                        Machine
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.machine)}
                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label fw-bold">
                                        Serial Number
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.serial_number)}
                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                    <!-- CONSUMABLES -->

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header">

                            <h5 class="mb-0">

                                <i class="bi bi-box-seam me-2"></i>

                                Consumables

                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="row g-3">


                                <div class="col-md-4">

                                    <label class="form-label fw-bold">
                                        Consumable Unit
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.consumable_unit)}
                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label fw-bold">
                                        Consumables
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.consumables)}
                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label fw-bold">
                                        Lot Number
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.lot_number)}
                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                    <!-- DETAILS -->

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header">

                            <h5 class="mb-0">

                                <i class="bi bi-card-text me-2"></i>

                                Details

                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="row g-3">


                                <div class="col-12">

                                    <label class="form-label fw-bold">
                                        Reason
                                    </label>

                                    <div
                                        class="form-control bg-light"
                                        style="min-height:80px; white-space:pre-wrap;">

                                        ${displayValue(mfs.reason)}

                                    </div>

                                </div>


                                <div class="col-12">

                                    <label class="form-label fw-bold">
                                        Remarks
                                    </label>

                                    <div
                                        class="form-control bg-light"
                                        style="min-height:80px; white-space:pre-wrap;">

                                        ${displayValue(mfs.remarks)}

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Personnel
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(mfs.personnel)}
                                    </div>

                                </div>


                                <div class="col-md-3">

                                    <label class="form-label fw-bold">
                                        Acknowledged
                                    </label>

                                    <div class="form-control bg-light">

                                        ${
                                            Number(mfs.acknowledged) === 1

                                            ? `
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Yes
                                                </span>
                                              `

                                            : `
                                                <span class="badge bg-secondary">
                                                    No
                                                </span>
                                              `
                                        }

                                    </div>

                                </div>


                                <div class="col-md-3">

                                    <label class="form-label fw-bold">
                                        Returned
                                    </label>

                                    <div class="form-control bg-light">

                                        ${
                                            Number(mfs.returned) === 1

                                            ? `
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Yes
                                                </span>
                                              `

                                            : `
                                                <span class="badge bg-secondary">
                                                    No
                                                </span>
                                              `
                                        }

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                    <!-- RECEIPT -->

                    ${receiptHtml}


                </div>

            `;

        })

        .catch(function (error) {

            console.error(
                'MFS LOAD ERROR:',
                error
            );

            content.innerHTML = `

                <div class="alert alert-danger">

                    <h5>

                        <i class="bi bi-exclamation-triangle me-2"></i>

                        Unable to Load MFS

                    </h5>

                    <hr>

                    <div>
                        ${escapeHtml(error.message)}
                    </div>

                </div>

            `;

        });

    }
);


 /* ==========================================================
   LOAD FSR RECORD
   ========================================================== */

document.addEventListener(
    'click',
    function (event) {

        const button =
            event.target.closest('.view-fsr-btn');

        if (!button) {
            return;
        }

        const fsrId =
            button.getAttribute('data-fsr-id');

        const content =
            document.getElementById('fsrViewContent');

        console.log('FSR BUTTON CLICKED');
        console.log('FSR ID:', fsrId);

        if (!content) {
            console.error('fsrViewContent not found.');
            return;
        }

        if (!fsrId || fsrId === '0') {

            content.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    FSR ID is missing.
                </div>
            `;

            return;
        }

        content.innerHTML = `
            <div class="text-center py-5">

                <div
                    class="spinner-border text-primary"
                    role="status">
                </div>

                <div class="mt-3">
                    Loading FSR record...
                </div>

            </div>
        `;

        const url =
            `<?= site_url('pms/view-fsr/') ?>${encodeURIComponent(fsrId)}`;

        console.log('FSR REQUEST URL:', url);

        fetch(
            url,
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        )

        .then(async function (response) {

            const text =
                await response.text();

            console.log(
                'FSR HTTP STATUS:',
                response.status
            );

            console.log(
                'FSR SERVER RESPONSE:',
                text
            );

            if (!response.ok) {

                throw new Error(
                    'HTTP ' +
                    response.status +
                    ': ' +
                    text.substring(0, 500)
                );

            }

            try {

                return JSON.parse(text);

            }
            catch (error) {

                throw new Error(
                    'Server did not return valid JSON.'
                );

            }

        })

        .then(function (result) {

            console.log('FSR RESULT:', result);

            if (
                !result ||
                !result.success
            ) {

                throw new Error(
                    result?.message ||
                    'FSR record not found.'
                );

            }

            const fsr =
                result.data || {};


            /* ==================================================
               RECEIPT
               ================================================== */

            let receiptHtml = '';


            if (
                fsr.receipt &&
                Number(fsr.receipt) > 0
            ) {

                const receiptUrl =
                    `<?= site_url('pms/receipt/') ?>${encodeURIComponent(fsr.receipt)}`;


                receiptHtml = `

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header bg-success text-white">

                            <h5 class="mb-0">

                                <i class="bi bi-receipt me-2"></i>

                                Receipt

                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="text-center">

                                <div class="mb-3">

                                    <span class="badge bg-success">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Receipt Attached

                                    </span>

                                </div>


                                <div
                                    class="border rounded p-3 bg-light">

                                    <img
                                        src="${receiptUrl}"
                                        class="img-fluid rounded shadow-sm"
                                        style="
                                            max-height: 650px;
                                            max-width: 100%;
                                            object-fit: contain;
                                        "
                                        alt="FSR Receipt"
                                        onerror="
                                            this.style.display='none';
                                            this.nextElementSibling.style.display='block';
                                        "
                                    >


                                    <div
                                        style="display:none;"
                                        class="alert alert-danger mb-0">

                                        <i class="bi bi-exclamation-triangle me-2"></i>

                                        Unable to display the receipt image.

                                    </div>

                                </div>


                                <div class="mt-3">

                                    <a
                                        href="${receiptUrl}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-box-arrow-up-right me-1"></i>

                                        Open Receipt

                                    </a>

                                </div>


                                ${
                                    fsr.receipt_date
                                    ? `
                                        <div class="text-muted small mt-2">

                                            Uploaded:
                                            ${displayValue(fsr.receipt_date)}

                                        </div>
                                      `
                                    : ''
                                }

                            </div>

                        </div>

                    </div>

                `;

            }
            else {

                receiptHtml = `

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header">

                            <h5 class="mb-0">

                                <i class="bi bi-receipt me-2"></i>

                                Receipt

                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="alert alert-secondary mb-0">

                                <i class="bi bi-info-circle me-2"></i>

                                No receipt attached to this FSR record.

                            </div>

                        </div>

                    </div>

                `;

            }


            /* ==================================================
               FSR INFORMATION
               ================================================== */

            content.innerHTML = `

                <div class="container-fluid">


                    <!-- FSR INFORMATION -->

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header bg-primary text-white">

                            <h5 class="mb-0">

                                <i class="bi bi-file-earmark-text me-2"></i>

                                FSR Information

                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="row g-3">


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        FSR Number
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(fsr.fsr_number)}
                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Service Engineer
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(fsr.service_engineer)}
                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Account
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(fsr.account)}
                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Date
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(fsr.date)}
                                    </div>

                                </div>


                                <div class="col-12">

                                    <label class="form-label fw-bold">
                                        Address
                                    </label>

                                    <div
                                        class="form-control bg-light"
                                        style="min-height:60px;">

                                        ${displayValue(fsr.address)}

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                    <!-- MACHINE INFORMATION -->

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header bg-secondary text-white">

                            <h5 class="mb-0">

                                <i class="bi bi-cpu me-2"></i>

                                Machine Information

                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="row g-3">


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Machine
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(fsr.machine)}
                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Serial Number
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(fsr.serial_number)}
                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                    <!-- SERVICE DETAILS -->

                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header">

                            <h5 class="mb-0">

                                <i class="bi bi-tools me-2"></i>

                                Service Details

                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="row g-3">


                                <div class="col-12">

                                    <label class="form-label fw-bold">
                                        Technical Concern
                                    </label>

                                    <div
                                        class="form-control bg-light"
                                        style="
                                            min-height:120px;
                                            white-space:pre-wrap;
                                        ">

                                        ${displayValue(fsr.technical_concern)}

                                    </div>

                                </div>


                                <div class="col-12">

                                    <label class="form-label fw-bold">
                                        Action Made
                                    </label>

                                    <div
                                        class="form-control bg-light"
                                        style="
                                            min-height:120px;
                                            white-space:pre-wrap;
                                        ">

                                        ${displayValue(fsr.action_made)}

                                    </div>

                                </div>


                                <div class="col-12">

                                    <label class="form-label fw-bold">
                                        Remarks
                                    </label>

                                    <div
                                        class="form-control bg-light"
                                        style="
                                            min-height:80px;
                                            white-space:pre-wrap;
                                        ">

                                        ${displayValue(fsr.remarks)}

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Acknowledge
                                    </label>

                                    <div class="form-control bg-light">
                                        ${displayValue(fsr.acknowledge)}
                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                    <!-- RECEIPT -->

                    ${receiptHtml}


                </div>

            `;

        })

        .catch(function (error) {

            console.error(
                'FSR LOAD ERROR:',
                error
            );

            content.innerHTML = `

                <div class="alert alert-danger">

                    <h5>

                        <i class="bi bi-exclamation-triangle me-2"></i>

                        Unable to Load FSR

                    </h5>

                    <hr>

                    <div>
                        ${escapeHtml(error.message)}
                    </div>

                </div>

            `;

        });

    }
);

});


/* ==============================================================
   DATATABLE
   ============================================================== */

$(document).ready(function () {

    if (
        typeof $ !== 'undefined' &&
        typeof $.fn.DataTable !== 'undefined' &&
        $('#pmsTable').length
    ) {

        $('#pmsTable').DataTable({

            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],

            order: [
                [0, 'asc']
            ],

            responsive: true,

            autoWidth: false

        });

    }

});

</script>



</body>
</html>
