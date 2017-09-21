(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Profession', Profession);
	Profession.$inyect = ['$http', 'PUBLIC_URL'];
	function Profession($http, PUBLIC_URL){
		return{
			getProfessions: function(){
				var promise = $http({
					method: 'GET',
					url: PUBLIC_URL + 'professions'
				}).then(function(response){
					return response.data;	
				});
				return promise;
			},
		};
	};
})();