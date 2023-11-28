<?php

use App\Http\Controllers\CollegeGraduateStudyController;
use App\Http\Controllers\PDS\OtherInformationController;
use App\Http\Controllers\PDS\CivilServiceEligibilityController;
use App\Http\Controllers\PDS\EducationalBackgroundController;
use App\Http\Controllers\PDS\FamilyBackgroundController;
use App\Http\Controllers\PDS\LearningAndDevelopmentController;
use App\Http\Controllers\PDS\PageFourQuestionsController;
use App\Http\Controllers\PDS\PageFourReferencesIdController;
use App\Http\Controllers\PDS\PersonalInformationController;
use App\Http\Controllers\PDS\VoluntaryWorkController;
use App\Http\Controllers\PDS\WorkExperienceController;
use Illuminate\Support\Facades\Route;


// PDS Controller
Route::prefix('profile/pds')
->middleware('auth')
->name('profile.pds.')
->group(function() {

    // personal information
    Route::name('personal_information.store_or_update')->post('/personal_information', [PersonalInformationController::class, 'store_or_update']);
    Route::name('personal_information.edit')->get('/personal_information/edit', [PersonalInformationController::class, 'edit']);

    // family background
    Route::name('family_background.edit')->get('/family_background/edit', [FamilyBackgroundController::class, 'edit']);
    Route::name('family_background.store_or_update')->post('/family_background/store_or_update', [FamilyBackgroundController::class, 'store_or_update']);
    Route::name('family_background.store_child')->post('/family_background/store_child', [FamilyBackgroundController::class, 'store_child']);
    Route::name('children.delete')->delete('/family_background/children/{children}/delete', [FamilyBackgroundController::class, 'delete_child']);
    
    // educational background
    Route::name('educational_background.edit')->get('/educational_background/edit', [EducationalBackgroundController::class, 'edit']);
    Route::name('educational_background.store_or_update')->post('/educational_background/store_or_update', [EducationalBackgroundController::class, 'store_or_update']);
    Route::resource('college_graduate_study', CollegeGraduateStudyController::class);

    // civil service eligiblity
    Route::resource('civil_service_eligibility', CivilServiceEligibilityController::class)->only(['index', 'store', 'destroy', 'create', 'edit', 'update']);

    // work experience
    Route::resource('work_experience', WorkExperienceController::class);

    // work experience
    Route::resource('voluntary_work', VoluntaryWorkController::class);

    // learning and development
    Route::resource('learning_and_development', LearningAndDevelopmentController::class);
    
    // other information
    Route::name('other_information.edit')->get('/other_information/edit', [OtherInformationController::class, 'edit']);
    Route::name('other_information.index')->get('/other_information', [OtherInformationController::class, 'index']);
    Route::name('other_information.store_or_update')->post('/other_information/store_or_update', [OtherInformationController::class, 'store_or_update']);

    // page four questions
    Route::name('page_four_questions.edit')->get('/page_four_questions/edit', [PageFourQuestionsController::class, 'edit']);
    Route::name('page_four_questions.store_or_update')->post('/page_four_questions/store_or_update', [PageFourQuestionsController::class, 'store_or_update']);

    // page four references and government issued id
    // other information
    Route::name('reference_id.edit')->get('/reference_id/edit', [PageFourReferencesIdController::class, 'edit']);
    Route::name('reference_id.index')->get('/reference_id', [PageFourReferencesIdController::class, 'index']);
    Route::name('reference_id.store_or_update')->post('/reference_id/store_or_update', [PageFourReferencesIdController::class, 'store_or_update']);
    
});





?>