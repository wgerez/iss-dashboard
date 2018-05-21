(function(){
	"user strict";

	angular.module('app', [
		'ngResource'
	])

	.factory('Contactos', function($resource){
			return $resource('/sistema/api/vercontactos/:id');
	})

	.controller('contactosCtrl', function($scope, Contactos){
		console.log($scope.organizacionid);
		$scope.contactos = Contactos.get({id:$scope.organizacionid});
	})


})();