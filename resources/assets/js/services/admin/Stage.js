(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Stage',['Auth', '$http', 'locker', 'PUBLIC_URL' ,'AUTH_URL', Stage]);
	function Stage(Auth, $http, locker, PUBLIC_URL, AUTH_URL){
		return{
		    getStages: function(){
          //todo
					var promise = $http({
						url: PUBLIC_URL + 'stages',
						method: 'GET',
					}).then(function(response){
						return response.data;
					});
					return promise;
        },
				getStage: function(id){
					var promise = $http({
						url: AUTH_URL + 'stages/' + id,
						method: 'GET',
						params: {token: Auth.getSession().token }
					}).then(function(response){
						return response.data;
					});
					return promise;
				},
        createStage: function(data){
					var promise = $http({
						url: AUTH_URL + 'stages',
						data:data,
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
