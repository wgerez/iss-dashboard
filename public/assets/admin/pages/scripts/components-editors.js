var ComponentsEditors = function () {
    
    var handleSummernote = function () {
        $('#contrato_1').summernote({
            height: 400,
            focus: false,
            lang: 'es-ES',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
              ]            
        });
        //API:
        //var sHTML = $('#summernote_1').code(); // get code
        //$('#summernote_1').destroy(); // destroy
    }

    var handleSummernote2 = function () {
        $('#contrato_2').summernote({
            height: 400,
            focus: false,
            lang: 'es-ES',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
              ]            
        });
        //API:
        //var sHTML = $('#summernote_1').code(); // get code
        //$('#summernote_1').destroy(); // destroy
    }

    return {
        //main function to initiate the module
        init: function () {
            handleSummernote();
            handleSummernote2();
        }
    };

}();
