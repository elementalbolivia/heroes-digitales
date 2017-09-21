(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('HeaderUserCtrl', HeaderUserCtrl);
	HeaderUserCtrl.$inyect = ['User', 'Auth'];

	function HeaderUserCtrl(User, Auth){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.hasMinFields = vm.userCreds.minFields;
		// Methods
		vm.logout = logout;

		// Methos implementation
		function logout(){
			Auth.logout();
		};
	};
})();