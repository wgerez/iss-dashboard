(function(){
	
	angular.module('planestudiosDirectives', [])

	.directive('listadoPlanestudios', function(){
		// Runs during compile
		return {
			restrict: 'E', 
			templateUrl: '../assets/global/partials/planestudios/listaplanestudios.html',
		};
	});

})();