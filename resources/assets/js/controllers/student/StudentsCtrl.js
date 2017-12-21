(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('StudentsCtrl',['User', 'Student', StudentsCtrl]);

	function StudentsCtrl(User, Student){
		var vm = this;
		// Props
		vm.students = [];
		vm.filters = {
			cities: ['La Paz', 'El Alto'],
			withTeam: true,
		};
		vm.isLoading = true;
		// Methods
		vm.getStudents = getStudents;
		vm.updateFilter = updateFilter;
		// Methods implementation
		function getStudents(){
			Student.getStudents().then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.students = data.students;
				}else{
					vm.isLoading = false;
					alert(data.msg);
				}
			}, function(err){
				vm.isLoading = false;
				alert('Hubo un error al cargar los datos de los estudiantes, inténtelo nuevamente');
			});
		};
		function updateFilter(type, arg){
			var index = vm.filters[type].indexOf(arg);
			if(index == -1){
				vm.filters[type].push(arg);
			}else{
				vm.filters[type].splice(index, 1);
			}
		};
		// Methods self invoking
		getStudents();
	};
})();
