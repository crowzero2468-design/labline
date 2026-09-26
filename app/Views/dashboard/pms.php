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

<div class="d-flex align-items-center gap-2 flex-nowrap">

    <!-- IMPORT PMS EXCEL -->
    <form 
        method="post" 
        action="<?= site_url('pms/import') ?>" 
        enctype="multipart/form-data" 
        class="d-flex align-items-center gap-2 mb-0">

        <?= csrf_field() ?>

        <input 
            type="file" 
            name="excel_file" 
            accept=".xlsx,.csv" 
            class="form-control form-control-sm"
            style="width: 220px;"
            required>

        <button 
            type="submit" 
            class="btn btn-success btn-sm text-nowrap">
            <i class="fas fa-file-import me-1"></i>
            Import PMS Excel
        </button>

        <a 
            href="<?= base_url('templates/pms_import_template.xlsx') ?>" 
            class="btn btn-success btn-sm text-nowrap"
            download>
            <i class="fas fa-download me-1"></i>
            Download Excel Template Here
        </a>

    </form>


    <!-- EXPORT ALL -->
    <a
        href="<?= site_url('pms/export') ?>"
        class="btn btn-outline-success btn-sm text-nowrap">
        <i class="bi bi-file-earmark-excel"></i>
        Export Excel (All)
    </a>


    <!-- EXPORT FILTERED TECH -->
    <?php if (!empty($selected_tech)): ?>

        <a
            href="<?= site_url('pms/export') . '?tech=' . urlencode($selected_tech) ?>"
            class="btn btn-success btn-sm text-nowrap">
            <i class="bi bi-file-earmark-excel"></i>
            Export <?= esc($selected_tech) ?>
        </a>

    <?php endif; ?>


    <!-- ADD PMS -->
    <button
        type="button"
        class="btn btn-primary btn-sm text-nowrap"
        data-bs-toggle="modal"
        data-bs-target="#addPmsModal">
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
                                <th>Action</th>

                            </tr>

                        </thead>


                    <tbody>

<?php

/*
|--------------------------------------------------------------------------
| GROUP PMS RECORDS
|--------------------------------------------------------------------------
| Records are grouped ONLY when:
|
|   1. PMS Number is the same
|   2. Date is the same
|
| Example:
|
| PMS-001 + 2026-09-23 = Group 1
| PMS-001 + 2026-09-24 = Group 2
| PMS-002 + 2026-09-23 = Group 3
|
|--------------------------------------------------------------------------
*/

$pmsGroups = [];

if (!empty($pms_records)) {

    foreach ($pms_records as $r) {

        $pmsNumber = trim($r['pms_number'] ?? '');
        $pmsDate   = trim($r['date'] ?? '');

        /*
         * Create a unique grouping key
         */
        $groupKey = $pmsNumber . '||' . $pmsDate;

        if (!isset($pmsGroups[$groupKey])) {

            $pmsGroups[$groupKey] = [];

        }

        $pmsGroups[$groupKey][] = $r;
    }
}

?>


