(function(){
	
	angular.module('materiasDirectives', [])

	.directive('listadoMaterias', function(){
		// Runs during compile
		return {
			restrict: 'E', 
			templateUrl: '../assets/global/partials/materias/listamaterias.html',
		};
	});

})();