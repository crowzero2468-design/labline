<!-- ==========================================================
     JAVASCRIPT
     ========================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================
       SELECT2 ACCOUNT
       ========================================================== */

    if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {

        $('#data_id').select2({
            placeholder: '-- Select Account --',
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0,
            dropdownParent: $('#addPmsModal')
        });

    }


    /* ==========================================================
       FLASH MESSAGES
       ========================================================== */

    function escapeFlashMessage(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;

    }


    function showFlashMessage(message, type = 'success') {

        document
            .querySelectorAll('.js-flash-message')
            .forEach(function (element) {
                element.remove();
            });


        let icon = 'check-circle';

        if (type === 'danger') {
            icon = 'exclamation-triangle';
        }
        else if (type === 'warning') {
            icon = 'exclamation-circle';
        }
        else if (type === 'info') {
            icon = 'info-circle';
        }


        const flash = document.createElement('div');

        flash.className =
            'alert alert-' +
            type +
            ' alert-dismissible fade show js-flash-message';

        flash.style.position = 'fixed';
        flash.style.top = '12px';
        flash.style.left = '50%';
        flash.style.transform = 'translateX(-50%)';
        flash.style.zIndex = '99999';
        flash.style.width = 'min(90vw, 520px)';
        flash.style.boxShadow = '0 4px 15px rgba(0,0,0,0.15)';
        flash.style.transition = 'opacity 0.5s ease';


        flash.innerHTML = `
            <i class="bi bi-${icon} me-2"></i>

            <strong>
                ${type === 'success' ? 'Success!' : 'Notice!'}
            </strong>

            <span class="ms-1">
                ${escapeFlashMessage(message)}
            </span>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>
        `;


        document.body.appendChild(flash);


        setTimeout(function () {

            if (!flash.parentNode) {
                return;
            }

            flash.style.opacity = '0';

            setTimeout(function () {

                if (flash.parentNode) {
                    flash.remove();
                }

            }, 500);

        }, 5000);

    }


    setTimeout(function () {

        document
            .querySelectorAll('.flash-message')
            .forEach(function (message) {

                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease';

                setTimeout(function () {
                    message.remove();
                }, 500);

            });

    }, 5000);


    /* ==========================================================
       ELEMENTS
       ========================================================== */

    const dataSelect =
        document.getElementById('data_id');

    const addressInput =
        document.getElementById('address');

    const machineRows =
        document.getElementById('machineRows');

    const addMachineBtn =
        document.getElementById('addMachineBtn');

    const pmsForm =
        document.getElementById('addPmsForm');

    const mfsForm =
        document.getElementById('mfsForm');

    const fsrForm =
        document.getElementById('fsrForm');


    /* ==========================================================
       STATE
       ========================================================== */

    let currentClinicMachines = {};

    let machineRowIndex = 0;

    let pendingMfs = false;

    let pendingFsr = false;

    let savedPmsData = null;

    let savedPmsRecords = [];


    /* ==========================================================
       TECHNICAL DONE OPTIONS
       ========================================================== */

    function getTechnicalOptions(machine) {

        const m =
            (machine || '')
                .toString()
                .toLowerCase()
                .trim();


        if (m.indexOf('hematology') !== -1) {

            return [
                'Light PMS',
                'Mid PMS',
                'Heavy PMS',
                'Troubleshooting',
                'Quality Control',
                'Installation',
                'Relocation'
            ];

        }


        if (m.indexOf('chemistry') !== -1) {

            return [
                'Manual Checking',
                'For Release',
                'New Accessed',
                'Cancelled Service'
            ];

        }


        if (m !== '') {

            return [
                'Manual Checking',
                'For Release',
                'New Accessed',
                'Cancelled Service'
            ];

        }


        return [];

    }


    /* ==========================================================
       CREATE MACHINE ROW
       ========================================================== */

    function createMachineRow() {

        const index = machineRowIndex++;


        const row = document.createElement('div');

        row.className =
            'machine-row border rounded p-3 mb-3 bg-white';

        row.dataset.index = index;


        row.innerHTML = `

            <div class="row g-3 align-items-end">

                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Machine Type
                    </label>

                    <select
                        name="machines[${index}][machine]"
                        class="form-select machine-select"
                        required>

                        <option value="">
                            -- Select Machine --
                        </option>

                    </select>

                </div>


                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Serial Number
                    </label>

                    <input
                        type="text"
                        name="machines[${index}][sn]"
                        class="form-control machine-sn"
                        readonly>

                </div>


                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Technical Done
                    </label>

                    <select
                        name="machines[${index}][technical_done]"
                        class="form-select technical-done"
                        required>

                        <option value="">
                            -- Select Technical Done --
                        </option>

                    </select>

                </div>


                <div class="col-md-1 text-end">

                    <button
                        type="button"
                        class="btn btn-outline-danger remove-machine"
                        title="Remove Machine">

                        <i class="bi bi-trash"></i>

                    </button>

                </div>

            </div>
        `;


        if (!machineRows) {
            return row;
        }


        machineRows.appendChild(row);


        const machineSelect =
            row.querySelector('.machine-select');

        const serialInput =
            row.querySelector('.machine-sn');

        const technicalSelect =
            row.querySelector('.technical-done');

        const removeButton =
            row.querySelector('.remove-machine');


        populateMachineSelect(machineSelect);


        machineSelect.addEventListener('change', function () {

            const machine = this.value;

            serialInput.value =
                currentClinicMachines[machine] || '';

            populateTechnicalDone(
                technicalSelect,
                machine
            );

        });


        removeButton.addEventListener('click', function () {

            row.remove();

            updateRemoveButtons();

        });


        updateRemoveButtons();


        return row;

    }


    /* ==========================================================
       POPULATE MACHINE SELECT
       ========================================================== */

    function populateMachineSelect(select) {

        if (!select) {
            return;
        }


        select.innerHTML = `
            <option value="">
                -- Select Machine --
            </option>
        `;


        Object.keys(currentClinicMachines).forEach(function (machine) {

            const option =
                document.createElement('option');

            option.value = machine;
            option.textContent = machine;

            select.appendChild(option);

        });


        select.disabled =
            Object.keys(currentClinicMachines).length === 0;

    }


    /* ==========================================================
       POPULATE TECHNICAL DONE
       ========================================================== */

    function populateTechnicalDone(select, machine) {

        if (!select) {
            return;
        }


        select.innerHTML = `
            <option value="">
                -- Select Technical Done --
            </option>
        `;


        getTechnicalOptions(machine).forEach(function (text) {

            const option =
                document.createElement('option');

            option.value = text;
            option.textContent = text;

            select.appendChild(option);

        });

    }


    /* ==========================================================
       UPDATE REMOVE BUTTONS
       ========================================================== */

    function updateRemoveButtons() {

        if (!machineRows) {
            return;
        }


        const rows =
            machineRows.querySelectorAll('.machine-row');


        rows.forEach(function (row) {

            const button =
                row.querySelector('.remove-machine');

            if (button) {
                button.disabled = rows.length === 1;
            }

        });

    }


    /* ==========================================================
       RESET MACHINE ROWS
       ========================================================== */

    function resetMachineRows() {

        if (!machineRows) {
            return;
        }


        machineRows.innerHTML = '';

        machineRowIndex = 0;

        createMachineRow();

    }


    /* ==========================================================
       LOAD SELECTED CLINIC
       ========================================================== */

    function loadSelectedClinic() {

        if (!dataSelect) {
            return;
        }


        const selected =
            dataSelect.options[dataSelect.selectedIndex];


        if (!selected || !selected.value) {

            if (addressInput) {
                addressInput.value = '';
            }

            currentClinicMachines = {};

            if (addMachineBtn) {
                addMachineBtn.disabled = true;
            }

            resetMachineRows();

            return;
        }


        const clinic =
            selected.getAttribute('data-clinic') || '';

        const address =
            selected.getAttribute('data-address') || '';

        const machinesJson =
            selected.getAttribute('data-machines') || '';


        console.log('Selected Clinic:', clinic);
        console.log('Selected Address:', address);
        console.log('Machine JSON:', machinesJson);


        if (addressInput) {
            addressInput.value = address;
        }


        try {

            currentClinicMachines =
                machinesJson
                    ? JSON.parse(machinesJson)
                    : {};

        }
        catch (error) {

            console.error(
                'Unable to read machine data:',
                error
            );

            currentClinicMachines = {};

        }


        console.log(
            'Clinic Machines:',
            currentClinicMachines
        );


        if (addMachineBtn) {

            addMachineBtn.disabled =
                Object.keys(currentClinicMachines).length === 0;

        }


        resetMachineRows();


        const firstRow =
            machineRows
                ? machineRows.querySelector('.machine-row')
                : null;


        if (!firstRow) {
            return;
        }


        const select =
            firstRow.querySelector('.machine-select');

        const serial =
            firstRow.querySelector('.machine-sn');

        const technical =
            firstRow.querySelector('.technical-done');


        const machines =
            Object.keys(currentClinicMachines);


        if (machines.length === 0) {
            return;
        }


        const firstMachine = machines[0];


        select.value = firstMachine;

        serial.value =
            currentClinicMachines[firstMachine] || '';


        populateTechnicalDone(
            technical,
            firstMachine
        );

    }


    /* ==========================================================
       ACCOUNT CHANGE
       ========================================================== */

    if (
        typeof $ !== 'undefined' &&
        typeof $.fn.select2 !== 'undefined'
    ) {

        $('#data_id').on(
            'change',
            loadSelectedClinic
        );

    }
    else if (dataSelect) {

        dataSelect.addEventListener(
            'change',
            loadSelectedClinic
        );

    }


    /* ==========================================================
       ADD MACHINE
       ========================================================== */

    if (addMachineBtn) {

        addMachineBtn.addEventListener(
            'click',
            function () {

                if (
                    Object.keys(currentClinicMachines).length === 0
                ) {
                    return;
                }

                createMachineRow();

            }
        );

    }


    /* ==========================================================
       INITIAL MACHINE ROW
       ========================================================== */

    resetMachineRows();


    /* ==========================================================
       GET PMS DATA
       ========================================================== */

    function getPmsDataFromForm() {

        const selectedAccount =
            dataSelect
                ? dataSelect.options[dataSelect.selectedIndex]
                : null;


        const engineerSelect =
            document.getElementById('service_eng_id');


        let serviceEngineer = '';


        if (
            engineerSelect &&
            engineerSelect.selectedIndex >= 0
        ) {

            serviceEngineer =
                engineerSelect.options[
                    engineerSelect.selectedIndex
                ].textContent.trim();

        }


        const rows =
            machineRows
                ? machineRows.querySelectorAll('.machine-row')
                : [];


        const machines = [];


        rows.forEach(function (row) {

            machines.push({

                machine:
                    row.querySelector('.machine-select')?.value || '',

                sn:
                    row.querySelector('.machine-sn')?.value || '',

                technical_done:
                    row.querySelector('.technical-done')?.value || ''

            });

        });


        const firstMachine =
            machines.length > 0
                ? machines[0]
                : {};


        return {

            pms_number:
                document.getElementById('pms_number')?.value || '',

            service_tech:
                serviceEngineer,

            clinic:
                selectedAccount
                    ? (
                        selectedAccount.getAttribute('data-clinic') || ''
                    )
                    : '',

            address:
                addressInput?.value || '',

            date:
                document.getElementById('pms_date')?.value || '',

            machine:
                firstMachine.machine || '',

            sn:
                firstMachine.sn || '',

            technical_done:
                firstMachine.technical_done || '',

            machines:
                machines

        };

    }


    /* ==========================================================
       SHOW MFS MODAL
       ========================================================== */

    function showMfsModal() {

        populateMfsFromPms(savedPmsData);


        const element =
            document.getElementById('mfsModal');


        if (!element) {

            console.error('MFS modal not found.');

            return;

        }


        bootstrap.Modal
            .getOrCreateInstance(element)
            .show();

    }


    /* ==========================================================
       SHOW FSR MODAL
       ========================================================== */

    function showFsrModal() {

        populateFsrFromPms(savedPmsData);


        const element =
            document.getElementById('fsrModal');


        if (!element) {

            console.error('FSR modal not found.');

            return;

        }


        bootstrap.Modal
            .getOrCreateInstance(element)
            .show();

    }


    /* ==========================================================
       POPULATE MFS FROM PMS
       ========================================================== */

    function populateMfsFromPms(pms) {

        if (!pms) {
            return;
        }


        const employee =
            document.getElementById('mfs_employee');

        const accounts =
            document.getElementById('mfs_accounts');

        const address =
            document.getElementById('mfs_address');

        const machine =
            document.getElementById('mfs_machine');

        const serial =
            document.getElementById('mfs_serial');

        const date =
            document.getElementById('mfs_date_status');


        if (employee) {
            employee.value = pms.service_tech || '';
        }

        if (accounts) {
            accounts.value = pms.clinic || '';
        }

        if (address) {
            address.value = pms.address || '';
        }

        if (machine) {
            machine.value = pms.machine || '';
        }

        if (serial) {
            serial.value = pms.sn || '';
        }

        if (date) {
            date.value = pms.date || '';
        }

    }


    /* ==========================================================
       POPULATE FSR FROM PMS
       ========================================================== */

    function populateFsrFromPms(pms) {

        if (!pms) {
            return;
        }


        const engineer =
            document.getElementById('fsr_service_engineer');

        const account =
            document.getElementById('fsr_account');

        const address =
            document.getElementById('fsr_address');

        const machine =
            document.getElementById('fsr_machine');

        const serial =
            document.getElementById('fsr_serial');


        if (engineer) {
            engineer.value = pms.service_tech || '';
        }

        if (account) {
            account.value = pms.clinic || '';
        }

        if (address) {
            address.value = pms.address || '';
        }

        if (machine) {
            machine.value = pms.machine || '';
        }

        if (serial) {
            serial.value = pms.sn || '';
        }

    }


    /* ==========================================================
       GET PMS ID
       ========================================================== */

    function getPmsId() {

        if (
            savedPmsData &&
            savedPmsData.id
        ) {

            return savedPmsData.id;

        }


        if (
            Array.isArray(savedPmsRecords) &&
            savedPmsRecords.length > 0
        ) {

            const first =
                savedPmsRecords[0];

            return (
                first.id ||
                first.pms_id ||
                ''
            );

        }


        return '';

    }


    /* ==========================================================
       UPDATE SAVED PMS MFS ID
       ========================================================== */

    function updateSavedPmsMfsId(mfsId) {

        if (!mfsId) {
            return;
        }


        if (!savedPmsData) {
            savedPmsData = {};
        }


        savedPmsData.mfs = mfsId;
        savedPmsData.mfs_id = mfsId;


        if (
            Array.isArray(savedPmsRecords) &&
            savedPmsRecords.length > 0
        ) {

            savedPmsRecords[0].mfs = mfsId;
            savedPmsRecords[0].mfs_id = mfsId;

        }


        console.log('Saved MFS ID:', mfsId);

    }


    /* ==========================================================
       UPDATE SAVED PMS FSR ID
       ========================================================== */

    function updateSavedPmsFsrId(fsrId) {

        if (!fsrId) {
            return;
        }


        if (!savedPmsData) {
            savedPmsData = {};
        }


        savedPmsData.fsr = fsrId;
        savedPmsData.fsr_id = fsrId;


        if (
            Array.isArray(savedPmsRecords) &&
            savedPmsRecords.length > 0
        ) {

            savedPmsRecords[0].fsr = fsrId;
            savedPmsRecords[0].fsr_id = fsrId;

        }


        console.log('Saved FSR ID:', fsrId);

    }


    /* ==========================================================
       PMS SUBMIT
       ========================================================== */

    if (pmsForm) {

        pmsForm.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                console.log(
                    'PMS SUBMIT HANDLER RUNNING'
                );


                if (!machineRows) {

                    showFlashMessage(
                        'Machine rows container was not found.',
                        'danger'
                    );

                    return;

                }


                const rows =
                    machineRows.querySelectorAll('.machine-row');


                if (rows.length === 0) {

                    alert(
                        'Please add at least one machine.'
                    );

                    return;

                }


                let valid = true;


                rows.forEach(function (row) {

                    const machine =
                        row.querySelector(
                            '.machine-select'
                        )?.value || '';


                    const technical =
                        row.querySelector(
                            '.technical-done'
                        )?.value || '';


                    if (!machine || !technical) {
                        valid = false;
                    }

                });


                if (!valid) {

                    alert(
                        'Please select a Machine and Technical Done for every machine.'
                    );

                    return;

                }


                pendingMfs =
                    document.getElementById(
                        'mfs_check'
                    )?.checked || false;


                pendingFsr =
                    document.getElementById(
                        'fsr_check'
                    )?.checked || false;


                savedPmsData =
                    getPmsDataFromForm();


                savedPmsRecords = [];


                const saveButton =
                    document.getElementById(
                        'savePmsButton'
                    );


                if (saveButton) {

                    saveButton.disabled = true;

                    saveButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

                }


                const formData =
                    new FormData(pmsForm);


                if (pendingMfs) {
                    formData.set('mfs', '1');
                }
                else {
                    formData.delete('mfs');
                }


                if (pendingFsr) {
                    formData.set('fsr', '1');
                }
                else {
                    formData.delete('fsr');
                }


                fetch(
                    pmsForm.action,
                    {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }
                )

                .then(async function (response) {

                    const text =
                        await response.text();


                    console.log(
                        'PMS response:',
                        text
                    );


                    if (!response.ok) {

                        throw new Error(
                            'HTTP ' +
                            response.status +
                            ': ' +
                            text.substring(0, 500)
                        );

                    }


                    try {

                        return JSON.parse(text);

                    }
                    catch (error) {

                        throw new Error(
                            'PMS server did not return valid JSON.'
                        );

                    }

                })

                .then(function (data) {

                    console.log(
                        'PMS save response:',
                        data
                    );


                    if (!data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to save PMS record.'
                        );

                    }


                    if (Array.isArray(data.records)) {

                        savedPmsRecords =
                            data.records;

                    }
                    else if (
                        Array.isArray(data.pms_records)
                    ) {

                        savedPmsRecords =
                            data.pms_records;

                    }


                    if (data.pms) {

                        savedPmsData =
                            Object.assign(
                                {},
                                savedPmsData,
                                data.pms
                            );

                    }


                    if (
                        data.id &&
                        !savedPmsData.id
                    ) {

                        savedPmsData.id =
                            data.id;

                    }


                    console.log(
                        'Final PMS data:',
                        savedPmsData
                    );


                    showFlashMessage(
                        data.message ||
                        'PMS saved successfully.',
                        'success'
                    );


                    const modalElement =
                        document.getElementById(
                            'addPmsModal'
                        );


                    const modalInstance =
                        modalElement
                            ? bootstrap.Modal.getInstance(
                                modalElement
                            )
                            : null;


                    if (modalInstance) {
                        modalInstance.hide();
                    }


                    setTimeout(function () {

                        if (pendingMfs) {

                            showMfsModal();

                        }
                        else if (pendingFsr) {

                            showFsrModal();

                        }
                        else {

                            setTimeout(function () {
                                location.reload();
                            }, 1500);

                        }

                    }, 500);

                })

                .catch(function (error) {

                    console.error(
                        'PMS save error:',
                        error
                    );


                    showFlashMessage(
                        error.message ||
                        'An error occurred while saving PMS.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save PMS';

                    }

                });

            }
        );

    }


    /* ==========================================================
       MFS SUBMIT
       ========================================================== */

    if (mfsForm) {

        mfsForm.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                console.log(
                    'MFS SUBMIT HANDLER RUNNING'
                );


                const saveButton =
                    document.getElementById(
                        'saveMfsButton'
                    );


                if (saveButton) {

                    saveButton.disabled = true;

                    saveButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

                }


                const formData =
                    new FormData(mfsForm);


                const pmsId =
                    getPmsId();


                if (!pmsId) {

                    showFlashMessage(
                        'PMS ID was not found. MFS cannot be linked to PMS.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save MFS';

                    }


                    return;

                }


                formData.set(
                    'pms_id',
                    pmsId
                );


                console.log(
                    'MFS PMS ID:',
                    pmsId
                );


                fetch(
                    mfsForm.action,
                    {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }
                )

                .then(async function (response) {

                    const text =
                        await response.text();


                    console.log(
                        'MFS response:',
                        text
                    );


                    if (!response.ok) {

                        throw new Error(
                            'HTTP ' +
                            response.status +
                            ': ' +
                            text.substring(0, 500)
                        );

                    }


                    try {

                        return JSON.parse(text);

                    }
                    catch (error) {

                        throw new Error(
                            'MFS server did not return valid JSON.'
                        );

                    }

                })

                .then(function (data) {

                    console.log(
                        'MFS save response:',
                        data
                    );


                    if (!data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to save MFS.'
                        );

                    }


                    const mfsId =
                        data.mfs_id ||
                        data.id ||
                        data.mfs?.id ||
                        '';


                    if (mfsId) {

                        updateSavedPmsMfsId(
                            mfsId
                        );

                    }


                    console.log(
                        'MFS ID returned:',
                        mfsId
                    );


                    showFlashMessage(
                        data.message ||
                        'MFS saved successfully.',
                        'success'
                    );


                    const modalElement =
                        document.getElementById(
                            'mfsModal'
                        );


                    const modal =
                        modalElement
                            ? bootstrap.Modal.getInstance(
                                modalElement
                            )
                            : null;


                    if (modal) {
                        modal.hide();
                    }


                    setTimeout(function () {

                        if (pendingFsr) {

                            showFsrModal();

                        }
                        else {

                            setTimeout(function () {
                                location.reload();
                            }, 1500);

                        }

                    }, 500);

                })

                .catch(function (error) {

                    console.error(
                        'MFS save error:',
                        error
                    );


                    showFlashMessage(
                        error.message ||
                        'An error occurred while saving MFS.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save MFS';

                    }

                });

            }
        );

    }


    /* ==========================================================
       FSR SUBMIT
       ========================================================== */

    if (fsrForm) {

        fsrForm.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                console.log(
                    'FSR SUBMIT HANDLER RUNNING'
                );


                const saveButton =
                    document.getElementById(
                        'saveFsrButton'
                    );


                if (saveButton) {

                    saveButton.disabled = true;

                    saveButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

                }


                const formData =
                    new FormData(fsrForm);


                const pmsId =
                    getPmsId();


                if (!pmsId) {

                    showFlashMessage(
                        'PMS ID was not found. FSR cannot be linked to PMS.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save FSR';

                    }


                    return;

                }


                formData.set(
                    'pms_id',
                    pmsId
                );


                console.log(
                    'FSR PMS ID:',
                    pmsId
                );


                fetch(
                    fsrForm.action,
                    {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }
                )

                .then(async function (response) {

                    const text =
                        await response.text();


                    console.log(
                        'FSR response:',
                        text
                    );


                    if (!response.ok) {

                        throw new Error(
                            'HTTP ' +
                            response.status +
                            ': ' +
                            text.substring(0, 500)
                        );

                    }


                    try {

                        return JSON.parse(text);

                    }
                    catch (error) {

                        throw new Error(
                            'FSR server did not return valid JSON.'
                        );

                    }

                })

                .then(function (data) {

                    console.log(
                        'FSR save response:',
                        data
                    );


                    if (!data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to save FSR.'
                        );

                    }


                    const fsrId =
                        data.fsr_id ||
                        data.id ||
                        data.fsr?.id ||
                        '';


                    if (fsrId) {

                        updateSavedPmsFsrId(
                            fsrId
                        );

                    }


                    console.log(
                        'FSR ID returned:',
                        fsrId
                    );


                    showFlashMessage(
                        data.message ||
                        'FSR saved successfully.',
                        'success'
                    );


                    const modalElement =
                        document.getElementById(
                            'fsrModal'
                        );


                    const modal =
                        modalElement
                            ? bootstrap.Modal.getInstance(
                                modalElement
                            )
                            : null;


                    if (modal) {
                        modal.hide();
                    }


                    setTimeout(function () {

                        location.reload();

                    }, 1200);

                })

                .catch(function (error) {

                    console.error(
                        'FSR save error:',
                        error
                    );


                    showFlashMessage(
                        error.message ||
                        'An error occurred while saving FSR.',
                        'danger'
                    );


                    if (saveButton) {

                        saveButton.disabled = false;

                        saveButton.innerHTML =
                            '<i class="bi bi-save"></i> Save FSR';

                    }

                });

            }
        );

    }


    /* ==========================================================
       RESET BUTTONS WHEN MODALS CLOSE
       ========================================================== */

    [
        {
            modal: 'addPmsModal',
            button: 'savePmsButton',
            html: '<i class="bi bi-save"></i> Save PMS'
        },
        {
            modal: 'mfsModal',
            button: 'saveMfsButton',
            html: '<i class="bi bi-save"></i> Save MFS'
        },
        {
            modal: 'fsrModal',
            button: 'saveFsrButton',
            html: '<i class="bi bi-save"></i> Save FSR'
        }
    ].forEach(function (item) {

        const modal =
            document.getElementById(item.modal);


        if (!modal) {
            return;
        }


        modal.addEventListener(
            'hidden.bs.modal',
            function () {

                const button =
                    document.getElementById(
                        item.button
                    );


                if (button) {

                    button.disabled = false;

                    button.innerHTML =
                        item.html;

                }

            }
        );

    });


    /* ==========================================================
       ESCAPE HTML
       ========================================================== */

    function escapeHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {
            return '';
        }


        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    /* ==========================================================
       DISPLAY VALUE
       ========================================================== */

    function displayValue(value) {

        if (
            value === null ||
            value === undefined ||
            value === ''
        ) {

            return '<span class="text-muted">N/A</span>';

        }


        return escapeHtml(value);

    }


    /* ==========================================================
       LOAD MFS RECORD
       ========================================================== */

    document.addEventListener(
        'click',
        function (event) {

            const button =
                event.target.closest('.view-mfs-btn');

            if (!button) {
                return;
            }


            const mfsId =
                button.getAttribute('data-mfs-id');


            const content =
                document.getElementById('mfsViewContent');


            console.log('MFS BUTTON CLICKED');
            console.log('MFS ID:', mfsId);


            if (!content) {
                console.error('mfsViewContent not found.');
                return;
            }


            if (!mfsId || mfsId === '0') {

                content.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        MFS ID is missing.
                    </div>
                `;

                return;

            }


            content.innerHTML = `
                <div class="text-center py-5">

                    <div
                        class="spinner-border text-primary"
                        role="status">
                    </div>

                    <div class="mt-3">
                        Loading MFS record...
                    </div>

                </div>
            `;


            const url =
                `<?= site_url('pms/view-mfs/') ?>${encodeURIComponent(mfsId)}`;


            console.log('MFS REQUEST URL:', url);


            fetch(
                url,
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            )

            .then(async function (response) {

                const text =
                    await response.text();


                console.log(
                    'MFS HTTP STATUS:',
                    response.status
                );


                console.log(
                    'MFS SERVER RESPONSE:',
                    text
                );


                if (!response.ok) {

                    throw new Error(
                        'HTTP ' +
                        response.status +
                        ': ' +
                        text.substring(0, 500)
                    );

                }


                try {

                    return JSON.parse(text);

                }
                catch (error) {

                    throw new Error(
                        'Server did not return valid JSON.'
                    );

                }

            })

            .then(function (result) {

                console.log('MFS RESULT:', result);


                if (
                    !result ||
                    !result.success
                ) {

                    throw new Error(
                        result?.message ||
                        'MFS record not found.'
                    );

                }


                const mfs =
                    result.data || {};


                /* ==================================================
                   RECEIPT
                   ================================================== */

                let receiptHtml = '';


                if (
                    mfs.receipt &&
                    Number(mfs.receipt) > 0
                ) {

                    const receiptUrl =
                        `<?= site_url('pms/receipt/') ?>${encodeURIComponent(mfs.receipt)}`;


                    receiptHtml = `

                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header bg-success text-white">

                                <h5 class="mb-0">
                                    <i class="bi bi-receipt me-2"></i>
                                    Receipt
                                </h5>

                            </div>

                            <div class="card-body">

                                <div class="text-center">

                                    <div class="mb-3">

                                        <span class="badge bg-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Receipt Attached

                                        </span>

                                    </div>


                                    <div
                                        class="border rounded p-3 bg-light">

                                        <img
                                            src="${receiptUrl}"
                                            class="img-fluid rounded shadow-sm"
                                            style="
                                                max-height: 650px;
                                                max-width: 100%;
                                                object-fit: contain;
                                            "
                                            alt="MFS Receipt"
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.style.display='block';
                                            "
                                        >


                                        <div
                                            style="display:none;"
                                            class="alert alert-danger mb-0">

                                            <i class="bi bi-exclamation-triangle me-2"></i>

                                            Unable to display the receipt image.

                                        </div>

                                    </div>


                                    <div class="mt-3">

                                        <a
                                            href="${receiptUrl}"
                                            target="_blank"
                                            class="btn btn-sm btn-outline-primary">

                                            <i class="bi bi-box-arrow-up-right me-1"></i>

                                            Open Receipt

                                        </a>

                                    </div>


                                    ${
                                        mfs.receipt_date
                                        ? `
                                            <div class="text-muted small mt-2">

                                                Uploaded:
                                                ${displayValue(mfs.receipt_date)}

                                            </div>
                                          `
                                        : ''
                                    }

                                </div>

                            </div>

                        </div>

                    `;

                }
                else {

                    receiptHtml = `

                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header">

                                <h5 class="mb-0">
                                    <i class="bi bi-receipt me-2"></i>
                                    Receipt
                                </h5>

                            </div>

                            <div class="card-body">

                                <div class="alert alert-secondary mb-0">

                                    <i class="bi bi-info-circle me-2"></i>

                                    No receipt attached to this MFS record.

                                </div>

                            </div>

                        </div>

                    `;

                }


                /* ==================================================
                   MFS INFORMATION
                   ================================================== */

                content.innerHTML = `

                    <div class="container-fluid">

                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header bg-primary text-white">

                                <h5 class="mb-0">

                                    <i class="bi bi-file-earmark-text me-2"></i>

                                    MFS Information

                                </h5>

                            </div>


                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            MFS Number
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.mfs_number)}
                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            Employee
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.employee)}
                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            Account
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.accounts)}
                                        </div>

                                    </div>


                                    <div class="col-md-3">

                                        <label class="form-label fw-bold">
                                            Date Fill-up
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.date_fillup)}
                                        </div>

                                    </div>


                                    <div class="col-md-3">

                                        <label class="form-label fw-bold">
                                            Date Status
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.date_status)}
                                        </div>

                                    </div>


                                    <div class="col-12">

                                        <label class="form-label fw-bold">
                                            Address
                                        </label>

                                        <div
                                            class="form-control bg-light"
                                            style="min-height:60px;">

                                            ${displayValue(mfs.address)}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header bg-secondary text-white">

                                <h5 class="mb-0">

                                    <i class="bi bi-cpu me-2"></i>

                                    Machine Information

                                </h5>

                            </div>


                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-md-4">

                                        <label class="form-label fw-bold">
                                            Unit
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.unit)}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-bold">
                                            Machine
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.machine)}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-bold">
                                            Serial Number
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.serial_number)}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header">

                                <h5 class="mb-0">

                                    <i class="bi bi-box-seam me-2"></i>

                                    Consumables

                                </h5>

                            </div>


                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-md-4">

                                        <label class="form-label fw-bold">
                                            Consumable Unit
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.consumable_unit)}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-bold">
                                            Consumables
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.consumables)}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-bold">
                                            Lot Number
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.lot_number)}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header">

                                <h5 class="mb-0">

                                    <i class="bi bi-card-text me-2"></i>

                                    Details

                                </h5>

                            </div>


                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-12">

                                        <label class="form-label fw-bold">
                                            Reason
                                        </label>

                                        <div
                                            class="form-control bg-light"
                                            style="min-height:80px; white-space:pre-wrap;">

                                            ${displayValue(mfs.reason)}

                                        </div>

                                    </div>


                                    <div class="col-12">

                                        <label class="form-label fw-bold">
                                            Remarks
                                        </label>

                                        <div
                                            class="form-control bg-light"
                                            style="min-height:80px; white-space:pre-wrap;">

                                            ${displayValue(mfs.remarks)}

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            Personnel
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(mfs.personnel)}
                                        </div>

                                    </div>


                                    <div class="col-md-3">

                                        <label class="form-label fw-bold">
                                            Acknowledged
                                        </label>

                                        <div class="form-control bg-light">

                                            ${
                                                Number(mfs.acknowledged) === 1
                                                ? `
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Yes
                                                    </span>
                                                  `
                                                : `
                                                    <span class="badge bg-secondary">
                                                        No
                                                    </span>
                                                  `
                                            }

                                        </div>

                                    </div>


                                    <div class="col-md-3">

                                        <label class="form-label fw-bold">
                                            Returned
                                        </label>

                                        <div class="form-control bg-light">

                                            ${
                                                Number(mfs.returned) === 1
                                                ? `
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Yes
                                                    </span>
                                                  `
                                                : `
                                                    <span class="badge bg-secondary">
                                                        No
                                                    </span>
                                                  `
                                            }

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        ${receiptHtml}

                    </div>

                `;

            })

            .catch(function (error) {

                console.error(
                    'MFS LOAD ERROR:',
                    error
                );


                content.innerHTML = `

                    <div class="alert alert-danger">

                        <h5>

                            <i class="bi bi-exclamation-triangle me-2"></i>

                            Unable to Load MFS

                        </h5>

                        <hr>

                        <div>
                            ${escapeHtml(error.message)}
                        </div>

                    </div>

                `;

            });

        }
    );


    /* ==========================================================
       LOAD FSR RECORD
       ========================================================== */

    document.addEventListener(
        'click',
        function (event) {

            const button =
                event.target.closest('.view-fsr-btn');

            if (!button) {
                return;
            }


            const fsrId =
                button.getAttribute('data-fsr-id');


            const content =
                document.getElementById('fsrViewContent');


            console.log('FSR BUTTON CLICKED');
            console.log('FSR ID:', fsrId);


            if (!content) {
                console.error('fsrViewContent not found.');
                return;
            }


            if (!fsrId || fsrId === '0') {

                content.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        FSR ID is missing.
                    </div>
                `;

                return;

            }


            content.innerHTML = `
                <div class="text-center py-5">

                    <div
                        class="spinner-border text-primary"
                        role="status">
                    </div>

                    <div class="mt-3">
                        Loading FSR record...
                    </div>

                </div>
            `;


            const url =
                `<?= site_url('pms/view-fsr/') ?>${encodeURIComponent(fsrId)}`;


            console.log('FSR REQUEST URL:', url);


            fetch(
                url,
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            )

            .then(async function (response) {

                const text =
                    await response.text();


                console.log(
                    'FSR HTTP STATUS:',
                    response.status
                );


                console.log(
                    'FSR SERVER RESPONSE:',
                    text
                );


                if (!response.ok) {

                    throw new Error(
                        'HTTP ' +
                        response.status +
                        ': ' +
                        text.substring(0, 500)
                    );

                }


                try {

                    return JSON.parse(text);

                }
                catch (error) {

                    throw new Error(
                        'Server did not return valid JSON.'
                    );

                }

            })

            .then(function (result) {

                console.log('FSR RESULT:', result);


                if (
                    !result ||
                    !result.success
                ) {

                    throw new Error(
                        result?.message ||
                        'FSR record not found.'
                    );

                }


                const fsr =
                    result.data || {};


                /* ==================================================
                   RECEIPT
                   ================================================== */

                let receiptHtml = '';


                if (
                    fsr.receipt &&
                    Number(fsr.receipt) > 0
                ) {

                    const receiptUrl =
                        `<?= site_url('pms/receipt/') ?>${encodeURIComponent(fsr.receipt)}`;


                    receiptHtml = `

                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header bg-success text-white">

                                <h5 class="mb-0">

                                    <i class="bi bi-receipt me-2"></i>

                                    Receipt

                                </h5>

                            </div>


                            <div class="card-body">

                                <div class="text-center">

                                    <div class="mb-3">

                                        <span class="badge bg-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Receipt Attached

                                        </span>

                                    </div>


                                    <div
                                        class="border rounded p-3 bg-light">

                                        <img
                                            src="${receiptUrl}"
                                            class="img-fluid rounded shadow-sm"
                                            style="
                                                max-height: 650px;
                                                max-width: 100%;
                                                object-fit: contain;
                                            "
                                            alt="FSR Receipt"
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.style.display='block';
                                            "
                                        >


                                        <div
                                            style="display:none;"
                                            class="alert alert-danger mb-0">

                                            <i class="bi bi-exclamation-triangle me-2"></i>

                                            Unable to display the receipt image.

                                        </div>

                                    </div>


                                    <div class="mt-3">

                                        <a
                                            href="${receiptUrl}"
                                            target="_blank"
                                            class="btn btn-sm btn-outline-primary">

                                            <i class="bi bi-box-arrow-up-right me-1"></i>

                                            Open Receipt

                                        </a>

                                    </div>


                                    ${
                                        fsr.receipt_date
                                        ? `
                                            <div class="text-muted small mt-2">

                                                Uploaded:
                                                ${displayValue(fsr.receipt_date)}

                                            </div>
                                          `
                                        : ''
                                    }

                                </div>

                            </div>

                        </div>

                    `;

                }
                else {

                    receiptHtml = `

                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header">

                                <h5 class="mb-0">

                                    <i class="bi bi-receipt me-2"></i>

                                    Receipt

                                </h5>

                            </div>


                            <div class="card-body">

                                <div class="alert alert-secondary mb-0">

                                    <i class="bi bi-info-circle me-2"></i>

                                    No receipt attached to this FSR record.

                                </div>

                            </div>

                        </div>

                    `;

                }


                /* ==================================================
                   FSR INFORMATION
                   ================================================== */

                content.innerHTML = `

                    <div class="container-fluid">


                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header bg-primary text-white">

                                <h5 class="mb-0">

                                    <i class="bi bi-file-earmark-text me-2"></i>

                                    FSR Information

                                </h5>

                            </div>


                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            FSR Number
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(fsr.fsr_number)}
                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            Service Engineer
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(fsr.service_engineer)}
                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            Account
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(fsr.account)}
                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            Date
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(fsr.date)}
                                        </div>

                                    </div>


                                    <div class="col-12">

                                        <label class="form-label fw-bold">
                                            Address
                                        </label>

                                        <div
                                            class="form-control bg-light"
                                            style="min-height:60px;">

                                            ${displayValue(fsr.address)}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header bg-secondary text-white">

                                <h5 class="mb-0">

                                    <i class="bi bi-cpu me-2"></i>

                                    Machine Information

                                </h5>

                            </div>


                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            Machine
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(fsr.machine)}
                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            Serial Number
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(fsr.serial_number)}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-header">

                                <h5 class="mb-0">

                                    <i class="bi bi-tools me-2"></i>

                                    Service Details

                                </h5>

                            </div>


                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-12">

                                        <label class="form-label fw-bold">
                                            Technical Concern
                                        </label>

                                        <div
                                            class="form-control bg-light"
                                            style="
                                                min-height:120px;
                                                white-space:pre-wrap;
                                            ">

                                            ${displayValue(fsr.technical_concern)}

                                        </div>

                                    </div>


                                    <div class="col-12">

                                        <label class="form-label fw-bold">
                                            Action Made
                                        </label>

                                        <div
                                            class="form-control bg-light"
                                            style="
                                                min-height:120px;
                                                white-space:pre-wrap;
                                            ">

                                            ${displayValue(fsr.action_made)}

                                        </div>

                                    </div>


                                    <div class="col-12">

                                        <label class="form-label fw-bold">
                                            Remarks
                                        </label>

                                        <div
                                            class="form-control bg-light"
                                            style="
                                                min-height:80px;
                                                white-space:pre-wrap;
                                            ">

                                            ${displayValue(fsr.remarks)}

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-bold">
                                            Acknowledge
                                        </label>

                                        <div class="form-control bg-light">
                                            ${displayValue(fsr.acknowledge)}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        ${receiptHtml}


                    </div>

                `;

            })

            .catch(function (error) {

                console.error(
                    'FSR LOAD ERROR:',
                    error
                );


                content.innerHTML = `

                    <div class="alert alert-danger">

                        <h5>

                            <i class="bi bi-exclamation-triangle me-2"></i>

                            Unable to Load FSR

                        </h5>

                        <hr>

                        <div>
                            ${escapeHtml(error.message)}
                        </div>

                    </div>

                `;

            });

        }
    );


});


