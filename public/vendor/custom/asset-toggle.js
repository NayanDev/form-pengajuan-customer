$(document).ready(function() {
    // Function untuk toggle specification fields
    function toggleSpecificationFields() {
        var categoryCreate = $('select[name="category"]').val();
        var categoryEdit = $('select[name="edit_category"]').val();
        var category = categoryCreate || categoryEdit;
        
        // List semua specification fields
        var specFieldNames = ['cpu', 'ram', 'storage', 'os', 'gpu'];
        
        specFieldNames.forEach(function(fieldName) {
            var createField = $('input[name="' + fieldName + '"]');
            var editField = $('input[name="edit_' + fieldName + '"]');
            
            if (category === 'Laptop' || category === 'PC') {
                // Show specification fields
                createField.closest('.my-2').show();
                editField.closest('.my-2').show();
            } else {
                // Hide specification fields dan kosongkan nilainya
                createField.val('').closest('.my-2').hide();
                editField.val('').closest('.my-2').hide();
            }
        });
    }
    
    // Trigger saat category berubah
    $(document).on('change', 'select[name="category"], select[name="edit_category"]', function() {
        toggleSpecificationFields();
    });
    
    // Trigger saat modal/drawer dibuka
    $(document).on('shown.bs.modal shown.bs.offcanvas', function() {
        toggleSpecificationFields();
    });
    
    // Trigger saat halaman load (untuk edit mode)
    setTimeout(function() {
        toggleSpecificationFields();
    }, 500);
});