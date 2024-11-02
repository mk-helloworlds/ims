<?php

use App\Http\Controllers\AdminAdvisorSelectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvisorSelectionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SubmissionFormController;
use App\Http\Controllers\StudentSubmissionFormController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\AdvisorFollowUpController;
use App\Http\Controllers\AdvisorInternshipProjectController;
use App\Http\Controllers\JuryGroupController;
use App\Http\Controllers\JuryEvaluationController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\DefenseResultsController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\InternshipParticipantController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\InternshipProjectController;
use App\Http\Controllers\StudentInternshipProjectController;
use App\Http\Middleware\CheckRole;
use App\Models\InternshipParticipant;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'preference', 'middleware' => ['auth']], function () {

    // <> NOT EFFECTED ROUTE______________________________

    // MyProfile
    Route::get('/profile', [MyProfileController::class, 'show'])->name('my-profile.show');
    Route::get('/profile/edit', [MyProfileController::class, 'edit'])->name('my-profile.edit');
    Route::post('/profile/update', [MyProfileController::class, 'update'])->name('my-profile.update');
    Route::post('/profile/change-password', [MyProfileController::class, 'updatePassword'])->name('my-profile.update-password');

    // USER_ROLE & USER
    Route::resource('user', 'App\Http\Controllers\UserController')->middleware('check.role:admin');
    Route::resource('user_role', 'App\Http\Controllers\UserRoleController')->middleware('check.role:admin');

    // CATEGORY
    Route::resource('category', 'App\Http\Controllers\CategoryController')->middleware('check.role:admin');
    // COMPANY
    Route::resource('company', 'App\Http\Controllers\CompanyController')->middleware('check.role:admin');
    Route::post('/company/store/ajax', [CompanyController::class, 'storeAjax'])->name('company.store.ajax')->middleware('check.role:admin,student');

    // EVALUATION QUESTION
    // EVALUATION QUESTION : ADMIN 
    Route::resource('evaluation_question','App\Http\Controllers\EvaluationQuestionController')->middleware('check.role:admin');

    // </> NOT EFFECTED ROUTE_____________________________

    // <> EFFECTED ROUTE__________________________________

    // ADMIN: Internships: CRUD
    Route::resource('internship', 'App\Http\Controllers\InternshipController')->middleware('check.role:admin,advisor,student');

    // INTERNSHIP PARTICIPANT
    // Route::resource('internship_participant', 'App\Http\Controllers\InternshipParticipantController')->middleware('check.role:admin');
    // SHOW & DELETE
    Route::get('internship/{internship}/manage_participant', [InternshipParticipantController::class, 'index'])->name('internships_participants.index');
    Route::post('internship/{internship}/manage_participant', [InternshipParticipantController::class, 'store'])->name('internships_participants.store');
    Route::delete('internship/{internship}/manage_participant/{user}', [InternshipParticipantController::class, 'destroy'])->name('internships_participants.destroy');

    // STUDENT: AVISOR SELECTION
    Route::get('internship/{internship}/advisor_selection', [AdvisorSelectionController::class, 'index'])->middleware('check.role:student,admin')->name('student_advisor_selection.index');
    Route::post('internship/{internship}/advisor_selection/request', [AdvisorSelectionController::class, 'sendRequest'])->middleware('check.role:student,admin')->name('student_advisor_selection.request');
    // ADVISOR: AVISOR SELECTION
    Route::group(['middleware' => ['check.role:advisor,admin']], function(){
        Route::get('internship/{internship}/advisor_selection/pending', [AdvisorSelectionController::class, 'viewPendingRequests'])->name('advisor_advisor_selection.pending');
        Route::post('internship/{internship}/advisor_selection/respond', [AdvisorSelectionController::class, 'respondToRequest'])->name('advisor_advisor_selection.respond');
    });
    // ADMIN: ADVISOR SELECTION
    Route::group(['prefix' => 'internship/{internship}', 'middleware' => ['check.role:admin']], function(){

        Route::get('/advisor_selection/admin/index', [AdminAdvisorSelectionController::class, 'index'])->name('admin_advisor_selection.index');

        Route::get('/advisor_selection/admin/create', [AdminAdvisorSelectionController::class, 'create'])->name('admin_advisor_selection.create');

        Route::post('/advisor_selection/admin/store', [AdminAdvisorSelectionController::class, 'store'])->name('admin_advisor_selection.store');

        Route::get('/advisor_selection/admin/edit/{id}', [AdminAdvisorSelectionController::class, 'edit'])->name('admin_advisor_selection.edit');

        Route::put('/advisor_selection/admin/update/{id}', [AdminAdvisorSelectionController::class, 'update'])->name('admin_advisor_selection.update');

        Route::delete('advisor_selection/admin/delete/{id}', [AdminAdvisorSelectionController::class, 'destroy'])->name('admin_advisor_selection.destroy');
    });






    
    Route::group(['prefix' => 'internship/{internship}', 'middleware' => ['check.role:admin,student,advisor']], function(){
        // Student : Internship Project
        Route::resource('student_internship_project', StudentInternshipProjectController::class);

        // Admin : Internship Project
        Route::resource('advisor_internship_project', AdvisorInternshipProjectController::class);

        // Admin : Internship Project
        Route::resource('admin_internship_project', InternshipProjectController::class);
    });


    




    
    // ADMIN: Submission_form: CRUD
    Route::resource('submission_form', 'App\Http\Controllers\SubmissionFormController')->middleware('check.role:admin,student');
    // STUDENT: Submission_form
    Route::group(['prefix' => 'student_submission_form', 'middleware' => ['check.role:student,admin']], function () {
        Route::get('/', [StudentSubmissionFormController::class, 'studentIndex'])->name('student_submission_form.index');
        Route::get('/create', [StudentSubmissionFormController::class, 'studentCreate'])->name('student_submission_form.create');
        Route::post('/', [StudentSubmissionFormController::class, 'studentStore'])->name('student_submission_form.store');
        Route::get('/{submissionForm}/edit', [StudentSubmissionFormController::class, 'studentEdit'])->name('student_submission_form.edit');
        Route::put('/{submissionForm}', [StudentSubmissionFormController::class, 'studentUpdate'])->name('student_submission_form.update');
        Route::delete('/{submissionForm}', [StudentSubmissionFormController::class, 'studentDestroy'])->name('student_submission_form.destroy');
    });
    
    // ADMIN: FOLLOW UP: CRUD
    Route::resource('follow_up', 'App\Http\Controllers\FollowUpController')->middleware('check.role:admin');
    // ADVISOR: FOLLOW UP: CRUD
    Route::group(['prefix' => 'advisor_follow_up', 'middleware' => ['check.role:advisor,admin']], function () {
        Route::get('/', [AdvisorFollowUpController::class, 'advisorIndex'])->name('advisor.follow_up.index');
        Route::get('/{StudentRequestID}/student_detail', [AdvisorFollowUpController::class, 'advisorStudentDetail'])->name('advisor.follow_up.student_detail');
        Route::get('/{StudentRequestID}/create', [AdvisorFollowUpController::class, 'advisorStudentDetailCreate'])->name('advisor.follow_up.student_detail.create');
        Route::post('{StudentRequestID}/store', [AdvisorFollowUpController::class, 'advisorStudentDetailStore'])->name('advisor.follow_up.student_detail.store');
        Route::get('/{studentId}/edit', [AdvisorFollowUpController::class, 'advisorStudentDetailEdit'])->name('advisor.follow_up.student_detail.edit');
        Route::put('/{followUp}', [AdvisorFollowUpController::class, 'advisorStudentDetailUpdate'])->name('advisor.follow_up.student_detail.update');
        Route::delete('/{followUp}', [AdvisorFollowUpController::class, 'advisorStudentDetailDestroy'])->name('advisor.follow_up.student_detail.destroy');
    });
    // STUDENT: FOLLOW UP
    Route::get('student/follow_up/student_detail/{studentId}', [AdvisorFollowUpController::class, 'studentIndex'])->middleware('check.role:student,admin')->name('student.follow_up.index');

    // ADMIN: THESIS DOCUMENT
    Route::resource('thesis_document', 'App\Http\Controllers\ThesisDocumentController')->middleware('check.role:admin');
    // ADVISOR: THESIS DOCUMENT
    Route::resource('advisor_thesis_document', 'App\Http\Controllers\AdvisorThesisDocumentController')->middleware('check.role:advisor,admin');
    // STUDENT: THESIS DOCUMENT
    Route::resource('student_thesis_document', 'App\Http\Controllers\StudentThesisDocumentController')->middleware('check.role:student,admin');

    // DEFENSE REUQUEST
    // DEFENSE REQUEST : ADMIN 
    Route::resource('admin_defense_request','App\Http\Controllers\DefenseRequestController')->middleware('check.role:admin');
    // DEFENSE REQUEST : ADVISOR 
    Route::resource('advisor_defense_request','App\Http\Controllers\AdvisorDefenseRequestController')->middleware('check.role:advisor,admin');
    // DEFENSE REQUEST : STUDENT 
    Route::resource('student_defense_request','App\Http\Controllers\StudentDefenseRequestController')->middleware('check.role:student,admin');

    // JURY GROUP
    // JURY GROUP : ADMIN 
    Route::resource('jury_group','App\Http\Controllers\JuryGroupController')->middleware('check.role:admin');

    // DEFENSE_ENROLLMENT
    // DEFENSE_ENROLLMENT : ADMIN 
    Route::resource('defense_enrollment','App\Http\Controllers\DefenseEnrollmentController')->middleware('check.role:admin');
    Route::get('/get-jury-group/{id}', [JuryGroupController::class, 'getJuryGroup'])->middleware('check.role:admin');
    // DEFENSE_ENROLLMENT : JURY 
    Route::resource('jury_defense_enrollment','App\Http\Controllers\JuryDefenseEnrollmentController')->middleware('check.role:jury,admin');
    // DEFENSE_ENROLLMENT : STUDENT 
    Route::resource('student_defense_enrollment','App\Http\Controllers\StudentDefenseEnrollmentController')->middleware('check.role:student,admin');



    // EVALUATION
    // EVALUATION : ADMIN 
    Route::resource('evaluation','App\Http\Controllers\EvaluationController')->middleware('check.role:admin');
    // EVALUATION : JURY 
    Route::resource('jury_evaluation','App\Http\Controllers\JuryEvaluationController')->middleware('check.role:jury,admin');
    // EVALUATION : JURY - Create with Param
    Route::get('jury_evaluation/create/{defenseEnrollment}', [JuryEvaluationController::class, 'create'])->middleware('check.role:jury,admin')->name('jury_evaluation.create_with_param');
    // EVALUATION : JURY - DELTE ALL
    Route::delete('/jury_evaluation/{enrollment_id}/delete_all', [JuryEvaluationController::class, 'deleteAllEvaluations'])
    ->middleware('check.role:jury,admin')->name('jury_evaluation.delete_all');
    // EVALUATION : JURY - Mark as Completed
    Route::put('preference/jury_evaluation/{enrollment_id}/complete', [JuryEvaluationController::class, 'markAsCompleted'])->middleware('check.role:jury,admin')->name('jury_evaluation.complete');

    // EVALUATOIN : ADMIN : GET 2 PARAM 
    Route::get('evaluation/{defense_enrollment_id}/jury/{jury_id}', [EvaluationController::class, 'filterByJury'])
    ->middleware('check.role:admin')->name('evaluation.filter_by_jury');
    // EVALUATION : ADMIN - Create with Param
    Route::get('evaluation/create/{defense_enrollment_id}/jury/{jury_id}', [EvaluationController::class, 'create'])->middleware('check.role:admin')->name('evaluation.create_with_param');
    // EVALUATION : ADMIN - DELETE ALL by enrollment_id and jury_id
    Route::delete('/evaluation/{defense_enrollment_id}/jury/{jury_id}/delete_all', [EvaluationController::class, 'deleteAllEvaluations'])
    ->middleware('check.role:admin')->name('evaluation.delete_all');

    // DEFENSE RESULTS
    // DEFENSE RESULTS : ADMIN
    Route::get('/defense_results', [DefenseResultsController::class, 'index'])->middleware('check.role:admin')->name('defense_results.index');
    // DEFENSE RESULTS : JURY
    Route::get('/defense_results/jury', [DefenseResultsController::class, 'juryResults'])->middleware('check.role:jury,admin')->name('defense_results.jury');
    // DEFENSE RESULTS : STUDENT
    Route::get('/defense_results/student', [DefenseResultsController::class, 'studentResults'])->middleware('check.role:student,admin')->name('defense_results.student');
    // DEFENSE RESULTS : ADVISOR
    Route::get('/defense_results/advisor', [DefenseResultsController::class, 'advisorResults'])->middleware('check.role:advisor,admin')->name('defense_results.advisor');

    // DEFENSE RESULTS : ADMIN : EXPORT
    Route::get('export-defense-results', [DefenseResultsController::class, 'export'])->name('export.defense.results');
    Route::get('export-defense-results', [DefenseResultsController::class, 'export'])->name('export.defense.results');

    // AUTHENTICATION
    Route::get('login', [App\Http\Controllers\LoginController::class, 'index']);
});

// AUTHENTICATION SYSTEM
Route::get('login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
// Route::get('/dashboard', function () { return view('dashboard');})->middleware('auth')->name('dashboard');
Route::get('/dashboard', [InternshipController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::get('/unauthorized', function () {
    return view('errors.unauthorized');
});