<?= view('dashboard/layout/head') ?>

<style>
    .input-group .select2-container {
        flex: 1 1 auto;
        width: 1% !important;
    }

    .input-group .select2-container .select2-selection {
        min-height: 38px;
        border-radius: 0 0.375rem 0.375rem 0;
        border-color: #dee2e6;
    }

    .input-group .input-group-text {
        border-radius: 0.375rem 0 0 0.375rem;
    }
</style>

<body>

    <!-- ==========================================================
         FLASH MESSAGES
         ========================================================== -->

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


    <!-- ==========================================================
         SIDEBAR
         ========================================================== -->

    <?= view('dashboard/layout/sidebar') ?>


    <!-- ==========================================================
         MAIN WRAPPER
         ========================================================== -->

    <div class="main-wrapper">

        <?= view('dashboard/layout/navbar') ?>


        <!-- ======================================================
             MAIN CONTENT
             ====================================================== -->

        <main class="container-fluid py-4">


            <!-- ==================================================
                 PAGE HEADER
                 ================================================== -->

            <div
                class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4"
            >

                <div>

                    <h4 class="mb-1">
                        <i class="bi bi-arrow-repeat me-2"></i>
                        Rotor Replacement
                    </h4>

                    <p class="text-muted mb-0">
                        Monitor and manage rotor replacement reports.
                    </p>

                </div>

                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#rotorModal"
                >
                    <i class="bi bi-plus-circle me-1"></i>
                    Add Replacement Report
                </button>

            </div>


            <!-- ==================================================
                 ROTOR REPLACEMENT CARD
                 ================================================== -->

            <div class="row mb-4">

                <div class="col-12 col-md-6 col-xl-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div
                                class="d-flex align-items-center justify-content-between"
                            >

                                <div>

                                    <div class="text-muted small mb-1">
                                        Rotor Replacement
                                    </div>

                                    <h2 class="mb-0 fw-bold">
                                        <?= number_format(count($records ?? [])) ?>
                                    </h2>

                                    <div class="text-muted small mt-2">
                                        Total replacement reports
                                    </div>

                                </div>

                                <div
                                    class="rounded-circle d-flex align-items-center justify-content-center"
                                    style="
                                        width: 55px;
                                        height: 55px;
                                        background: rgba(13, 110, 253, 0.10);
                                        color: #0d6efd;
                                    "
                                >
                                    <i class="bi bi-arrow-repeat fs-3"></i>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ==================================================
                 FILTER
                 ================================================== -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">

                        <i class="bi bi-funnel me-2"></i>

                        <h6 class="mb-0 fw-semibold">
                            Filter Replacement Reports
                        </h6>

                    </div>

                    <form
                        method="get"
                        action="<?= site_url('rotor_replace') ?>"
                    >

                        <div class="row g-3 align-items-end">

                            <div class="col-12 col-md-3">

                                <label
                                    for="start_date"
                                    class="form-label"
                                >
                                    Start Date
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="start_date"
                                    name="start_date"
                                    value="<?= esc($startDate ?? '') ?>"
                                >

                            </div>


                            <div class="col-12 col-md-3">

                                <label
                                    for="end_date"
                                    class="form-label"
                                >
                                    End Date
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="end_date"
                                    name="end_date"
                                    value="<?= esc($endDate ?? '') ?>"
                                >

                            </div>


                            <div class="col-12 col-md-2">

                                <label for="status_filter" class="form-label">Status</label>

                                <select name="status" id="status_filter" class="form-select">
                                    <option value="">All Statuses</option>
                                    <?php foreach (['Report by Clinic', 'Report to Manufacture', 'Order', 'Delivered'] as $statusOption): ?>
                                        <option value="<?= esc($statusOption) ?>" <?= ($status ?? '') === $statusOption ? 'selected' : '' ?>>
                                            <?= esc($statusOption) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                            <div class="col-12 col-md-2">

                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                >
                                    <i class="bi bi-search me-1"></i>
                                    Filter
                                </button>

                            </div>


                            <div class="col-12 col-md-2">

                                <a
                                    href="<?= site_url('rotor_replace') ?>"
                                    class="btn btn-outline-secondary w-100"
                                >
                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                    Reset
                                </a>

                            </div>


                            <div class="col-12 col-md-2">

                                <button
                                    type="button"
                                    class="btn btn-success w-100"
                                    id="btnPrintReport"
                                >
                                    <i class="bi bi-printer me-1"></i>
                                    Print Report
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            <!-- ==================================================
                 REPLACEMENT REPORTS
                 ================================================== -->

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0 py-3">

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center gap-2"
                    >

                        <div>

                            <h5 class="mb-1">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                Replacement Reports
                            </h5>

                            <small class="text-muted">
                                Rotor replacement history
                            </small>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            id="rotorTable"
                            class="table table-hover align-middle w-100"
                        >

                            <thead>

                                <tr>

                                    <th>#</th>
                                    <th>Clinic Name</th>
                                    <th>Address</th>
                                    <th>Model</th>
                                    <th>Rotor</th>
                                    <th>Lot Number</th>
                                    <th>Product Code</th>
                                    <th>Concern</th>
                                    <th>Date</th>
                                    <th>Replaceable</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th class="text-center">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php if (!empty($records)): ?>

                                    <?php foreach ($records as $index => $record): ?>

                                        <tr>

                                            <td>
                                                <?= $index + 1 ?>
                                            </td>

                                            <td>
                                                <?= esc($record['clinic_name'] ?? '') ?>
                                            </td>

                                            <td>
                                                <?= esc($record['address'] ?? '') ?>
                                            </td>

                                            <td>
                                                <?= esc($record['model'] ?? '') ?>
                                            </td>

                                            <td>
                                                <?= esc($record['rotor'] ?? '') ?>
                                            </td>

                                            <td>
                                                <?= esc($record['lot_number'] ?? '') ?>
                                            </td>

                                            <td>
                                                <?= esc($record['product_code'] ?? '') ?>
                                            </td>

                                            <td>
                                                <?= esc($record['concern'] ?? '') ?>
                                            </td>

                                            <td class="text-nowrap">

                                                <?php if (!empty($record['date'])): ?>

                                                    <?= date(
                                                        'M d, Y',
                                                        strtotime($record['date'])
                                                    ) ?>

                                                <?php endif; ?>

                                            </td>

                                            <td>

                                                <?php
                                                $replaceable = strtolower(
                                                    trim($record['replaceable'] ?? '')
                                                );
                                                ?>

                                                <?php if (
                                                    $replaceable === 'yes' ||
                                                    $replaceable === '1'
                                                ): ?>

                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Yes
                                                    </span>

                                                <?php elseif (
                                                    $replaceable === 'no' ||
                                                    $replaceable === '0'
                                                ): ?>

                                                    <span class="badge bg-secondary">
                                                        No
                                                    </span>

                                                <?php else: ?>

                                                    <span class="text-muted">
                                                        —
                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                            <td>
                                                <?= esc($record['reason'] ?? '') ?>
                                            </td>

                                            <td>
                                                <?php
                                                $recordStatus = $record['status'] ?? 'Report by Clinic';
                                                $statusClass = $recordStatus === 'Delivered' ? 'success' : ($recordStatus === 'Order' ? 'primary' : ($recordStatus === 'Report to Manufacture' ? 'warning text-dark' : 'secondary'));
                                                ?>
                                                <?php if ($recordStatus !== 'Delivered'): ?>
                                                    <form method="post" action="<?= site_url('rotor_replace/advance-status') ?>" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id" value="<?= esc($record['id'] ?? '') ?>">
                                                        <button type="submit" class="badge border-0 bg-<?= esc($statusClass) ?>" title="Advance status">
                                                            <?= esc($recordStatus) ?>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="badge bg-success">
                                                        Delivered
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- ACTION -->

                                            <td class="text-center text-nowrap">

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-secondary"
                                                    title="Edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editRotorModal"
                                                    data-id="<?= esc($record['id'] ?? '') ?>"
                                                    data-clinic="<?= esc($record['clinic_name'] ?? '') ?>"
                                                    data-address="<?= esc($record['address'] ?? '') ?>"
                                                    data-model="<?= esc($record['model'] ?? '') ?>"
                                                    data-rotor="<?= esc($record['rotor'] ?? '') ?>"
                                                    data-lot-number="<?= esc($record['lot_number'] ?? '') ?>"
                                                    data-product-code="<?= esc($record['product_code'] ?? '') ?>"
                                                    data-concern="<?= esc($record['concern'] ?? '') ?>"
                                                    data-date="<?= esc($record['date'] ?? '') ?>"
                                                    data-replaceable="<?= esc($record['replaceable'] ?? '') ?>"
                                                    data-reason="<?= esc($record['reason'] ?? '') ?>"
                                                    data-status="<?= esc($record['status'] ?? 'Report by Clinic') ?>"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                </button>


                                                <form
                                                    action="<?= site_url('rotor_replace/delete/' . ($record['id'] ?? '')) ?>"
                                                    method="post"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this rotor replacement report?');"
                                                >

                                                    <?= csrf_field() ?>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete"
                                                    >
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                </form>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </tbody>

                        </table>


                        <?php if (empty($records)): ?>

                            <div class="text-center text-muted py-4">

                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                                No rotor replacement reports found.

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </main>


        <!-- ======================================================
             ADD REPLACEMENT MODAL
             ====================================================== -->

        <div
            class="modal fade"
            id="rotorModal"
            tabindex="-1"
            aria-labelledby="rotorModalLabel"
            aria-hidden="true"
        >

            <div
                class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
            >

                <div class="modal-content">


                    <div class="modal-header">

                        <h5
                            class="modal-title"
                            id="rotorModalLabel"
                        >
                            <i class="bi bi-arrow-repeat me-2"></i>
                            Add Replacement Report
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>


                    <form
                        method="post"
                        action="<?= site_url('rotor_replace/save') ?>"
                        id="rotorForm"
                    >

                        <?= csrf_field() ?>

                        <div class="modal-body">

                            <div class="row g-3">


                                <!-- ==================================================
                                     CLINIC
                                     ================================================== -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="data_id"
                                        class="form-label fw-semibold"
                                    >
                                        <i class="bi bi-hospital me-1"></i>
                                        Clinic Name
                                    </label>


                                    <?php

                                    /*
                                    |--------------------------------------------------------------------------
                                    | BUILD UNIQUE CLINIC LIST
                                    |--------------------------------------------------------------------------
                                    |
                                    | IMPORTANT:
                                    | We keep the actual model belonging to
                                    | the clinic.
                                    |
                                    */

                                    $clinicMap = [];

                                    foreach ($accounts ?? [] as $account) {

                                        $clinicName = trim(
                                            $account['clinic_name'] ?? ''
                                        );

                                        if ($clinicName === '') {
                                            continue;
                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | ONE OPTION PER CLINIC
                                        |--------------------------------------------------------------------------
                                        */

                                        if (!isset($clinicMap[$clinicName])) {

                                            $clinicMap[$clinicName] = [
                                                'id'      => $account['id'] ?? '',
                                                'address' => $account['address'] ?? '',
                                                'model'   => $account['model'] ?? '',
                                            ];

                                        }

                                    }

                                    ?>


                                    <div class="input-group">

                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-hospital"></i>
                                        </span>

                                        <select
                                            name="data_id"
                                            id="data_id"
                                            class="form-select select2-account"
                                            required
                                        >

                                            <option value="">
                                                -- Select Clinic --
                                            </option>

                                            <?php foreach (
                                                $clinicMap as $clinicName => $info
                                            ): ?>

                                                <option
                                                    value="<?= esc($info['id']) ?>"
                                                    data-clinic="<?= esc($clinicName) ?>"
                                                    data-address="<?= esc($info['address']) ?>"
                                                    data-model="<?= esc($info['model']) ?>"
                                                >
                                                    <?= esc($clinicName) ?>
                                                </option>

                                            <?php endforeach; ?>

                                        </select>

                                    </div>


                                    <!-- HIDDEN CLINIC NAME -->

                                    <input
                                        type="hidden"
                                        name="clinic_name"
                                        id="clinic_name"
                                    >


                                    <div class="form-text mt-2">

                                        <i class="bi bi-search me-1"></i>

                                        Search and select the clinic account.

                                    </div>

                                </div>


                                <!-- ==================================================
                                     ADDRESS
                                     ================================================== -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="address"
                                        class="form-label fw-semibold"
                                    >
                                        Address
                                    </label>

                                    <input
                                        type="text"
                                        name="address"
                                        id="address"
                                        class="form-control"
                                        placeholder="Address will be filled automatically"
                                        readonly
                                    >

                                    <div class="form-text">

                                        <i class="bi bi-info-circle me-1"></i>

                                        Automatically loaded from the selected clinic.

                                    </div>

                                </div>


                                <!-- ==================================================
                                     MODEL
                                     ================================================== -->

                                <div class="col-12 col-md-4">

                                    <label
                                        for="model"
                                        class="form-label"
                                    >
                                        Model
                                    </label>

                                    <input
                                        type="text"
                                        name="model"
                                        id="model"
                                        class="form-control"
                                        placeholder="Model will be filled automatically"
                                        readonly
                                        required
                                    >

                                    <div class="form-text">

                                        <i class="bi bi-info-circle me-1"></i>

                                        Automatically loaded from the selected clinic.

                                    </div>

                                </div>


                                <!-- ROTOR -->

                                <div class="col-12 col-md-4">

                                    <label
                                        for="rotor"
                                        class="form-label"
                                    >
                                        Rotor
                                    </label>

                                    <input
                                        type="text"
                                        name="rotor"
                                        id="rotor"
                                        class="form-control"
                                        placeholder="Enter rotor"
                                        required
                                    >

                                </div>


                                <!-- LOT NUMBER -->

                                <div class="col-12 col-md-4">

                                    <label
                                        for="lot_number"
                                        class="form-label"
                                    >
                                        Lot Number
                                    </label>

                                    <input
                                        type="text"
                                        name="lot_number"
                                        id="lot_number"
                                        class="form-control"
                                        placeholder="Enter lot number"
                                    >

                                </div>


                                <!-- PRODUCT CODE -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="product_code"
                                        class="form-label"
                                    >
                                        Product Code
                                    </label>

                                    <input
                                        type="text"
                                        name="product_code"
                                        id="product_code"
                                        class="form-control"
                                        placeholder="Enter product code"
                                    >

                                </div>


                                <!-- DATE -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="date"
                                        class="form-label"
                                    >
                                        Date
                                    </label>

                                    <input
                                        type="date"
                                        name="date"
                                        id="date"
                                        class="form-control"
                                        value="<?= date('Y-m-d') ?>"
                                        required
                                    >

                                </div>


                                <!-- CONCERN -->

                                <div class="col-12">

                                    <label
                                        for="concern"
                                        class="form-label"
                                    >
                                        Concern
                                    </label>

                                    <select
                                        name="concern"
                                        id="concern"
                                        class="form-select"
                                        required
                                    >
                                        <option value="">-- Select Concern --</option>
                                        <option value="Reagent disk fault">Reagent disk fault</option>
                                        <option value="Equipment failure">Equipment failure</option>
                                        <option value="Insufficient sample or coagulation">Insufficient sample or coagulation</option>
                                        <option value="Machine error">Machine error</option>
                                    </select>

                                </div>


                                <!-- REPLACEABLE -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="replaceable"
                                        class="form-label"
                                    >
                                        Replaceable
                                    </label>

                                    <select
                                        name="replaceable"
                                        id="replaceable"
                                        class="form-select"
                                    >

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


                                <!-- REASON -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="reason"
                                        class="form-label"
                                    >
                                        Reason
                                    </label>

                                    <input
                                        type="text"
                                        name="reason"
                                        id="reason"
                                        class="form-control"
                                        placeholder="Enter reason"
                                    >

                                </div>


                                <!-- STATUS -->

                                <div class="col-12 col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <?php foreach (['Report by Clinic', 'Report to Manufacture', 'Order', 'Delivered'] as $statusOption): ?>
                                            <option value="<?= esc($statusOption) ?>" <?= $statusOption === 'Report by Clinic' ? 'selected' : '' ?>>
                                                <?= esc($statusOption) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
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
                            >
                                <i class="bi bi-save me-1"></i>
                                Save Replacement Report
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        <!-- ======================================================
             EDIT ROTOR REPLACEMENT MODAL
             ====================================================== -->

        <div
            class="modal fade"
            id="editRotorModal"
            tabindex="-1"
            aria-labelledby="editRotorModalLabel"
            aria-hidden="true"
        >

            <div
                class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
            >

                <div class="modal-content">


                    <div class="modal-header">

                        <h5
                            class="modal-title"
                            id="editRotorModalLabel"
                        >
                            <i class="bi bi-pencil-square me-2"></i>
                            Edit Rotor Replacement Report
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>


                    <form
                        method="post"
                        action="<?= site_url('rotor_replace/update') ?>"
                        id="editRotorForm"
                    >

                        <?= csrf_field() ?>

                        <div class="modal-body">

                            <input
                                type="hidden"
                                name="id"
                                id="edit_id"
                            >


                            <div class="row g-3">


                                <!-- CLINIC NAME -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="edit_clinic_name"
                                        class="form-label fw-semibold"
                                    >
                                        <i class="bi bi-hospital me-1"></i>
                                        Clinic Name
                                    </label>

                                    <input
                                        type="text"
                                        name="clinic_name"
                                        id="edit_clinic_name"
                                        class="form-control"
                                        required
                                    >

                                </div>


                                <!-- ADDRESS -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="edit_address"
                                        class="form-label fw-semibold"
                                    >
                                        Address
                                    </label>

                                    <input
                                        type="text"
                                        name="address"
                                        id="edit_address"
                                        class="form-control"
                                        required
                                    >

                                </div>


                                <!-- MODEL -->

                                <div class="col-12 col-md-4">

                                    <label
                                        for="edit_model"
                                        class="form-label"
                                    >
                                        Model
                                    </label>

                                    <input
                                        type="text"
                                        name="model"
                                        id="edit_model"
                                        class="form-control"
                                        readonly
                                    >

                                </div>


                                <!-- ROTOR -->

                                <div class="col-12 col-md-4">

                                    <label
                                        for="edit_rotor"
                                        class="form-label"
                                    >
                                        Rotor
                                    </label>

                                    <input
                                        type="text"
                                        name="rotor"
                                        id="edit_rotor"
                                        class="form-control"
                                        required
                                    >

                                </div>


                                <!-- LOT NUMBER -->

                                <div class="col-12 col-md-4">

                                    <label
                                        for="edit_lot_number"
                                        class="form-label"
                                    >
                                        Lot Number
                                    </label>

                                    <input
                                        type="text"
                                        name="lot_number"
                                        id="edit_lot_number"
                                        class="form-control"
                                    >

                                </div>


                                <!-- PRODUCT CODE -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="edit_product_code"
                                        class="form-label"
                                    >
                                        Product Code
                                    </label>

                                    <input
                                        type="text"
                                        name="product_code"
                                        id="edit_product_code"
                                        class="form-control"
                                    >

                                </div>


                                <!-- DATE -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="edit_date"
                                        class="form-label"
                                    >
                                        Date
                                    </label>

                                    <input
                                        type="date"
                                        name="date"
                                        id="edit_date"
                                        class="form-control"
                                        required
                                    >

                                </div>


                                <!-- CONCERN -->

                                <div class="col-12">

                                    <label
                                        for="edit_concern"
                                        class="form-label"
                                    >
                                        Concern
                                    </label>

                                    <select
                                        name="concern"
                                        id="edit_concern"
                                        class="form-select"
                                        required
                                    >
                                        <option value="">-- Select Concern --</option>
                                        <option value="Reagent disk fault">Reagent disk fault</option>
                                        <option value="Equipment failure">Equipment failure</option>
                                        <option value="Insufficient sample or coagulation">Insufficient sample or coagulation</option>
                                        <option value="Machine error">Machine error</option>
                                    </select>

                                </div>


                                <!-- REPLACEABLE -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="edit_replaceable"
                                        class="form-label"
                                    >
                                        Replaceable
                                    </label>

                                    <select
                                        name="replaceable"
                                        id="edit_replaceable"
                                        class="form-select"
                                    >

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


                                <!-- REASON -->

                                <div class="col-12 col-md-6">

                                    <label
                                        for="edit_reason"
                                        class="form-label"
                                    >
                                        Reason
                                    </label>

                                    <input
                                        type="text"
                                        name="reason"
                                        id="edit_reason"
                                        class="form-control"
                                    >

                                </div>


                                <!-- STATUS -->

                                <div class="col-12 col-md-6">
                                    <label for="edit_status" class="form-label">Status</label>
                                    <select name="status" id="edit_status" class="form-select" required>
                                        <?php foreach (['Report by Clinic', 'Report to Manufacture', 'Order', 'Delivered'] as $statusOption): ?>
                                            <option value="<?= esc($statusOption) ?>"><?= esc($statusOption) ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
                            >
                                <i class="bi bi-save me-1"></i>
                                Save Changes
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        <!-- ======================================================
             FOOTER
             ====================================================== -->

        <?= view('dashboard/layout/footer') ?>

    </div>


    <!-- ==========================================================
         JAVASCRIPT
         ========================================================== -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================
       FLASH MESSAGE
       ========================================================== */

    setTimeout(function () {

        document
            .querySelectorAll('.flash-message')
            .forEach(function (message) {

                message.style.opacity = '0';

                setTimeout(function () {
                    message.remove();
                }, 500);

            });

    }, 5000);


    /* ==========================================================
       DATATABLE
       ========================================================== */

    if (
        typeof $ !== 'undefined' &&
        typeof $.fn.DataTable !== 'undefined'
    ) {

        const rotorTable = $('#rotorTable').DataTable({

            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],

            order: [
                [8, 'desc']
            ],

            responsive: false,

            autoWidth: false,

            scrollX: true

        });


        /*
         * Keep row numbers correct when DataTables
         * changes page.
         */

        rotorTable.on('draw', function () {

            const pageInfo =
                rotorTable.page.info();

            rotorTable
                .column(0, {
                    page: 'current'
                })
                .nodes()
                .each(function (cell, index) {

                    cell.innerHTML =
                        pageInfo.start + index + 1;

                });

        });

        rotorTable.draw();

    }


    /* ==========================================================
       ELEMENTS
       ========================================================== */

    const clinicSelect =
        document.getElementById('data_id');

    const clinicNameInput =
        document.getElementById('clinic_name');

    const addressInput =
        document.getElementById('address');

    const modelInput =
        document.getElementById('model');


    /* ==========================================================
       SELECT2
       ========================================================== */

    if (
        typeof $ !== 'undefined' &&
        typeof $.fn.select2 !== 'undefined' &&
        clinicSelect
    ) {

        $('#data_id').select2({

            dropdownParent: $('#rotorModal'),

            placeholder: '-- Select Clinic --',

            allowClear: true,

            width: '100%'

        });

    }


    /* ==========================================================
       CLINIC AUTO-FILL
       ========================================================== */

    function updateClinicDetails() {

        if (!clinicSelect) {
            return;
        }


        const selectedOption =
            clinicSelect.options[
                clinicSelect.selectedIndex
            ];


        /*
         * No clinic selected
         */

        if (
            !selectedOption ||
            !clinicSelect.value
        ) {

            if (clinicNameInput) {
                clinicNameInput.value = '';
            }

            if (addressInput) {
                addressInput.value = '';
            }

            if (modelInput) {
                modelInput.value = '';
            }

            return;
        }


        /*
         * Read information from selected clinic option.
         */

        const clinicName =
            selectedOption.dataset.clinic || '';

        const address =
            selectedOption.dataset.address || '';

        const model =
            selectedOption.dataset.model || '';


        /*
         * Automatically fill clinic name.
         */

        if (clinicNameInput) {
            clinicNameInput.value = clinicName;
        }


        /*
         * Automatically fill address.
         */

        if (addressInput) {
            addressInput.value = address;
        }


        /*
         * Automatically fill ACTUAL MODEL.
         */

        if (modelInput) {
            modelInput.value = model;
        }

    }


    /* ==========================================================
       NORMAL SELECT CHANGE
       ========================================================== */

    if (clinicSelect) {

        clinicSelect.addEventListener(
            'change',
            updateClinicDetails
        );

    }


    /* ==========================================================
       SELECT2 CHANGE
       ========================================================== */

    if (
        typeof $ !== 'undefined' &&
        typeof $.fn.select2 !== 'undefined'
    ) {

        $('#data_id').on(
            'select2:select select2:clear change',
            function () {

                updateClinicDetails();

            }
        );

    }


    /* ==========================================================
       RESET ADD MODAL
       ========================================================== */

    const rotorModal =
        document.getElementById('rotorModal');


    if (rotorModal) {

        rotorModal.addEventListener(
            'hidden.bs.modal',
            function () {

                const rotorForm =
                    document.getElementById('rotorForm');


                /*
                 * Reset entire form.
                 */

                if (rotorForm) {
                    rotorForm.reset();
                }


                /*
                 * Reset Select2.
                 */

                if (
                    typeof $ !== 'undefined' &&
                    typeof $.fn.select2 !== 'undefined'
                ) {

                    $('#data_id')
                        .val(null)
                        .trigger('change');

                }


                /*
                 * Clear automatic fields.
                 */

                if (clinicNameInput) {
                    clinicNameInput.value = '';
                }

                if (addressInput) {
                    addressInput.value = '';
                }

                if (modelInput) {
                    modelInput.value = '';
                }


                /*
                 * Restore today's date.
                 */

                const dateInput =
                    document.getElementById('date');

                if (dateInput) {

                    dateInput.value =
                        '<?= date('Y-m-d') ?>';

                }

            }
        );

    }


    /* ==========================================================
       EDIT ROTOR MODAL
       ========================================================== */

    const editRotorModal =
        document.getElementById('editRotorModal');


    if (editRotorModal) {

        editRotorModal.addEventListener(
            'show.bs.modal',
            function (event) {

                const button =
                    event.relatedTarget;


                if (!button) {
                    return;
                }


                /*
                 * Get values from edit button.
                 */

                const values = {

                    id:
                        button.getAttribute('data-id') || '',

                    clinic:
                        button.getAttribute('data-clinic') || '',

                    address:
                        button.getAttribute('data-address') || '',

                    model:
                        button.getAttribute('data-model') || '',

                    rotor:
                        button.getAttribute('data-rotor') || '',

                    lotNumber:
                        button.getAttribute('data-lot-number') || '',

                    productCode:
                        button.getAttribute('data-product-code') || '',

                    concern:
                        button.getAttribute('data-concern') || '',

                    date:
                        button.getAttribute('data-date') || '',

                    replaceable:
                        button.getAttribute('data-replaceable') || '',

                    reason:
                        button.getAttribute('data-reason') || '',

                    status:
                        button.getAttribute('data-status') || 'Report by Clinic'

                };


                /*
                 * Set edit form values.
                 */

                const fieldMap = {

                    edit_id: values.id,

                    edit_clinic_name: values.clinic,

                    edit_address: values.address,

                    edit_model: values.model,

                    edit_rotor: values.rotor,

                    edit_lot_number: values.lotNumber,

                    edit_product_code: values.productCode,

                    edit_concern: values.concern,

                    edit_date: values.date,

                    edit_replaceable: values.replaceable,

                    edit_reason: values.reason,

                    edit_status: values.status

                };


                Object.keys(fieldMap).forEach(
                    function (fieldId) {

                        const field =
                            document.getElementById(fieldId);

                        if (field) {
                            field.value =
                                fieldMap[fieldId];
                        }

                    }
                );

            }
        );

    }


    /* ==========================================================
       DATE FILTER VALIDATION
       ========================================================== */

    const startDate =
        document.getElementById('start_date');

    const endDate =
        document.getElementById('end_date');


    if (startDate && endDate) {

        if (startDate.value) {

            endDate.min =
                startDate.value;

        }


        startDate.addEventListener(
            'change',
            function () {

                if (this.value) {

                    endDate.min =
                        this.value;


                    if (
                        endDate.value &&
                        endDate.value < this.value
                    ) {

                        endDate.value = '';

                    }

                } else {

                    endDate.removeAttribute('min');

                }

            }
        );


        endDate.addEventListener(
            'change',
            function () {

                if (
                    startDate.value &&
                    this.value &&
                    this.value < startDate.value
                ) {

                    this.value = '';


                    if (
                        typeof Swal !== 'undefined'
                    ) {

                        Swal.fire({

                            icon: 'warning',

                            title: 'Invalid Date Range',

                            text:
                                'End date cannot be earlier than start date.',

                            confirmButtonText: 'OK'

                        });

                    }

                }

            }
        );

    }


    /* ==========================================================
       PRINT REPORT
       ========================================================== */

    const printButton =
        document.getElementById('btnPrintReport');


    if (printButton) {

        printButton.addEventListener(
            'click',
            function () {

                const start =
                    document.getElementById(
                        'start_date'
                    )?.value || '';

                const end =
                    document.getElementById(
                        'end_date'
                    )?.value || '';


                let url =
                    '<?= site_url('rotor_replace/print') ?>';


                const params = [];


                if (start) {

                    params.push(
                        'start_date=' +
                        encodeURIComponent(start)
                    );

                }


                if (end) {

                    params.push(
                        'end_date=' +
                        encodeURIComponent(end)
                    );

                }


                if (params.length) {

                    url +=
                        '?' +
                        params.join('&');

                }


                window.open(
                    url,
                    '_blank'
                );

            }
        );

    }

});
</script>


</body>

</html>