<script>
$(document).ready(function () {

    function showMfsAlert(icon, title, text, reload = false) {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            timer: reload ? 3000 : undefined,
            timerProgressBar: reload,
            showConfirmButton: !reload
        }).then(function () {
            if (reload) {
                window.location.reload();
            }
        });
    }

    function formatMfsAccount(account) {
        if (!account.id) {
            return account.text;
        }

        const option = account.element;
        const clinic = option?.dataset.clinic || account.text;
        const address = option?.dataset.address || '';
        const result = $('<span>');

        result.append($('<span>').text(clinic));
        result.append($('<span class="mfs-account-address">').text(address ? ' | ' + address : ''));

        return result;
    }

    if ($.fn.select2) {
        $('#mfs_accounts').select2({
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0,
            dropdownParent: $('#addMfsModal'),
            templateResult: formatMfsAccount,
            templateSelection: formatMfsAccount
        });

        $('#edit_accounts').select2({
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0,
            dropdownParent: $('#editMfsModal'),
            templateResult: formatMfsAccount,
            templateSelection: formatMfsAccount
        });
    }

    function addAccessoryRow(containerId = 'mfsAccessoryRows') {
        const rowsContainer = document.getElementById(containerId);

        if (!rowsContainer) {
            return;
        }

        const rowCount = rowsContainer.querySelectorAll('.accessory-row').length;
        const row = document.createElement('div');
        row.className = 'row g-2 accessory-row align-items-end mt-1';
        row.innerHTML = `
            <div class="col-md-6">
                <label class="form-label small mb-1">Accessory</label>
                <input type="text"
                    name="accessories[${rowCount}][name]"
                    class="form-control"
                    placeholder="Accessory">
            </div>
            <div class="col-md-5">
                <label class="form-label small mb-1">Quantity</label>
                <input type="number"
                    name="accessories[${rowCount}][quantity]"
                    class="form-control"
                    min="1"
                    value="1">
            </div>
            <div class="col-md-1 text-end align-self-end">
                <button type="button"
                    class="btn btn-outline-danger remove-mfs-accessory"
                    title="Remove Accessory">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;

        rowsContainer.appendChild(row);
    }

    function addConsumableRow(containerId = 'mfsConsumableRows') {
        const rowsContainer = document.getElementById(containerId);

        if (!rowsContainer) {
            return;
        }

        const rowCount = rowsContainer.querySelectorAll('.consumable-row').length;
        const row = document.createElement('div');
        row.className = 'row g-2 consumable-row align-items-end mt-1';
        row.innerHTML = `
            <div class="col-md-5">
                <label class="form-label small mb-1">Consumable</label>
                <input type="text"
                    name="consumables_rows[${rowCount}][name]"
                    class="form-control"
                    placeholder="Consumable">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Unit</label>
                <input type="text"
                    name="consumables_rows[${rowCount}][unit]"
                    class="form-control"
                    placeholder="Unit">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Lot Number</label>
                <input type="text"
                    name="consumables_rows[${rowCount}][lot_number]"
                    class="form-control"
                    placeholder="Lot Number">
            </div>
            <div class="col-md-1 text-end align-self-end">
                <button type="button"
                    class="btn btn-outline-danger remove-mfs-consumable"
                    title="Remove Consumable">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;

        rowsContainer.appendChild(row);
    }

    document.getElementById('addMfsAccessoryRow')?.addEventListener('click', () => addAccessoryRow('mfsAccessoryRows'));
    document.getElementById('addMfsConsumableRow')?.addEventListener('click', () => addConsumableRow('mfsConsumableRows'));
    document.getElementById('editMfsAccessoryRow')?.addEventListener('click', () => addAccessoryRow('editMfsAccessoryRows'));
    document.getElementById('editMfsConsumableRow')?.addEventListener('click', () => addConsumableRow('editMfsConsumableRows'));

    document.addEventListener('click', function (event) {
        const target = event.target.closest('.remove-mfs-accessory');
        if (target) {
            target.closest('.accessory-row')?.remove();
            return;
        }

        const consumableTarget = event.target.closest('.remove-mfs-consumable');
        if (consumableTarget) {
            consumableTarget.closest('.consumable-row')?.remove();
        }
    });

    function setReceiptUploadPreview(inputId, previewId, viewId, existingUrl = '') {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const viewLink = document.getElementById(viewId);

        if (!input || !preview) {
            return;
        }

        const renderPlaceholder = () => {
            preview.innerHTML = `
                <div class="text-muted small">
                    <i class="bi bi-cloud-upload fs-3 d-block mb-2"></i>
                    Upload Receipt
                </div>
            `;

            if (viewLink) {
                viewLink.classList.add('d-none');
                viewLink.href = '#';
            }
        };

        const renderImage = (src, altText = 'Receipt preview') => {
            preview.innerHTML = `
                <div class="text-center w-100">
                    <img src="${src}" alt="${altText}" class="img-fluid rounded" style="max-height: 140px; object-fit: contain;" />
                </div>
            `;

            if (viewLink) {
                viewLink.href = src;
                viewLink.classList.remove('d-none');
            }
        };

        if (existingUrl) {
            renderImage(existingUrl, 'Receipt image');
        } else {
            renderPlaceholder();
        }

        input.onchange = function () {
            const file = this.files && this.files[0];

            if (!file) {
                if (existingUrl) {
                    renderImage(existingUrl, 'Receipt image');
                } else {
                    renderPlaceholder();
                }
                return;
            }

            const fileUrl = URL.createObjectURL(file);
            renderImage(fileUrl, file.name || 'Receipt preview');
        };
    }

    setReceiptUploadPreview('mfs_receipt', 'mfsReceiptPreview', 'mfsReceiptView');
    setReceiptUploadPreview('edit_mfs_receipt', 'editMfsReceiptPreview', 'editMfsReceiptView');

    function populateEditMfsMachines(selectedMachine, selectedSerial) {
        const accountSelect = document.getElementById('edit_accounts');
        const machineSelect = document.getElementById('edit_machine');
        const addressInput = document.getElementById('edit_address');
        const serialInput = document.getElementById('edit_serial_number');

        if (!accountSelect || !machineSelect) {
            return;
        }

        const selectedOption = accountSelect.options[accountSelect.selectedIndex] || null;
        const option = selectedOption || null;
        let machines = {};

        try {
            machines = JSON.parse(option?.dataset.machines || '{}');
        }
        catch (error) {
            machines = {};
        }

        if (addressInput) {
            addressInput.value = option?.dataset.address || '';
        }

        machineSelect.innerHTML = '<option value="">-- Select Machine --</option>';

        Object.keys(machines).forEach(function (machine) {
            const machineOption = document.createElement('option');
            machineOption.value = machine;
            machineOption.textContent = machine;
            machineSelect.appendChild(machineOption);
        });

        machineSelect.disabled = Object.keys(machines).length === 0;
        machineSelect.value = selectedMachine || '';

        if (serialInput) {
            serialInput.value = selectedMachine && machines[selectedMachine]
                ? machines[selectedMachine]
                : (selectedSerial || '');
        }
    }

    $('#edit_accounts').on('change select2:select select2:clear', function () {
        populateEditMfsMachines('', '');
    });

    $('#edit_machine').on('change', function () {
        populateEditMfsMachines(this.value, '');
    });

    // ============================================================
    // MFS DATATABLE
    // ============================================================

    $('#mfsTable').DataTable({

        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],

        // Date column
        order: [[4, 'desc']],

        responsive: true,

        autoWidth: false

    });


    // ============================================================
    // EDIT MFS BUTTON
    // ============================================================

    $(document).on('click', '.edit-mfs-btn', function () {

        const id = $(this).data('id');

        if (!id) {

            showMfsAlert('error', 'Unable to edit MFS', 'Invalid MFS record.');

            return;
        }


        /*
         * Get MFS record
         */
        $.ajax({

            url: "<?= site_url('mfs/edit/') ?>" + id,

            type: "GET",

            dataType: "json",

            success: function (response) {

                if (!response || !response.success) {

                    showMfsAlert('error', 'Unable to load MFS', response?.message || 'Unable to load MFS record.');

                    return;
                }


                const r = response.data;


                // =================================================
                // FILL EDIT MODAL
                // =================================================

                $('#edit_mfs_id').val(
                    r.id ?? ''
                );

                $('#edit_mfs_number').val(
                    r.mfs_number ?? ''
                );

                $('#edit_pull_out_personnel').val(
                    r.pull_out_personnel ?? ''
                );

                $('#edit_service_eng_id').val(
                    r.service_eng_id ?? ''
                );

                $('#edit_accounts').val(
                    r.accounts ?? ''
                );

                $('#edit_address').val(
                    r.address ?? ''
                );

                $('#edit_date_fillup').val(
                    r.date_fillup ?? ''
                );

                $('#edit_unit').val(
                    r.unit ?? ''
                );

                populateEditMfsMachines(
                    r.machine ?? '',
                    r.serial_number ?? ''
                );

                $('#edit_serial_number').val(
                    r.serial_number ?? ''
                );

                $('#edit_reason').val(
                    r.reason ?? ''
                );

                $('#edit_date_status').val(
                    r.date_status ?? ''
                );

                $('#edit_returned_personnel').val(
                    r.returned_personnel ?? ''
                );

                $('#edit_acknowledged').val(
                    r.acknowledged ?? 0
                );

                $('#edit_remarks').val(
                    r.remarks ?? ''
                );

                const receiptId = Number(r.receipt || 0);
                const receiptUrl = receiptId > 0
                    ? `<?= site_url('pms/receipt/') ?>${encodeURIComponent(receiptId)}`
                    : '';

                setReceiptUploadPreview('edit_mfs_receipt', 'editMfsReceiptPreview', 'editMfsReceiptView', receiptUrl);

                const existingAccessories = Array.isArray(r.accessories)
                    ? r.accessories
                    : String(r.accessories || '').split(';').map(v => v.trim()).filter(Boolean);

                const existingConsumables = Array.isArray(r.consumables)
                    ? r.consumables
                    : String(r.consumables || '').split(';').map(v => v.trim()).filter(Boolean);

                const editAccessoryRows = document.getElementById('editMfsAccessoryRows');
                if (editAccessoryRows) {
                    editAccessoryRows.innerHTML = '';

                    if (existingAccessories.length > 0) {
                        existingAccessories.forEach((entry) => {
                            const match = entry.split('|');
                            const name = match[0]?.trim() || '';
                            const quantity = match[1]?.trim() || '1';
                            addAccessoryRow('editMfsAccessoryRows');
                            const row = editAccessoryRows.lastElementChild;
                            const nameInput = row?.querySelector('input[name^="accessories"][name$="[name]"]');
                            const quantityInput = row?.querySelector('input[name^="accessories"][name$="[quantity]"]');
                            if (nameInput) nameInput.value = name;
                            if (quantityInput) quantityInput.value = quantity;
                        });
                    } else {
                        addAccessoryRow('editMfsAccessoryRows');
                    }
                }

                const editConsumableRows = document.getElementById('editMfsConsumableRows');
                if (editConsumableRows) {
                    editConsumableRows.innerHTML = '';

                    if (existingConsumables.length > 0) {
                        existingConsumables.forEach((entry) => {
                            const match = String(entry).split('|').map(part => part.trim());
                            const name = match[0] || '';
                            const hasUnitInEntry = match.length >= 3;
                            const unitValue = hasUnitInEntry ? match[1] : (r.consumable_unit || '');
                            const lotNumber = hasUnitInEntry ? match[2] : (match[1] || '');
                            addConsumableRow('editMfsConsumableRows');
                            const row = editConsumableRows.lastElementChild;
                            const nameInput = row?.querySelector('input[name^="consumables_rows"][name$="[name]"]');
                            const unitInput = row?.querySelector('input[name^="consumables_rows"][name$="[unit]"]');
                            const lotInput = row?.querySelector('input[name^="consumables_rows"][name$="[lot_number]"]');
                            if (nameInput) nameInput.value = name;
                            if (unitInput) unitInput.value = unitValue;
                            if (lotInput) lotInput.value = lotNumber;
                        });
                    } else {
                        addConsumableRow('editMfsConsumableRows');
                    }
                }


                // =================================================
                // SET UPDATE URL
                // =================================================

                $('#editMfsForm').attr(
                    'action',
                    "<?= site_url('mfs/update/') ?>" + id
                );


                // =================================================
                // SHOW EDIT MODAL
                // =================================================

                const modalElement =
                    document.getElementById('editMfsModal');

                if (modalElement) {

                    const modal =
                        bootstrap.Modal.getOrCreateInstance(
                            modalElement
                        );

                    modal.show();

                }

            },

            error: function (xhr) {

                console.error(
                    'MFS EDIT ERROR:',
                    xhr.responseText
                );

                showMfsAlert('error', 'Unable to load MFS', 'Unable to load the MFS record.');

            }

        });

    });


    // ============================================================
    // UPDATE MFS
    // ============================================================

    $('#editMfsForm').on('submit', function (e) {

        e.preventDefault();


        const form = this;

        const $button =
            $('#updateMfsBtn');


        /*
         * Prevent double submit
         */
        $button.prop(
            'disabled',
            true
        );


        $button.html(
            '<span class="spinner-border spinner-border-sm me-1"></span>' +
            'Updating...'
        );


        const formData = new FormData(form);

        $.ajax({

            url: $(form).attr('action'),

            type: 'POST',

            data: formData,

            processData: false,

            contentType: false,

            dataType: 'json',

            success: function (response) {

                if (
                    response &&
                    response.success
                ) {


                    // =============================================
                    // CLOSE MODAL
                    // =============================================

                    const modalElement =
                        document.getElementById(
                            'editMfsModal'
                        );

                    if (modalElement) {

                        const modal =
                            bootstrap.Modal.getInstance(
                                modalElement
                            );

                        if (modal) {
                            modal.hide();
                        }

                    }


                    // =============================================
                    // SUCCESS MESSAGE
                    // =============================================

                    showMfsAlert('success', 'Updated', response.message || 'MFS record updated successfully.', true);

                } else {

                    showMfsAlert('error', 'Update Failed', response?.message || 'Unable to update MFS record.');

                }

            },

            error: function (xhr) {

                console.error(
                    'MFS UPDATE ERROR:',
                    xhr.responseText
                );

                showMfsAlert('error', 'Update Failed', 'An error occurred while updating the MFS record.');

            },

            complete: function () {

                $button.prop(
                    'disabled',
                    false
                );

                $button.html(
                    '<i class="bi bi-save me-1"></i>' +
                    'Update MFS'
                );

            }

        });

    });


    // ============================================================
    // DELETE MFS
    // ============================================================

    $(document).on('click', '.delete-mfs-btn', function () {

        const id =
            $(this).data('id');

        const mfsNumber =
            $(this).data('mfs') || '';


        if (!id) {

            showMfsAlert('error', 'Unable to delete MFS', 'Invalid MFS record.');

            return;
        }


        Swal.fire({
            icon: 'warning',
            title: 'Delete MFS record?',
            text: 'Delete MFS ' + mfsNumber + '? This action cannot be undone.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc3545'
        }).then(function (confirmation) {
            if (!confirmation.isConfirmed) {
                return;
            }


        /*
         * DELETE REQUEST
         */
        $.ajax({

            url:
                "<?= site_url('mfs/delete/') ?>" +
                id,

            type: 'POST',

            data: {

                <?= csrf_token() ?>:
                    '<?= csrf_hash() ?>'

            },

            dataType: 'json',

            success: function (response) {

                if (
                    response &&
                    response.success
                ) {

                    showMfsAlert('success', 'Deleted', response.message || 'MFS record deleted successfully.', true);

                } else {

                    showMfsAlert('error', 'Delete Failed', response?.message || 'Unable to delete MFS record.');

                }

            },

            error: function (xhr) {

                console.error(
                    'MFS DELETE ERROR:',
                    xhr.responseText
                );

                showMfsAlert('error', 'Delete Failed', 'An error occurred while deleting the MFS record.');

            }

            });
        });

    });

});


