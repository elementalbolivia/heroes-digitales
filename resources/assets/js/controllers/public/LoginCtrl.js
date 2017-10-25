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
		function navigate(id){
			if ($location.hash() !== id) {
        // set the $location.hash to `newHash` and
        // $anchorScroll will automatically scroll to it
        $location.hash(id);
      } else {
        // call $anchorScroll() explicitly,
        // since $location.hash hasn't changed
        $anchorScroll();
      }
		}
	};
})();
