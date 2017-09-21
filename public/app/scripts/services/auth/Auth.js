(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Auth', Auth);
	Auth.$inyect = ['$http', '$state', 'locker', 'PUBLIC_URL'];
	function Auth($http, $state, locker, PUBLIC_URL){
		return{
			setSession: function(uid, rid, username, token, minFields, hasTeam, teamId, isLeader){
				locker.driver('session').put({
					user: {
						id: uid,
						role: rid,
						username: username,
						token: token,
						minFields: minFields,
						hasTeam: hasTeam,
						teamId: teamId,
						isLeader: isLeader,
					}
				});
			},
			hasMinFields: function(){
				return this.getSession().minFields != null;
			},
			hasTeam: function(){
				return this.getSession().hasTeam != null || this.getSession().hasTeam != false;
			},
			setMinFields: function(bool){
				locker.driver('session').put('user', function(curr){
						curr.minFields = bool;
						return curr;
				});
			},
			setToken: function(token){
				locker.driver('session').put('user', function(curr){
						curr.token = token;
						return curr;
				});
			},
			setHasTeam: function(bool){
				locker.driver('session').put('user', function(curr){
						curr.hasTeam = bool;
						return curr;
				});
			},
			setIsLeader: function(bool){
				locker.driver('session').put('user', function(curr){
						curr.isLeader = bool;
						return curr;
				});
			},
			setTeamId: function(teamId){
				locker.driver('session').put('user', function(curr){
						curr.teamId = teamId;
						return curr;
				});
			},
			getSession: function(){
				return locker.driver('session').get('user', null);
			},
			isAuth: function(){
				if (this.getSession() == null)
					return false;
				else
					return this.getSession().token != null;
			},
			login: function(data){
				var promise = $http({
					method: 'POST',
					url: PUBLIC_URL + 'login',
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			logout: function(){
				locker.driver('session').forget('user');
				$state.go('home');
			},
		};
	};
})();
