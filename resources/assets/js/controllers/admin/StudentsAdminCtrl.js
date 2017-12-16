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
		// Methods
		vm.getStudents = getStudents;
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
		// Methods self invoking
		vm.getStudents();
	};
})();
