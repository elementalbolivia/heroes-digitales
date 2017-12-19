(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('MentorAdminCtrl',['User', 'Auth', 'Team', 'Mentor', 'Request', 'LxNotificationService', MentorAdminCtrl]);

	function MentorAdminCtrl(User, Auth, Team, Mentor, Request, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.mentors = [];
		vm.isLoading = true;
		// Methods
		vm.getMentors = getMentors;
		// Methods implementation
		function getMentors(){
			Mentor.getMentors().then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.mentors = data.mentors;
				}else{
					alert(data.msg);
				}
			}, function(err){
				alert('Hubo un error al obtener a los mentores');
			});
		};

		// Methods self invoking
		vm.getMentors();
	};
})();
