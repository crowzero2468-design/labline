
  <?= view('dashboard/layout/head') ?>
<style>
  /* ==========================================
   SELECT2 - BOOTSTRAP STYLE
   ========================================== */

.select2-container {
    width: 100% !important;
}

.select2-container--default .select2-selection--single {
    height: 38px !important;
    min-height: 38px !important;

    border: 1px solid #dee2e6 !important;
    border-radius: 0.375rem !important;

    background-color: #fff !important;

    display: flex !important;
    align-items: center !important;

    transition:
        border-color 0.15s ease-in-out,
        box-shadow 0.15s ease-in-out;
}

.select2-container--default
.select2-selection--single
.select2-selection__rendered {
    color: #212529 !important;
    line-height: 36px !important;
    padding-left: 12px !important;
    padding-right: 40px !important;
}

.select2-container--default
.select2-selection--single
.select2-selection__placeholder {
    color: #6c757d !important;
}

.select2-container--default
.select2-selection--single
.select2-selection__arrow {
    height: 36px !important;
    width: 35px !important;
    top: 1px !important;
    right: 2px !important;
}

.select2-container--default
.select2-selection--single
.select2-selection__arrow b {
    border-color: #6c757d transparent transparent transparent !important;
}

/* Focus */
.select2-container--default.select2-container--focus
.select2-selection--single {
    border-color: #86b7fe !important;

    box-shadow:
        0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

/* Dropdown */
.select2-container--default .select2-dropdown {
    border: 1px solid #dee2e6 !important;
    border-radius: 0.375rem !important;

    box-shadow:
        0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;

    overflow: hidden;
}

/* Search box */
.select2-container--default
.select2-search--dropdown {
    padding: 8px !important;
    background: #fff !important;
}

.select2-container--default
.select2-search--dropdown
.select2-search__field {
    width: 100% !important;
    height: 38px !important;

    padding: 6px 12px !important;

    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;

    outline: none !important;

    font-size: 0.875rem !important;

    transition:
        border-color 0.15s ease-in-out,
        box-shadow 0.15s ease-in-out;
}

.select2-container--default
.select2-search--dropdown
.select2-search__field:focus {
    border-color: #86b7fe !important;

    box-shadow:
        0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

/* Options */
.select2-container--default
.select2-results__option {
    padding: 8px 12px !important;
    font-size: 0.875rem !important;
}

.select2-container--default
.select2-results__option--highlighted[aria-selected] {
    background-color: #0d6efd !important;
    color: #fff !important;
}

/* Selected option */
.select2-container--default
.select2-results__option[aria-selected="true"] {
    background-color: #e9ecef !important;
    color: #212529 !important;
}

/* Clear X */
.select2-container--default
.select2-selection--single
.select2-selection__clear {
    color: #6c757d !important;
    font-size: 18px !important;
    margin-right: 8px !important;
}
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
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1 fw-bold text-dark">Support Tickets</h2>
          <p class="text-muted mb-0">Assign technical support to clinics and machines.</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#supportTicketModal">
          <i class="bi bi-plus-lg me-1"></i> New Ticket
        </button>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
            <div>
              <h5 class="mb-0 fw-semibold">Ticket list</h5>
            </div>
            <!-- <form method="get" action="<?= site_url('dashboard/support') ?>" class="d-flex gap-2 align-items-center">
              <input type="text" name="search" class="form-control form-control-sm" value="<?= esc($search ?? '') ?>" placeholder="Search clinic, machine, tech..." style="min-width: 240px;">
              <button type="submit" class="btn btn-outline-secondary btn-sm">Search</button>
            </form> -->
          </div>

          <div class="table-responsive">
            <table id="supportTable" class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>Ticket Number</th>
                  <th>Date</th>
                  <th>Clinic</th>
                  <th>Machine</th>
                  <th>Technician</th>
                  <th>Concern</th>
                  <th>Remarks</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php if (!empty($tickets)): ?>
                      <?php foreach ($tickets as $ticket): ?>

                          <?php $status = strtolower((string) ($ticket['status'] ?? 'waiting')); ?>

                          <?php
                          $statusLabels = [
                              'waiting'      => ['label' => 'Not Started', 'class' => 'warning'],
                              'ongoing'      => ['label' => 'In Progress', 'class' => 'primary'],
                              'done'         => ['label' => 'Completed', 'class' => 'success'],
                              'on_hold'      => ['label' => 'On Hold', 'class' => 'secondary'],
                              'pullout'      => ['label' => 'Pullout', 'class' => 'danger'],
                              'unservicable' => ['label' => 'Unservicable', 'class' => 'dark'],
                              'canceled'     => ['label' => 'Canceled', 'class' => 'secondary'],
                          ];

                          $statusInfo = $statusLabels[$status]
                              ?? ['label' => ucfirst($status), 'class' => 'secondary'];
                          ?>

                          <tr>
                              <td><?= esc($ticket['ticket_number'] ?? '-') ?></td>
                              
                              <td><?= esc($ticket['support_date'] ?? '-') ?></td>

                              <td><?= esc($ticket['clinic_name'] ?? '-') ?></td>

                              <td><?= esc($ticket['machine'] ?? '-') ?></td>

                              <td><?= esc($ticket['technician'] ?? '-') ?></td>

                              <td><?= esc($ticket['concern'] ?? '-') ?></td>

                              <td><?= esc($ticket['remarks'] ?? '-') ?></td>

                              <td>
                                  <span class="badge bg-<?= esc($statusInfo['class']) ?> text-uppercase">
                                      <?= esc($statusInfo['label']) ?>
                                  </span>
                              </td>

                              <td>
                                    <?php if ($status === 'waiting'): ?>

                                        <form method="post"
                                              action="<?= site_url('dashboard/support/update-status') ?>">

                                            <input type="hidden"
                                                  name="id"
                                                  value="<?= (int) ($ticket['id'] ?? 0) ?>">

                                            <button type="submit"
                                                    name="status"
                                                    value="ongoing"
                                                    class="btn btn-sm btn-primary">
                                                Accept
                                            </button>

                                        </form>

                                    <?php elseif ($status === 'on_hold'): ?>

                                      <form method="post"
                                          action="<?= site_url('dashboard/support/update-status') ?>">

                                        <input type="hidden"
                                            name="id"
                                            value="<?= (int) ($ticket['id'] ?? 0) ?>">

                                        <button type="submit"
                                            name="status"
                                            value="ongoing"
                                            class="btn btn-sm btn-primary">
                                          <i class="bi bi-play-fill me-1"></i>
                                          Start
                                        </button>

                                      </form>

                                    <?php elseif ($status === 'ongoing'): ?>

                                        <form method="post"
                                              action="<?= site_url('dashboard/support/update-status') ?>"
                                              class="d-flex flex-column gap-2"
                                              id="supportForm<?= (int) ($ticket['id'] ?? 0) ?>">

                                            <input type="hidden"
                                                  name="id"
                                                  value="<?= (int) ($ticket['id'] ?? 0) ?>">

                                            <div class="d-flex align-items-center gap-2">

                                                <select name="status"
                                                        class="form-select form-select-sm support-status-select"
                                                        data-ticket-id="<?= (int) ($ticket['id'] ?? 0) ?>"
                                                        aria-label="Support action"
                                                        style="min-width:125px;">

                                                    <option value="">Action</option>
                                                    <option value="done">Completed</option>
                                                    <option value="on_hold">On Hold</option>
                                                    <option value="pullout">Pullout</option>
                                                    <option value="unservicable">Unservicable</option>
                                                    <option value="canceled">Canceled</option>

                                                </select>

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-secondary">
                                                    Apply
                                                </button>

                                            </div>

                                            <textarea name="remarks"
                                                      class="form-control form-control-sm support-remarks"
                                                      data-ticket-id="<?= (int) ($ticket['id'] ?? 0) ?>"
                                                      rows="2"
                                                      placeholder="Remarks required for Completed or Unservicable"
                                                      style="min-width:220px;"></textarea>

                                        </form>

                                    <?php elseif ($status === 'pullout' && ($ticket['returnstat'] ?? null) === null): ?>

                                        <form method="post"
                                              action="<?= site_url('dashboard/support/update-status') ?>">

                                            <input type="hidden"
                                                  name="id"
                                                  value="<?= (int) ($ticket['id'] ?? 0) ?>">

                                            <input type="hidden"
                                                  name="returnstat"
                                                  value="return">

                                            <button type="submit"
                                                    name="status"
                                                    value="pullout"
                                                    class="btn btn-sm btn-success">
                                                <i class="bi bi-arrow-return-left me-1"></i>
                                                Return
                                            </button>

                                        </form>

                                    <?php else: ?>

                                        <span class="text-muted small">Closed</span>

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
    </main>

    <?= view('dashboard/layout/footer') ?>
  </div>

  <div class="modal fade" id="supportTicketModal" tabindex="-1" aria-labelledby="supportTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form action="<?= site_url('dashboard/support/save') ?>" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="supportTicketModalLabel">Assign Support Ticket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body row g-3">
            <div class="col-md-6">
              <label class="form-label">Clinic</label>

              <select
                  class="form-select"
                  name="clinic_name"
                  id="clinic_name"
                  required
              >
                  <option value="">Select clinic</option>

                    <?php
                    $clinicOptions = [];
                    foreach ($clinics as $clinic) {
                      $clinicName = trim((string) ($clinic['Clinic_name'] ?? ''));
                      $address = trim((string) ($clinic['Address'] ?? ''));
                      $clinicKey = $clinicName . '|' . $address;

                      if ($clinicName === '') {
                        continue;
                      }

                      if (!isset($clinicOptions[$clinicKey])) {
                        $clinicOptions[$clinicKey] = [
                          'name' => $clinicName,
                          'province' => $clinic['Province'] ?? '',
                          'address' => $address,
                          'machines' => [],
                        ];
                      }

                      $machineName = trim((string) ($clinic['Machine'] ?? ''));
                      if ($machineName !== '') {
                        $clinicOptions[$clinicKey]['machines'][$machineName] = true;
                      }
                    }
                    ?>

                    <?php foreach ($clinicOptions as $clinicOption): ?>
                      <?php $clinicMachines = htmlspecialchars(json_encode(array_keys($clinicOption['machines'])), ENT_QUOTES, 'UTF-8'); ?>
                      <option value="<?= esc($clinicOption['name']) ?>"
                          data-province="<?= esc($clinicOption['province']) ?>"
                          data-address="<?= esc($clinicOption['address']) ?>"
                          data-machines="<?= $clinicMachines ?>">
                        <?= esc($clinicOption['name']) ?> | <?= esc($clinicOption['address']) ?>
                      </option>
                    <?php endforeach; ?>
              </select>
          </div>

            <div class="col-md-6">
              <label class="form-label">Machine</label>
              <select class="form-select" name="machine" id="support_machine" required disabled>
                <option value="">Select machine</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Province</label>
              <input type="text" class="form-control" name="province" id="support_province" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label">Address</label>
              <input type="text" class="form-control" name="address" id="support_address" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label">Service Engr</label>
              <select class="form-select" name="service_engr" required>
                <option value="">Select service engineer</option>
                <?php foreach ($techs as $tech): ?>
                  <?php $techName = trim((($tech['fname'] ?? '') . ' ' . ($tech['lname'] ?? ''))); ?>
                  <?php if ($techName !== ''): ?>
                    <option value="<?= esc($techName) ?>"><?= esc($techName) ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Machine Status</label>
              <select class="form-select" name="machine_status">
                <option value="">Select machine status</option>
                <option value="Operational">Operational</option>
                <option value="Not Operational">Not Operational</option>
                <option value="Fully Functional">Fully Functional</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Date</label>
              <input type="date" class="form-control" name="support_date" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="col-12">
              <label class="form-label">Concern</label>
              <textarea class="form-control" name="concern" rows="4" placeholder="Describe the issue or troubleshooting concern..." required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save ticket</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
$(document).ready(function () {

    $('#supportTable').DataTable({
        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],

        order: [[0, 'asc']],

        responsive: true,

        autoWidth: false,

        language: {
            emptyTable: "No support tickets yet.",
            zeroRecords: "No matching support tickets found."
        },

        columnDefs: [
            {
                targets: 7,
                orderable: false,
                searchable: false
            }
        ]
    });

});

    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.support-status-select').forEach(function (select) {
        const ticketId = select.dataset.ticketId;
        const form = document.getElementById('supportForm' + ticketId);
        const remarks = form ? form.querySelector('.support-remarks') : null;

        function updateRemarksRequirement() {
          if (!remarks) return;
          const required = ['done', 'unservicable'].includes(select.value);
          remarks.required = required;
          remarks.placeholder = required
            ? 'Remarks required before marking as Completed or Unservicable'
            : 'Remarks required for Completed or Unservicable';
        }

        updateRemarksRequirement();
        select.addEventListener('change', updateRemarksRequirement);
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

    $(document).ready(function () {

    $('#clinic_name').select2({
        placeholder: 'Select clinic',
        allowClear: true,
        width: '100%',
        minimumResultsForSearch: 0,
        dropdownParent: $('#supportTicketModal')
    });

    function updateClinicFields() {
      const clinicSelect = document.getElementById('clinic_name');
      const machineSelect = document.getElementById('support_machine');
      const provinceInput = document.getElementById('support_province');
      const addressInput = document.getElementById('support_address');
      const selected = clinicSelect?.options[clinicSelect.selectedIndex];
      let machines = [];

      try {
        machines = JSON.parse(selected?.dataset.machines || '[]');
      } catch (error) {
        machines = [];
      }

      if (provinceInput) {
        provinceInput.value = selected?.dataset.province || '';
      }

      if (addressInput) {
        addressInput.value = selected?.dataset.address || '';
      }

      if (machineSelect) {
        machineSelect.innerHTML = '<option value="">Select machine</option>';
        machines.forEach(function (machine) {
          const option = document.createElement('option');
          option.value = machine;
          option.textContent = machine;
          machineSelect.appendChild(option);
        });
        machineSelect.disabled = machines.length === 0;
      }
    }

    $('#clinic_name').on('change select2:select select2:clear', updateClinicFields);
    updateClinicFields();

});
  </script>
</body>
</html>