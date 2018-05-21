(function(){
	angular.module('carrerasServices', [])


	.factory('carrerasporOrganizacion', ['$http', '$q', function carrerasporOrganizacion($http, $q) {
        // interface
        var carrerasporOrganizacion = {
            carreras: [],
            listado: listado
        };
        return carrerasporOrganizacion;

        // implementation
        function listado(organizacion) {
            var def = $q.defer();

            $http.post('../carreras/buscarjson',{ organizacionid : organizacion })
                .success(function(data) {
                	carrerasporOrganizacion.carreras = data;
                	def.resolve(data);
                    console.log(data);
                })
                .error(function(data) {
                    def.reject("Error al obtener planes");
                });

            return def.promise;
        }
    }]);
})();
