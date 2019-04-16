var TableAdvanced = function () {

    var tableAlumnos = function () {
        var table = $('#table_alumnos');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,



        });

    }

    var tableOrganizaciones = function () {
        var table = $('#table_organizaciones');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [-1, 20, 15, 5],
                ["Todos", 20, 15, 5]
            ],
            // set the initial value
            "pageLength": -1,



        });

    }


    var tableCiclos = function () {
        var table = $('#table_ciclos');
        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            }, {
                "orderable": true
            },{    
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [-1, 20, 15, 5],
                ["Todos", 20, 15, 5]
            ],
            // set the initial value
            "pageLength": -1,
        });
    }

    var tableDocentes = function () {
        var table = $('#table_docentes');
        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }


    var tableCarreras = function () {
        var table = $('#table_carreras');
        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{    
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [-1, 20, 15, 5],
                ["Todos", 20, 15, 5] // change per page values here
            ],
            // set the initial value
            "pageLength": -1,
        });
    }

    var tableMatriculas = function () {
        var table = $('#table_matriculas');
        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            }, {    
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [-1, 20, 15, 5],
                ["Todos", 20, 15, 5] // change per page values here
            ],
            // set the initial value
            "pageLength": -1,
        });
    }


    var tablePerfiles = function () {
        var table = $('#table_perfiles');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }

    var tableUsuarios = function () {
        var table = $('#table_usuarios');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }    

    var tableInformeUsuarios = function () {
        var table = $('#table_informes_alumnos');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }

    var tableInformeDocentes = function () {
        var table = $('#table_informes_docentes');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 20,
        });
    }    

    var ImprimirContratos = function () {
        var table = $('#imprimir_contratos');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 20,
        });
    }   

    var Listadoplanes = function () {
        var table = $('#table_planestudios');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 20,
        });
    }      




    var Listadomaterias = function () {
        var table = $('#table_materias');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }          



    var Listadomateriasplanes = function () {
        var table = $('#table_materias_planes');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }      

    /*var Listadocorrelatividades = function () {
        var table = $('#table_correlatividades');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }  */      

    var Listadocuotas = function () {
        var table = $('#table_cuotas');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }         

    var Listadopagoparcial = function () {
        var table = $('#table_informes');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }         

    var Listadoplanesestu = function () {
        var table = $('#table_planes');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }         

    var Listadopagomatriculas = function () {
        var table = $('#table_informesmatricula');


        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }         

    var Informebecadosactivos = function () {
        var table = $('#table_informesabb');
        
        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }

    var tableMatriculass = function () {
        var table = $('#table_matriculass');
        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            }, {    
                "orderable": true
            }, {
                "orderable": false
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }

    var Listadopagoanio = function () {
        var table = $('#table_informespagos');
        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [15, 20, 30, -1],
                [15, 20, 30, "Todos"]
            ],
            // set the initial value
            "pageLength": 15,
        });
    }         

    var ListadoFeriados = function () {
        var table = $('#table_feriados');
        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [20, 30, 40, -1],
                [20, 30, 40, "Todos"]
            ],
            // set the initial value
            "pageLength": 20,
        });
    }         

    var ListadoExamenFinal = function () {
        var table = $('#table_examenfinal');
        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }, {
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }],            
            "lengthMenu": [
                [20, 30, 40, -1],
                [20, 30, 40, "Todos"]
            ],
            // set the initial value
            "pageLength": 20,
        });
    }         




    return {
        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            tableAlumnos();
            //tableOrganizaciones();
            tableCiclos();
            tableDocentes();
            tableCarreras();
            tableMatriculas();
            tablePerfiles();
            tableUsuarios();
            tableInformeUsuarios();
            tableInformeDocentes();
            ImprimirContratos();
            Listadoplanes();
            Listadomaterias();
            Listadomateriasplanes();
            //Listadocorrelatividades();
            Listadocuotas();
            Listadopagoparcial();
            Listadoplanesestu();
            Listadopagomatriculas();
            Informebecadosactivos();
            tableMatriculass();
            Listadopagoanio();
            ListadoFeriados();
            ListadoExamenFinal();
        }

    };

}();