
  <?= view('dashboard/layout/head') ?>
<body>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="flash-message" style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%); z-index: 1200; width: min(90vw, 520px); opacity: 1; transition: opacity 0.5s ease;">
      <div style="background: #ffe4e6; color: #991b1b; border: 1px solid #fecdd3; padding: 12px 16px; border-radius: 10px; font-weight: 600;">
        <?= esc(session()->getFlashdata('error')) ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('success')): ?>
    <div class="flash-message" style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%); z-index: 1200; width: min(90vw, 520px); opacity: 1; transition: opacity 0.5s ease;">
      <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 10px; font-weight: 600;">
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

    <!-- START: Dashboard Header Banner -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">LABLINE INC.</p>
      </div>
      <!-- <button class="btn-date-picker" type="button" id="date-picker-trigger">
        <i class="bi bi-calendar4-event"></i>
        <span id="selected-date-range">January 12, 2026 - January 23, 2026</span>
        <i class="bi bi-chevron-down ms-1"></i>
      </button>
    </div> -->
    <!-- END: Dashboard Header Banner -->

    <!-- START: Main Layout Grid (2 Columns: Dashboard + Performance Pane) -->
    <div class="row g-4">

      <!-- TOP AREA: Quick Info Stat Cards Row (Full Width) -->
      <div class="col-12">
        <div class="row g-4">
          <!-- Stat Card 1: Green Alert Banner -->




          <div class="col-md-4">
            <div class="card card-stat d-flex flex-column justify-content-between">
              <div>
                <div class="card-header">
                  <span class="stat-label">Total Province</span>
                  <div class="dropdown">
                    <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                      aria-label="More Options" id="btn-more-total-area">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                      <li><a class="dropdown-item" href="#"><i class="bi bi-arrow-repeat"></i> Refresh</a></li>
                    </ul>
                  </div>
                </div>
                <div class="stat-value"><?= number_format($total_data ?? 0) ?></div>
                <div class="trend-badge trend-up">
                  <i class="bi bi-database"></i>
                  <span>Unique provinces in tb_data.Province</span>
                </div>
              </div>
            </div>
          </div>


          <!-- Stat Card 2: Total Clinics -->
          <div class="col-md-4">
            <div class="card card-stat d-flex flex-column justify-content-between">
              <div>
                <div class="card-header">
                  <span class="stat-label">Total Clinics</span>
                  <div class="dropdown">
                    <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                      aria-label="More Options" id="btn-more-machine">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                      <li><a class="dropdown-item" href="#"><i class="bi bi-arrow-repeat"></i> Refresh</a></li>
                    </ul>
                  </div>
                </div>
                <div class="stat-value"><?= number_format($total_machine ?? 0) ?></div>
                <div class="trend-badge trend-up">
                  <i class="bi bi-hospital"></i>
                  <span>Unique clinic names in tb_data.Clinic_name</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Stat Card 3: All Machine -->
          <div class="col-md-4">
            <div class="card card-stat d-flex flex-column justify-content-between">
              <div>
                <div class="card-header">
                  <span class="stat-label">Machine</span>
                  <div class="dropdown">
                    <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                      aria-label="More Options" id="btn-more-model">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                      <?php foreach ($machine_counts ?? [] as $machine): ?>
                        <li>
                          <button
                            type="button"
                            class="dropdown-item machine-count-item"
                            data-machine="<?= esc($machine['Machine']) ?>"
                            data-total="<?= (int) $machine['total'] ?>"
                          >
                            <i class="bi bi-box"></i>
                            <?= esc($machine['Machine']) ?> (<?= number_format((int) $machine['total']) ?>)
                          </button>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
                <div class="stat-value" id="all-machine-total" data-default-value="<?= (int) count($machine_counts ?? []) ?>"><?= number_format(count($machine_counts ?? [])) ?></div>
                <div class="trend-badge trend-up" id="all-machine-trend">
                  <i class="bi bi-gear"></i>
                  <span>Machine types in tb_data</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END: TOP AREA -->

    
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
          <div>
            <h2 class="card-title mb-0">Clinic Records</h2>
          </div>

          <div class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto align-items-md-center justify-content-md-end">
            <button type="button"
                    class="btn btn-danger btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#canceledaccoun">
                Cancel Account
            </button>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addRecordModal">
              Add Machine
            </button>

            <form method="post" action="<?= site_url('dashboard/import') ?>" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
              <?= csrf_field() ?>
              <input type="file" name="excel_file" accept=".xlsx,.csv" class="form-control form-control-sm" required>
              <button type="submit" class="btn btn-success btn-sm">Import Excel</button>
            </form>

            <form method="get" action="<?= site_url('dashboard') ?>" class="d-flex gap-2 w-100 w-md-auto" style="max-width: 420px;">
              <input
                type="text"
                name="search"
                value="<?= esc($search ?? '') ?>"
                class="form-control"
                placeholder="Search clinic, machine, model..."
              >
              <button type="submit" class="btn btn-primary">Search</button>
              <?php if (!empty($search)): ?>
                <a href="<?= site_url('dashboard') ?>" class="btn btn-outline-secondary">Reset</a>
              <?php endif; ?>
            </form>
          </div>
        </div>

        <div class="card-body p-0">

          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Clinic Name</th>
                  <th>Address</th>
                  <th>Province</th>
                  <th>Machine</th>
                  <th>Model</th>
                  <th>Installed Date</th>
                  <th>SN</th>
                  <th>DR Number</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
                <tbody>
                    <?php if (!empty($records)): ?>

                        <?php foreach ($records as $index => $row): ?>

                            <?php
                            $rowNumber =
                                ((int) ($page ?? 1) - 1) *
                                (int) ($per_page ?? 10) +
                                $index +
                                1;

                            $recordId = (int) ($row['id'] ?? 0);

                            $contractId = (int) ($row['contract_id'] ?? 0);

                            $status = strtoupper(
                                trim((string) ($row['status'] ?? ''))
                            );
                            ?>

                            <tr class="<?= $status === 'I' ? 'table-danger' : '' ?>">

                                <td><?= esc($rowNumber) ?></td>

                                <td><?= esc($row['Clinic_name'] ?? '') ?></td>

                                <td><?= esc($row['Address'] ?? '') ?></td>

                                <td><?= esc($row['Province'] ?? '') ?></td>

                                <td><?= esc($row['Machine'] ?? '') ?></td>

                                <td><?= esc($row['Model'] ?? '') ?></td>

                                <td><?= esc($row['Installed_date'] ?? '') ?></td>

                                <td><?= esc($row['SN'] ?? '') ?></td>

                                <td><?= esc($row['DR_Number'] ?? '') ?></td>

                                <td class="text-center">

                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">

                                        <!-- ==================================================
                                            CONTRACT
                                            ================================================== -->

                                        <?php if ($contractId > 0): ?>

                                            <!-- VIEW CONTRACT -->
                                            <button
                                                type="button"
                                                class="btn btn-outline-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewContractModal<?= $recordId ?>"
                                                title="View Contract">

                                                <i class="bi bi-file-earmark-text"></i>
                                                View

                                            </button>

                                        <?php else: ?>

                                            <!-- NO CONTRACT -->
                                            <span
                                                class="badge bg-warning text-dark"
                                                title="No contract attached">

                                                <i class="bi bi-file-earmark-x"></i>
                                                No Contract Attached

                                            </span>

                                        <?php endif; ?>


                                        <!-- ==================================================
                                            ATTACH / REPLACE CONTRACT
                                            ================================================== -->

                                        <button
                                            type="button"
                                            class="btn btn-outline-success btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#contractModal<?= $recordId ?>"
                                            title="<?= $contractId > 0 ? 'Replace Contract' : 'Attach Contract' ?>">

                                            <i class="bi bi-paperclip"></i>

                                            <?= $contractId > 0 ? 'Replace' : 'Attach' ?>

                                        </button>


                                        <!-- ==================================================
                                            EDIT
                                            ================================================== -->

                                        <button
                                            type="button"
                                            class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editRecordModal<?= $recordId ?>">

                                            <i class="bi bi-pencil"></i>
                                            Edit

                                        </button>


                                        <!-- ==================================================
                                            DELETE
                                            ================================================== -->

                                        <a
                                            href="<?= site_url('dashboard') ?>?delete=<?= $recordId ?>"
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Delete this record?');">

                                            <i class="bi bi-trash"></i>
                                            Delete

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                No records found.
                            </td>
                        </tr>

                    <?php endif; ?>
                </tbody>
            </table>
          </div>

          <?php if (($total_pages ?? 1) > 1): ?>
            <div class="d-flex align-items-center p-3 border-top">
              <div class="text-muted small">
                Showing <?= count($records ?? []) ?> of <?= (int) ($total_rows ?? 0) ?> records
              </div>

              <nav aria-label="Pagination" class="ms-auto">
                <ul class="pagination pagination-sm mb-0">
                  <li class="page-item <?= ($page ?? 1) <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= site_url('dashboard') ?>?search=<?= urlencode($search ?? '') ?>&page=<?= max(1, ($page ?? 1) - 1) ?>">Previous</a>
                  </li>

                  <?php
                    $curPage = (int) ($page ?? 1);
                    $totalPages = (int) ($total_pages ?? 1);
                    $maxLinks = 5;
                    $start = max(1, $curPage - (int) floor($maxLinks / 2));
                    $end = min($totalPages, $start + $maxLinks - 1);
                    if ($end - $start + 1 < $maxLinks) {
                      $start = max(1, $end - $maxLinks + 1);
                    }
                    for ($i = $start; $i <= $end; $i++):
                  ?>
                    <li class="page-item <?= ($i == ($page ?? 1)) ? 'active' : '' ?>">
                      <a class="page-link" href="<?= site_url('dashboard') ?>?search=<?= urlencode($search ?? '') ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                  <?php endfor; ?>

                  <li class="page-item <?= ($page ?? 1) >= ($total_pages ?? 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= site_url('dashboard') ?>?search=<?= urlencode($search ?? '') ?>&page=<?= min(($total_pages ?? 1), ($page ?? 1) + 1) ?>">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    </div>

    
    <!-- END: Main Layout Grid -->

    <?php
