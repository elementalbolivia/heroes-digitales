(function(){
	"use strict";
	function LoginCtrl($state, $timeout, Auth){
		var vm = this;
		vm.creds = {
			email: "",
			password: ""
		};
		vm.loginState = {
			isNotLogged: false,
			msg: "",
			isLoading: false
		};

		vm.login = login;

		function login(){
			vm.loginState.isNotLogged = false;
			vm.loginState.isLoading = true;
			Auth.login(vm.creds).then(function(data){
				if(data.success){
					console.log(data);
					$timeout(function(){
						$state.go(data.path);
					}, 1000);
					Auth.setSession(data.uid, data.rid, data.username,
												data.token, data.min_fields, data.has_team,
											 	data.team_id, data.is_leader);
					console.log(Auth.getSession());
					$("#login").modal("hide");
				}else{
					vm.loginState.isNotLogged = true;
					vm.loginState.isLoading = false;
					vm.loginState.msg = data.msg
				}
			}, function(err){
				vm.loginState.isNotLogged = true;
				vm.loginState.isLoading = false;
				vm.loginState.msg = 'Hubo un error al iniciar sesión, revise su conexión a internet e inténtelo nuevamente';
 			});
		};
	};
	angular.module("heroesDigitalesApp")
	.controller("LoginCtrl",["$state", "$timeout", "Auth", LoginCtrl]);
})();
