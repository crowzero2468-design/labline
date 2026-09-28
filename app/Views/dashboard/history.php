<?= view('dashboard/layout/head') ?>

<style>
    .history-row,
    .clinic-summary-row {
        cursor: pointer;
    }

    .timeline-item {
        display: flex;
        gap: 12px;
        position: relative;
        padding-bottom: 22px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 5px;
        top: 12px;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }

    .timeline-dot {
        flex: 0 0 12px;
        height: 12px;
        margin-top: 4px;
        border-radius: 50%;
        position: relative;
        z-index: 1;
    }

    .timeline-item strong,
    .timeline-item small {
        display: block;
    }

    .timeline-item small {
        color: #6b7280;
        margin-top: 3px;
    }

    .action-buttons {
        white-space: nowrap;
    }
    .action-cell {
    position: relative;
    z-index: 50;
    white-space: nowrap;
    }

    .action-buttons {
        position: relative;
        z-index: 51;
        display: flex;
        gap: 4px;
    }

    .action-buttons button {
        position: relative;
        z-index: 52;
        pointer-events: auto !important;
        cursor: pointer !important;
    }
</style>

<body>

<?php if (session()->getFlashdata('error')): ?>

    <div class="flash-message"
         style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%); z-index: 1200; width: min(90vw, 520px); opacity: 1; transition: opacity 0.5s ease;">

        <div style="background: #ffe4e6; color: #991b1b; border: 1px solid #fecdd3; padding: 12px 16px; border-radius: 10px; font-weight: 600;">

            <?= esc(session()->getFlashdata('error')) ?>

        </div>

    </div>

<?php endif; ?>


<?php if (session()->getFlashdata('success')): ?>

    <div class="flash-message"
         style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%); z-index: 1200; width: min(90vw, 520px); opacity: 1; transition: opacity 0.5s ease;">

        <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 10px; font-weight: 600;">

            <?= esc(session()->getFlashdata('success')) ?>

        </div>

    </div>

<?php endif; ?>


<?= view('dashboard/layout/sidebar') ?>