$database = db_connect();
?>

<?php if (!empty($records)): ?>

    <?php foreach ($records as $row): ?>

        <?php
        $recordId = (int) ($row['id'] ?? 0);
        $contractId = (int) ($row['contract_id'] ?? 0);

        $contractLocation = '';
        $contractUrl = '';
        $contractExtension = '';
        ?>

        <?php if ($contractId > 0): ?>

            <?php
            // --------------------------------------------------
            // GET CONTRACT
            // --------------------------------------------------

            $contractRecord = $database->table('tb_contract')
                ->select('id, location')
                ->where('id', $contractId)
                ->get()
                ->getRowArray();

            if ($contractRecord) {

                $contractLocation = trim(
                    (string) ($contractRecord['location'] ?? '')
                );

                if ($contractLocation !== '') {

                    $contractUrl = base_url(
                        ltrim($contractLocation, '/\\')
                    );

                    $contractExtension = strtolower(
                        pathinfo(
                            $contractLocation,
                            PATHINFO_EXTENSION
                        )
                    );
                }
            }
            ?>

            <!-- ==================================================
                 VIEW CONTRACT MODAL
                 ================================================== -->

            <div
                class="modal fade"
                id="viewContractModal<?= $recordId ?>"
                tabindex="-1"
                aria-labelledby="viewContractModalLabel<?= $recordId ?>"
                aria-hidden="true">

                <div
                    class="modal-dialog modal-xl modal-dialog-centered">

                    <div class="modal-content">

                        <!-- HEADER -->
                        <div class="modal-header">

                            <h5
                                class="modal-title"
                                id="viewContractModalLabel<?= $recordId ?>">

                                <i class="bi bi-file-earmark-text"></i>
                                Contract

                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            </button>

                        </div>


                        <!-- BODY -->
                        <div class="modal-body p-0">

                            <?php if ($contractUrl !== ''): ?>

                                <?php if ($contractExtension === 'pdf'): ?>

                                    <!-- PDF -->
                                    <iframe
                                        src="<?= esc($contractUrl) ?>"
                                        style="
                                            width: 100%;
                                            height: 75vh;
                                            border: none;
                                        "
                                        title="Contract PDF">
                                    </iframe>

                                <?php elseif (
                                    in_array(
                                        $contractExtension,
                                        ['jpg', 'jpeg', 'png'],
                                        true
                                    )
                                ): ?>

                                    <!-- IMAGE -->
                                    <div
                                        class="d-flex justify-content-center align-items-center p-3"
                                        style="
                                            min-height: 70vh;
                                            background: #f8f9fa;
                                        ">

                                        <img
                                            src="<?= esc($contractUrl) ?>"
                                            alt="Contract"
                                            class="img-fluid"
                                            style="
                                                max-width: 100%;
                                                max-height: 70vh;
                                                object-fit: contain;
                                            ">

                                    </div>

                                <?php else: ?>

                                    <!-- UNKNOWN FILE TYPE -->
                                    <div class="p-5 text-center">

                                        <i
                                            class="bi bi-file-earmark-x"
                                            style="font-size: 3rem;">
                                        </i>

                                        <h5 class="mt-3">
                                            File cannot be previewed
                                        </h5>

                                        <p class="text-muted">
                                            This file type cannot be displayed
                                            inside the browser.
                                        </p>

                                        <a
                                            href="<?= esc($contractUrl) ?>"
                                            target="_blank"
                                            class="btn btn-primary">

                                            <i class="bi bi-box-arrow-up-right"></i>
                                            Open Contract

                                        </a>

                                    </div>

                                <?php endif; ?>

                            <?php else: ?>

                                <!-- FILE NOT FOUND -->
                                <div class="p-5 text-center">

                                    <i
                                        class="bi bi-file-earmark-x text-warning"
                                        style="font-size: 3rem;">
                                    </i>

                                    <h5 class="mt-3">
                                        Contract File Not Found
                                    </h5>

                                    <p class="text-muted mb-0">
                                        The contract record exists, but no
                                        file location was found.
                                    </p>

                                </div>

                            <?php endif; ?>

                        </div>


                        <!-- FOOTER -->
                        <div class="modal-footer">

                            <?php if ($contractUrl !== ''): ?>

                                <a
                                    href="<?= esc($contractUrl) ?>"
                                    target="_blank"
                                    class="btn btn-outline-primary">

                                    <i class="bi bi-box-arrow-up-right"></i>
                                    Open in New Tab

                                </a>

                            <?php endif; ?>

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

        <?php endif; ?>

    <?php endforeach; ?>

