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

<!-- ==========================================
     START: Main Content Area
     ========================================== -->

<div class="main-wrapper">


<?= view('dashboard/layout/navbar') ?>

<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-receipt me-2"></i>
                Upload Receipt
            </h4>

            <p class="text-muted mb-0">
                Upload and manage receipt images.
            </p>
        </div>

    </div>


    <!-- ==========================================
         UPLOAD RECEIPT
         ========================================== -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-cloud-arrow-up me-2"></i>
                Upload New Receipt
            </h6>
        </div>

        <div class="card-body">

            <form action="<?= site_url('dashboard/receipts/upload') ?>"
                  method="post"
                  enctype="multipart/form-data">

                <?= csrf_field() ?>

                <div class="row align-items-end">

                    <div class="col-md-8">

                        <label for="receipt" class="form-label fw-semibold">
                            Receipt Image
                        </label>

                        <input type="file"
                               name="receipt"
                               id="receipt"
                               class="form-control"
                               accept=".jpg,.jpeg,image/jpeg"
                               required>

                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            JPG/JPEG only. Maximum file size: 5MB.
                        </div>

                    </div>

                    <div class="col-md-4 mt-3 mt-md-0">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            <i class="bi bi-upload me-1"></i>
                            Upload Receipt

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- ==========================================
         RECEIPT LIST
         ========================================== -->

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-images me-2"></i>
                    Uploaded Receipts
                </h6>

                <span class="badge bg-primary">
                    <?= count($receipts ?? []) ?> Receipt(s)
                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table id="receiptTable"
                       class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>ID</th>
                            <th>Receipt</th>
                            <th>Date Uploaded</th>
                            <th class="text-center">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (!empty($receipts)): ?>

                            <?php foreach ($receipts as $receipt): ?>

                                <tr>

                                    <td>
                                        <?= esc($receipt['id']) ?>
                                    </td>

                                    <td>
                                        <i class="bi bi-file-earmark-image text-primary me-2"></i>
                                        Receipt #<?= esc($receipt['id']) ?>
                                    </td>

                                    <td>
                                        <?= esc($receipt['date_upload']) ?>
                                    </td>

                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-1">

                                            <!-- VIEW -->
                                            <a href="<?= base_url('uploads/receipts/' . basename($receipt['file_location'])) ?>"
                                            target="_blank"
                                            class="btn btn-sm btn-outline-primary">

                                                <i class="bi bi-eye me-1"></i>
                                                View

                                            </a>


                                            <!-- DELETE -->
                                            <form action="<?= site_url('dashboard/receipts/delete/' . $receipt['id']) ?>"
                                                method="post"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete Receipt #<?= esc($receipt['id']) ?>? This action cannot be undone.');">

                                                <?= csrf_field() ?>

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger">

                                                    <i class="bi bi-trash me-1"></i>
                                                    Delete

                                                </button>

                                            </form>

                                        </div>

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


<?= view('dashboard/layout/footer') ?>


</div>

<!-- ==========================================
     SCRIPTS
     ========================================== -->

<script>

    // ------------------------------------------
    // Flash Messages
    // ------------------------------------------

    setTimeout(function () {

        const messages = document.querySelectorAll('.flash-message');

        messages.forEach(function (message) {

            message.style.opacity = '0';

            setTimeout(function () {
                message.remove();
            }, 500);

        });

    }, 5000);


    // ------------------------------------------
    // Receipt DataTable
    // ------------------------------------------

    $(document).ready(function () {

    $('#receiptTable').DataTable({

        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],

        order: [[2, 'desc']],

        responsive: true,

        autoWidth: false,

        columnDefs: [
            {
                targets: 3,
                orderable: false,
                searchable: false
            }
        ],

        language: {
            emptyTable: "No receipts uploaded yet."
        }

    });

});


    // ------------------------------------------
    // File validation
    // ------------------------------------------

    document.addEventListener('DOMContentLoaded', function () {

        const receiptInput = document.getElementById('receipt');

        if (receiptInput) {

            receiptInput.addEventListener('change', function () {

                const file = this.files[0];

                if (!file) {
                    return;
                }

                const allowedTypes = [
                    'image/jpeg'
                ];

                const maxSize = 5 * 1024 * 1024;

                if (!allowedTypes.includes(file.type)) {

                    alert('Only JPG/JPEG files are allowed.');

                    this.value = '';

                    return;
                }

                if (file.size > maxSize) {

                    alert('Receipt image must not exceed 5MB.');

                    this.value = '';

                    return;
                }

            });

        }

    });

</script>

</body>

</html>
