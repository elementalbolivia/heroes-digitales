(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('JudgeAdminCtrl',['User', 'Auth', 'Team', 'Judge', 'Request', 'LxNotificationService', JudgeAdminCtrl]);

	function JudgeAdminCtrl(User, Auth, Team, Judge, Request, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.judges = [];
		// Methods
		vm.getJudges = getJudges;
		vm.processRequest = processRequest;
		// Methods implementation
		function getJudges(){
			Judge.getJudges().then(function(data){
				if(data.success){
					console.log(data);
					vm.judges = data.judges;
				}else{
					alert(data.msg);
				}
			}, function(err){

			});
		};
		function processRequest(id, bool){
			var title = bool ? 'Esta seguro que desea aprobarlo para ser juez/experto?' : 'Esta seguro que desea rechazarlo para ser juez/experto?'
			LxNotificationService.confirm(title, '', {
				cancel: 'Cancelar',
				ok: 'Si, deseo hacerlo',
			}, function (answer){
				if(answer){
					var data = {id: id, accept: bool};
					Request.confirmRequest(data).then(function(data){
						if(data.success){
							vm.getExperts();
							vm.getJudges();
							LxNotificationService.success('La acción fue realizada con éxito');
						}else{
							LxNotificationService.warn('Hubo un error al realizar la acción');
						}
					}, function(err){
						LxNotificationService.error('Hubo un error al realizar la acción')
					});
				}else{
					return;
				}
			});
		};
		// Methods self invoking
		vm.getJudges();
	};
})();
