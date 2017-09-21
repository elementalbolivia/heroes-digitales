(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Register', Register);
	Register.$inyect = ['$http', 'Upload', 'PUBLIC_URL'];
	function Register($http, Upload, PUBLIC_URL){
		return{
			register: function(data){
				var promise = Upload.upload({
					method: 'POST',
					url: PUBLIC_URL + 'register',
					data: data
				}).then(function(response){
					return response.data;	
				});
				return promise;
			},
		};
	};
})();