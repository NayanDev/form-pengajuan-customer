$(document).ready(function() {
    console.log('Employee autofill script loaded');
    
    var employeeData = {};
    var isDataLoaded = false;
    
    // Function untuk load data dari API
    function loadEmployeeData() {
        if (isDataLoaded) {
            return Promise.resolve(employeeData);
        }
        
        console.log('Loading employee data from API...');
        
        return $.ajax({
            url: 'https://simco.sampharindogroup.com/api/pegawai',
            method: 'GET',
            dataType: 'json',
            timeout: 30000
        })
        .done(function(response) {
            console.log('API response received:', response);
            
            if (Array.isArray(response)) {
                response.forEach(function(employee) {
                    // Filter hanya PT. SAMPHARINDO PUTRA TRADING
                    if (employee.company === 'PT. SAMPHARINDO PUTRA TRADING' && employee.nik) {
                        employeeData[employee.nik] = {
                            nik: employee.nik || '',
                            nama: employee.nama || '',
                            email: employee.email || '',
                            company: employee.company || '',
                            divisi: employee.divisi || '',
                            jabatan: employee.jabatan || '',
                            no_ktp: employee.no_ktp || '',
                            unit_kerja: employee.unit_kerja || '',
                            status: employee.status || '',
                            jk: employee.jk || '',
                            telp: employee.telp || ''
                        };
                    }
                });
                
                isDataLoaded = true;
                console.log('Employee data loaded successfully:', Object.keys(employeeData).length, 'employees');
            }
        })
        .fail(function(xhr, status, error) {
            console.error('Failed to load employee data:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
        });
    }
    
    // Function untuk fill form fields
    function fillEmployeeFields(nik, prefix) {
        if (!nik) {
            console.warn('No NIK provided');
            return;
        }
        
        if (!employeeData[nik]) {
            console.warn('No employee data found for NIK:', nik);
            return;
        }
        
        var employee = employeeData[nik];
        console.log('Filling fields with employee data:', employee);
        
        // Daftar field yang akan diisi
        var fieldMapping = {
            'email': employee.email,
            'nama': employee.nama,
            'company': employee.company,
            'divisi': employee.divisi,
            'jabatan': employee.jabatan,
            'no_ktp': employee.no_ktp,
            'unit_kerja': employee.unit_kerja,
            'status': employee.status,
            'jk': employee.jk,
            'telp': employee.telp,
            'nik': employee.nik
        };
        
        // Loop dan isi setiap field
        $.each(fieldMapping, function(fieldName, value) {
            var selectors = [
                'input[name="' + prefix + fieldName + '"]',
                '#' + prefix + fieldName,
                'input[id="' + prefix + fieldName + '"]',
                '[name="' + prefix + fieldName + '"]'
            ];
            
            var filled = false;
            selectors.forEach(function(selector) {
                var $field = $(selector);
                if ($field.length > 0 && !filled) {
                    $field.val(value);
                    filled = true;
                    console.log('Field filled:', prefix + fieldName, '=', value);
                }
            });
            
            if (!filled) {
                console.warn('Field not found:', prefix + fieldName);
            }
        });
    }
    
    // Function untuk handle perubahan selector
    function handleSelectorChange($selector) {
        var nik = $selector.val();
        var prefix = '';
        
        // Deteksi prefix untuk edit mode
        if ($selector.attr('name') && $selector.attr('name').indexOf('edit_') === 0) {
            prefix = 'edit_';
        } else if ($selector.attr('id') && $selector.attr('id').indexOf('edit_') === 0) {
            prefix = 'edit_';
        }
        
        console.log('Employee selector changed, NIK:', nik, 'Prefix:', prefix);
        
        if (!nik) {
            console.log('No NIK selected, clearing fields');
            return;
        }
        
        // Load data dulu jika belum, baru fill fields
        loadEmployeeData().then(function() {
            fillEmployeeFields(nik, prefix);
        });
    }
    
    // Event handler untuk create mode
    $(document).on('change', 'select[name="employee_selector"]', function() {
        console.log('Create mode selector changed');
        handleSelectorChange($(this));
    });
    
    // Event handler untuk edit mode
    $(document).on('change', 'select[name="edit_employee_selector"], select[id="edit_employee_selector"]', function() {
        console.log('Edit mode selector changed');
        handleSelectorChange($(this));
    });
    
    // Trigger pada saat modal/drawer dibuka
    $(document).on('shown.bs.modal shown.bs.offcanvas', function() {
        console.log('Modal/Drawer opened, checking for selected employee');
        setTimeout(function() {
            var $selector = $('select[name="employee_selector"], select[name="edit_employee_selector"], select[id="edit_employee_selector"]');
            if ($selector.length > 0 && $selector.val()) {
                handleSelectorChange($selector);
            }
        }, 300);
    });
    
    // Auto load data saat page load
    loadEmployeeData();
    
    // Auto fill pada page load jika ada value
    setTimeout(function() {
        var $selector = $('select[name="employee_selector"], select[name="edit_employee_selector"], select[id="edit_employee_selector"]');
        if ($selector.length > 0 && $selector.val()) {
            console.log('Auto-filling on page load');
            handleSelectorChange($selector);
        }
    }, 1000);
});