(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('CheckpointAdminCtrl',['User', 'Auth', 'Checkpoint', 'LxNotificationService', 'LxDatePickerService', '$state', '$stateParams', CheckpointAdminCtrl]);

	function CheckpointAdminCtrl(User, Auth, Checkpoint, LxNotificationService, LxDatePickerService, $state, $stateParams){
		var vm = this;
		// Props
    vm.checkpoint = {};
		vm.questions = [];
    vm.checkpointQuestions = [];
		vm.isUploaded = {
			state: false,
			msg: '',
			isLoading: false,
		};
		// Methods
    vm.getCheckpoint = getCheckpoint;
		vm.getQuestions = getQuestions;
    vm.addQuestion = addQuestion;
    vm.deleteQuestion = deleteQuestion;
    vm.createQuestions = createQuestions;
		vm.openDatePicker = openDatePicker;
		vm.datePickerCallback = datePickerCallback;
		// Methods implementation
		function getQuestions(){
			Checkpoint.getQuestions($stateParams.checkpointId).then(function(data){
				if(data.success){
					vm.questions = data.questions;
				}else{
					alert(data.msg);
				}
			}, function(err){
        console.error('Hubo un error en el servidor');
			});
		};
    function getCheckpoint(){
			Checkpoint.getCheckpoint($stateParams.id, $stateParams.checkpointId).then(function(data){
				if(data.success){
					vm.checkpoint = data.checkpoint;
				}else{
					alert(data.msg);
				}
			}, function(err){
        console.error('Hubo un error en el servidor');
			});
		};
    function createQuestions(){
      if(vm.checkpointQuestions.length == 0){
        vm.isUploaded.state = true;
        vm.isUploaded.msg = 'Debes crear almenos una pregunta';
        return;
      }
			vm.isUploaded.isLoading = true;
			vm.isUploaded.state = false;
			Checkpoint.createQuestions($stateParams.checkpointId, {questions: vm.checkpointQuestions}).then(function(data){
				if(data.success){
					vm.getQuestions();
          vm.checkpointQuestions = [];
				}else{
					vm.isUploaded.isLoading = false;
					vm.isUploaded.state = true;
					vm.isUploaded.msg = data.msg;
				}
			}, function(data){
        vm.isUploaded.isLoading = false;
				console.error('Hubo un error en el servidor');
			});
		};
    function addQuestion(){
      vm.checkpointQuestions.push({
        id: Date.now(),
        type: {
          id: 0,
          label: 'Ninguno'
        },
        question: ''
      });
    };
    function deleteQuestion(id){
      var pos = 0;
      for (var i = 0; i < vm.checkpointQuestions.length; i++) {
        if(vm.checkpointQuestions[i].id == id){
          pos = i;
          break;
        }
      }
      vm.checkpointQuestions.splice(pos, 1);
    }
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
		// Methods self invoking
		vm.getQuestions();
    vm.getCheckpoint();
	};
})();