<?php if (!empty($pmsGroups)): ?>

    <?php foreach ($pmsGroups as $groupKey => $groupRecords): ?>

        <?php

        /*
        |--------------------------------------------------------------------------
        | FIRST RECORD
        |--------------------------------------------------------------------------
        | Used for the main/parent row.
        |--------------------------------------------------------------------------
        */

        $main = $groupRecords[0];

        $groupCount = count($groupRecords);

        ?>

        <!-- ============================================================
             MAIN PMS ROW
             ============================================================ -->

        <tr
            class="pms-parent-row"
            data-group="<?= esc(md5($groupKey)) ?>"
        >

            <!-- PMS NUMBER -->

            <td class="text-nowrap">

               <?php if ($groupCount > 1): ?>

                        <?php $groupId = md5($groupKey); ?>

                        <button
                            type="button"
                            class="btn btn-link btn-sm p-0 fw-bold text-decoration-none pms-expand-btn"
                            data-group="<?= esc($groupId) ?>"
                            aria-expanded="false"
                            title="Show PMS records"
                        >

                            <i class="bi bi-chevron-right me-1"></i>

                            <?= esc($main['pms_number'] ?? '') ?>

                            <span class="badge bg-primary ms-1">
                                <?= $groupCount ?>
                            </span>

                        </button>

                    <?php else: ?>
                    <span class="fw-bold">

                        <?= esc($main['pms_number'] ?? '') ?>

                    </span>

                <?php endif; ?>

            </td>


            <!-- SERVICE ENGINEER -->

            <td>

                <?= esc($main['service_tech'] ?? '') ?>

                <?php if ($groupCount > 1): ?>

                    <span class="badge bg-light text-dark border ms-1">
                        <?= $groupCount ?> records
                    </span>

                <?php endif; ?>

            </td>


            <!-- ACCOUNT -->

            <td>

                <?= esc($main['clinic'] ?? '') ?>

            </td>


            <!-- ADDRESS -->

            <td>

                <?= esc($main['address'] ?? '') ?>

            </td>


            <!-- DATE -->

            <td class="text-nowrap">

                <?= esc($main['date'] ?? '') ?>

            </td>


            <!-- MACHINE TYPE -->

            <td>

                <?= esc($main['machine'] ?? '') ?>

            </td>


            <!-- SERIAL NUMBER -->

            <td>

                <?= esc($main['sn'] ?? '') ?>

            </td>


            <!-- TECHNICAL DONE -->

            <td>

                <?= esc($main['status'] ?? '') ?>

            </td>


            <!-- MFS -->

            <td class="text-center">

                <?php if (!empty($main['mfs']) && (int)$main['mfs'] > 0): ?>

                    <button
                        type="button"
                        class="btn btn-sm btn-success view-mfs-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#mfsViewModal"
                        data-mfs-id="<?= (int)$main['mfs'] ?>"
                    >

                        <i class="bi bi-check-circle me-1"></i>

                        MSF

                    </button>

                <?php else: ?>

                    <button
                        type="button"
                        class="btn btn-sm btn-secondary connect-pms-document-btn"
                        data-id="<?= (int)$main['id'] ?>"
                        data-document="mfs"
                        title="Connect an MFS record"
                    >
                        No MFS
                    </button>

                <?php endif; ?>

            </td>


            <!-- FSR -->

            <td class="text-center">

                <?php if (!empty($main['fsr']) && (int)$main['fsr'] > 0): ?>

                    <button
                        type="button"
                        class="btn btn-sm btn-success view-fsr-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#fsrViewModal"
                        data-fsr-id="<?= (int)$main['fsr'] ?>"
                    >

                        <i class="bi bi-check-circle me-1"></i>

                        FSR

                    </button>

                <?php else: ?>

                    <button
                        type="button"
                        class="btn btn-sm btn-secondary connect-pms-document-btn"
                        data-id="<?= (int)$main['id'] ?>"
                        data-document="fsr"
                        title="Connect an FSR record"
                    >
                        No FSR
                    </button>

                <?php endif; ?>

            </td>


            <!-- RECEIPT -->

            <td class="text-center">

                <?php if (!empty($main['receipt'])): ?>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#receiptModal<?= (int)$main['id'] ?>"
                    >

                        <i class="bi bi-eye me-1"></i>

                        View

                    </button>

                <?php else: ?>

                    <form method="post" action="<?= site_url('pms/receipt/upload/' . (int)$main['id']) ?>" enctype="multipart/form-data" class="d-inline-flex align-items-center gap-1">
                        <?= csrf_field() ?>
                        <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.webp,.pdf" class="form-control form-control-sm" style="max-width: 150px" required>
                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Upload receipt">
                            <i class="bi bi-upload"></i>
                        </button>
                    </form>

                <?php endif; ?>

            </td>


            <!-- ACTION -->

            <td class="text-center text-nowrap">

                <button
                    type="button"
                    class="btn btn-outline-success btn-sm edit-pms-btn"
                    data-id="<?= (int)$main['id'] ?>"
                    title="Edit PMS"
                >

                    Edit PMS

                </button>


                <button
                    type="button"
                    class="btn btn-outline-danger btn-sm delete-pms-btn"
                    data-id="<?= (int)$main['id'] ?>"
                    data-pms="<?= esc($main['pms_number'] ?? '') ?>"
                    title="Delete PMS"
                >

                    Delete

                </button>

            </td>

        </tr>


        <!-- ============================================================
             HIDDEN CHILD DATA
             ============================================================ -->

        <?php if ($groupCount > 1): ?>

            <tr
                class="pms-child-data d-none"
                data-parent-group="<?= esc(md5($groupKey)) ?>"
            >

                <td colspan="12">

                    <div class="p-3 bg-light border rounded">

                        <div class="fw-bold mb-3">

                            <i class="bi bi-list-ul me-1"></i>

                            PMS <?= esc($main['pms_number'] ?? '') ?>

                            <span class="text-muted">
                                — <?= esc($main['date'] ?? '') ?>
                            </span>

                        </div>


                        <div class="table-responsive">

                            <table class="table table-sm table-bordered table-hover mb-0 bg-white">

                                <thead class="table-secondary">

                                    <tr>

                                        <th>#</th>

                                        <th>Service Engr</th>

                                        <th>Account</th>

                                        <th>Address</th>

                                        <th>Machine Type</th>

                                        <th>Serial Number</th>

                                        <th>Technical Done</th>

                                        <th>MSF</th>

                                        <th>FSR</th>

                                        <th>Receipt</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>


                                <tbody>

                                <?php foreach ($groupRecords as $index => $r): ?>

                                    <tr>

                                        <!-- NUMBER -->

                                        <td>

                                            <?= $index + 1 ?>

                                        </td>


                                        <!-- SERVICE ENGINEER -->

                                        <td>

                                            <?= esc($r['service_tech'] ?? '') ?>

                                        </td>


                                        <!-- ACCOUNT -->

                                        <td>

                                            <?= esc($r['clinic'] ?? '') ?>

                                        </td>


                                        <!-- ADDRESS -->

                                        <td>

                                            <?= esc($r['address'] ?? '') ?>

                                        </td>


                                        <!-- MACHINE -->

                                        <td>

                                            <?= esc($r['machine'] ?? '') ?>

                                        </td>


                                        <!-- SERIAL NUMBER -->

                                        <td>

                                            <?= esc($r['sn'] ?? '') ?>

                                        </td>


                                        <!-- TECHNICAL DONE -->

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

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-secondary connect-pms-document-btn"
                                                    data-id="<?= (int)$r['id'] ?>"
                                                    data-document="mfs"
                                                    title="Connect an MFS record"
                                                >
                                                    No MFS
                                                </button>

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

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-secondary connect-pms-document-btn"
                                                    data-id="<?= (int)$r['id'] ?>"
                                                    data-document="fsr"
                                                    title="Connect an FSR record"
                                                >
                                                    No FSR
                                                </button>

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

                                                <form method="post" action="<?= site_url('pms/receipt/upload/' . (int)$r['id']) ?>" enctype="multipart/form-data" class="d-inline-flex align-items-center gap-1">
                                                    <?= csrf_field() ?>
                                                    <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.webp,.pdf" class="form-control form-control-sm" style="max-width: 150px" required>
                                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Upload receipt">
                                                        <i class="bi bi-upload"></i>
                                                    </button>
                                                </form>

                                            <?php endif; ?>

                                        </td>


                                        <!-- ACTION -->

                                        <td class="text-center text-nowrap">

                                            <button
                                                type="button"
                                                class="btn btn-outline-success btn-sm edit-pms-btn"
                                                data-id="<?= (int)$r['id'] ?>"
                                                title="Edit PMS"
                                            >

                                                Edit PMS

                                            </button>


                                            <button
                                                type="button"
                                                class="btn btn-outline-danger btn-sm delete-pms-btn"
                                                data-id="<?= (int)$r['id'] ?>"
                                                data-pms="<?= esc($r['pms_number'] ?? '') ?>"
                                                title="Delete PMS"
                                            >

                                                Delete

                                            </button>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </td>

            </tr>

        <?php endif; ?>

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

