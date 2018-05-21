var ComponentsFormTools = function () {

    var handleInputMasks = function () {
        $.extend($.inputmask.defaults, {
            'autounmask': true
        });
        $("#fechanacimiento").inputmask("dd/mm/yyyy", {
            "placeholder": "__/__/____"
        });
        $("#fechaingreso").inputmask("dd/mm/yyyy", {
            "placeholder": "__/__/____"
        });
        $("#fechaegreso").inputmask("dd/mm/yyyy", {
            "placeholder": "__/__/____"
        });
    }

    var InputMaskCilcoLectivo = function () {

        $("#cicloFechaInicio").inputmask("dd/mm/yyyy", {
            "placeholder": "__/__/____"
        });
        $("#cicloFechaFin").inputmask("dd/mm/yyyy", {
            "placeholder": "__/__/____"
        });
        $("#periodoFechaInicio").inputmask("dd/mm/yyyy", {
            "placeholder": "__/__/____"
        });
        $("#periodoFechaFin").inputmask("dd/mm/yyyy", {
            "placeholder": "__/__/____"
        }); 

        $("#MtxtFechaIni").inputmask("dd/mm/yyyy", {
            "placeholder": "__/__/____"
        });
        $("#MtxtFechaFin").inputmask("dd/mm/yyyy", {
            "placeholder": "__/__/____"
        });                       
    }




    return {
        //main function to initiate the module
        init: function () {
            handleInputMasks();
            InputMaskCilcoLectivo();
        }
    };

}();