<?php endif; ?>

<?php if (!empty($records)): ?>

    <?php foreach ($records as $row): ?>

        <?php
        $recordId = (int) ($row['id'] ?? 0);
        $contractId = (int) ($row['contract_id'] ?? 0);
        ?>

        <div
            class="modal fade"
            id="contractModal<?= $recordId ?>"
            tabindex="-1"
            aria-labelledby="contractModalLabel<?= $recordId ?>"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <form
                        method="post"
                        action="<?= site_url('dashboard/attach-contract') ?>"
                        enctype="multipart/form-data">

                        <?= csrf_field() ?>

                        <input
                            type="hidden"
                            name="id"
                            value="<?= $recordId ?>">

                        <div class="modal-header">

                            <h5
                                class="modal-title"
                                id="contractModalLabel<?= $recordId ?>">

                                <i class="bi bi-file-earmark-text me-2"></i>
                                <?= $contractId > 0 ? 'Replace Contract' : 'Attach Contract' ?>

                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            </button>

                        </div>

                        <div class="modal-body">

                            <!-- CLINIC -->
                            <div class="mb-3">

                                <label class="form-label">
                                    Clinic
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= esc($row['Clinic_name'] ?? '') ?>"
                                    readonly>

                            </div>

                            <!-- CURRENT CONTRACT ID -->
                            <!-- <div class="mb-3">

                                <label class="form-label">
                                    Current Contract ID
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= $contractId > 0 ? $contractId : 'No contract attached' ?>"
                                    readonly>

                            </div> -->

                            <?php if ($contractId > 0): ?>

                                <div class="alert alert-info">

                                    <i class="bi bi-info-circle me-1"></i>

                                    This record already has contract
                                    <strong>#<?= $contractId ?></strong>.

                                    <br>

                                    Uploading a new file will create a new
                                    contract record and update
                                    <code>tb_data.contract_id</code>.

                                </div>

                            <?php else: ?>

                                <div class="alert alert-warning">

                                    <i class="bi bi-exclamation-triangle me-1"></i>

                                    No contract is currently attached.

                                    <br>

                                    Upload a contract below to create a new
                                    record in <code>tb_contract</code>.

                                </div>

                            <?php endif; ?>


                            <!-- FILE -->
                            <div class="mb-3">

                                <label
                                    for="contract_file<?= $recordId ?>"
                                    class="form-label">

                                    Contract File
                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="file"
                                    name="contract_file"
                                    id="contract_file<?= $recordId ?>"
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

                                Cancel

                            </button>

                            <button
                                type="submit"
                                class="btn btn-success">

                                <i class="bi bi-upload me-1"></i>

                                <?= $contractId > 0
                                    ? 'Replace Contract'
                                    : 'Upload Contract'
                                ?>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

