<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

$route['about']	= "home/about";
$route['contact']	= "home/contact";
$route['help']	= "home/help";

// admin
$route['admin']	= "admin/home";
$route['admin/users']	= "admin/adminusers";
$route['admin/users/edit']	= "admin/adminusers/edit";
$route['admin/users/publish']	= "admin/adminusers/publish";
$route['admin/users/unpublish']	= "admin/adminusers/unpublish";
$route['admin/users/trash']	= "admin/adminusers/trash";
$route['admin/users/delete']	= "admin/adminusers/delete";
$route['admin/users/bypass']	= "admin/adminusers/bypass";
$route['admin/users/restore']	= "admin/adminusers/restore";
$route['admin_restricted_access']	= "home/admin_restricted_access";
$route['profile']	= "profile/index";

$route['trainer']	= "trainer/home";
$route['trainer_restricted_access']	= "home/trainer_restricted_access";

// advisor
$route['advisor/homeroom']	= "advisor/advisorhomeroom";
$route['advisor/homeroom/activity']	= "advisor/advisorhomeroom/activity";
$route['advisor/homeroom/activity_save']	= "advisor/advisorhomeroom/activity_save";
$route['advisor/homeroom/obedience']	= "advisor/advisorhomeroom/obedience";
$route['advisor/homeroom/risk']	= "advisor/advisorhomeroom/risk";
$route['advisor/homeroom/risk_save']	= "advisor/advisorhomeroom/risk_save";
$route['advisor/homeroom/confirm']	= "advisor/advisorhomeroom/confirm";
$route['advisor/homeroom/confirm_save']	= "advisor/advisorhomeroom/confirm_save";
$route['advisor']	= "advisor/home";
$route['advisor_restricted_access']	= "home/advisor_restricted_access";

// staff
$route['staff']	= "staff/home";
$route['staff_restricted_access']	= "home/staff_restricted_access";


// headdepartment
$route['headdepartment/homeroom']	= "headdepartment/headdepartmenthomeroom";
$route['headdepartment/homeroom/activity']	= "headdepartment/headdepartmenthomeroom/activity";
$route['headdepartment/homeroom/activity_save']	= "headdepartment/headdepartmenthomeroom/activity_save";
$route['headdepartment/homeroom/obedience']	= "headdepartment/headdepartmenthomeroom/obedience";
$route['headdepartment/homeroom/risk']	= "headdepartment/headdepartmenthomeroom/risk";
$route['headdepartment/homeroom/risk_save']	= "headdepartment/headdepartmenthomeroom/risk_save";
$route['headdepartment/homeroom/confirm']	= "headdepartment/headdepartmenthomeroom/confirm";
$route['headdepartment/homeroom/confirm_save']	= "headdepartment/headdepartmenthomeroom/confirm_save";

$route['headdepartment/report']	= "headdepartment/headdepartmentreport";

$route['headdepartment']	= "headdepartment/home";
$route['headdepartment_restricted_access']	= "home/headdepartment_restricted_access";

// headadvisor
$route['headadvisor']	= "headadvisor/home";
$route['headadvisor/users']	= "headadvisor/userscontroller";
$route['headadvisor/users/edit']	= "headadvisor/userscontroller/edit";

$route['headadvisor/users/publish']	= "headadvisor/userscontroller/publish";
$route['headadvisor/users/unpublish']	= "headadvisor/userscontroller/unpublish";
$route['headadvisor/users/trash']	= "headadvisor/userscontroller/trash";
$route['headadvisor/users/delete']	= "headadvisor/userscontroller/delete";
$route['headadvisor/users/restore']	= "headadvisor/userscontroller/restore";

$route['headadvisor/report']	= "headadvisor/headadvisorreport";

$route['headadvisor_restricted_access']	= "home/headadvisor_restricted_access";

// executive
$route['executive']	= "executive/home";
$route['executive/report']	= "executive/executivereport";
$route['executive_restricted_access']	= "home/executive_restricted_access";

$route['student']	= "student/home";
$route['student_restricted_access']	= "home/student_restricted_access";
