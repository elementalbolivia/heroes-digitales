'use strict';
angular.module('heroesDigitalesApp', [
	'ui.router',
	'ngAnimate',
	'ngTouch',
	'ngFileUpload',
	'angular-locker',
	'lumx',
])
.constant('PUBLIC_URL', 'http://localhost:8000/api/v1/')
.constant('AUTH_URL', 'http://localhost:8000/api/v1/auth/')
.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function($stateProvider, $urlRouterProvider, $locationProvider){
	$stateProvider
		/**
		 *######### PUBLIC STATES ##########
		 */
		.state('home',{
			url: '/',
			views: {
				'header': {
					templateUrl: '/app/views/public/header.html',
					controller: 'LoginCtrl as vm'
				},
				'content': {
					templateUrl: '/app/views/public/dashboard.html',
					controller: 'HomeCtrl as vm'
				},
				'footer': {
					templateUrl: '/app/views/public/footer.html'
				},
			}
		})
		.state('home.register',{
			url: 'registro/:type',
			views: {
				'content@': {
					templateUrl: '/app/views/public/user-register.html',
					controller: 'UserRegisterCtrl as vm'
				},
			}
		})
		.state('home.admin',{
			url: 'admin',
			views: {
				'content@': {
					templateUrl: '/app/views/admin/login-form.html',
					controller: 'LoginAdminCtrl as vm'
				},
			}
		})
		.state('home.success-register',{
			url: 'registro',
			views: {
				'content@': {
					templateUrl: '/app/views/public/success-register.html',
					controller: 'RegisterSuccessCtrl as vm'
				},
			}
		})
		.state('home.forgot-password',{
			url: 'recuperar-contraseña',
			views: {
				'content@': {
					templateUrl: '/app/views/public/forgot-password.html',
					controller: 'ForgotPasswordCtrl as vm'
				},
			}
		})
		.state('home.success-email-verif',{
			url: 'exito-email-verificacion',
			views: {
				'content@': {
					templateUrl: '/app/views/public/success-email-verif.html',
				},
			}
		})
		.state('home.reset-password',{
			url: 'reestablecer-contraseña/:id/:token',
			views: {
				'content@': {
					templateUrl: '/app/views/public/reset-password.html',
					controller: 'ResetPasswordCtrl as vm'
				},
			}
		})
		.state('home.success-reset-password',{
			url: 'exito-recuperacion-contraseña',
			views: {
				'content@': {
					templateUrl: '/app/views/public/success-reset-password.html',
				},
			}
		})
		.state('home.auth-parents',{
			url: 'autorizacion-padres/:id/:token',
			views: {
				'content@': {
					templateUrl: '/app/views/public/auth-parents.html',
					controller: 'AuthParentsCtrl as vm',
				},
			}
		})
		/**
		 * EMAIL CONFIRMATION STATE
		 */
		.state('home.email-confirmation',{
			url: 'confirmacion-usuario/:uid/:token/:email',
			views: {
				'content@': {
					templateUrl: '/app/views/public/user-email-confirmation.html',
					controller: 'EmailConfirmationCtrl as vm'
				}
			},
		})
		/**
		 *########## AUTH STATES #########
		 *
		 * USER-MENTOR STATES
		 */
		.state('user', {
			url: '/dashboard',
			views: {
				'user-header': {
					templateUrl: '/app/views/user/header.html',
					controller: 'HeaderUserCtrl as vm',
				},
				'user-content': {
					templateUrl: '/app/views/user/dashboard.html',
					controller: 'DashboardUserCtrl as vm'
				},
				'user-footer': {
					templateUrl: '/app/views/user/footer.html'
				},
			}
		})
		.state('user.terms-use', {
			url: '/codigo-de-honor',
			views: {
				'user-content@': {
					templateUrl: '/app/views/user/honor-code.html',
					controller: 'HonorCodeCtrl as vm'
				}
			}
		})
		.state('user.parents-auth', {
			url: '/autorizacion-de-padres',
			views: {
				'user-content@': {
					templateUrl: '/app/views/user/parents-auth.html',
					controller: 'ParentsAuthCtrl as vm'
				}
			}
		})
		.state('user.my-profile', {
			url: '/perfil',
			views: {
				'user-content@': {
					templateUrl: '/app/views/user/my-profile.html',
					controller: 'MyProfileCtrl as vm'
				}
			}
		})
		.state('user.my-profile.edit', {
			url: '/editar',
			views: {
				'user-content@': {
					templateUrl: '/app/views/user/edit-profile.html',
					controller: 'EditProfileCtrl as vm'
				}
			}
		})
		.state('user.students', {
			url: '/estudiantes',
			views: {
				'user-content@': {
					templateUrl: '/app/views/student/students.html',
					controller: 'StudentsCtrl as vm'
				}
			}
		})
		.state('user.student-profile', {
			url: '/estudiante/:id',
			views: {
				'user-content@': {
					templateUrl: '/app/views/student/student-profile.html',
					controller: 'StudentProfileCtrl as vm'
				}
			}
		})
		.state('user.teams', {
			url: '/equipos',
			views: {
				'user-content@': {
					templateUrl: '/app/views/team/teams.html',
					controller: 'TeamsCtrl as vm'
				}
			}
		})
		.state('user.team-profile', {
			url: '/equipo/:id',
			views: {
				'user-content@': {
					templateUrl: '/app/views/team/team-profile.html',
					controller: 'TeamProfileCtrl as vm'
				}
			}
		})
		.state('user.team-profile.edit', {
			url: '/editar/:leaderId',
			views: {
				'user-content@': {
					templateUrl: '/app/views/team/team-profile-edit.html',
					controller: 'EditTeamProfileCtrl as vm'
				}
			}
		})
		.state('user.create-team', {
			url: '/crear-equipo',
			views: {
				'user-content@': {
					templateUrl: '/app/views/user/create-team.html',
					controller: 'CreateTeamCtrl as vm'
				}
			}
		})
		.state('user.mentors', {
			url: '/mentores',
			views: {
				'user-content@': {
					templateUrl: '/app/views/mentor/mentors.html',
					controller: 'MentorsCtrl as vm'
				}
			}
		})
		.state('user.mentor-profile', {
			url: '/mentor/:id',
			views: {
				'user-content@': {
					templateUrl: '/app/views/mentor/mentor-profile.html',
					controller: 'MentorProfileCtrl as vm'
				}
			}
		})
		/**
		 *######### ADMIN STATES ##########
		 */
		.state('admin',{
			url: '/admin/dashboard',
			views: {
				'admin-header': {
					templateUrl: '/app/views/admin/header.html',
					controller: 'HeaderAdminCtrl as vm'
				},
				'admin-content': {
					templateUrl: '/app/views/admin/dashboard.html',
					controller: 'DashboardAdminCtrl as vm'
				},
				'admin-footer': {
					templateUrl: '/app/views/admin/footer.html'
				},
			}
		})
		.state('admin.judges', {
			url: '/jueces',
			views: {
				'admin-content@':{
						templateUrl: '/app/views/admin/judges.html',
						controller: 'JudgeAdminCtrl as vm'
				},
			}
		})
		.state('admin.experts', {
			url: '/expertos',
			views: {
				'admin-content@':{
						templateUrl: '/app/views/admin/experts.html',
						controller: 'ExpertAdminCtrl as vm'
				},
			}
		})
		.state('admin.stages', {
			url: '/etapas',
			views: {
				'admin-content@':{
						templateUrl: '/app/views/admin/create-stage.html',
						controller: 'CreateStageAdminCtrl as vm'
				},
			}
		})
		.state('admin.stage', {
			url: '/etapas/:id',
			views: {
				'admin-content@':{
						templateUrl: '/app/views/admin/stage.html',
						controller: 'StageAdminCtrl as vm'
				},
			}
		})
		.state('admin.stage.checkpoint', {
			url: '/checkpoint/:checkpointId',
			views: {
				'admin-content@':{
						templateUrl: '/app/views/admin/checkpoint.html',
						controller: 'CheckpointAdminCtrl as vm'
				},
			}
		});
	$urlRouterProvider.otherwise('/');
	$locationProvider.html5Mode(true);
}])
.run(["$transitions", "$state", "$window", function($transitions, $state, $window) {
  $transitions.onStart({}, function($transition$){
    document.body.scrollTop = document.documentElement.scrollTop = 0;
  });
  $transitions.onStart({to : 'user.**'}, function(trans){
    var $state = trans.router.stateService;
    var AuthService = trans.injector().get('Auth');
    if(!AuthService.isAuth()){
    	// $window.location.href ='http://localhost:8000';
    	return $state.target('home');
    }
  });
	$transitions.onStart({to : 'admin.**'}, function(trans){
    var $state = trans.router.stateService;
    var AuthService = trans.injector().get('Auth');
    if(!AuthService.isAuth()){
    	// $window.location.href ='http://localhost:8000';
    	return $state.target('home');
    }
  });
  $transitions.onStart({to : 'home.**'}, function(trans){
    var $state = trans.router.stateService;
    var AuthService = trans.injector().get('Auth');
    if(AuthService.isAuth() && AuthService.getSession().role != 5){
    	// $window.location.href ='http://localhost:8000';
    	return $state.target('user');
    }else if(AuthService.isAuth() && AuthService.getSession().role == 5){
    	return $state.target('admin');
    }else{
    	return;
    }
  });
}]);