// ================================================================
// AUTOMATICALLY HIDE FLASH MESSAGES
// ================================================================

setTimeout(function () {

    const messages =
        document.querySelectorAll(
            '.flash-message'
        );


    messages.forEach(function (message) {

        message.style.opacity =
            '0';


        setTimeout(function () {

            message.remove();

        }, 500);

    });

}, 5000);


// ================================================================
// ACCOUNT / MACHINE / SERIAL HANDLING
// ================================================================

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const accountSelect =
            document.getElementById(
                'mfs_accounts'
            );


        const addressInput =
            document.getElementById(
                'mfs_address'
            );


        const machineSelect =
            document.getElementById(
                'mfs_machine'
            );


        const serialInput =
            document.getElementById(
                'mfs_serial'
            );


        function getSelectedAccountOption(selectElement) {
            if (!selectElement || !selectElement.value) {
                return null;
            }

            const selectedValue = String(selectElement.value).trim();

            if (!selectedValue) {
                return null;
            }

            return Array.from(selectElement.options).find(function (option) {
                return String(option.value).trim() === selectedValue;
            }) || null;
        }


        /*
         * Machine => Serial Number
         */
        let currentMachines = {};


        // ========================================================
        // ACCOUNT / CLINIC CHANGED
        // ========================================================

        if (accountSelect) {

            function refreshClinicDetails(event) {
                let selected = null;

                if (event && event.params && event.params.data && event.params.data.element) {
                    selected = event.params.data.element;
                } else if (accountSelect.selectedIndex >= 0) {
                    selected = accountSelect.options[accountSelect.selectedIndex];
                }

                if (!selected || !selected.value) {
                    if (addressInput) {
                        addressInput.value = '';
                    }

                    if (machineSelect) {
                        machineSelect.innerHTML = '<option value="">-- Select Machine --</option>';
                        machineSelect.disabled = true;
                    }

                    if (serialInput) {
                        serialInput.value = '';
                    }

                    currentMachines = {};
                    return;
                }

                const address = selected.getAttribute('data-address') || selected.dataset?.address || '';

                if (addressInput) {
                    addressInput.value = address;
                }

                const machinesJson = selected.getAttribute('data-machines') || selected.dataset?.machines || '{}';

                try {
                    currentMachines = JSON.parse(machinesJson);
                } catch (error) {
                    console.error('Invalid machine mapping:', error);
                    currentMachines = {};
                }

                if (machineSelect) {
                    machineSelect.innerHTML = '<option value="">-- Select Machine --</option>';

                    const machines = Object.keys(currentMachines);

                    if (machines.length > 0) {
                        machines.forEach(function (machine) {
                            const option = document.createElement('option');
                            option.value = machine;
                            option.textContent = machine;
                            machineSelect.appendChild(option);
                        });

                        machineSelect.disabled = false;
                    } else {
                        machineSelect.innerHTML = '<option value="">-- No Machine Found --</option>';
                        machineSelect.disabled = true;
                    }
                }

                if (serialInput) {
                    serialInput.value = '';
                }
            }

            $(accountSelect)
                .on('change select2:select select2:clear', refreshClinicDetails);
        }


        // ========================================================
        // MACHINE CHANGED
        // ========================================================

        if (machineSelect) {

            machineSelect.addEventListener(
                'change',
                function () {


                    const selectedMachine =
                        (
                            machineSelect.value ||
                            ''
                        )
                        .toString()
                        .trim()
                        .toLowerCase();


                    let serial =
                        '';


                    // =================================================
                    // FIND SERIAL NUMBER
                    // =================================================

                    Object.keys(
                        currentMachines
                    ).some(
                        function (machine) {


                            if (
                                machine
                                    .toString()
                                    .trim()
                                    .toLowerCase() ===
                                selectedMachine
                            ) {

                                serial =
                                    currentMachines[
                                        machine
                                    ] || '';


                                return true;

                            }


                            return false;

                        }
                    );


                    // =================================================
                    // SET SERIAL NUMBER
                    // =================================================

                    if (serialInput) {

                        serialInput.value =
                            serial;

                    }

                }
            );

        }

    }
);

</script>