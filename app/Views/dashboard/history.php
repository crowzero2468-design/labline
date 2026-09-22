
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

  <div class="main-wrapper">
    <?= view('dashboard/layout/navbar') ?>

    <main class="content-area px-4 py-4">
      <div class="page-header">
        <div>
          <h1 class="page-title">Support History</h1>
          <p class="page-subtitle">All records from tb_support</p>
        </div>

        <div class="d-flex gap-2 flex-wrap align-items-center">
          <a href="<?= site_url('dashboard/history/export') . (!empty($date_from) || !empty($date_to) ? '?date_from=' . urlencode($date_from ?? '') . '&date_to=' . urlencode($date_to ?? '') : '') ?>" class="btn btn-success">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
          </a>
          <a href="<?= site_url('dashboard/history/export-clinic-counts') . (!empty($date_from) || !empty($date_to) ? '?date_from=' . urlencode($date_from ?? '') . '&date_to=' . urlencode($date_to ?? '') : '') ?>" class="btn btn-outline-primary">
            <i class="bi bi-bar-chart me-1"></i> Export Clinic Count
          </a>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h2 class="card-title mb-0">Clinic Count Summary</h2>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead style="background: #f3f4f6;">
                <tr>
                  <th>Clinic</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($clinic_counts)): ?>
                  <?php foreach ($clinic_counts as $item): ?>
                    <tr>
                      <td><?= esc($item['clinic_name'] ?? '-') ?></td>
                      <td><?= esc($item['total'] ?? 0) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="2" class="text-center text-muted py-4">No clinic records found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
          <div>
            <h2 class="card-title mb-0">All Support Tickets</h2>
          </div>

          <form method="get" action="<?= site_url('dashboard/history') ?>" class="d-flex flex-wrap gap-2 align-items-center justify-content-end ms-auto" style="max-width: 620px; width: 100%;">
            <input type="date" name="date_from" class="form-control" value="<?= esc($date_from ?? '') ?>" style="max-width: 180px;">
            <input type="date" name="date_to" class="form-control" value="<?= esc($date_to ?? '') ?>" style="max-width: 180px;">
            <!-- <input type="text" name="search" class="form-control" value="<?= esc($search ?? '') ?>" placeholder="Search clinic, machine, tech..." style="max-width: 220px;"> -->
            <button type="submit" class="btn btn-primary">Filter</button>
            <?php if (!empty($date_from) || !empty($date_to) || !empty($search)): ?>
              <a href="<?= site_url('dashboard/history') ?>" class="btn btn-outline-secondary">Reset</a>
            <?php endif; ?>
          </form>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table id="historyTable" class="table table-striped table-hover align-middle mb-0">
              <thead style="background: #f3f4f6;">
                <tr>
                  <th>Ticket Number</th>
                  <th>Date</th>
                  <th>Clinic</th>
                  <th>Machine</th>
                  <th>Technician</th>
                  <th>Concern</th>
                  <th>Status</th>
                </tr>
              </thead>

              <tbody>

                <?php if (!empty($tickets)): ?>

                  <?php foreach ($tickets as $ticket): ?>

                    <?php
                    $status = strtolower(
                        (string) ($ticket['status'] ?? 'waiting')
                    );

                    $statusLabels = [

                        'waiting' => [
                            'label' => 'Waiting',
                            'class' => 'warning'
                        ],

                        'ongoing' => [
                            'label' => 'Ongoing',
                            'class' => 'primary'
                        ],

                        'done' => [
                            'label' => 'Done',
                            'class' => 'success'
                        ],

                        'pullout' => [
                            'label' => 'Pullout',
                            'class' => 'danger'
                        ],

                        'unservicable' => [
                            'label' => 'Unservicable',
                            'class' => 'dark'
                        ],

                        'canceled' => [
                            'label' => 'Canceled',
                            'class' => 'secondary'
                        ],

                    ];

                    $statusInfo =
                        $statusLabels[$status]
                        ?? [
                            'label' => ucfirst($status),
                            'class' => 'secondary'
                        ];
                    ?>

                    <tr>

                      <td>
                        <?= esc($ticket['ticket_number'] ?? '-') ?>
                      <td>
                        
                        <?= esc($ticket['support_date'] ?? '-') ?>
                      </td>

                      <td>
                        <?= esc($ticket['clinic_name'] ?? '-') ?>
                      </td>

                      <td>
                        <?= esc($ticket['machine'] ?? '-') ?>
                      </td>

                      <td>
                        <?= esc($ticket['technician'] ?? '-') ?>
                      </td>

                      <td>
                        <?= esc($ticket['concern'] ?? '-') ?>
                      </td>

                      <td>

                        <span
                          class="badge bg-<?= esc($statusInfo['class']) ?> text-uppercase"
                        >
                          <?= esc($statusInfo['label']) ?>
                        </span>

                      </td>

                    </tr>

                  <?php endforeach; ?>

                <?php else: ?>

                  <!--
                    IMPORTANT:
                    DataTables expects the same number of TD
                    elements as TH elements.
                  -->

                  <tr>

                    <td class="text-center text-muted py-4">
                      No records
                    </td>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                  </tr>

                <?php endif; ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <?= view('dashboard/layout/footer') ?>
  </div>


  <script>
      $(document).ready(function () {

      $('#historyTable').DataTable({

          paging: true,

          searching: true,

          ordering: true,

          pageLength: 10,

          lengthMenu: [
              [10, 25, 50, 100],
              [10, 25, 50, 100]
          ],

          order: [
              [0, 'asc']
          ],

          autoWidth: false

      });

  });

    setTimeout(function () {
      const messages = document.querySelectorAll('.flash-message');
      messages.forEach(function (message) {
        message.style.opacity = '0';
        setTimeout(function () {
          message.remove();
        }, 500);
      });
    }, 5000);
  </script>
</body>
</html>