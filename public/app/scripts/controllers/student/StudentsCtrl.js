(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('StudentsCtrl', StudentsCtrl);
	StudentsCtrl.$inyect = ['User', 'Student'];

	function StudentsCtrl(User, Student){
		var vm = this;
		// Props
		vm.students = [];
		vm.filters = {
			cities: ['La Paz', 'El Alto'],
			withTeam: true,
		};
		// Methods
		vm.getStudents = getStudents;
		vm.updateFilter = updateFilter;
		// Methods implementation
		function getStudents(){
			Student.getStudents().then(function(data){
				if(data.success){
					console.log(data);
					vm.students = data.students;
				}else{
					alert(data.msg);
				}
			}, function(err){

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