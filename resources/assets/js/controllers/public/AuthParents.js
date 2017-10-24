(function(){
  angular.module('heroesDigitalesApp')
    .controller('AuthParentsCtrl', ['$stateParams', '$state', '$timeout', 'LxNotificationService', 'Student', AuthParentsCtrl]);
  function AuthParentsCtrl($stateParams, $state, $timeout, LxNotificationService, Student){
    var vm = this;
    // Props
    vm.signature = {
      name: '',
    };
    vm.sended = {
			isLoading: false,
			msg: '',
			title: '',
			success: false,
		};
    // Methods
    vm.accept = accept;
    vm.redirect = redirect;
    // Method implementation
    function accept(){
      var authParams = {
        rid: $stateParams.id,
        token: $stateParams.token,
        signature: vm.signature.name,
      };
      Student.parentAuth(authParams).then(function(data){
        $('#parentAuth').modal('show');
        if(data.success){
          vm.sended.title = 'Felicitaciones';
          vm.sended.msg = data.msg;
          vm.sended.success = true;
        }else{
          vm.sended.title = 'Error en la verificación';
          vm.sended.msg = data.msg;
          vm.sended.success = false;
        }
      }, function(data){
        LxNotificationService.error('Hubo un error al procesar la autorización, revise su conexión a internet');
      });
    }
    function redirect(bool){
			if(bool){
				$timeout(function(){
					$state.go('home');
				}, 500);
			}else{
				return;
			}
		}
  };
})();
