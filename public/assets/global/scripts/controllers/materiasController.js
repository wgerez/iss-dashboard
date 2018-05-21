(function(){

	angular.module('materiasControllers', [])

	.controller('listadoController', ['$scope', '$http', function($scope, $http){
		$scope.materias = [
			{
				'codigo': '00.000',
				'nombre': 'Socorrismo',
				'periodo': 'Anual',
				'hsSemanales': '99',
				'hsCatedra': '99',
				'hsReloj': '99',
				'anoCursado': '2015'
			},
			{
				'codigo': '00.000',
				'nombre': 'Socorrismo',
				'periodo': 'Anual',
				'hsSemanales': '99',
				'hsCatedra': '99',
				'hsReloj': '99',
				'anoCursado': '2015'
			},
			{
				'codigo': '00.000',
				'nombre': 'Socorrismo',
				'periodo': 'Anual',
				'hsSemanales': '99',
				'hsCatedra': '99',
				'hsReloj': '99',
				'anoCursado': '2015'
			}				
		];
	}]);

})();

