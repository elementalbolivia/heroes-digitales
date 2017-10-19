(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Expertise', ['$http', 'PUBLIC_URL', 'AUTH_URL', 'Auth',Expertise]);
	function Expertise($http, PUBLIC_URL, AUTH_URL, Auth){
		return{
			getExpertises: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'expertises',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
