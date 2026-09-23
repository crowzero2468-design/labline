<script>
$(document).ready(function () {

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

            alert('Invalid MFS record.');

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

                    alert(
                        response?.message ||
                        'Unable to load MFS record.'
                    );

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

                $('#edit_employee').val(
                    r.employee ?? ''
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

                $('#edit_machine').val(
                    r.machine ?? ''
                );

                $('#edit_serial_number').val(
                    r.serial_number ?? ''
                );

                $('#edit_consumable_unit').val(
                    r.consumable_unit ?? ''
                );

                $('#edit_consumables').val(
                    r.consumables ?? ''
                );

                $('#edit_lot_number').val(
                    r.lot_number ?? ''
                );

                $('#edit_reason').val(
                    r.reason ?? ''
                );

                $('#edit_date_status').val(
                    r.date_status ?? ''
                );

                $('#edit_personnel').val(
                    r.personnel ?? ''
                );

                $('#edit_acknowledged').val(
                    r.acknowledged ?? 0
                );

                $('#edit_returned').val(
                    r.returned ?? 0
                );

                $('#edit_remarks').val(
                    r.remarks ?? ''
                );


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

                alert(
                    'Unable to load the MFS record.'
                );

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


        $.ajax({

            url: $(form).attr('action'),

            type: 'POST',

            data: $(form).serialize(),

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

                    alert(
                        response.message ||
                        'MFS record updated successfully.'
                    );


                    // =============================================
                    // REFRESH TABLE
                    // =============================================

                    location.reload();

                } else {

                    alert(
                        response?.message ||
                        'Unable to update MFS record.'
                    );

                }

            },

            error: function (xhr) {

                console.error(
                    'MFS UPDATE ERROR:',
                    xhr.responseText
                );

                alert(
                    'An error occurred while updating the MFS record.'
                );

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

            alert(
                'Invalid MFS record.'
            );

            return;
        }


        /*
         * Native browser confirmation
         */
        const confirmed =
            confirm(
                'Are you sure you want to delete MFS ' +
                mfsNumber +
                '?\n\n' +
                'This action cannot be undone.'
            );


        if (!confirmed) {
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

                    alert(
                        response.message ||
                        'MFS record deleted successfully.'
                    );


                    location.reload();

                } else {

                    alert(
                        response?.message ||
                        'Unable to delete MFS record.'
                    );

                }

            },

            error: function (xhr) {

                console.error(
                    'MFS DELETE ERROR:',
                    xhr.responseText
                );

                alert(
                    'An error occurred while deleting the MFS record.'
                );

            }

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


        /*
         * Machine => Serial Number
         */
        let currentMachines = {};


        // ========================================================
        // ACCOUNT / CLINIC CHANGED
        // ========================================================

        if (accountSelect) {

            accountSelect.addEventListener(
                'change',
                function () {


                    const selected =
                        accountSelect.options[
                            accountSelect.selectedIndex
                        ];


                    // ------------------------------------------------
                    // NO ACCOUNT SELECTED
                    // ------------------------------------------------

                    if (
                        !selected ||
                        !selected.value
                    ) {

                        if (addressInput) {

                            addressInput.value =
                                '';

                        }


                        if (machineSelect) {

                            machineSelect.innerHTML =
                                '<option value="">-- Select Machine --</option>';

                            machineSelect.disabled =
                                true;

                        }


                        if (serialInput) {

                            serialInput.value =
                                '';

                        }


                        currentMachines =
                            {};

                        return;
                    }


                    // =================================================
                    // GET ADDRESS
                    // =================================================

                    const address =
                        selected.getAttribute(
                            'data-address'
                        ) || '';


                    if (addressInput) {

                        addressInput.value =
                            address;

                    }


                    // =================================================
                    // GET MACHINE => SERIAL MAP
                    // =================================================

                    const machinesJson =
                        selected.getAttribute(
                            'data-machines'
                        ) || '{}';


                    try {

                        currentMachines =
                            JSON.parse(
                                machinesJson
                            );

                    } catch (error) {

                        console.error(
                            'Invalid machine mapping:',
                            error
                        );

                        currentMachines =
                            {};

                    }


                    // =================================================
                    // POPULATE MACHINE DROPDOWN
                    // =================================================

                    if (machineSelect) {

                        machineSelect.innerHTML =
                            '<option value="">-- Select Machine --</option>';


                        const machines =
                            Object.keys(
                                currentMachines
                            );


                        if (
                            machines.length > 0
                        ) {

                            machines.forEach(
                                function (machine) {

                                    const option =
                                        document.createElement(
                                            'option'
                                        );


                                    option.value =
                                        machine;


                                    option.textContent =
                                        machine;


                                    machineSelect.appendChild(
                                        option
                                    );

                                }
                            );


                            machineSelect.disabled =
                                false;

                        } else {

                            machineSelect.innerHTML =
                                '<option value="">-- No Machine Found --</option>';

                            machineSelect.disabled =
                                true;

                        }

                    }


                    // =================================================
                    // CLEAR SERIAL
                    // =================================================

                    if (serialInput) {

                        serialInput.value =
                            '';

                    }

                }
            );

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