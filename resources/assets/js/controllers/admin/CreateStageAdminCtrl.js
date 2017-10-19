(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('CreateStageAdminCtrl',['User', 'Auth', 'Stage', 'LxNotificationService', 'LxDatePickerService' , '$state', CreateStageAdminCtrl]);

	function CreateStageAdminCtrl(User, Auth, Stage, LxNotificationService, LxDatePickerService, $state){
		var vm = this;
		// Props
		vm.stages = [];
		vm.newStage = {
			name: '',
			desc: '',
			locale: 'es',
			minDate: new Date(new Date().getFullYear(), new Date().getMonth() - 2, new Date().getDate()),
			maxDate: new Date(new Date().getFullYear(), new Date().getMonth() + 2, new Date().getDate()),
			beginDate: {
				id: '_begin',
				date: new Date(),
				formatted: moment().locale('es').format('L'),
			},
			endDate: {
					id: '_end',
					date: new Date(),
					formatted: moment().locale('es').format('L'),
			},
		};
		vm.isUploaded = {
			state: false,
			msg: '',
			isLoading: false,
		};
		// Methods
		vm.getStages = getStages;
		vm.openDatePicker = openDatePicker;
		vm.datePickerCallback = datePickerCallback;
		vm.createStage = createStage;
		// Methods implementation
		function getStages(){
			Stage.getStages().then(function(data){
				if(data.success){
					console.log(data.stages);
					vm.stages = data.stages;
				}else{
					alert(data.msg);
				}
			}, function(err){

			});
		};
		function openDatePicker(pickerid){
			LxDatePickerService.open(pickerid);
		};
		function datePickerCallback(_newdate, pickerid){
				if(pickerid == 'BEGIN'){
					vm.newStage.beginDate.date = _newdate;
	        vm.newStage.beginDate.formatted = moment(_newdate).locale(vm.newStage.locale).format('L');
				}else{
					vm.newStage.endDate.date = _newdate;
					vm.newStage.endDate.formatted = moment(_newdate).locale(vm.newStage.locale).format('L');
				}
    };
		function createStage(){
			vm.isUploaded.isLoading = true;
			vm.isUploaded.state = false;
			var stageData = {
					name: vm.newStage.name,
					desc: vm.newStage.desc,
					beginDate: vm.newStage.beginDate.formatted.split('/').reverse().join('-'),
					endDate: vm.newStage.endDate.formatted.split('/').reverse().join('-'),
			};
			Stage.createStage(stageData).then(function(data){
				if(data.success){
					$state.go('admin.stage', {id: data.stageId});
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
		vm.getStages();
	};
})();
