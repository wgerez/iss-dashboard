(function(){
	angular.module('planesServices', [])

	.factory('planesxCarrera', ['$http', '$q', function planesxCarrera($http, $q) {
        // interface
        var service = {
            planes: [],
            getPlanes: getPlanes
        };
        return service;

        // implementation
        function getPlanes(carrera) {
            var def = $q.defer();
            console.log(carrera);

            $http.get('../api/planestudios/'+ carrera)
                .success(function(data) {
                    service.planes = data;
                    def.resolve(data);
                })
                .error(function(data) {
                    def.reject("Error al obtener planes");
                });
            return def.promise;

        }
    }])

    .factory('materiasxCarrera', ['$http', '$q', function materiasxCarrera($http, $q) {
        // interface
        var service = {
            materias: [],
            getMaterias: getMaterias
        };
        return service;

        // implementation
        function getMaterias(carrera, plan) {
            var def = $q.defer();

            $http.get('../api/materias?carrera='+ carrera + '&plan=' + plan)
                .success(function(data) {
                    service.materias = data;
                    def.resolve(data);
                })
                .error(function(data) {
                    def.reject("Error al obtener materias");
                });

            return def.promise;
        }
    }]);


})();
