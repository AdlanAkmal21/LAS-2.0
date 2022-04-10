<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveManagementController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLogController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Default
Route::get('/', function () {
    return redirect()->route('login');
});

//Authentications
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    //Approver Group
    Route::group(['middleware' => 'role:3'], function () {
        Route::prefix('approver')->group(function () {
            Route::get('application/list', [ApproverController::class, 'approver_list'])->name('approver.approver_list');
            Route::get('application/show/{application}', [ApproverController::class, 'approver_list_show'])->name('approver.approver_list_show');
            Route::get('application/approve/{application}', [ApproverController::class, 'approve'])->name('approver.approve');
            Route::get('application/reject/{application}', [ApproverController::class, 'reject'])->name('approver.reject');

            Route::get('applicant/list', [ApproverController::class, 'applicant_list'])->name('approver.applicant_list');
            Route::get('applicant/{applicant_id}', [ApproverController::class, 'applicant_show'])->name('approver.applicant_show');
        });
    });

    //Admin Group
    Route::group(['middleware' => 'role:1'], function () {
        Route::prefix('admin')->group(function () {
            Route::get('employee/list', [AdminController::class, 'employee_list'])->name('admin.employee_list');
            Route::get('employee/list/search', [AdminController::class, 'search'])->name('admin.employee_search');
            Route::get('employee/list/search/report', [AdminController::class, 'search_report'])->name('admin.search_report');
            Route::get('employee/list/search/resigned', [AdminController::class, 'search_resigned'])->name('admin.search_resigned');
            Route::get('application/list', [AdminController::class, 'application_list'])->name('admin.application_list');
            Route::get('application/list/{year}', [AdminController::class, 'application_list_ty'])->name('admin.application_list_ty');
            Route::get('application/list/user/{user_id}', [AdminController::class, 'application_list_employee'])->name('admin.application_list_employee');
            Route::get('application/{application}', [AdminController::class, 'application_show'])->name('admin.application_show');

            Route::get('wfh/attendance', [UserLogController::class, 'admin_user_log_index'])->name('admin.admin_user_log_index');
            Route::post('wfh/attendance', [UserLogController::class, 'admin_user_log_search'])->name('admin.admin_user_log_search');

            Route::get('office/attendance', [OfficeController::class, 'admin_office_index'])->name('admin.admin_office_index');
            Route::post('office/attendance', [OfficeController::class, 'admin_office_search'])->name('admin.admin_office_search');

            Route::get('report/overview', [ReportController::class, 'overview'])->name('report.overview');
            Route::get('report/individual', [ReportController::class, 'individual'])->name('report.individual');
            Route::get('report/individual/search', [ReportController::class, 'search_employee'])->name('report.search_employee');
            Route::get('report/individual/{id}', [ReportController::class, 'view_individual'])->name('report.view_individual');
            Route::get('report/application', [ReportController::class, 'application'])->name('report.application');
            Route::get('report/application/employee/search', [ReportController::class, 'search_application_employee'])->name('report.search_application_employee');
            Route::get('report/application/period/{period}', [ReportController::class, 'application_period_overview'])->name('report.application_period_overview');

            Route::get('report/application/pdf', [PrintController::class, 'generate_overview'])->name('print.overview_pdf');
            Route::get('report/application/{period}/pdf', [PrintController::class, 'generate_period'])->name('print.period_pdf');
            Route::get('report/application/{period}/xlsx', [PrintController::class, 'generate_period_xlsx'])->name('print.period_xlsx');
            Route::get('application/{application}/pdf', [PrintController::class, 'generate_application_pdf'])->name('print.generate_application_pdf');
            Route::post('userlog', [PrintController::class, 'generate_user_log_admin'])->name('print.generate_user_log_admin');
            Route::post('office_log', [PrintController::class, 'generate_office_log_admin'])->name('print.generate_office_log_admin');

            Route::resource('file', FileController::class);

            Route::get('leave_management', [LeaveManagementController::class, 'index'])->name('leave_management.index');
            Route::post('leave_management', [LeaveManagementController::class, 'store'])->name('leave_management.store');
            Route::get('leave_management/{leave_detail}', [LeaveManagementController::class, 'edit'])->name('leave_management.edit');
            Route::post('leave_management/{leave_detail}', [LeaveManagementController::class, 'update'])->name('leave_management.update');

            Route::get('activity_log', [AdminController::class, 'activity_log'])->name('admin.activity_log');
        });

        Route::get('application/search', [AdminController::class, 'search_application'])->name('admin.search_application');
        Route::post('application/search', [AdminController::class, 'search_application_search'])->name('admin.search_application_search');

        Route::resource('holiday', HolidayController::class);
        Route::resource('admin', AdminController::class);
    });


    //User Group
    Route::prefix('user')->group(function () {
        Route::get('notifications/read', [UserController::class, 'read_notifications'])->name('user.read_notifications');
        Route::get('notifications/view', [UserController::class, 'view_notifications'])->name('user.view_notifications');
        Route::post('notifications/clear', [UserController::class, 'clear_notifications'])->name('user.clear_notifications');

        Route::get('wfh/attendance', [UserLogController::class, 'index'])->name('user_log.index');
        Route::post('wfh/attendance/in', [UserLogController::class, 'clock_in'])->name('user_log.clock_in');
        Route::post('wfh/attendance/out', [UserLogController::class, 'clock_out'])->name('user_log.clock_out');
        Route::get('wfh/log', [UserLogController::class, 'user_log_index'])->name('user_log.user_log_index');
        Route::post('wfh/log', [UserLogController::class, 'user_log_search'])->name('user_log.user_log_search');

        Route::get('office/attendance', [OfficeController::class, 'index'])->name('office.index');
        Route::post('office/attendance/in', [OfficeController::class, 'clock_in'])->name('office.clock_in');
        Route::post('office/attendance/out', [OfficeController::class, 'clock_out'])->name('office.clock_out');
        Route::get('office/attendance/log', [OfficeController::class, 'office_logs'])->name('office.office_logs');
        Route::post('office/attendance/log', [OfficeController::class, 'office_logs_search'])->name('office.office_logs_search');


        Route::get('change-password', [ResetPasswordController::class, 'change_page'])->name('reset.view');
        Route::post('change-password', [ResetPasswordController::class, 'change'])->name('reset.change');
        Route::post('userlog', [PrintController::class, 'generate_user_log'])->name('print.generate_user_log');
        Route::post('office_log', [PrintController::class, 'generate_office_log'])->name('print.generate_office_log');
    });
    Route::get('application/list/{year}', [LeaveApplicationController::class, 'index_ty'])->name('application.index_ty');

    Route::resource('user', UserController::class);
    Route::resource('application', LeaveApplicationController::class);
});

//Forgot Password
Route::get('forgot-password', [ForgotPasswordController::class, 'get_email'])->name('forgot.get_email');
Route::post('forgot-password', [ForgotPasswordController::class, 'post_email'])->name('forgot.post_email');
Route::get('forgot-reset-password/{token}', [ForgotPasswordController::class, 'reset_page']);
Route::post('forgot-reset-password', [ForgotPasswordController::class, 'reset'])->name('forgot.reset');

//Error Messages
Route::view('/error', 'error.no_permission')->name('error.no_permission');
