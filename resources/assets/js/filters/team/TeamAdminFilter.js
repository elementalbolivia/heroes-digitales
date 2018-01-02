(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.filter('TeamAdminFilter', TeamAdminFilter);
	function TeamAdminFilter(){
		return function(teams, city, division){
			// Filtrar en base a un hash
			var hash = {};
			// En cada coincidencia que exista con alguno de los parametros
			// del filtro, crear una llave unica en el hash
			// si existe otro con la misma llave, no se repite en hash
			// o se sobreescribe
			for (var i = 0; i < teams.length; i++) {
				var eligible = [];
        if(city.length != 0){
          if(city.indexOf(teams[i].city.nombre) >= 0) eligible.push(true);
          else eligible.push(false);
        }
        if(division.length != 0){
          if(division.indexOf(teams[i].division.nombre) >= 0) eligible.push(true);
          else eligible.push(false);
        }

				if(eligible.indexOf(false) == -1)
					hash[teams[i].id] = teams[i];
			}
			// console.log(hash);
			var filtered = [];
			for (var i in hash) {
				filtered.push(hash[i]);
			};
			return filtered;
		};
	}
})();