/* ==============================================================
   EDIT / DELETE
   ============================================================== */

document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================
       FLASH MESSAGE
       ========================================================== */

    function showMessage(message, type = 'success') {

        document
            .querySelectorAll('.flash-message-js')
            .forEach(function (element) {
                element.remove();
            });


        const isSuccess =
            type === 'success';


        const background =
            isSuccess
                ? '#d1e7dd'
                : '#f8d7da';


        const textColor =
            isSuccess
                ? '#0f5132'
                : '#842029';


        const borderColor =
            isSuccess
                ? '#badbcc'
                : '#f5c2c7';


        const icon =
            isSuccess
                ? 'bi-check-circle-fill'
                : 'bi-exclamation-triangle-fill';


        const messageBox =
            document.createElement('div');


        messageBox.className =
            'flash-message flash-message-js';


        messageBox.style.cssText = `
            position: fixed;
            top: 12px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: min(90vw, 520px);
            padding: 12px 18px;
            border-radius: 6px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            opacity: 1;
            transition: opacity 0.5s ease;
            background: ${background};
            color: ${textColor};
            border: 1px solid ${borderColor};
        `;


        messageBox.innerHTML =
            '<i class="bi ' +
            icon +
            ' me-2"></i>' +
            escapeHtml(message);


        document.body.appendChild(
            messageBox
        );


        setTimeout(function () {

            messageBox.style.opacity =
                '0';


            setTimeout(function () {

                if (messageBox.parentNode) {
                    messageBox.remove();
                }

            }, 500);

        }, 5000);

    }


    /* ==========================================================
       EDIT PMS
       ========================================================== */

    document.addEventListener('click', function (event) {

        const button =
            event.target.closest(
                '.edit-pms-btn'
            );


        if (!button) {
            return;
        }


        const id =
            button.getAttribute(
                'data-id'
            );


        if (!id) {
            return;
        }


        const modalElement =
            document.getElementById(
                'editPmsModal'
            );


        const editForm =
            document.getElementById(
                'editPmsForm'
            );


        if (!modalElement || !editForm) {

            console.error(
                'Edit PMS modal or form not found.'
            );

            return;

        }


        const modal =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );


        editForm.reset();


        const idInput =
            document.getElementById(
                'edit_pms_id'
            );


        if (idInput) {
            idInput.value = id;
        }


        const documentsContent =
            document.getElementById(
                'editPmsDocumentsContent'
            );


        if (documentsContent) {

            documentsContent.innerHTML =
                '<span class="text-muted">' +
                '<i class="bi bi-hourglass-split me-1"></i>' +
                'Loading...' +
                '</span>';

        }


        modal.show();


        fetch(
            '<?= site_url('pms/edit/') ?>' + id,
            {
                method: 'GET',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        )

        .then(function (response) {

            if (!response.ok) {

                throw new Error(
                    'Server returned HTTP ' +
                    response.status
                );

            }

            return response.json();

        })

        .then(function (result) {

            if (!result.success) {

                throw new Error(
                    result.message ||
                    'Unable to load PMS record.'
                );

            }


            const data =
                result.data || {};


            const fields = {

                'edit_pms_id':
                    data.id || '',

                'edit_pms_number':
                    data.pms_number || '',

                'edit_pms_date':
                    data.date || '',

                'edit_pms_address':
                    data.address || '',

                'edit_pms_machine':
                    data.machine || '',

                'edit_pms_sn':
                    data.sn || '',

                'edit_pms_status':
                    data.status || ''

            };


            Object.keys(fields)
                .forEach(function (fieldId) {

                    const field =
                        document.getElementById(
                            fieldId
                        );


                    if (field) {

                        field.value =
                            fields[fieldId];

                    }

                });


            /* ==================================================
               SERVICE ENGINEER
               ================================================== */

            const engineerSelect =
                document.getElementById(
                    'edit_service_eng_id'
                );


            if (engineerSelect) {

                engineerSelect.value =
                    data.service_eng_id || '';


                if (
                    window.jQuery &&
                    window.jQuery.fn.select2
                ) {

                    window.jQuery(
                        '#edit_service_eng_id'
                    ).val(
                        data.service_eng_id || ''
                    ).trigger('change');

                }

            }


            /* ==================================================
               ACCOUNT
               ================================================== */

            const accountSelect =
                document.getElementById(
                    'edit_data_id'
                );


            if (accountSelect) {

                accountSelect.value =
                    data.data_id || '';


                if (
                    window.jQuery &&
                    window.jQuery.fn.select2
                ) {

                    window.jQuery(
                        '#edit_data_id'
                    ).val(
                        data.data_id || ''
                    ).trigger('change');

                }

            }


            /* ==================================================
               DOCUMENT STATUS
               ================================================== */

            let documentsHtml = '';


            if (
                data.mfs &&
                data.mfs.id
            ) {

                documentsHtml +=
                    '<span class="badge bg-success me-2">' +
                    '<i class="bi bi-check-circle me-1"></i>' +
                    'MFS #' +
                    escapeHtml(
                        data.mfs.mfs_number ||
                        data.mfs.id
                    ) +
                    '</span>';

            }
            else {

                documentsHtml +=
                    '<span class="badge bg-secondary me-2">' +
                    'No MFS' +
                    '</span>';

            }


            if (
                data.fsr &&
                data.fsr.id
            ) {

                documentsHtml +=
                    '<span class="badge bg-success me-2">' +
                    '<i class="bi bi-check-circle me-1"></i>' +
                    'FSR #' +
                    escapeHtml(
                        data.fsr.fsr_number ||
                        data.fsr.id
                    ) +
                    '</span>';

            }
            else {

                documentsHtml +=
                    '<span class="badge bg-secondary me-2">' +
                    'No FSR' +
                    '</span>';

            }


            if (
                data.receipt &&
                data.receipt.id
            ) {

                documentsHtml +=
                    '<span class="badge bg-primary">' +
                    '<i class="bi bi-receipt me-1"></i>' +
                    'Receipt Uploaded' +
                    '</span>';

            }
            else {

                documentsHtml +=
                    '<span class="badge bg-secondary">' +
                    'No Receipt' +
                    '</span>';

            }


            if (documentsContent) {

                documentsContent.innerHTML =
                    documentsHtml;

            }

        })

        .catch(function (error) {

            console.error(error);


            if (documentsContent) {

                documentsContent.innerHTML =
                    '<span class="text-danger">' +
                    '<i class="bi bi-exclamation-triangle me-1"></i>' +
                    escapeHtml(
                        error.message ||
                        'Unable to load PMS record.'
                    ) +
                    '</span>';

            }


            showMessage(
                error.message ||
                'Unable to load PMS record.',
                'error'
            );

        });

    });


    /* ==========================================================
       EDIT ACCOUNT CHANGE
       ========================================================== */

    const editAccount =
        document.getElementById(
            'edit_data_id'
        );


    if (editAccount) {

        editAccount.addEventListener(
            'change',
            function () {

                const option =
                    this.options[
                        this.selectedIndex
                    ];


                if (!option) {
                    return;
                }


                const address =
                    option.getAttribute(
                        'data-address'
                    ) || '';


                const addressInput =
                    document.getElementById(
                        'edit_pms_address'
                    );


                if (addressInput) {

                    addressInput.value =
                        address;

                }

            }
        );

    }


    /* ==========================================================
       SUBMIT EDIT FORM
       ========================================================== */

    const editForm =
        document.getElementById(
            'editPmsForm'
        );


    if (editForm) {

        editForm.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                const id =
                    document.getElementById(
                        'edit_pms_id'
                    )?.value;


                if (!id) {

                    showMessage(
                        'Invalid PMS ID.',
                        'error'
                    );

                    return;

                }


                const saveButton =
                    document.getElementById(
                        'saveEditPmsBtn'
                    );


                let originalHtml = '';


                if (saveButton) {

                    originalHtml =
                        saveButton.innerHTML;

                    saveButton.disabled =
                        true;

                    saveButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span>' +
                        'Saving...';

                }


                const formData =
                    new FormData(editForm);


                fetch(
                    '<?= site_url('pms/update/') ?>' + id,
                    {
                        method: 'POST',

                        body: formData,

                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                )

                .then(function (response) {

                    if (!response.ok) {

                        throw new Error(
                            'Server returned HTTP ' +
                            response.status
                        );

                    }

                    return response.json();

                })

                .then(function (result) {

                    if (!result.success) {

                        throw new Error(
                            result.message ||
                            'Unable to update PMS.'
                        );

                    }


                    const modalElement =
                        document.getElementById(
                            'editPmsModal'
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


                    showMessage(
                        result.message ||
                        'PMS record updated successfully.',
                        'success'
                    );


                    setTimeout(function () {

                        window.location.reload();

                    }, 1000);

                })

                .catch(function (error) {

                    console.error(error);


                    showMessage(
                        error.message ||
                        'Unable to update PMS record.',
                        'error'
                    );

                })

                .finally(function () {

                    if (saveButton) {

                        saveButton.disabled =
                            false;

                        saveButton.innerHTML =
                            originalHtml;

                    }

                });

            }
        );

    }


    /* ==========================================================
       DELETE PMS
       ========================================================== */

    document.addEventListener('click', function (event) {

        const button =
            event.target.closest(
                '.delete-pms-btn'
            );


        if (!button) {
            return;
        }


        const id =
            button.getAttribute(
                'data-id'
            );


        const pmsNumber =
            button.getAttribute(
                'data-pms'
            ) || id;


        if (!id) {

            showMessage(
                'Invalid PMS ID.',
                'error'
            );

            return;

        }


        const confirmed =
            window.confirm(
                'Delete PMS Record?\n\n' +
                'You are about to delete PMS record #' +
                pmsNumber +
                '.\n\n' +
                'Existing MFS, FSR and receipt records will NOT be deleted.'
            );


        if (!confirmed) {
            return;
        }


        button.disabled = true;


        const originalHtml =
            button.innerHTML;


        button.innerHTML =
            '<span class="spinner-border spinner-border-sm"></span>';


        fetch(
            '<?= site_url('pms/delete/') ?>' + id,
            {
                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type':
                        'application/x-www-form-urlencoded'
                },

                body:
                    '<?= csrf_token() ?>=' +
                    encodeURIComponent(
                        '<?= csrf_hash() ?>'
                    )
            }
        )

        .then(function (response) {

            if (!response.ok) {

                throw new Error(
                    'Server returned HTTP ' +
                    response.status
                );

            }

            return response.json();

        })

        .then(function (result) {

            if (!result.success) {

                throw new Error(
                    result.message ||
                    'Unable to delete PMS record.'
                );

            }


            showMessage(
                result.message ||
                'PMS record deleted successfully.',
                'success'
            );


            setTimeout(function () {

                window.location.reload();

            }, 1000);

        })

        .catch(function (error) {

            console.error(error);


            button.disabled = false;

            button.innerHTML =
                originalHtml;


            showMessage(
                error.message ||
                'Unable to delete PMS record.',
                'error'
            );

        });

    });


    /* ==========================================================
       HTML ESCAPE HELPER
       ========================================================== */

    function escapeHtml(value) {

        return String(
            value ?? ''
        )
        .replace(
            /&/g,
            '&amp;'
        )
        .replace(
            /</g,
            '&lt;'
        )
        .replace(
            />/g,
            '&gt;'
        )
        .replace(
            /"/g,
            '&quot;'
        )
        .replace(
            /'/g,
            '&#039;'
        );

    }

});


