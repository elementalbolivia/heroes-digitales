(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('LoginAdminCtrl', LoginAdminCtrl);
	LoginAdminCtrl.$inyect = ['$state', '$timeout', 'Auth'];

	function LoginAdminCtrl($state, $timeout, Auth){
		var vm = this;
		vm.creds = {
			email: '',
			password: ''
		};
		vm.loginAdminState = {
			isNotLogged: false,
			msg: '',
			isLoading: false
		};

		vm.loginAdmin = loginAdmin;

		function loginAdmin(){
			vm.loginAdminState.isNotLogged = false;
			vm.loginAdminState.isLoading = true;
			Auth.login(vm.creds).then(function(data){
				if(data.success){
					console.log(data);
					Auth.setSession(data.uid, data.rid, data.username,
												data.token, data.min_fields, data.has_team,
											 	data.team_id, data.is_leader);
					$state.go(data.path)
					console.log(Auth.getSession());
				}else{
					vm.loginAdminState.isNotLogged = true;
					vm.loginAdminState.isLoading = false;
					vm.loginAdminState.msg = data.msg
				}
			}, function(err){
				console.error('Problema en el servidor');
			});
		};
	};
})();
