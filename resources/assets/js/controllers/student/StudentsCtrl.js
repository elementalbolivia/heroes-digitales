(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('StudentsCtrl',['$stateParams', 'User', 'Student', StudentsCtrl]);

	function StudentsCtrl($stateParams, User, Student){
		var vm = this;
		// Props
		vm.students = [];
		console.log($stateParams);
		vm.filters = {
			cities: $stateParams.city.split(','),
			gender: $stateParams.gender.split(','),
			withTeam: $stateParams.wteam == "true" ? true : false,
			studentName: $stateParams.studentName,
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
			vm.isLoading = true;
			Student.getStudentsPage($stateParams.num, vm.filters).then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.pagination = [];
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
			if(type == 'TEXT'){
				getStudents();
				return;
			}
			if(type == 'withTeam'){
				vm.filters.withTeam = arg;
				getStudents();
				return;
			}
			var index = vm.filters[type].indexOf(arg);
			if(index == -1){
				vm.filters[type].push(arg);
			}else{
				vm.filters[type].splice(index, 1);
			}
			getStudents();
		}
		// Methods self invoking
		getStudents();
	};
})();