<?php endif; ?>


    <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form method="post" action="<?= site_url('dashboard/save') ?>">
            <?= csrf_field() ?>
            <div class="modal-header">
              <h5 class="modal-title" id="addRecordModalLabel">Add Machine</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Clinic Name</label>
                  <input type="text" name="Clinic_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Address</label>
                  <input type="text" name="Address" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Province</label>
                  <input type="text" name="Province" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Machine</label>
                  <input type="text" name="Machine" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Model</label>
                  <input type="text" name="Model" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Installed Date</label>
                  <input type="date" name="Installed_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">SN</label>
                  <input type="text" name="SN" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">DR Number</label>
                  <input type="text" name="DR_Number" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Machine</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php if (!empty($records)): ?>
      <?php foreach ($records as $row): ?>
        <?php $recordId = (int) ($row['id'] ?? 0); ?>
        <div class="modal fade" id="editRecordModal<?= $recordId ?>" tabindex="-1" aria-labelledby="editRecordModalLabel<?= $recordId ?>" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <form method="post" action="<?= site_url('dashboard/update') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $recordId ?>">
                <div class="modal-header">
                  <h5 class="modal-title" id="editRecordModalLabel<?= $recordId ?>">Edit Machine</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Clinic Name</label>
                      <input type="text" name="Clinic_name" class="form-control" value="<?= esc($row['Clinic_name'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Address</label>
                      <input type="text" name="Address" class="form-control" value="<?= esc($row['Address'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Province</label>
                      <input type="text" name="Province" class="form-control" value="<?= esc($row['Province'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Machine</label>
                      <input type="text" name="Machine" class="form-control" value="<?= esc($row['Machine'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Model</label>
                      <input type="text" name="Model" class="form-control" value="<?= esc($row['Model'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Installed Date</label>
                      <input type="date" name="Installed_date" class="form-control" value="<?= esc($row['Installed_date'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">SN</label>
                      <input type="text" name="SN" class="form-control" value="<?= esc($row['SN'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">DR Number</label>
                      <input type="text" name="DR_Number" class="form-control" value="<?= esc($row['DR_Number'] ?? '') ?>" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update Machine</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>







<!-- ==========================================================
     CANCEL ACCOUNT MODAL
     ========================================================== -->

<div class="modal fade"
     id="canceledaccoun"
     tabindex="-1"
     aria-labelledby="canceledaccounLabel"
     aria-hidden="true">


