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
		// Methods
		vm.getMentors = getMentors;
		// Methods implementation
		function getMentors(){
			Mentor.getMentors().then(function(data){
				if(data.success){
					console.log(data);
					vm.mentors = data.mentors;
				}else{
					alert(data.msg);
				}
			}, function(err){

			});
		};
		// Methods self invoking
		vm.getMentors();
	};
})();