/* ==============================================================
   PMS NUMBER GROUPING + DATATABLE
   ============================================================== */


/* ============================================================
   PMS GROUPED DATATABLE
   ============================================================ */

(function () {

    function initPmsGroupedTable() {

        if (
            typeof window.jQuery === 'undefined' ||
            typeof $.fn.DataTable === 'undefined' ||
            $('#pmsTable').length === 0
        ) {
            return;
        }

        const $table = $('#pmsTable');

        /*
         * Prevent DataTables from being initialized twice.
         */
        if ($.fn.DataTable.isDataTable('#pmsTable')) {
            return;
        }

        /*
         * ========================================================
         * SAVE ALL CHILD CONTENT BEFORE DATATABLES INITIALIZES
         * ========================================================
         *
         * DataTables does not understand our special child rows.
         *
         * So we first collect the HTML from every:
         *
         *     .pms-child-data
         *
         * Then we remove those rows before DataTables starts.
         *
         * The content is later displayed using:
         *
         *     row.child(...)
         *
         * ========================================================
         */

        const pmsChildData = {};

        $table.find('tbody > tr.pms-child-data').each(function () {

            const groupId = $(this).attr('data-parent-group');

            if (!groupId) {
                return;
            }

            const $cell = $(this).children('td').first();

            if ($cell.length) {

                pmsChildData[groupId] = $cell.html();

            }

            /*
             * IMPORTANT:
             * Remove child row BEFORE DataTables initialization.
             */
            $(this).remove();

        });


        /*
         * ========================================================
         * INITIALIZE DATATABLE
         * ========================================================
         */

        const pmsDataTable = $table.DataTable({

            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],

            /*
             * Date column
             *
             * 0 = PMS Number
             * 1 = Engineer
             * 2 = Account
             * 3 = Address
             * 4 = Date
             */
            order: [[4, 'desc']],

            scrollX: true,

            responsive: false,

            autoWidth: false,

            /*
             * Keep PMS Number sortable.
             */
            columnDefs: [
                {
                    targets: 0,
                    orderable: true
                }
            ]

        });


        /*
         * ========================================================
         * PMS NUMBER CLICK
         * ========================================================
         */

        $table.on(
            'click',
            '.pms-expand-btn',
            function (e) {

                e.preventDefault();
                e.stopPropagation();

                const button = this;

                /*
                 * Get the parent DataTables row.
                 */
                const $parentRow = $(button).closest('tr');

                if (!$parentRow.length) {
                    return;
                }

                const row = pmsDataTable.row($parentRow);

                /*
                 * Get group ID.
                 */
                const groupId = $(button).attr('data-group');

                if (!groupId) {
                    console.warn(
                        'PMS group ID is missing from .pms-expand-btn'
                    );

                    return;
                }

                /*
                 * Check whether child row is already visible.
                 */
                const isShown = row.child.isShown();


                /*
                 * ====================================================
                 * COLLAPSE
                 * ====================================================
                 */

                if (isShown) {

                    row.child.hide();

                    $(button)
                        .attr('aria-expanded', 'false')
                        .removeClass('active');

                    const icon = $(button).find('i').first();

                    icon
                        .removeClass('bi-chevron-up')
                        .addClass('bi-chevron-down');

                    return;
                }


                /*
                 * ====================================================
                 * EXPAND
                 * ====================================================
                 */

                if (
                    typeof pmsChildData[groupId] === 'undefined' ||
                    !pmsChildData[groupId]
                ) {

                    console.warn(
                        'No child data found for PMS group:',
                        groupId
                    );

                    /*
                     * This means the PMS button exists,
                     * but the PHP child row was not found.
                     */
                    return;
                }


                /*
                 * Put the saved HTML inside DataTables child row.
                 */
                row.child(
                    pmsChildData[groupId],
                    'pms-expanded-child-row'
                ).show();


                /*
                 * Update button state.
                 */
                $(button)
                    .attr('aria-expanded', 'true')
                    .addClass('active');


                /*
                 * Change arrow.
                 */
                const icon = $(button).find('i').first();

                icon
                    .removeClass('bi-chevron-down')
                    .addClass('bi-chevron-up');

            }
        );


        /*
         * ========================================================
         * CLICK PMS CELL
         * ========================================================
         *
         * This allows the user to click anywhere in the first
         * column, not only directly on the button.
         *
         * ========================================================
         */

        $table.on(
            'click',
            'tbody td:first-child',
            function (e) {

                /*
                 * If the actual button was clicked,
                 * the handler above already handles it.
                 */
                if ($(e.target).closest('.pms-expand-btn').length) {
                    return;
                }

                const button = $(this)
                    .find('.pms-expand-btn')
                    .first();

                if (button.length) {

                    button.trigger('click');

                }

            }
        );


        /*
         * ========================================================
         * DATATABLE REDRAW
         * ========================================================
         *
         * When searching, sorting or changing pages,
         * DataTables rebuilds the visible rows.
         *
         * Reset all arrows so they don't remain visually expanded.
         *
         * ========================================================
         */

        pmsDataTable.on(
            'draw',
            function () {

                $table
                    .find('.pms-expand-btn')
                    .each(function () {

                        $(this)
                            .attr('aria-expanded', 'false')
                            .removeClass('active');

                        const icon = $(this)
                            .find('i')
                            .first();

                        icon
                            .removeClass('bi-chevron-up')
                            .addClass('bi-chevron-down');

                    });

            }
        );


        /*
         * ========================================================
         * OPTIONAL DEBUG
         * ========================================================
         *
         * Open browser console and you should see something like:
         *
         * PMS GROUPS FOUND: 5
         *
         * Remove this console.log later if desired.
         * ========================================================
         */

        console.log(
            'PMS GROUPS FOUND:',
            Object.keys(pmsChildData).length
        );

    }


    /*
     * ============================================================
     * START AFTER DOM IS READY
     * ============================================================
     */

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initPmsGroupedTable
        );

    } else {

        initPmsGroupedTable();

    }

})();


</script>
