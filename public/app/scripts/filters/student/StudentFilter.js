(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.filter('StudentFilter', StudentFilter);
	function StudentFilter(){
		return function(students, city, withTeam){
			// Filtrar en base a un hash
			var hashStudents = {};
			// En cada coincidencia que exista con alguno de los parametros
			// del filtro, crear una llave unica en el hash
			// si existe otro con la misma llave, no se repite en hash
			// o se sobreescribe
			for (var i = 0; i < students.length; i++) {
				if(students[i].has_team == withTeam){
					hashStudents[students[i].id] = students[i];
				}
				for (var j = 0; j < city.length; j++) {
					if(students[i].city.nombre == city[j]) 
						hashStudents[students[i].id] = students[i];					
				}
			}
			var filtered = [];
			for (var i in hashStudents) {
				filtered.push(hashStudents[i]);
			};
			return filtered;
		};
	}
})();