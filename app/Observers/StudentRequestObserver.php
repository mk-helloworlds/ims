<?php

namespace App\Observers;

use App\Models\StudentRequest;
use App\Models\InternshipAdvisorStudent;

class StudentRequestObserver
{
    /**
     * Handle the StudentRequest "created" event.
     *
     * @param  \App\Models\StudentRequest  $studentRequest
     * @return void
     */

    public function created(StudentRequest $studentRequest): void
    {
        // if ($studentRequest->status === 'Accepted') {
        //     InternshipAdvisorStudent::create([
        //         'internship_id' => $studentRequest->internship_id,
        //         'user_student_id' => $studentRequest->student_id,
        //         'user_advisor_id' => $studentRequest->advisor_id,
        //     ]);
        // }
    }

     /**
     * Handle the StudentRequest "updated" event.
     *
     * @param  \App\Models\StudentRequest  $studentRequest
     * @return void
     */

    public function updated(StudentRequest $studentRequest): void
    {
        // if ($studentRequest->status === 'Accepted') {
        //     InternshipAdvisorStudent::updateOrCreate(
        //         [
        //             'internship_id' => $studentRequest->internship_id,
        //             'user_student_id' => $studentRequest->student_id,
        //         ],
        //         [
        //             'user_advisor_id' => $studentRequest->advisor_id,
        //         ]
        //     );
        // } else {
        //     // If status is changed to not accepted, remove the entry from InternshipAdvisorStudent
        //     InternshipAdvisorStudent::where([
        //         'internship_id' => $studentRequest->internship_id,
        //         'user_student_id' => $studentRequest->student_id,
        //     ])->delete();
        // }
    }

    /**
     * Handle the StudentRequest "deleted" event.
     *
     * @param  \App\Models\StudentRequest  $studentRequest
     * @return void
     */
    
    public function deleted(StudentRequest $studentRequest): void
    {
        // InternshipAdvisorStudent::where([
        //     'internship_id' => $studentRequest->internship_id,
        //     'user_student_id' => $studentRequest->student_id,
        // ])->delete();
    }

    /**
     * Handle the StudentRequest "restored" event.
     */
    public function restored(StudentRequest $studentRequest): void
    {
        //
    }

    /**
     * Handle the StudentRequest "force deleted" event.
     */
    public function forceDeleted(StudentRequest $studentRequest): void
    {
        //
    }
}
