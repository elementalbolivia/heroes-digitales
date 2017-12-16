(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('StudentAdminCtrl',['User', 'Auth', 'Team', 'Student', 'Request', 'LxNotificationService', StudentAdminCtrl]);

	function StudentAdminCtrl(User, Auth, Team, Student, Request, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.students = [];
		vm.isLoading = true;
		// Methods
		vm.getStudents = getStudents;
		// Methods implementation
		function getStudents(){
			Student.getStudents().then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.students = data.students;
				}else{
					alert(data.msg);
				}
			}, function(err){

			});
		};
		// Methods self invoking
		vm.getStudents();
	};
})();
