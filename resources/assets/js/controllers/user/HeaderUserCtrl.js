(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('HeaderUserCtrl',['User', 'Auth', HeaderUserCtrl]);

	function HeaderUserCtrl(User, Auth){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.hasMinFields = vm.userCreds.minFields;
		console.log(vm.hasMinFields);
		// Methods
		vm.logout = logout;

		// Methos implementation
		function logout(){
			Auth.logout();
		};
	};
})();
