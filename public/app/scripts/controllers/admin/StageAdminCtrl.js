(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('StageAdminCtrl', StageAdminCtrl);
	StageAdminCtrl.$inyect = ['User', 'Auth', 'Stage', 'LxNotificationService', 'LxDatePickerService'];

	function StageAdminCtrl(User, Auth, Stage, LxNotificationService, LxDatePickerService){
		var vm = this;
		// Props
		vm.stages = [];
		vm.newStage = {
			name: '',
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
		// Methods
		vm.getStages = getStages;
		vm.openDatePicker = openDatePicker;
		vm.datePickerCallback = datePickerCallback;
		// Methods implementation
		function getStages(){
			Stage.getStages().then(function(data){
				if(data.success){
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

    }
		// Methods self invoking
		vm.getStages();
	};
})();
