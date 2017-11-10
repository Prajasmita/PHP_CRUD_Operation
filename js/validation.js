$(document).ready(function() {

    $.validator.addMethod("allchar", function (value, element) {
        return /^[a-zA-Z ]*$/.test(value);
    }, 'Category name should be in characters.');


    $("#form").validate({
        rules: {
            category_name: {
                required: true,
                allchar: true,
                minlength: 2,
                maxlength: 20
            }
        }


    });
});