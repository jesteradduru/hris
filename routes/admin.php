<?php


 // Admin Page Routes

use App\Http\Controllers\Admin\AdminDailyTimeRecordController;
use App\Http\Controllers\Admin\AdminJobApplicationController;
use App\Http\Controllers\Admin\AdminJobPostingController;
use App\Http\Controllers\Admin\AdminLearningAndDevelopmentController;
use App\Http\Controllers\Admin\AdminRewardAndRecognitionController;
use App\Http\Controllers\Admin\AdminSpmsController;
use App\Http\Controllers\Admin\ApplicationHistoryController;
use App\Http\Controllers\Admin\ApplicationResultController;
use App\Http\Controllers\Admin\ApplicationScoreController;
use App\Http\Controllers\Admin\CompetencyGapController;
use App\Http\Controllers\Admin\EligibilityController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EmployeeRewardController;
use App\Http\Controllers\Admin\ExportJobApplicationReportsController;
use App\Http\Controllers\Admin\IdpAccomplishmentController;
use App\Http\Controllers\Admin\IdpController;
use App\Http\Controllers\Admin\LndTrainingsAttendedController;
use App\Http\Controllers\Admin\PesRatingController;
use App\Http\Controllers\Admin\PlantillaPositionController;
use App\Http\Controllers\Admin\PublishHiringResultController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\Selection\AcademicAwardController;
use App\Http\Controllers\Admin\Selection\LearningAndDevelopmentController;
use App\Http\Controllers\Admin\Selection\NonAcademicAwardController;
use App\Http\Controllers\Admin\Selection\PsbPointController;
use App\Http\Controllers\Admin\Selection\WorkExperienceController;
use App\Http\Controllers\Admin\SetExamScheduleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PDS\NonAcademicDistinctionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

 Route::prefix('admin')
 ->middleware(['admin', 'auth'])
 ->name('admin.')
 ->group(function () {

     // Admin Dashboard
     Route::name('dashboard')->get('dashboard', [AdminController::class, 'index']);

    //  Employee
    Route::prefix('employees')
    ->name('employees.')
    ->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        // Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        // Route::post('/store', [EmployeeController::class, 'store'])->name('store');
        // Route::put('/{employee}/update', [EmployeeController::class, 'update'])->name('update');
        // Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::resource('employee', EmployeeController::class);
        Route::get('/{employee}/rewards/edit', [EmployeeController::class, 'editRewards'])->name('rewards.edit');
        Route::get('/{employee}/rewards/add', [EmployeeController::class, 'addReward'])->name('rewards.add');
        // Rewarding the employee
        Route::get('rewards/{reward?}/create', [EmployeeRewardController::class, 'create'])->name('rewards.create');
        Route::post('{user}/rewards/store', [EmployeeRewardController::class, 'store'])->name('rewards.store');
        Route::delete('rewards/{reward}/destroy', [EmployeeRewardController::class, 'destroy'])->name('rewards.destroy');
        Route::get('rewards/{reward?}/rankByIpcr', [EmployeeRewardController::class, 'rank_by_ipcr'])->name('rewards.rank_by_ipcr');
    });   


     // routes for Roles and Permissions
     Route::prefix('role_permission')
     ->name('role_permission.')
     ->group(function () {
         Route::name('index')->get('/', [RolePermissionController::class, 'index']);
         Route::resource('role', RoleController::class);
         Route::resource('permission', PermissionController::class);
     });

     // Routes for Recruiment Page
     Route::prefix('recruitment')
     ->name('recruitment.')
     ->group(function () {
         Route::resource('job_posting', AdminJobPostingController::class);
         Route::name('job_posting.archived')->put('job_posting/{job_posting}/archived', [AdminJobPostingController::class, 'archived']);
         Route::resource('job_posting.application_history', ApplicationHistoryController::class)->only(['index']);
         Route::name('job_posting.application_history.show')->get('job_posting/{job_posting}/application_history/show', [ApplicationHistoryController::class, 'show']);

        //  viewing of job applications for vacancies
        Route::resource('selection', AdminJobApplicationController::class)->only(['index', 'show']);
       
        Route::name('application_result.store')->post('application_result/store', [ApplicationResultController::class, 'store']);
        Route::name('application_result.updateNotes')->put('application_result/updateNotes', [ApplicationResultController::class, 'updateNotes']);

        Route::name('application_result.publish')->put('application_result/{results}/publish', PublishHiringResultController::class);
        Route::name('neda_exam.set')->put('neda_exam/{result}/setShedule', SetExamScheduleController::class);

        // application scores
        Route::resource('application_score', ApplicationScoreController::class);

        // plantilla position
        Route::resource('plantilla', PlantillaPositionController::class);
        Route::resource('plantilla.rule', RuleController::class);

        Route::resource('eligibility', EligibilityController::class)->only(['store', 'update', 'destroy']);

        // pes rating
        Route::resource('pes', PesRatingController::class)->only(['store']);

        // selection/nonacademicaward
        // Route::resource('non_academic_distinction', NonAcademicAwardController::class);
        Route::put('non_academic_distinction/{non_academic}/updateCategory', [NonAcademicAwardController::class, 'updateCategory'])->name('non_academic_distinction.updateCategory');
        Route::post('non_academic_distinction/{non_academic}/includeAward', [NonAcademicAwardController::class, 'includeAward'])->name('non_academic_distinction.includeAward');

        // selection/academic awards
        Route::post('academic_distinction/{academic}/includeAward', [AcademicAwardController::class, 'includeAward'])->name('academic_distinction.includeAward');
        // selection/lnd
        Route::post('lnd/{lnd}/includeLnd', [LearningAndDevelopmentController::class, 'includeLnd'])->name('lnd.includeLnd');
        // selection/work experience
        Route::post('work/{work}/includeWork', [WorkExperienceController::class, 'includeWork'])->name('work.includeWork');

        // selection/psbpoints
        Route::post('psb_point/{job_application}/save', [PsbPointController::class, 'save'])->name('psb_point.save');
    });
        
    // rewards and recognition
    Route::resource('rewards', AdminRewardAndRecognitionController::class);
    // spms
    Route::resource('spms', AdminSpmsController::class);

    // reports
    Route::resource('reports', ReportController::class)->only('index');
    Route::name('reports.export')->get('reports/export/', [ReportController::class, 'export']);
    Route::name('reports.job_application.export')->get('reports/job_applicaion/export/', [ExportJobApplicationReportsController::class, 'export']);

    // lnd
    Route::resource('lnd', AdminLearningAndDevelopmentController::class);
    Route::resource('competency_gap', CompetencyGapController::class);
    Route::resource('competency_training', LndTrainingsAttendedController::class);
    Route::name('competency_gap.addPriority')->post('/compentency_gap/{report_id}/addPriority', [CompetencyGapController::class, 'addPriority']);
    Route::name('competency_gap.removePriority')->delete('/compentency_gap/removePriority/{target_staff}', [CompetencyGapController::class, 'removePriority']);

    // lnd idp
    Route::resource('idp', IdpController::class);
    Route::resource('idp_accomplishment', IdpAccomplishmentController::class)->only(['store', 'destroy']);

    Route::get('daily_time_record', [AdminDailyTimeRecordController::class, 'index'])->name('daily_time_record.index');
    Route::post('daily_time_record/getDtr', [AdminDailyTimeRecordController::class, 'getDtr'])->name('daily_time_record.getDtr');

    
 });

?>