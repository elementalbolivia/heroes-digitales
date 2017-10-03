<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Heróes Digitales</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <!-- CSS -->
    <link rel="stylesheet" href="/bower_components/lumx/dist/lumx.css">
    <link rel="stylesheet" type="text/css" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/app/styles/style.css">
    <!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700"> -->
    <!-- -->
</head>
<body ng-app="heroesDigitalesApp">
    <div ui-view="header"></div>
    <div ui-view="content"></div>
    <div ui-view="footer"></div>
    <div ui-view="user-header"></div>
    <div ui-view="user-content"></div>
    <div ui-view="user-footer"></div>
    <div ui-view="admin-header"></div>
    <div ui-view="admin-content"></div>
    <div ui-view="admin-footer"></div>
<!-- Bower dependencies -->
<script src="/bower_components/jquery/dist/jquery.js"></script>
<script src="/bower_components/velocity/velocity.js"></script>
<script src="/bower_components/moment/min/moment-with-locales.js"></script>
<script src="/bower_components/angular/angular.js"></script>
<script src="/bower_components/lumx/dist/lumx.js"></script>
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
<script src="/bower_components/angular-touch/angular-touch.min.js"></script>
<script src="/bower_components/angular-animate/angular-animate.min.js"></script>
<script src="/bower_components/ng-file-upload/ng-file-upload.min.js"></script>
<script src="/bower_components/ng-file-upload/ng-file-upload-shim.min.js"></script>
<script src="/bower_components/angular-locker/dist/angular-locker.min.js"></script>
<!-- Angular Script dependencies -->
<script src="/app/scripts/app.js"></script>
<!-- Controllers  -->
<script src="/app/scripts/controllers/public/UserRegister.js"></script>
<script src="/app/scripts/controllers/public/EmailConfirmationCtrl.js"></script>
<script src="/app/scripts/controllers/public/LoginCtrl.js"></script>
<script src="/app/scripts/controllers/public/RegisterSuccessCtrl.js"></script>
<script src="/app/scripts/controllers/public/ForgotPasswordCtrl.js"></script>
<script src="/app/scripts/controllers/public/ResetPasswordCtrl.js"></script>
<script src="/app/scripts/controllers/user/DashboardUserCtrl.js"></script>
<script src="/app/scripts/controllers/user/HeaderUserCtrl.js"></script>
<script src="/app/scripts/controllers/user/HonorCodeCtrl.js"></script>
<script src="/app/scripts/controllers/user/ParentsAuthCtrl.js"></script>
<script src="/app/scripts/controllers/user/MyProfileCtrl.js"></script>
<script src="/app/scripts/controllers/user/EditProfileCtrl.js"></script>
<script src="/app/scripts/controllers/user/CreateTeamCtrl.js"></script>
<script src="/app/scripts/controllers/student/StudentProfileCtrl.js"></script>
<script src="/app/scripts/controllers/student/StudentsCtrl.js"></script>
<script src="/app/scripts/controllers/team/TeamsCtrl.js"></script>
<script src="/app/scripts/controllers/team/TeamProfileCtrl.js"></script>
<script src="/app/scripts/controllers/team/EditTeamProfileCtrl.js"></script>
<script src="/app/scripts/controllers/mentor/MentorsCtrl.js"></script>
<script src="/app/scripts/controllers/mentor/MentorProfileCtrl.js"></script>
<script src="/app/scripts/controllers/admin/LoginAdminCtrl.js"></script>
<script src="/app/scripts/controllers/admin/DashboardAdminCtrl.js"></script>
<script src="/app/scripts/controllers/admin/HeaderAdminCtrl.js"></script>
<script src="/app/scripts/controllers/admin/JudgeAdminCtrl.js"></script>
<script src="/app/scripts/controllers/admin/ExpertAdminCtrl.js"></script>
<script src="/app/scripts/controllers/admin/StageAdminCtrl.js"></script>
<!-- Services -->
<script src="/app/scripts/services/public/Register.js"></script>
<script src="/app/scripts/services/public/City.js"></script>
<script src="/app/scripts/services/public/Zone.js"></script>
<script src="/app/scripts/services/public/Genre.js"></script>
<script src="/app/scripts/services/public/School.js"></script>
<script src="/app/scripts/services/user/User.js"></script>
<script src="/app/scripts/services/auth/Auth.js"></script>
<script src="/app/scripts/services/team/Division.js"></script>
<script src="/app/scripts/services/team/Category.js"></script>
<script src="/app/scripts/services/team/Team.js"></script>
<script src="/app/scripts/services/student/Student.js"></script>
<script src="/app/scripts/services/professional/Profession.js"></script>
<script src="/app/scripts/services/professional/Expertise.js"></script>
<script src="/app/scripts/services/professional/Skill.js"></script>
<script src="/app/scripts/services/professional/CV.js"></script>
<script src="/app/scripts/services/mentor/Mentor.js"></script>
<script src="/app/scripts/services/expert/Expert.js"></script>
<script src="/app/scripts/services/judge/Judge.js"></script>
<script src="/app/scripts/services/professional/Request.js"></script>
<script src="/app/scripts/services/admin/Stage.js"></script>
<!-- Filters -->
<script src="/app/scripts/filters/team/TeamFilter.js"></script>
<script src="/app/scripts/filters/student/StudentFilter.js"></script>
<script src="/app/scripts/filters/mentor/Mentors.js"></script>

</body>
</html>
