(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('HeaderAdminCtrl',['Auth',  HeaderAdminCtrl]);

	function HeaderAdminCtrl(Auth){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		// Methods
		vm.logout = logout;

		// Methos implementation
		function logout(){
			Auth.logout();
		};
	};
})();
