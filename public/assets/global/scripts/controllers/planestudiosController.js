(function(){

	angular.module('planestudiosControllers', [])

	.controller('listadoController', ['$scope', 'carrerasporOrganizacion', 'planesxCarrera', 'materiasxCarrera', function($scope, carrerasporOrganizacion, planesxCarrera, materiasxCarrera){
		//AL CARGAR LA PAGINA COLOCO SELECCIONE EN EL CBO DE CARRERAS

		$scope.carreras = [{id:0, carrera:'Seleccione'}];
		//SELECCIONO EL PRIMER ITEM
		$scope.carreraSeleccionada = 0;

		//METODO AL SELECCIONAR UNA ORGANIZACION CARGO EL CBO DE CARRERAS.
		$scope.org_selec = function(item){
			carrerasporOrganizacion.listado(item)
                .then(function(carreras) {
                    $scope.carreras = carreras;
                },
                function(data) {
                    console.log('Error: '+ data);
                });
		}

		/*$scope.buscarmaterias = function() {
			$scope.filtros = [];
			$scope.filtros.push({'carrera':$scope.carrera.id, 'plan': $scope.plan});
			//console.log($scope.filtros);
		}*/

		$scope.carr_selec = function(item) {
			planesxCarrera.getPlanes(item.id)
                .then(function(planes) {
                    $scope.planesx = planes;
                    console.log($scope.planesx);
                },
                function(data) {
                    console.log('Error: '+ data);
                });
		}

		$scope.buscar_materias = function() {
			materiasxCarrera.getMaterias($scope.carrera.id, $scope.plan.id)
                .then(function(materias) {
                    $scope.materiasx = materias;
                    console.log($scope.materiasx);
                },
                function(data) {
                	//$scope.planesx = [];
                    console.log('Error: '+ data);
                });
		}
	}])
	.controller('NuevoPlanEstudiosController', ['$scope', 'carrerasporOrganizacion', '$http', function($scope, carrerasporOrganizacion, $http){
		//AL CARGAR LA PAGINA COLOCO SELECCIONE EN EL CBO DE CARRERAS
		$scope.carreras = [{id:0, carrera:'Seleccione'}];
		//SELECCIONO EL PRIMER ITEM
		$scope.carreraSeleccionada = 0;
		$scope.ciclolectivo = null;

		$scope.validafecha = false;
		//METODO AL SELECCIONAR UNA ORGANIZACION CARGO EL CBO DE CARRERAS.
		$scope.org_seleccionada = function(item){
			/*$scope.carreras = carrerasporOrganizacion.listado(item);
			if ($scope.carreras[0]!= undefined) {
				$scope.carrera = $scope.carreras[0].id;
			}*/

			carrerasporOrganizacion.listado(item)
                .then(function(carreras) {
                    $scope.carreras = carreras;
					if ($scope.carreras[0]!= undefined) {
						$scope.carrera = $scope.carreras[0].id;
					}
                },
                function(data) {
                    console.log('Error: '+ data);
                });
		}

		$scope.carr_seleccionada = function() {
			if ($("#ciclo option:selected").text()!=''){
				$scope.codigoplan = primeraletra($("#mcarrera option:selected").text()) +'/'+$("#ciclo option:selected").text();
				$scope.mtituloplan = $("#mcarrera option:selected").text();
			}
			else
			{
				$scope.codigoplan = primeraletra($("#mcarrera option:selected").text());
				$scope.mtituloplan = $("#mcarrera option:selected").text();
			}
		}

		$scope.ciclo_seleccionado = function() {
			$scope.codigoplan = primeraletra($("#mcarrera option:selected").text()) +'/'+$("#ciclo option:selected").text();
		}

		function primeraletra(frase) {
		    var resultado =	frase.concat(' ').replace(/([a-zA-ZñÑáéíóúÁÉÍÓÚ]{0,} )/g, function(match){
		    	return (match.trim()[0]);
		    });

			return resultado;
		}

		$scope.valiDate = function(startDate,endDate) {
		    $scope.validafecha = false;

			tmp = startDate.split('/');
			fini = tmp[2]+tmp[1]+tmp[0];
			tmp = endDate.split('/');
			ffin = tmp[2]+tmp[1]+tmp[0];
			// la comparación
			if(fini > ffin){
		        $scope.validafecha = true;
		      	return false;
			}
		}

		$scope.guardarForm = function() {
			$scope.alerta = [];
			$http({
			  method: 'POST',
			  url: '../api/planestudios',
			  params: {
				'organizacion':$scope.orgItem,
				'carrera': $scope.carrera,
				'ciclos':$scope.cicloItem,
				'codigoplan':$scope.codigoplan,
				'tituloplan': $scope.mtituloplan,
				'fechaInicio': $scope.startDate,
				'fechaFin': $scope.endDate,
				}
			}).then(function successCallback(request) {
				$scope.alerta.guardo = true;
				$scope.alerta.noguardo = false;
				console.log($scope.alerta.guardo);
				$scope.orgItem = 0;
				$scope.carrera = 0;
				$scope.cicloItem = 0;
				$scope.codigoplan = "";
				$scope.mtituloplan = "";
				$scope.startDate = "";
				$scope.endDate = "";
			  }, function errorCallback(request) {
			  	$scope.alerta.guardo = false;
			  	$scope.alerta.noguardo = true;
			  	console.log($scope.alerta.guardo);
			  });
		}

	}]);

})();
