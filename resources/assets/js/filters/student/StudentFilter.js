(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.filter('StudentFilter', StudentFilter);
	function StudentFilter(){
		return function(students, city, withTeam, gender){
			// Filtrar en base a un hash
			var hashStudents = {};
			// En cada coincidencia que exista con alguno de los parametros
			// del filtro, crear una llave unica en el hash
			// si existe otro con la misma llave, no se repite en hash
			// o se sobreescribe

			// TODO: TODOS LOS FILTROS APLICADOS DEBEN SER
			// APILADOS MEDIANTE UN AND
			for (var i = 0; i < students.length; i++) {
				var eligible = [];
				if(students[i].has_team == withTeam) eligible.push(true);
				else eligible.push(false);
				// si en el array de generos, esta uno del usuario
				// empujar al array de eligible como true
				// if(students[i].gender == null)
				// if(gender.indexOf(students[i].gender) >= 0 ) eligible.push(true);
				// else eligible.push(false);
				// si en el array de ciudades, esta uno del usuario
				// empujar al array de eligible como true
				if(city.indexOf(students[i].city.nombre) >= 0 ) eligible.push(true);
				else eligible.push(false);

				if(eligible.indexOf(false) == -1)
					hashStudents[students[i].id] = students[i];

			}
			var filtered = [];
			for (var i in hashStudents) {
				filtered.push(hashStudents[i]);
			};
			return filtered;
		};
	}
})();
