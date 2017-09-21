(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Judge', Judge);
	Judge.$inyect = ['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL'];
	function Judge($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
			getJudges: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'judges',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();