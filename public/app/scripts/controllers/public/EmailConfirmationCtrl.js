(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('EmailConfirmationCtrl', EmailConfirmationCtrl);
	EmailConfirmationCtrl.$inyect = ['$stateParams', '$state', '$timeout', 'User', 'Auth'];

	function EmailConfirmationCtrl($stateParams, $state, $timeout, User, Auth){
		var vm = this;
		// Props
		vm.authParams = {
			uid: $stateParams.uid,
			token: $stateParams.token,
			email: $stateParams.email,
			password: ''
		};
		vm.isSubmited = {
			state: false,
			success: {
				state: false,
				msg: ''
			}
		};
		// Methods
		vm.confirmRoute = confirmRoute;
		// Methods implementation
		function confirmRoute(){
			vm.isSubmited.state = true;
			vm.isSubmited.success.state = false;	
			User.confirmEmail(vm.authParams).then(function(data){
				if(data.success){
					if(data.already_verif)
						$state.go(data.path);
					Auth.setSession(data.uid, data.rid, data.username, data.token);
					$state.go(data.path);
				}else{
					vm.isSubmited.success.msg = data.msg;
					vm.isSubmited.success.state = true;
					vm.isSubmited.state = false;
				}
			}, function(err){
				alert('Problema con el servidor, revise su conexión a internet');
			});
		};
	};
})();