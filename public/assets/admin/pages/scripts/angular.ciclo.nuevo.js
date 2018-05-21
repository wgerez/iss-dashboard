var app = angular.module('app', []);

app.controller('PeriodoController', function ($scope, $http) {

	$http.get('http://localhost/sistema/ciclolectivo/crear').success(function(data){
		console.log(data);
	});

	$scope.periodos = [];
	
	$scope.agregarPeriodo = function(){
		$scope.periodos.push({
				descripcion: 	$scope.descripcion, 
				fechainicio: 	$scope.fechainicio, 
				fechafin: 		$scope.fechafin 
		});
		//$scope.descripcion = "";
		//$scope.fechainicio = "";
		//$scope.fechafin = "";
		angular.element('#periodolectivo').focus();
		angular.element('#periodolectivo').select();
	}

	$scope.borrarPeriodo = function(item){
		var index = $scope.periodos.indexOf(item);
		$scope.periodos.splice(index,1);
	}
});

/*app.controller('CicloController', function ($scope, $http) {
	$http.get('http://localhost/sistema/ciclolectivo/organizaciones').success(function(data) 
    {
    	console.log(data.organizaciones);
         $scope.organizaciones = data.organizaciones;//así enviamos los posts a la vista
    });
});*/