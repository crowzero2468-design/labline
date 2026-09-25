
  <?= view('dashboard/layout/head') ?>
  <style>
    .history-row, .clinic-summary-row { cursor: pointer; }
    .timeline-item { display: flex; gap: 12px; position: relative; padding-bottom: 22px; }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-item:not(:last-child)::before { content: ''; position: absolute; left: 5px; top: 12px; bottom: 0; width: 2px; background: #e5e7eb; }
    .timeline-dot { flex: 0 0 12px; height: 12px; margin-top: 4px; border-radius: 50%; position: relative; z-index: 1; }
    .timeline-item strong, .timeline-item small { display: block; }
    .timeline-item small { color: #6b7280; margin-top: 3px; }
  </style>
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
            <table id="clinicSummaryTable" class="table table-hover align-middle mb-0">
              <thead style="background: #f3f4f6;">
                <tr>
                  <th>Clinic</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($clinic_counts)): ?>
                  <?php foreach ($clinic_counts as $item): ?>
                    <tr class="clinic-summary-row" role="button" data-clinic="<?= esc($item['clinic_name'] ?? '-') ?>">
                      <td><?= esc($item['clinic_name'] ?? '-') ?></td>
                      <td><?= esc($item['total'] ?? 0) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td class="text-center text-muted py-4">No clinic records found.</td>
                    <td></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="row g-4 align-items-start">
        <div class="col-12 col-xl-8">
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

                    <tr class="history-row" role="button"
                      data-ticket="<?= esc($ticket['ticket_number'] ?? '-') ?>"
                      data-clinic="<?= esc($ticket['clinic_name'] ?? '-') ?>"
                      data-inputed="<?= esc($ticket['created_at'] ?? '') ?>"
                      data-accepted="<?= esc($ticket['accepted_at'] ?? '') ?>"
                      data-updated="<?= esc($ticket['status_updated_at'] ?? '') ?>"
                      data-returned="<?= esc($ticket['update_date'] ?? '') ?>"
                      data-concern="<?= esc($ticket['concern'] ?? '-') ?>"
                      data-status="<?= esc($statusInfo['label']) ?>">

                      <td>
                        <?= esc($ticket['ticket_number'] ?? '-') ?>
                      </td>

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

                    <td></td>

                    <td></td>

                    <td></td>

                    <td class="text-center text-muted py-4">
                      No records</td>

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
        </div>

        <div class="col-12 col-xl-4">
          <div class="card history-timeline-card" id="historyTimeline">
            <div class="card-header">
              <h2 class="card-title mb-1">Ticket Timeline</h2>
              <p class="text-muted small mb-0" id="timelineTicket">Select a history record</p>
              <p class="small mb-0" id="timelineClinic"></p>
            </div>
            <div class="card-body">
              <div class="timeline-empty text-center text-muted py-4" id="timelineEmpty">
                <i class="bi bi-clock-history fs-2 d-block mb-2"></i>
                Click a history record to view its timeline.
              </div>
              <div class="timeline d-none" id="timelineEvents">
                <div class="timeline-item">
                  <span class="timeline-dot bg-secondary"></span>
                  <div><strong>Ticket inputed</strong><small id="timelineInputed">Not recorded</small></div>
                </div>
                <div class="timeline-item">
                  <span class="timeline-dot bg-primary"></span>
                  <div><strong>Ticket accepted</strong><small id="timelineAccepted">Not recorded</small></div>
                </div>
                <div class="timeline-item">
                  <span class="timeline-dot bg-success"></span>
                  <div><strong>Status updated</strong><small id="timelineUpdated">Not recorded</small></div>
                </div>
                <div class="timeline-item d-none" id="timelineReturnItem">
                  <span class="timeline-dot bg-warning"></span>
                  <div><strong>Pullout returned</strong><small id="timelineReturned">Not recorded</small></div>
                </div>
              </div>
              <div class="d-none" id="clinicHistory">
                <div class="table-responsive">
                  <table class="table table-sm align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Time Called</th>
                        <th>History</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="clinicHistoryBody"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <?= view('dashboard/layout/footer') ?>
  </div>


  <script>
      $(document).ready(function () {

        function formatTimelineDate(value) {
          if (!value) {
            return 'Not recorded';
          }

          return value.replace('T', ' ').replace(' ', ' at ');
        }

        function setTimelineValue(selector, value) {
          $(selector).text(formatTimelineDate(value));
        }

        function showTicketTimeline(row) {
          const returned = row.data('returned');

          $('#historyTimeline .card-title').text('Ticket Timeline');
          $('#timelineEmpty').addClass('d-none');
          $('#timelineEvents').removeClass('d-none');
          $('#clinicHistory').addClass('d-none');
          $('#timelineTicket').text((row.data('ticket') || '-') + ' - ' + (row.data('status') || ''));
          $('#timelineClinic').text('Clinic: ' + (row.data('clinic') || '-'));
          setTimelineValue('#timelineInputed', row.data('inputed'));
          setTimelineValue('#timelineAccepted', row.data('accepted'));
          setTimelineValue('#timelineUpdated', row.data('updated'));
          setTimelineValue('#timelineReturned', returned);
          $('#timelineReturnItem').toggleClass('d-none', !returned);
        }

        function showClinicHistory(clinic) {
          const matchingRows = $('.history-row').filter(function () {
            return ($(this).data('clinic') || '-') === clinic;
          });
          const historyRows = matchingRows.map(function () {
            const row = $(this);
            return '<tr><td>' + formatTimelineDate(row.data('inputed')) + '</td><td>' +
              $('<div>').text(row.data('concern') || '-').html() + '</td><td>' +
              $('<span>').text(row.data('status') || '-').html() + '</td></tr>';
          }).get().join('');

          $('#historyTimeline .card-title').text('Clinic History');
          $('#timelineTicket').text(clinic);
          $('#timelineClinic').text('');
          $('#timelineEmpty').addClass('d-none');
          $('#timelineEvents').addClass('d-none');
          $('#clinicHistory').removeClass('d-none');
          $('#clinicHistoryBody').html(historyRows || '<tr><td colspan="3" class="text-muted">No history found.</td></tr>');
        }

        const historyTable = $('#historyTable').DataTable({

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

      $('#clinicSummaryTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [
          [10, 25, 50, 100],
          [10, 25, 50, 100]
        ],
        order: [[1, 'desc']],
        autoWidth: false
      });

      $('#historyTable tbody').on('click', 'tr.history-row', function () {
        const row = $(this);

        $('.history-row').removeClass('table-primary');
        row.addClass('table-primary');
        $('.clinic-summary-row').removeClass('table-primary');
        showTicketTimeline(row);
      });

      $('#clinicSummaryTable tbody').on('click', 'tr.clinic-summary-row', function () {
        const row = $(this);
        const clinic = row.data('clinic') || '-';

        $('.clinic-summary-row').removeClass('table-primary');
        row.addClass('table-primary');
        $('.history-row').removeClass('table-primary');
        showClinicHistory(clinic);
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