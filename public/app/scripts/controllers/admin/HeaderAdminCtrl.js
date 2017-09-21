(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('HeaderAdminCtrl', HeaderAdminCtrl);
	HeaderAdminCtrl.$inyect = ['Auth'];

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