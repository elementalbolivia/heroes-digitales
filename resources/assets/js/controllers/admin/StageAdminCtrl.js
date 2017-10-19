(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('StageAdminCtrl',['User', 'Auth', 'Stage', 'Checkpoit', 'LxNotificationService', 'LxDatePickerService' , '$state', '$stateParams', StageAdminCtrl]);

	function StageAdminCtrl(User, Auth, Stage, Checkpoint, LxNotificationService, LxDatePickerService, $state, $stateParams){
		var vm = this;
		// Props
		vm.checkpoints = [];
    vm.stage = {};
		vm.isUploaded = {
			state: false,
			msg: '',
			isLoading: false,
		};
		vm.newCheckpoint = {
			name: '',
			locale: 'es',
			minDate: new Date(new Date().getFullYear(), new Date().getMonth() - 2, new Date().getDate()),
			maxDate: new Date(new Date().getFullYear(), new Date().getMonth() + 2, new Date().getDate()),
			evalDate: {
				id: '_eval',
				date: new Date(),
				formatted: moment().locale('es').format('L'),
			},
		};
		// Methods
		vm.getCheckpoints = getCheckpoints;
    vm.getStage = getStage;
		vm.openDatePicker = openDatePicker;
		vm.datePickerCallback = datePickerCallback;
		vm.createCheckpoint = createCheckpoint;
		// Methods implementation
		function getCheckpoints(){
			Checkpoint.getCheckpoints($stateParams.id).then(function(data){
				if(data.success){
					vm.checkpoints = data.checkpoints;
				}else{
					alert(data.msg);
				}
			}, function(err){
				console.error('Hubo un error en el servidor');
			});
		};
		function getStage(){
      Stage.getStage($stateParams.id).then(function(data){
        if(data.success){
          vm.stage = data.stage;
        }else{
          console.warn(data.msg);
        }
      }, function(data){
        console.error('Hubo un error en el servidor');
      });
    };
		function openDatePicker(pickerid){
			LxDatePickerService.open(pickerid);
		};
		function datePickerCallback(_newdate, pickerid){
				if(pickerid == 'EVAL'){
					vm.newCheckpoint.evalDate.date = _newdate;
	        vm.newCheckpoint.evalDate.formatted = moment(_newdate).locale(vm.newCheckpoint.locale).format('L');
				}
    };
		function createCheckpoint(){
			vm.isUploaded.isLoading = true;
			vm.isUploaded.state = false;
			var checkpointData = {
					stageId: $stateParams.id,
					name: vm.newCheckpoint.name,
					evalDate: vm.newCheckpoint.evalDate.formatted.split('/').reverse().join('-'),
			};
			Checkpoint.createCheckpoint(checkpointData).then(function(data){
				if(data.success){
					$state.go('admin.stage.checkpoint', {stageId: $stateParams.id, checkpointId: data.checkId});
				}else{
					vm.isUploaded.isLoading = false;
					vm.isUploaded.state = true;
					vm.isUploaded.msg = data.msg;
				}
			}, function(data){
				console.error('Hubo un error en el servidor');
			});
		};
		// Methods self invoking
		vm.getCheckpoints();
    vm.getStage();
	};
})();
