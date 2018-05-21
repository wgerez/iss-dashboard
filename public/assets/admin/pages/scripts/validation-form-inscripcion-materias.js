var ValidForm = function () {

	var menjoFormMaterias = function() {
		$('#FrmInscripcionMaterias').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                organizacion: {
	                    required: true
	                },
	                carreras: {
	                    required: true
	                },
	                planes: {
	                    required: true
	                },
	                documento: {
	                	required: true
	                }
	            },

	            messages: {
	                organizacion: {
	                    required: "selecciones una organización."
	                },
	                carreras: {
	                    required: "seleccione una carrera."
	                },
	                planes: {
	                	required: "seleccione un plan."	
	                },
	                documento: {
	                	required: "no se ha seleccionado un alumno."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.note-danger', $('#FrmInscripcionMaterias')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('#FrmInscripcionMaterias input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('#FrmInscripcionMaterias').validate().form()) {
	                    $('#FrmInscripcionMaterias').submit();
	                }
	                return false;
	            }
	        });
	}

    
    return {
        //main function to initiate the module
        init: function () {
            menjoFormMaterias();
        }

    };

}();