(function(){
	"use strict";
	angular.module('heroesDigitalesApp')
    .controller('LoginCtrl', ['$state', '$timeout', '$anchorScroll', '$location', 'Auth', LoginCtrl]);
	function LoginCtrl($state, $timeout, $anchorScroll, $location, Auth){
		var vm = this;
		// Props
		vm.creds = {
			email: "",
			password: ""
		};
		vm.loginState = {
			isNotLogged: false,
			msg: "",
			isLoading: false
		};
		// Method
		vm.login = login;
		vm.navigate = navigate;
		var goto = goto;
		function login(){
			vm.loginState.isNotLogged = false;
			vm.loginState.isLoading = true;
			Auth.login(vm.creds).then(function(data){
				if(data.success){
					$timeout(function(){
						$state.go(data.path);
					}, 1000);
					Auth.setSession(data.uid, data.rid, data.username,
												data.token, data.min_fields, data.has_team,
											 	data.team_id, data.is_leader);
					// console.log(Auth.getSession());
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
		function goto(id){
			$('html, body').animate({
					scrollTop: $(id).offset().top - 100
			}, 2000);
		}
		function navigate(id){
			if($state.current == $state.get('home.register')){
				$state.go('home');
				$timeout(function(){
					goto(id);
				}, 50);
			}else{
				goto(id);
			}
		}
	};
})();
