(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('StudentsCtrl',['User', 'Student', '$stateParams', StudentsCtrl]);

	function StudentsCtrl(User, Student, $stateParams){
		var vm = this;
		// Props
		vm.students = [];
		vm.filters = {
			cities: ['La Paz', 'El Alto'],
			gender: ['Masculino', 'Femenino'],
			withTeam: false,
		};
		var privateFilters = {
			cities: ['La Paz', 'El Alto'],
			gender: ['Masculino','Femenino'],
			withTeam: true,
		};
		vm.isLoading = true;
		vm.total = 0;
		vm.pagination = [];
		vm.currentPage = $stateParams.num;
		// Methods
		vm.getStudents = getStudents;
		vm.updateFilter = updateFilter;
		// Methods implementation
		function getStudents(){
			Student.getStudentsPage($stateParams.num).then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.students = data.students;
					vm.total = data.pages;
					for (var i = 0; i < data.pages; i++) {
						vm.pagination.push(i + 1);
					}
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