<div class="modal-dialog modal-lg modal-dialog-centered">

    <div class="modal-content">

        <!-- ==================================================
             MODAL HEADER
             ================================================== -->
        <div class="modal-header">

            <h5 class="modal-title" id="canceledaccounLabel">
                <i class="bi bi-x-circle me-2"></i>
                Cancel Account
            </h5>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
            </button>

        </div>


        <!-- ==================================================
             FORM
             ================================================== -->
        <form action="<?= base_url('cancelled-account/save') ?>"
              method="post"
              id="cancelledAccountForm">

            <?= csrf_field() ?>
            <!-- ======================================================
              HIDDEN TB_DATA ID
              ====================================================== -->
          <input type="hidden"
                name="id"
                id="cancelled_account_id"
                value="">

            <div class="modal-body">

                <div class="row g-3">

                    <!-- ======================================
                         ACCOUNT
                         ====================================== -->
                    <div class="col-md-6">

                        <label for="account" class="form-label">
                            Account
                            <span class="text-danger">*</span>
                        </label>

                        <select name="account"
                                id="account"
                                class="form-select select2-account"
                                style="width: 100%;"
                                required>

                            <option value="">
                                -- Select Account --
                            </option>

                            <?php if (!empty($clinicMap)): ?>

                                <?php foreach ($clinicMap as $clinicName => $info): ?>

                                    <?php
                                    $machinesJson = htmlspecialchars(
                                        json_encode(
                                            $info['machines'] ?? [],
                                            JSON_UNESCAPED_UNICODE
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );

                                    $address = trim(
                                        (string) ($info['address'] ?? '')
                                    );

                                    $province = trim(
                                        (string) ($info['province'] ?? '')
                                    );
                                    ?>

                                    <option
                                        value="<?= esc($info['id'] ?? '') ?>"
                                        data-clinic="<?= esc($clinicName) ?>"
                                        data-address="<?= esc($address) ?>"
                                        data-province="<?= esc($province) ?>"
                                        data-machines="<?= $machinesJson ?>"
                                    >
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


                    <!-- ======================================
                         ADDRESS
                         ====================================== -->
                    <div class="col-md-6">

                        <label for="account_address"
                               class="form-label">

                            Address
                            <span class="text-danger">*</span>

                        </label>

                        <input type="text"
                               name="address"
                               id="account_address"
                               class="form-control"
                               placeholder="Address will be filled automatically"
                               readonly
                               required>

                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Address is automatically loaded from the selected account.
                        </div>

                    </div>


                    <!-- ======================================
                            MACHINE
                            Machines available for selected Account
                            ====================================== -->
                        <div class="col-md-6">

                            <label for="cancelled_machine" class="form-label">
                                Machine
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="machine"
                                id="cancelled_machine"
                                class="form-select"
                                required
                                disabled
                            >
                                <option value="">
                                    -- Select Account First --
                                </option>
                            </select>

                            <div class="form-text">
                                <i class="bi bi-cpu me-1"></i>
                                Select the machine belonging to the selected account.
                            </div>

                        </div>
                                            

                    <!-- ======================================
                         DATE FOUND OUT
                         ====================================== -->
                    <div class="col-md-6">

                        <label for="date_found_out"
                               class="form-label">

                            Date Found Out
                            <span class="text-danger">*</span>

                        </label>

                        <input type="date"
                               name="date_found_out"
                               id="date_found_out"
                               class="form-control"
                               required>

                    </div>


                    <!-- ======================================
                         DATE CONFIRMED
                         ====================================== -->
                    <div class="col-md-6">

                        <label for="date_confirmed"
                               class="form-label">

                            Date Confirmed From Manufacturer
                            <span class="text-danger">*</span>

                        </label>

                        <input type="date"
                               name="date_confirmed"
                               id="date_confirmed"
                               class="form-control"
                               required>

                    </div>


                    <!-- ======================================
                         PERSONNEL
                         ====================================== -->
                    <div class="col-md-6">

                        <label for="cancelled_personnel"
                               class="form-label">

                            Personnel
                            <span class="text-danger">*</span>

                        </label>

                        <input type="text"
                               name="personnel"
                               id="cancelled_personnel"
                               class="form-control"
                               placeholder="Enter personnel"
                               required>

                    </div>


                    <!-- ======================================
                         SUPPLIER
                         ====================================== -->
                    <div class="col-md-6">

                        <label for="cancelled_supplier"
                               class="form-label">

                            Supplier
                            <span class="text-danger">*</span>

                        </label>

                        <input type="text"
                               name="supplier"
                               id="cancelled_supplier"
                               class="form-control"
                               placeholder="Enter supplier"
                               required>

                    </div>


                    <!-- ======================================
                         REASON
                         ====================================== -->
                    <div class="col-12">

                        <label for="cancelled_reason"
                               class="form-label">

                            Reason
                            <span class="text-danger">*</span>

                        </label>

                        <textarea name="reason"
                                  id="cancelled_reason"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Enter reason for account cancellation"
                                  required></textarea>

                    </div>

                </div>

            </div>


            <!-- ==================================================
                 MODAL FOOTER
                 ================================================== -->
            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                    <i class="bi bi-x-circle me-1"></i>
                    Cancel

                </button>


                <button type="submit"
                        class="btn btn-success">

                    <i class="bi bi-check-circle me-1"></i>
                    Save Cancel Account

                </button>

            </div>

        </form>

    </div>

</div>
```

</div>

<?= view('dashboard/layout/footer') ?>


<script>
    /* ==========================================================
       FLASH MESSAGE AUTO HIDE
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
       DOM READY
       ========================================================== */
    document.addEventListener('DOMContentLoaded', function () {


        /* ==========================================================
           DASHBOARD MACHINE COUNT
           ========================================================== */
        const statValue =
            document.getElementById('all-machine-total');

        const trendBadge =
            document.getElementById('all-machine-trend');


        document
            .querySelectorAll('.machine-count-item')
            .forEach(function (button) {

                button.addEventListener('click', function () {

                    const total =
                        Number(button.dataset.total || 0);

                    const machineName =
                        button.dataset.machine || 'Machine';


                    if (statValue) {

                        statValue.textContent =
                            new Intl.NumberFormat().format(total);

                    }


                    if (trendBadge) {

                        const icon =
                            trendBadge.querySelector('i');

                        const text =
                            trendBadge.querySelector('span');


                        if (icon) {

                            icon.className =
                                'bi bi-box';

                        }


                        if (text) {

                            text.textContent =
                                machineName + ' total';

                        }

                    }


                    const dropdownElement =
                        button.closest('.dropdown');


                    if (
                        dropdownElement &&
                        window.bootstrap &&
                        bootstrap.Dropdown
                    ) {

                        const toggleButton =
                            dropdownElement.querySelector(
                                '[data-bs-toggle="dropdown"]'
                            );


                        if (toggleButton) {

                            bootstrap.Dropdown
                                .getOrCreateInstance(toggleButton)
                                .hide();

                        }

                    }

                });

            });


        /* ==========================================================
           CANCELLED ACCOUNT MODAL
           ========================================================== */

        const cancelledModal =
            document.getElementById('canceledaccoun');

        const cancelledForm =
            document.getElementById('cancelledAccountForm');


        /*
         * All fields are searched inside the
         * Cancelled Account modal.
         */
        const modalAccount =
            cancelledModal
                ? cancelledModal.querySelector('#account')
                : null;


        /* ==========================================================
           HIDDEN TB_DATA ID
           ========================================================== */
        const modalAccountId =
            cancelledModal
                ? cancelledModal.querySelector(
                    '#cancelled_account_id'
                )
                : null;


        /* ==========================================================
           ADDRESS
           ========================================================== */
        const modalAddress =
            cancelledModal
                ? cancelledModal.querySelector(
                    '#account_address'
                )
                : null;


        /* ==========================================================
           MACHINE DROPDOWN
           ========================================================== */
        const modalMachine =
            cancelledModal
                ? cancelledModal.querySelector(
                    '#cancelled_machine'
                )
                : null;


        /* ==========================================================
           DATES
           ========================================================== */
        const dateFoundOut =
            cancelledModal
                ? cancelledModal.querySelector(
                    '#date_found_out'
                )
                : null;


        const dateConfirmed =
            cancelledModal
                ? cancelledModal.querySelector(
                    '#date_confirmed'
                )
                : null;


        /* ==========================================================
           FUNCTION: FILL ACCOUNT ADDRESS
           ========================================================== */
        function fillAccountAddress() {

            if (!modalAccount || !modalAddress) {
                return;
            }


            const selectedOption =
                modalAccount.options[
                    modalAccount.selectedIndex
                ];


            /*
             * Nothing selected.
             */
            if (
                !selectedOption ||
                !selectedOption.value
            ) {

                modalAddress.value = '';

                modalAddress.classList.remove(
                    'is-valid',
                    'is-invalid'
                );

                return;
            }


            /*
             * Get address from selected option.
             */
            const address =
                selectedOption.dataset.address ||
                selectedOption.getAttribute(
                    'data-address'
                ) ||
                '';


            modalAddress.value = address;


            /*
             * Visual feedback.
             */
            if (address.trim() !== '') {

                modalAddress.classList.remove(
                    'is-invalid'
                );

                modalAddress.classList.add(
                    'is-valid'
                );

            } else {

                modalAddress.classList.remove(
                    'is-valid'
                );

            }

        }


        /* ==========================================================
           FUNCTION: SET HIDDEN TB_DATA ID
           ========================================================== */
        function setCancelledAccountId() {

            if (!modalAccountId || !modalAccount) {
                return;
            }


            const selectedOption =
                modalAccount.options[
                    modalAccount.selectedIndex
                ];


            if (
                selectedOption &&
                selectedOption.value
            ) {

                /*
                 * The option value contains tb_data.id.
                 */
                modalAccountId.value =
                    selectedOption.value;

            } else {

                modalAccountId.value = '';

            }

        }


        /* ==========================================================
           FUNCTION: LOAD MACHINES FOR SELECTED ACCOUNT
           ========================================================== */
        function loadCancelledMachines() {

            if (!modalAccount || !modalMachine) {
                return;
            }


            /*
             * Clear current machine list.
             */
            modalMachine.innerHTML = '';


            /*
             * Get selected account.
             */
            const selectedOption =
                modalAccount.options[
                    modalAccount.selectedIndex
                ];


            /*
             * No account selected.
             */
            if (
                !selectedOption ||
                !selectedOption.value
            ) {

                modalMachine.innerHTML = `
                    <option value="">
                        -- Select Account First --
                    </option>
                `;

                modalMachine.disabled = true;

                return;
            }


            /*
             * Get machines from:
             *
             * data-machines="[...]"
             */
            const machinesData =
                selectedOption.getAttribute(
                    'data-machines'
                ) || '';


            let machines = [];


            /*
             * Decode JSON.
             */
            if (machinesData) {

                try {

                    machines =
                        JSON.parse(machinesData);

                } catch (error) {

                    console.error(
                        'Unable to read account machines:',
                        error
                    );

                    machines = [];

                }

            }


            /*
             * No machines found.
             */
            if (
                !Array.isArray(machines) ||
                machines.length === 0
            ) {

                modalMachine.innerHTML = `
                    <option value="">
                        -- No Machine Found --
                    </option>
                `;

                modalMachine.disabled = true;

                return;
            }


            /*
             * Default option.
             */
            modalMachine.innerHTML = `
                <option value="">
                    -- Select Machine --
                </option>
            `;


            /*
             * Add machines.
             */
            machines.forEach(function (machine) {

                let machineName = '';


                /*
                 * Simple string:
                 *
                 * "Mindray BC-20"
                 */
                if (typeof machine === 'string') {

                    machineName = machine;

                }


                /*
                 * Object:
                 *
                 * {
                 *     Machine: "Mindray BC-20"
                 * }
                 */
                else if (
                    typeof machine === 'object' &&
                    machine !== null
                ) {

                    machineName =
                        machine.Machine ??
                        machine.machine ??
                        machine.name ??
                        machine.model ??
                        '';

                }


                machineName =
                    String(machineName).trim();


                /*
                 * Skip empty machine names.
                 */
                if (!machineName) {
                    return;
                }


                const option =
                    document.createElement('option');


                option.value =
                    machineName;


                option.textContent =
                    machineName;


                modalMachine.appendChild(option);

            });


            /*
             * Enable machine dropdown
             * if machines were added.
             */
            if (modalMachine.options.length > 1) {

                modalMachine.disabled = false;

            } else {

                modalMachine.innerHTML = `
                    <option value="">
                        -- No Machine Found --
                    </option>
                `;

                modalMachine.disabled = true;

            }

        }


        /* ==========================================================
           SELECT2 ACCOUNT DROPDOWN
           ========================================================== */
        if (
            modalAccount &&
            window.jQuery &&
            typeof $.fn.select2 === 'function'
        ) {

            const $account =
                $(modalAccount);

            const $modal =
                $(cancelledModal);


            /*
             * Initialize Select2 only once.
             */
            if (
                !$account.hasClass(
                    'select2-hidden-accessible'
                )
            ) {

                $account.select2({

                    dropdownParent: $modal,

                    width: '100%',

                    placeholder:
                        '-- Select Account --',

                    allowClear: true

                });

            }


            /* ======================================================
               SELECT2 SELECT EVENT
               ====================================================== */
            $account.on(
                'select2:select',
                function (event) {

                    const selectedOption =
                        event.params &&
                        event.params.data
                            ? event.params.data.element
                            : null;


                    if (!selectedOption) {
                        return;
                    }


                    /* ==============================================
                       SET TB_DATA ID
                       ============================================== */
                    const accountId =
                        selectedOption.value || '';


                    if (modalAccountId) {

                        modalAccountId.value =
                            accountId;

                    }


                    /* ==============================================
                       GET ADDRESS
                       ============================================== */
                    const address =
                        selectedOption.dataset.address ||
                        selectedOption.getAttribute(
                            'data-address'
                        ) ||
                        '';


                    if (modalAddress) {

                        modalAddress.value =
                            address;


                        if (address.trim() !== '') {

                            modalAddress.classList.remove(
                                'is-invalid'
                            );

                            modalAddress.classList.add(
                                'is-valid'
                            );

                        } else {

                            modalAddress.classList.remove(
                                'is-valid'
                            );

                        }

                    }


                    /* ==============================================
                       LOAD ACCOUNT MACHINES
                       ============================================== */
                    loadCancelledMachines();

                }
            );


            /* ======================================================
               SELECT2 CHANGE EVENT
               ====================================================== */
            $account.on(
                'change',
                function () {

                    /*
                     * Update hidden tb_data.id.
                     */
                    setCancelledAccountId();


                    /*
                     * Update address.
                     */
                    fillAccountAddress();


                    /*
                     * Load machines.
                     */
                    loadCancelledMachines();

                }
            );


            /* ======================================================
               SELECT2 CLEAR EVENT
               ====================================================== */
            $account.on(
                'select2:clear',
                function () {

                    /*
                     * Clear hidden tb_data.id.
                     */
                    if (modalAccountId) {

                        modalAccountId.value = '';

                    }


                    /*
                     * Clear address.
                     */
                    if (modalAddress) {

                        modalAddress.value = '';

                        modalAddress.classList.remove(
                            'is-valid',
                            'is-invalid'
                        );

                    }


                    /*
                     * Clear machines.
                     */
                    if (modalMachine) {

                        modalMachine.innerHTML = `
                            <option value="">
                                -- Select Account First --
                            </option>
                        `;

                        modalMachine.disabled = true;

                    }

                }
            );

        } else if (modalAccount) {

            /*
             * Fallback if Select2 is not loaded.
             */
            modalAccount.addEventListener(
                'change',
                function () {

                    /*
                     * Set hidden tb_data.id.
                     */
                    setCancelledAccountId();


                    /*
                     * Fill address.
                     */
                    fillAccountAddress();


                    /*
                     * Load machines.
                     */
                    loadCancelledMachines();

                }
            );

        }


        /* ==========================================================
           MACHINE CHANGE
           ========================================================== */
        if (modalMachine) {

            modalMachine.addEventListener(
                'change',
                function () {

                    if (this.value) {

                        this.classList.remove(
                            'is-invalid'
                        );

                        this.classList.add(
                            'is-valid'
                        );

                    } else {

                        this.classList.remove(
                            'is-valid'
                        );

                    }

                }
            );

        }


        /* ==========================================================
           MODAL OPEN
           ========================================================== */
        if (cancelledModal) {

            cancelledModal.addEventListener(
                'show.bs.modal',
                function () {

                    /*
                     * Date Found Out = today.
                     */
                    if (
                        dateFoundOut &&
                        !dateFoundOut.value
                    ) {

                        const today =
                            new Date()
                                .toISOString()
                                .split('T')[0];


                        dateFoundOut.value =
                            today;

                    }


                    /*
                     * Date Confirmed starts empty.
                     */
                    if (dateConfirmed) {

                        dateConfirmed.value = '';

                    }


                    /*
                     * Make sure machine dropdown
                     * is ready for the selected account.
                     */
                    if (
                        modalAccount &&
                        modalAccount.value
                    ) {

                        loadCancelledMachines();

                    } else if (modalMachine) {

                        modalMachine.innerHTML = `
                            <option value="">
                                -- Select Account First --
                            </option>
                        `;

                        modalMachine.disabled = true;

                    }

                }
            );


            /* ======================================================
               MODAL CLOSED
               ====================================================== */
            cancelledModal.addEventListener(
                'hidden.bs.modal',
                function () {

                    /*
                     * Reset form.
                     */
                    if (cancelledForm) {

                        cancelledForm.reset();

                    }


                    /*
                     * Clear hidden tb_data.id.
                     */
                    if (modalAccountId) {

                        modalAccountId.value = '';

                    }


                    /*
                     * Reset Select2.
                     */
                    if (
                        modalAccount &&
                        window.jQuery &&
                        typeof $.fn.select2 === 'function' &&
                        $(modalAccount).hasClass(
                            'select2-hidden-accessible'
                        )
                    ) {

                        $(modalAccount)
                            .val(null)
                            .trigger('change');

                    }


                    /*
                     * Clear address.
                     */
                    if (modalAddress) {

                        modalAddress.value = '';

                        modalAddress.classList.remove(
                            'is-valid',
                            'is-invalid'
                        );

                    }


                    /*
                     * Reset machine dropdown.
                     */
                    if (modalMachine) {

                        modalMachine.innerHTML = `
                            <option value="">
                                -- Select Account First --
                            </option>
                        `;

                        modalMachine.disabled = true;

                        modalMachine.classList.remove(
                            'is-valid',
                            'is-invalid'
                        );

                    }

                }
            );

        }


        /* ==========================================================
           CANCELLED ACCOUNT FORM VALIDATION
           ========================================================== */
        if (cancelledForm) {

            cancelledForm.addEventListener(
                'submit',
                function (event) {

                    const account =
                        cancelledForm.querySelector(
                            'select[name="account"]'
                        );


                    /*
                     * Hidden tb_data ID.
                     */
                    const accountId =
                        cancelledForm.querySelector(
                            'input[name="id"]'
                        );


                    /*
                     * Address.
                     */
                    const address =
                        cancelledForm.querySelector(
                            'input[name="address"]'
                        );


                    /*
                     * Machine.
                     */
                    const machine =
                        cancelledForm.querySelector(
                            'select[name="machine"]'
                        );


                    /*
                     * Personnel.
                     */
                    const personnel =
                        cancelledForm.querySelector(
                            'input[name="personnel"]'
                        );


                    /*
                     * Supplier.
                     */
                    const supplier =
                        cancelledForm.querySelector(
                            'input[name="supplier"]'
                        );


                    /*
                     * Reason.
                     */
                    const reason =
                        cancelledForm.querySelector(
                            'textarea[name="reason"]'
                        );


                    /* ==================================================
                       REQUIRED FIELD VALIDATION
                       ================================================== */
                    if (
                        !account ||
                        !account.value.trim() ||

                        !accountId ||
                        !accountId.value.trim() ||

                        !address ||
                        !address.value.trim() ||

                        !machine ||
                        !machine.value.trim() ||

                        !dateFoundOut ||
                        !dateFoundOut.value ||

                        !dateConfirmed ||
                        !dateConfirmed.value ||

                        !personnel ||
                        !personnel.value.trim() ||

                        !supplier ||
                        !supplier.value.trim() ||

                        !reason ||
                        !reason.value.trim()
                    ) {

                        event.preventDefault();


                        alert(
                            'Please fill in all required fields.'
                        );


                        return false;

                    }


                    /* ==================================================
                       DATE VALIDATION
                       ================================================== */
                    if (
                        dateFoundOut.value &&
                        dateConfirmed.value &&
                        dateConfirmed.value <
                        dateFoundOut.value
                    ) {

                        event.preventDefault();


                        alert(
                            'Date Confirmed From Manufacturer cannot be earlier than Date Found Out.'
                        );


                        dateConfirmed.focus();


                        return false;

                    }


                    /* ==================================================
                       FINAL CONFIRMATION
                       ================================================== */
                    const confirmed =
                        confirm(
                            'Are you sure you want to save this cancel account?'
                        );


                    if (!confirmed) {

                        event.preventDefault();

                        return false;

                    }

                }
            );

        }

    });
</script>




</body>


</html>