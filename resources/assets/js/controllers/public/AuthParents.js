(function(){
  angular.module('heroesDigitalesApp')
    .controller('AuthParentsCtrl', ['$stateParams', '$state', 'LxNotificationService', 'Student', AuthParentsCtrl]);
  function AuthParentsCtrl($stateParams, $state, LxNotificationService, Student){
    var vm = this;
    // Props
    vm.signature = {
      name: '',
    };
    // Methods
    vm.accept = accept;

    // Method implementation
    function accept(){
      var authParams = {
        rid: $stateParams.id,
        token: $stateParams.token,
        signature: vm.signature.name,
      };
      Student.parentAuth(authParams).then(function(data){
        if(data.success){
          LxNotificationService.confirm('Felicitaciones', data.msg,
            {
                ok: 'Ver página de inicio',
                cancel: 'No gracias'
            }, function(answer){
                if (answer) $state.go('home');
                else return;
            });
        }else{
          LxNotificationService.warning(data.msg);
        }
      }, function(data){
        LxNotificationService.error('Hubo un error al procesar la autorización, revise su conexión a internet');
      });
    }

  };
})();
