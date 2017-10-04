(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Checkpoint', Checkpoint);
	Checkpoint.$inyect = ['Auth', '$http', 'locker', 'PUBLIC_URL' ,'AUTH_URL'];
	function Checkpoint(Auth, $http, locker, PUBLIC_URL, AUTH_URL){
		return{
		    getCheckpoints: function(stage_id){
          //todo
					var promise = $http({
						url: AUTH_URL + 'stages/' + stage_id + '/checkpoints',
						method: 'GET',
						params: {token: Auth.getSession().token }
					}).then(function(response){
						return response.data;
					});
					return promise;
        },
				getCheckpoint: function(stage_id, check_id){
					var promise = $http({
						url: AUTH_URL + 'stages/' + stage_id + '/checkpoints/' + check_id,
						method: 'GET',
						params: {token: Auth.getSession().token }
					}).then(function(response){
						return response.data;
					});
					return promise;
				},
        createCheckpoint: function(data){
					var promise = $http({
						url: AUTH_URL + 'checkpoints',
						data: data,
						method: 'POST',
						params: {token: Auth.getSession().token }
					}).then(function(response){
						return response.data;
					});
					return promise;
        },
        getQuestions: function(checkId){
          var promise = $http({
						url: AUTH_URL + 'checkpoints/' + checkId + '/questions',
						method: 'GET',
						params: {token: Auth.getSession().token }
					}).then(function(response){
						return response.data;
					});
					return promise;
        },
        createQuestions: function(checkid, data){
					var promise = $http({
						url: AUTH_URL + 'checkpoints/' + checkid +  '/questions',
						data: data,
						method: 'POST',
						params: {token: Auth.getSession().token }
					}).then(function(response){
						return response.data;
					});
					return promise;
        },
		};
	};
})();