.account-address {
    color: #6c757d;
}

.select2-results__option--highlighted[aria-selected] .account-address {
    color: #e9ecef;
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

                            $accountId =
                                $a['id']
                                ?? $a['ID']
                                ?? $a['data_id']
                                ?? '';

                            $address = $a['Address'] ?? '';
                            $clinicKey = $clinicName . '|' . $address;

                            if (!isset($clinicMap[$clinicKey])) {

                                $clinicMap[$clinicKey] = [

                                    'id' => $accountId,

                                    'clinic' => $clinicName,
                                    'address' => $address,

                                    'machines' => []

                                ];

                            }

                            $machine = trim(
                                $a['Machine'] ?? ''
                            );

                            if ($machine !== '') {

                                $clinicMap[$clinicKey]['machines'][$machine] =
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

                                <?php foreach ($clinicMap as $info): ?>

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
                                        data-clinic="<?= esc($info['clinic']) ?>"
                                        data-address="<?= esc($info['address']) ?>"
                                        data-machines="<?= $machinesJson ?>"
                                    >
                                        <?= esc($info['clinic']) ?> | <?= esc($info['address']) ?>
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

                            <iframe
                                src="<?= site_url('pms/receipt/' . (int)$r['receipt']) ?>"
                                class="w-100 rounded border"
                                style="height: 70vh;"
                                title="PMS Receipt"
                            ></iframe>

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
     EDIT PMS MODAL
     ========================================================== -->

<div
    class="modal fade"
    id="editPmsModal"
    tabindex="-1"
    aria-labelledby="editPmsModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="editPmsModalLabel"
                >

                    <i class="bi bi-pencil-square me-2"></i>

                    Edit PMS Record

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form
                id="editPmsForm"
                method="POST"
                enctype="multipart/form-data"
            >

                <?= csrf_field() ?>


                <div class="modal-body">

                    <!-- PMS ID -->

                    <input
                        type="hidden"
                        name="id"
                        id="edit_pms_id"
                    >


                    <!-- PMS NUMBER -->

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label
                                class="form-label fw-semibold"
                            >
                                PMS Number
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="pms_number"
                                id="edit_pms_number"
                                required
                            >

                        </div>


                        <!-- DATE -->

                        <div class="col-md-6">

                            <label
                                class="form-label fw-semibold"
                            >
                                Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                name="date"
                                id="edit_pms_date"
                                required
                            >

                        </div>


                        <!-- SERVICE ENGINEER -->

                        <div class="col-md-6">

                            <label
                                class="form-label fw-semibold"
                            >
                                Service Engineer
                            </label>

                            <select
                                class="form-select"
                                name="service_eng_id"
                                id="edit_service_eng_id"
                                required
                            >

                                <option value="">
                                    Select Service Engineer
                                </option>

                                <?php foreach ($users as $u): ?>

                                    <?php
                                        $fullName = trim(
                                            ($u['fname'] ?? '') .
                                            ' ' .
                                            ($u['lname'] ?? '')
                                        );
                                    ?>

                                    <option
                                        value="<?= (int)$u['id'] ?>"
                                        data-name="<?= esc($fullName) ?>"
                                    >
                                        <?= esc($fullName) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- ACCOUNT -->

                        <div class="col-md-6">

                            <label
                                class="form-label fw-semibold"
                            >
                                Account
                            </label>

                            <select
                                class="form-select"
                                name="data_id"
                                id="edit_data_id"
                                required
                            >

                                <option value="">
                                    Select Account
                                </option>

                                <?php foreach ($accounts as $account): ?>

                                    <option
                                        value="<?= (int)$account['id'] ?>"
                                        data-address="<?= esc($account['Address'] ?? '') ?>"
                                        data-machine="<?= esc($account['Machine'] ?? '') ?>"
                                        data-sn="<?= esc($account['SN'] ?? '') ?>"
                                    >

                                        <?= esc($account['Clinic_name'] ?? '') ?> | <?= esc($account['Address'] ?? '') ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- ADDRESS -->

                        <div class="col-12">

                            <label
                                class="form-label fw-semibold"
                            >
                                Address
                            </label>

                            <textarea
                                class="form-control"
                                name="address"
                                id="edit_pms_address"
                                rows="2"
                            ></textarea>

                        </div>


                        <!-- MACHINE -->

                        <div class="col-md-6">

                            <label
                                class="form-label fw-semibold"
                            >
                                Machine
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="machine"
                                id="edit_pms_machine"
                                required
                            >

                        </div>


                        <!-- SERIAL NUMBER -->

                        <div class="col-md-6">

                            <label
                                class="form-label fw-semibold"
                            >
                                Serial Number
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="sn"
                                id="edit_pms_sn"
                            >

                        </div>


                        <!-- TECHNICAL DONE -->

                        <div class="col-12">

                            <label
                                class="form-label fw-semibold"
                            >
                                Technical Done
                            </label>

                            <select
                                class="form-select"
                                name="status"
                                id="edit_pms_status"
                                required
                            >

                                <option value="">
                                    Select Technical Done
                                </option>

                                <option value="Light PMS">
                                    Light PMS
                                </option>

                                <option value="Mid PMS">
                                    Mid PMS
                                </option>

                                <option value="Heavy PMS">
                                    Heavy PMS
                                </option>

                                <option value="Troubleshooting">
                                    Troubleshooting
                                </option>

                                <option value="QC">
                                    QC
                                </option>

                                <option value="Installation">
                                    Installation
                                </option>

                                <option value="Relocation">
                                    Relocation
                                </option>

                                <option value="Manual Checking">
                                    Manual Checking
                                </option>

                                <option value="For Release">
                                    For Release
                                </option>

                                <option value="New Accessed">
                                    New Accessed
                                </option>

                                <option value="Cancelled Service">
                                    Cancelled Service
                                </option>

                            </select>

                        </div>


                        <!-- EXISTING DOCUMENTS -->

                        <div class="col-12">

                            <div class="row g-3 mb-3">

                                <div class="col-md-6">
                                    <label for="edit_mfs_id" class="form-label fw-semibold">MFS Number</label>
                                    <select class="form-select" name="mfs_id" id="edit_mfs_id">
                                        <option value="">No MFS</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="edit_fsr_id" class="form-label fw-semibold">FSR Number</label>
                                    <select class="form-select" name="fsr_id" id="edit_fsr_id">
                                        <option value="">No FSR</option>
                                    </select>
                                </div>

                            </div>

                            <div
                                class="alert alert-light border mb-0"
                                id="editPmsDocuments"
                            >

                                <div class="fw-semibold mb-2">
                                    Existing Documents
                                </div>

                                <div
                                    id="editPmsDocumentsContent"
                                    class="small text-muted"
                                >
                                    Loading...
                                </div>

                                <label for="edit_receipt" class="form-label fw-semibold mt-3">Replace Receipt</label>
                                <input type="file" class="form-control" name="receipt" id="edit_receipt" accept=".jpg,.jpeg,.png,.webp,.pdf">
                                <div class="form-text">Leave empty to keep the current receipt.</div>

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

                        <i class="bi bi-x-circle me-1"></i>

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="saveEditPmsBtn"
                    >

                        <i class="bi bi-save me-1"></i>

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?= view('dashboard/script/pmsscript') ?>

</body>
</html>