<div class="main-wrapper">

    <?= view('dashboard/layout/navbar') ?>


    <main class="content-area px-4 py-4">

        <!-- =========================================================
             PAGE HEADER
        ========================================================== -->

        <div class="page-header">

            <div>

                <h1 class="page-title">
                    Support History
                </h1>

                <p class="page-subtitle">
                    All records from tb_support
                </p>

            </div>


            <div class="d-flex gap-2 flex-wrap align-items-center">

                <a href="<?= site_url('dashboard/history/export') .
                    (!empty($date_from) || !empty($date_to)
                        ? '?date_from=' . urlencode($date_from ?? '') .
                          '&date_to=' . urlencode($date_to ?? '')
                        : '') ?>"
                   class="btn btn-success">

                    <i class="bi bi-file-earmark-excel me-1"></i>

                    Export Excel

                </a>


                <a href="<?= site_url('dashboard/history/export-clinic-counts') .
                    (!empty($date_from) || !empty($date_to)
                        ? '?date_from=' . urlencode($date_from ?? '') .
                          '&date_to=' . urlencode($date_to ?? '')
                        : '') ?>"
                   class="btn btn-outline-primary">

                    <i class="bi bi-bar-chart me-1"></i>

                    Export Clinic Count

                </a>

            </div>

        </div>


        <!-- =========================================================
             CLINIC COUNT SUMMARY
        ========================================================== -->

        <div class="card mb-4">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h2 class="card-title mb-0">
                    Clinic Count Summary
                </h2>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table id="clinicSummaryTable"
                           class="table table-hover align-middle mb-0">

                        <thead style="background: #f3f4f6;">

                            <tr>

                                <th>
                                    Clinic
                                </th>

                                <th>
                                    Total
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php if (!empty($clinic_counts)): ?>

                            <?php foreach ($clinic_counts as $item): ?>

                                <tr class="clinic-summary-row"
                                    role="button"
                                    data-clinic="<?= esc($item['clinic_name'] ?? '-') ?>">

                                    <td>
                                        <?= esc($item['clinic_name'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= esc($item['total'] ?? 0) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td class="text-center text-muted py-4">
                                    No clinic records found.
                                </td>

                                <td></td>

                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- =========================================================
             MAIN CONTENT
        ========================================================== -->

        <div class="row g-4 align-items-start">


            <!-- =====================================================
                 SUPPORT TICKETS
            ====================================================== -->

            <div class="col-12 col-xl-8">

                <div class="card">


                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                        <div>

                            <h2 class="card-title mb-0">
                                All Support Tickets
                            </h2>

                        </div>


                        <form method="get"
                              action="<?= site_url('dashboard/history') ?>"
                              class="d-flex flex-wrap gap-2 align-items-center justify-content-end ms-auto"
                              style="max-width: 620px; width: 100%;">

                            <input type="date"
                                   name="date_from"
                                   class="form-control"
                                   value="<?= esc($date_from ?? '') ?>"
                                   style="max-width: 180px;">


                            <input type="date"
                                   name="date_to"
                                   class="form-control"
                                   value="<?= esc($date_to ?? '') ?>"
                                   style="max-width: 180px;">


                            <button type="submit"
                                    class="btn btn-primary">

                                Filter

                            </button>


                            <?php if (
                                !empty($date_from) ||
                                !empty($date_to) ||
                                !empty($search)
                            ): ?>

                                <a href="<?= site_url('dashboard/history') ?>"
                                   class="btn btn-outline-secondary">

                                    Reset

                                </a>

                            <?php endif; ?>

                        </form>

                    </div>


                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table id="historyTable"
                                   class="table table-striped table-hover align-middle mb-0">

                                <thead style="background: #f3f4f6;">

                                    <tr>

                                        <th>
                                            Ticket Number
                                        </th>

                                        <th>
                                            Clinic Name
                                        </th>

                                        <th>
                                            Province
                                        </th>

                                        <th>
                                            Address
                                        </th>

                                        <th>
                                            Reported Date
                                        </th>

                                        <th>
                                            Concern
                                        </th>

                                        <th>
                                            Machine Status
                                        </th>

                                        <th>
                                            Service Engr
                                        </th>

                                        <th>
                                            Service Status
                                        </th>

                                        <th>
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>


                                <?php if (!empty($tickets)): ?>


                                    <?php foreach ($tickets as $ticket): ?>


                                        <?php

                                        $status = strtolower(
                                            (string) (
                                                $ticket['status']
                                                ?? 'waiting'
                                            )
                                        );


                                        $statusLabels = [

                                            'waiting' => [
                                                'label' => 'Not Started',
                                                'class' => 'warning'
                                            ],

                                            'ongoing' => [
                                                'label' => 'In Progress',
                                                'class' => 'primary'
                                            ],

                                            'done' => [
                                                'label' => 'Completed',
                                                'class' => 'success'
                                            ],

                                            'on_hold' => [
                                                'label' => 'On Hold',
                                                'class' => 'secondary'
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


                                        if (
                                            $status === 'pullout' &&
                                            strtolower(
                                                (string) (
                                                    $ticket['returnstat']
                                                    ?? ''
                                                )
                                            ) === 'return'
                                        ) {

                                            $statusInfo = [
                                                'label' => 'Return',
                                                'class' => 'success'
                                            ];

                                        }

                                        ?>


                                        <tr class="history-row"
                                            role="button"

                                            data-id="<?= esc($ticket['id'] ?? '') ?>"

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
                                                <?= esc($ticket['clinic_name'] ?? '-') ?>
                                            </td>


                                            <td>
                                                <?= esc($ticket['province'] ?? '-') ?>
                                            </td>


                                            <td>
                                                <?= esc($ticket['address'] ?? '-') ?>
                                            </td>


                                            <td>
                                                <?= esc($ticket['support_date'] ?? '-') ?>
                                            </td>


                                            <td>
                                                <?= esc($ticket['concern'] ?? '-') ?>
                                            </td>


                                            <td>
                                                <?= esc($ticket['machine_status'] ?? '-') ?>
                                            </td>


                                            <td>
                                                <?= esc(
                                                    $ticket['service_engr']
                                                    ?? (
                                                        $ticket['technician']
                                                        ?? '-'
                                                    )
                                                ) ?>
                                            </td>


                                            <td>

                                                <span class="badge bg-<?= esc($statusInfo['class']) ?> text-uppercase">

                                                    <?= esc($statusInfo['label']) ?>

                                                </span>

                                            </td>


                                            <!-- =================================================
                                                 ACTION
                                            ================================================== -->

                                            <td class="action-cell">

                                              <div class="d-flex gap-1 action-buttons">

                                                  <!-- EDIT -->
                                                  <button
                                                      type="button"
                                                      class="btn btn-sm btn-outline-primary"
                                                      onclick="openEditTicket(this); event.stopPropagation();"
                                                      data-id="<?= esc($ticket['id'] ?? '') ?>"
                                                      data-ticket="<?= esc($ticket['ticket_number'] ?? '') ?>"
                                                      data-clinic="<?= esc($ticket['clinic_name'] ?? '') ?>"
                                                      data-province="<?= esc($ticket['province'] ?? '') ?>"
                                                      data-address="<?= esc($ticket['address'] ?? '') ?>"
                                                      data-date="<?= esc($ticket['support_date'] ?? '') ?>"
                                                      data-concern="<?= esc($ticket['concern'] ?? '') ?>"
                                                      data-machine-status="<?= esc($ticket['machine_status'] ?? '') ?>"
                                                      data-service-engr="<?= esc(
                                                          $ticket['service_engr']
                                                          ?? ($ticket['technician'] ?? '')
                                                      ) ?>"
                                                      data-status="<?= esc($status) ?>"
                                                      title="Edit">

                                                      <i class="bi bi-pencil"></i>

                                                  </button>


                                                  <!-- DELETE -->
                                                  <button
                                                      type="button"
                                                      class="btn btn-sm btn-outline-danger"
                                                      onclick="deleteTicket(this); event.stopPropagation();"
                                                      data-id="<?= esc($ticket['id'] ?? '') ?>"
                                                      data-ticket="<?= esc($ticket['ticket_number'] ?? '') ?>"
                                                      title="Delete">

                                                      <i class="bi bi-trash"></i>

                                                  </button>

                                              </div>

                                          </td>


                                        </tr>


                                    <?php endforeach; ?>


                                <?php else: ?>


                                    <tr>

                                        <td class="text-center text-muted py-4">
                                            No records
                                        </td>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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

            </div>


            <!-- =====================================================
                 TIMELINE
            ====================================================== -->

            <div class="col-12 col-xl-4">

                <div class="card history-timeline-card"
                     id="historyTimeline">


                    <div class="card-header">

                        <h2 class="card-title mb-1">
                            Ticket Timeline
                        </h2>


                        <p class="text-muted small mb-0"
                           id="timelineTicket">

                            Select a history record

                        </p>


                        <p class="small mb-0"
                           id="timelineClinic"></p>

                    </div>


                    <div class="card-body">


                        <div class="timeline-empty text-center text-muted py-4"
                             id="timelineEmpty">

                            <i class="bi bi-clock-history fs-2 d-block mb-2"></i>

                            Click a history record to view its timeline.

                        </div>


                        <div class="timeline d-none"
                             id="timelineEvents">


                            <div class="timeline-item">

                                <span class="timeline-dot bg-secondary"></span>

                                <div>

                                    <strong>
                                        Ticket inputed
                                    </strong>

                                    <small id="timelineInputed">
                                        Not recorded
                                    </small>

                                </div>

                            </div>


                            <div class="timeline-item">

                                <span class="timeline-dot bg-primary"></span>

                                <div>

                                    <strong>
                                        Ticket accepted
                                    </strong>

                                    <small id="timelineAccepted">
                                        Not recorded
                                    </small>

                                </div>

                            </div>


                            <div class="timeline-item">

                                <span class="timeline-dot bg-success"></span>

                                <div>

                                    <strong>
                                        Status updated
                                    </strong>

                                    <small id="timelineUpdated">
                                        Not recorded
                                    </small>

                                </div>

                            </div>


                            <div class="timeline-item d-none"
                                 id="timelineReturnItem">

                                <span class="timeline-dot bg-warning"></span>

                                <div>

                                    <strong>
                                        Pullout returned
                                    </strong>

                                    <small id="timelineReturned">
                                        Not recorded
                                    </small>

                                </div>

                            </div>


                            <div class="timeline-item">

                                <span class="timeline-dot bg-info"></span>

                                <div>

                                    <strong>
                                        Service duration
                                    </strong>

                                    <small id="timelineDuration">
                                        Not completed
                                    </small>

                                </div>

                            </div>


                        </div>


                        <div class="d-none"
                             id="clinicHistory">

                            <div class="table-responsive">

                                <table class="table table-sm align-middle mb-0">

                                    <thead>

                                        <tr>

                                            <th>
                                                Time Called
                                            </th>

                                            <th>
                                                History
                                            </th>

                                            <th>
                                                Status
                                            </th>

                                            <th>
                                                Duration
                                            </th>

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


    <!-- =========================================================
         EDIT SUPPORT TICKET MODAL
    ========================================================== -->

    <div class="modal fade"
         id="editTicketModal"
         tabindex="-1"
         aria-hidden="true">


        <div class="modal-dialog modal-lg modal-dialog-centered">


            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Support Ticket

                    </h5>


                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <form id="editTicketForm">


                    <div class="modal-body">


                        <input type="hidden"
                               name="id"
                               id="edit_id">


                        <div class="row g-3">


                            <!-- Ticket Number -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Ticket Number
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="ticket_number"
                                       id="edit_ticket_number"
                                       readonly>

                            </div>


                            <!-- Clinic -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Clinic Name
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="clinic_name"
                                       id="edit_clinic_name">

                            </div>


                            <!-- Province -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Province
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="province"
                                       id="edit_province">

                            </div>


                            <!-- Address -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Address
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="address"
                                       id="edit_address">

                            </div>


                            <!-- Reported Date -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Reported Date
                                </label>

                                <input type="date"
                                       class="form-control"
                                       name="support_date"
                                       id="edit_support_date">

                            </div>


                            <!-- Machine Status -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Machine Status
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="machine_status"
                                       id="edit_machine_status">

                            </div>


                            <!-- Concern -->

                            <div class="col-12">

                                <label class="form-label">
                                    Concern
                                </label>

                                <textarea class="form-control"
                                          name="concern"
                                          id="edit_concern"
                                          rows="3"></textarea>

                            </div>


                            <!-- Service Engineer -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Service Engineer
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="service_engr"
                                       id="edit_service_engr">

                            </div>


                            <!-- Service Status -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Service Status
                                </label>

                                <select class="form-select"
                                        name="status"
                                        id="edit_status">


                                    <option value="waiting">
                                        Not Started
                                    </option>


                                    <option value="ongoing">
                                        In Progress
                                    </option>


                                    <option value="done">
                                        Completed
                                    </option>


                                    <option value="on_hold">
                                        On Hold
                                    </option>


                                    <option value="pullout">
                                        Pullout
                                    </option>


                                    <option value="unservicable">
                                        Unservicable
                                    </option>


                                    <option value="canceled">
                                        Canceled
                                    </option>


                                </select>

                            </div>


                        </div>

                    </div>


                    <div class="modal-footer">


                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>


                        <button type="submit"
                                class="btn btn-primary"
                                id="btnSaveTicket">

                            <i class="bi bi-check-lg me-1"></i>

                            Save Changes

                        </button>


                    </div>


                </form>


            </div>

        </div>

    </div>


    <?= view('dashboard/layout/footer') ?>

</div>


<script>

$(document).ready(function () {


    // ==========================================================
    // TIMELINE FUNCTIONS
    // ==========================================================

    function formatTimelineDate(value) {

        if (!value) {
            return 'Not recorded';
        }

        return value
            .replace('T', ' ')
            .replace(' ', ' at ');
    }


    function setTimelineValue(selector, value) {

        $(selector).text(
            formatTimelineDate(value)
        );
    }


    function formatDuration(startValue, endValue) {

        if (!startValue || !endValue) {
            return 'Not completed';
        }

        const start =
            new Date(
                startValue.replace(' ', 'T')
            );

        const end =
            new Date(
                endValue.replace(' ', 'T')
            );

        const milliseconds =
            end.getTime() -
            start.getTime();


        if (
            Number.isNaN(milliseconds) ||
            milliseconds < 0
        ) {
            return 'Not available';
        }


        const totalMinutes =
            Math.floor(
                milliseconds / 60000
            );


        const days =
            Math.floor(
                totalMinutes / 1440
            );


        const hours =
            Math.floor(
                (totalMinutes % 1440) / 60
            );


        const minutes =
            totalMinutes % 60;


        const parts = [];


        if (days) {
            parts.push(days + 'd');
        }


        if (hours) {
            parts.push(hours + 'h');
        }


        if (
            minutes ||
            !parts.length
        ) {
            parts.push(
                minutes + 'm'
            );
        }


        return parts.join(' ');
    }


    // ==========================================================
    // SHOW TICKET TIMELINE
    // ==========================================================

    function showTicketTimeline(row) {

        const returned =
            row.data('returned');


        $('#historyTimeline .card-title')
            .text('Ticket Timeline');


        $('#timelineEmpty')
            .addClass('d-none');


        $('#timelineEvents')
            .removeClass('d-none');


        $('#clinicHistory')
            .addClass('d-none');


        $('#timelineTicket').text(

            (row.data('ticket') || '-') +
            ' - ' +
            (row.data('status') || '')

        );


        $('#timelineClinic').text(

            'Clinic: ' +
            (row.data('clinic') || '-')

        );


        setTimelineValue(
            '#timelineInputed',
            row.data('inputed')
        );


        setTimelineValue(
            '#timelineAccepted',
            row.data('accepted')
        );


        setTimelineValue(
            '#timelineUpdated',
            row.data('updated')
        );


        setTimelineValue(
            '#timelineReturned',
            returned
        );


        $('#timelineReturnItem')
            .toggleClass(
                'd-none',
                !returned
            );


        $('#timelineDuration').text(

            formatDuration(

                row.data('inputed'),

                returned ||
                (
                    row.data('status') === 'Completed'
                        ? row.data('updated')
                        : ''
                )

            )

        );

    }


    // ==========================================================
    // SHOW CLINIC HISTORY
    // ==========================================================

    function showClinicHistory(clinic) {

        const matchingRows =
            $('.history-row').filter(
                function () {

                    return (
                        $(this).data('clinic') ||
                        '-'
                    ) === clinic;

                }
            );


        const historyRows =
            matchingRows.map(
                function () {

                    const row =
                        $(this);


                    const durationEnd =
                        row.data('returned') ||
                        (
                            row.data('status') === 'Completed'
                                ? row.data('updated')
                                : ''
                        );


                    return (

                        '<tr>' +

                        '<td>' +
                        formatTimelineDate(
                            row.data('inputed')
                        ) +
                        '</td>' +

                        '<td>' +
                        $('<div>')
                            .text(
                                row.data('concern') || '-'
                            )
                            .html() +
                        '</td>' +

                        '<td>' +
                        $('<span>')
                            .text(
                                row.data('status') || '-'
                            )
                            .html() +
                        '</td>' +

                        '<td>' +
                        formatDuration(
                            row.data('inputed'),
                            durationEnd
                        ) +
                        '</td>' +

                        '</tr>'

                    );

                }
            )
            .get()
            .join('');


        $('#historyTimeline .card-title')
            .text('Clinic History');


        $('#timelineTicket')
            .text(clinic);


        $('#timelineClinic')
            .text('');


        $('#timelineEmpty')
            .addClass('d-none');


        $('#timelineEvents')
            .addClass('d-none');


        $('#clinicHistory')
            .removeClass('d-none');


        $('#clinicHistoryBody').html(

            historyRows ||

            '<tr>' +
            '<td colspan="4" class="text-muted">' +
            'No history found.' +
            '</td>' +
            '</tr>'

        );

    }


    // ==========================================================
    // HISTORY DATATABLE
    // ==========================================================

    const historyTable =
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

            autoWidth: false,

            columnDefs: [

                {
                    targets: 9,
                    orderable: false,
                    searchable: false
                }

            ]

        });


    // ==========================================================
    // CLINIC SUMMARY DATATABLE
    // ==========================================================

    $('#clinicSummaryTable').DataTable({

        paging: true,

        searching: true,

        ordering: true,

        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],

        order: [
            [1, 'desc']
        ],

        autoWidth: false

    });


    // ==========================================================
    // HISTORY ROW CLICK
    // ==========================================================

$('#historyTable tbody').on(
    'click',
    'tr.history-row',
    function (e) {

        /*
         * Do NOT treat Edit/Delete as a row click.
         */
        if (
            $(e.target).closest(
                '.action-cell, button'
            ).length
        ) {
            return;
        }


        const row = $(this);


        $('.history-row')
            .removeClass('table-primary');


        row.addClass('table-primary');


        $('.clinic-summary-row')
            .removeClass('table-primary');


        showTicketTimeline(row);

    }
);

    // ==========================================================
    // CLINIC SUMMARY CLICK
    // ==========================================================

    $('#clinicSummaryTable tbody').on(
        'click',
        'tr.clinic-summary-row',
        function () {

            const row =
                $(this);


            const clinic =
                row.data('clinic') ||
                '-';


            $('.clinic-summary-row')
                .removeClass(
                    'table-primary'
                );


            row.addClass(
                'table-primary'
            );


            $('.history-row')
                .removeClass(
                    'table-primary'
                );


            showClinicHistory(clinic);

        }
    );



/* ==========================================================
   SUPPORT HISTORY
   EDIT / DELETE / SAVE
   ========================================================== */

(function () {

    'use strict';


    /* ==========================================================
       DEBUG
       ========================================================== */

    console.log('======================================');
    console.log('SUPPORT HISTORY JS LOADED');
    console.log('======================================');


    /* ==========================================================
       EDIT TICKET
       ========================================================== */

    window.openEditTicket = function (button) {

        console.log('======================================');
        console.log('EDIT BUTTON CLICKED');
        console.log('======================================');


        if (!button) {

            console.error('Edit button object is missing.');

            return;

        }


        const id =
            button.getAttribute('data-id') || '';


        console.log('EDIT ID:', id);


        if (!id) {

            alert('Ticket ID is missing.');

            return;

        }


        /* ------------------------------------------------------
           GET DATA FROM BUTTON
           ------------------------------------------------------ */

        const ticket =
            button.getAttribute('data-ticket') || '';

        const clinic =
            button.getAttribute('data-clinic') || '';

        const province =
            button.getAttribute('data-province') || '';

        const address =
            button.getAttribute('data-address') || '';

        const supportDate =
            button.getAttribute('data-date') || '';

        const concern =
            button.getAttribute('data-concern') || '';

        const machineStatus =
            button.getAttribute('data-machine-status') || '';

        const serviceEngr =
            button.getAttribute('data-service-engr') || '';

        const status =
            button.getAttribute('data-status') || 'waiting';


        console.log({
            id: id,
            ticket: ticket,
            clinic: clinic,
            province: province,
            address: address,
            supportDate: supportDate,
            concern: concern,
            machineStatus: machineStatus,
            serviceEngr: serviceEngr,
            status: status
        });


        /* ------------------------------------------------------
           FILL FORM
           ------------------------------------------------------ */

        const editId =
            document.getElementById('edit_id');

        const editTicketNumber =
            document.getElementById('edit_ticket_number');

        const editClinic =
            document.getElementById('edit_clinic_name');

        const editProvince =
            document.getElementById('edit_province');

        const editAddress =
            document.getElementById('edit_address');

        const editSupportDate =
            document.getElementById('edit_support_date');

        const editConcern =
            document.getElementById('edit_concern');

        const editMachineStatus =
            document.getElementById('edit_machine_status');

        const editServiceEngr =
            document.getElementById('edit_service_engr');

        const editStatus =
            document.getElementById('edit_status');


        if (!editId) {

            console.error(
                'edit_id element was not found.'
            );

            alert(
                'Edit form was not found on this page.'
            );

            return;

        }


        editId.value = id;


        if (editTicketNumber) {
            editTicketNumber.value = ticket;
        }


        if (editClinic) {
            editClinic.value = clinic;
        }


        if (editProvince) {
            editProvince.value = province;
        }


        if (editAddress) {
            editAddress.value = address;
        }


        if (editSupportDate) {
            editSupportDate.value = supportDate;
        }


        if (editConcern) {
            editConcern.value = concern;
        }


        if (editMachineStatus) {
            editMachineStatus.value = machineStatus;
        }


        if (editServiceEngr) {
            editServiceEngr.value = serviceEngr;
        }


        if (editStatus) {
            editStatus.value = status;
        }


        /* ------------------------------------------------------
           FIND MODAL
           ------------------------------------------------------ */

        const modalElement =
            document.getElementById(
                'editTicketModal'
            );


        if (!modalElement) {

            console.error(
                'editTicketModal DOES NOT EXIST.'
            );

            alert(
                'Edit Ticket modal was not found.'
            );

            return;

        }


        console.log(
            'Edit modal found:',
            modalElement
        );


        /* ------------------------------------------------------
           OPEN BOOTSTRAP 5 MODAL
           ------------------------------------------------------ */

        if (
            window.bootstrap &&
            typeof bootstrap.Modal === 'function'
        ) {

            console.log(
                'Bootstrap Modal detected.'
            );


            const modal =
                bootstrap.Modal.getOrCreateInstance(
                    modalElement
                );


            modal.show();


            console.log(
                'Edit modal show() called.'
            );


        } else {

            console.error(
                'Bootstrap Modal JavaScript is NOT loaded.'
            );


            /*
             * Emergency fallback
             */

            modalElement.style.display = 'block';

            modalElement.classList.add('show');

            modalElement.removeAttribute(
                'aria-hidden'
            );

            modalElement.setAttribute(
                'aria-modal',
                'true'
            );

            modalElement.setAttribute(
                'role',
                'dialog'
            );

            document.body.classList.add(
                'modal-open'
            );


            let backdrop =
                document.getElementById(
                    'editTicketBackdrop'
                );


            if (!backdrop) {

                backdrop =
                    document.createElement('div');

                backdrop.id =
                    'editTicketBackdrop';

                backdrop.className =
                    'modal-backdrop fade show';

                document.body.appendChild(
                    backdrop
                );

            }

        }

    };


    /* ==========================================================
       DELETE TICKET
       ========================================================== */

    window.deleteTicket = function (button) {

        console.log('======================================');
        console.log('DELETE BUTTON CLICKED');
        console.log('======================================');


        if (!button) {

            console.error(
                'Delete button object is missing.'
            );

            return;

        }


        const id =
            button.getAttribute('data-id') || '';


        const ticket =
            button.getAttribute('data-ticket') || '-';


        console.log('DELETE ID:', id);
        console.log('DELETE TICKET:', ticket);


        if (!id) {

            alert(
                'Ticket ID is missing.'
            );

            return;

        }


        /* ------------------------------------------------------
           CONFIRM
           ------------------------------------------------------ */

        if (
            window.Swal &&
            typeof Swal.fire === 'function'
        ) {

            Swal.fire({

                title: 'Delete this ticket?',

                html:
                    'Ticket Number: <strong>' +
                    escapeHtml(ticket) +
                    '</strong><br><br>' +
                    '<small>This action cannot be undone.</small>',

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText:
                    '<i class="bi bi-trash me-1"></i> Yes, Delete',

                cancelButtonText:
                    'Cancel',

                confirmButtonColor:
                    '#dc3545',

                cancelButtonColor:
                    '#6c757d'

            }).then(function (result) {

                if (
                    result.isConfirmed
                ) {

                    sendDeleteRequest(id);

                }

            });

        } else {

            const confirmed =
                confirm(
                    'Delete ticket ' +
                    ticket +
                    '?\n\nThis action cannot be undone.'
                );


            if (confirmed) {

                sendDeleteRequest(id);

            }

        }

    };


    /* ==========================================================
       HTML ESCAPE
       ========================================================== */

    function escapeHtml(value) {

        const div =
            document.createElement('div');

        div.textContent =
            value;

        return div.innerHTML;

    }


    /* ==========================================================
       DELETE AJAX
       ========================================================== */

    function sendDeleteRequest(id) {

        console.log(
            'Sending DELETE request for ID:',
            id
        );


        const url =
            '<?= site_url('dashboard/history/delete') ?>';


        const body =
            new URLSearchParams();


        body.append(
            'id',
            id
        );


        fetch(
            url,
            {
                method: 'POST',

                headers: {

                    'Content-Type':
                        'application/x-www-form-urlencoded; charset=UTF-8',

                    'X-Requested-With':
                        'XMLHttpRequest'

                },

                body:
                    body.toString()

            }
        )

        .then(function (response) {

            console.log(
                'DELETE HTTP STATUS:',
                response.status
            );


            return response.text();

        })

        .then(function (text) {

            console.log(
                'DELETE SERVER RESPONSE:',
                text
            );


            let result;


            try {

                result =
                    JSON.parse(text);

            } catch (error) {

                console.error(
                    'DELETE RESPONSE IS NOT JSON:',
                    text
                );


                alert(
                    'Server returned an invalid response:\n\n' +
                    text.substring(0, 500)
                );


                return;

            }


            if (result.success) {

                if (
                    window.Swal &&
                    typeof Swal.fire === 'function'
                ) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Deleted',

                        text:
                            result.message ||
                            'Support ticket deleted successfully.',

                        timer: 1500,

                        showConfirmButton: false

                    }).then(function () {

                        window.location.reload();

                    });

                } else {

                    alert(
                        result.message ||
                        'Support ticket deleted successfully.'
                    );


                    window.location.reload();

                }

            } else {

                const message =
                    result.message ||
                    'Unable to delete ticket.';


                if (
                    window.Swal &&
                    typeof Swal.fire === 'function'
                ) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Delete Failed',

                        text: message

                    });

                } else {

                    alert(message);

                }

            }

        })

        .catch(function (error) {

            console.error(
                'DELETE REQUEST ERROR:',
                error
            );


            alert(
                'Unable to connect to the server.'
            );

        });

    }


    /* ==========================================================
       SAVE EDITED TICKET
       ========================================================== */

    document.addEventListener(
        'submit',
        function (e) {


            if (
                e.target.id !==
                'editTicketForm'
            ) {

                return;

            }


            e.preventDefault();


            console.log(
                '======================================'
            );

            console.log(
                'EDIT FORM SUBMITTED'
            );

            console.log(
                '======================================'
            );


            const form =
                e.target;


            const saveButton =
                document.getElementById(
                    'btnSaveTicket'
                );


            const id =
                document.getElementById(
                    'edit_id'
                )?.value;


            console.log(
                'UPDATE ID:',
                id
            );


            if (!id) {

                alert(
                    'Ticket ID is missing.'
                );

                return;

            }


            if (saveButton) {

                saveButton.disabled =
                    true;


                saveButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

            }


            const formData =
                new FormData(form);


            const url =
                '<?= site_url('dashboard/history/update') ?>';


            fetch(
                url,
                {
                    method: 'POST',

                    headers: {

                        'X-Requested-With':
                            'XMLHttpRequest'

                    },

                    body:
                        formData

                }
            )

            .then(function (response) {

                console.log(
                    'UPDATE HTTP STATUS:',
                    response.status
                );


                return response.text();

            })

            .then(function (text) {

                console.log(
                    'UPDATE SERVER RESPONSE:',
                    text
                );


                let result;


                try {

                    result =
                        JSON.parse(text);

                } catch (error) {

                    console.error(
                        'UPDATE RESPONSE IS NOT JSON:',
                        text
                    );


                    alert(
                        'Server returned an invalid response:\n\n' +
                        text.substring(0, 500)
                    );


                    return;

                }


                if (result.success) {

                    if (
                        window.Swal &&
                        typeof Swal.fire === 'function'
                    ) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Updated',

                            text:
                                result.message ||
                                'Support ticket updated successfully.',

                            timer: 1500,

                            showConfirmButton: false

                        }).then(function () {

                            window.location.reload();

                        });

                    } else {

                        alert(
                            result.message ||
                            'Support ticket updated successfully.'
                        );


                        window.location.reload();

                    }

                } else {

                    const message =
                        result.message ||
                        'Unable to update ticket.';


                    if (
                        window.Swal &&
                        typeof Swal.fire === 'function'
                    ) {

                        Swal.fire({

                            icon: 'error',

                            title: 'Update Failed',

                            text: message

                        });

                    } else {

                        alert(message);

                    }

                }

            })

            .catch(function (error) {

                console.error(
                    'UPDATE REQUEST ERROR:',
                    error
                );


                alert(
                    'Unable to connect to the server.'
                );

            })

            .finally(function () {

                if (saveButton) {

                    saveButton.disabled =
                        false;


                    saveButton.innerHTML =
                        '<i class="bi bi-check-lg me-1"></i> Save Changes';

                }

            });

        }
    );


})();


    // ==========================================================
    // FLASH MESSAGE
    // ==========================================================

    setTimeout(
        function () {

            const messages =
                document.querySelectorAll(
                    '.flash-message'
                );


            messages.forEach(
                function (message) {

                    message.style.opacity =
                        '0';


                    setTimeout(
                        function () {

                            message.remove();

                        },
                        500
                    );

                }
            );

        },
        5000
    );


});
</script>





</body>
</html>
