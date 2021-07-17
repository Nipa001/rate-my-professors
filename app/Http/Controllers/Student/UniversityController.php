<?php

namespace App\Http\Controllers\Student;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Models\EduTeacher_User;
use App\Models\EduUniversity_User;
use App\Http\Controllers\Controller;
use App\Models\EduTeacherRating_User;
use App\Models\EduTeacherComment_User;
use App\Models\EduTeacherRating_Global;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        $search_text = $request->search_text;
        $data['universities'] = EduUniversity_User::valid()
            ->where("varsity_name", "LIKE", "%{$search_text}%")
            ->orWhere("district", "LIKE", "%{$search_text}%")
            ->latest()->get();
        return view('student.university.varsityList', $data);
    }
    public function varsityProfessorList(Request $request, $varsity_id)
    {
        $data['university_info'] = EduUniversity_User::valid()->find($varsity_id);
        $data['varsities_professors'] = $varsities_professors = EduTeacher_User::valid()
            ->where("varsity_id", $varsity_id)
            ->latest()->get();
        foreach ($varsities_professors as $key => $professor) {
            $rating = EduTeacherRating_Global::where('teacher_id', $professor->id)->avg('rating');
            $professor->rating = round($rating, 1);
        }
        return view('student.university.professorList', $data);
    }
    public function rateTeacher(Request $request)
    {
        $authId = Auth::id();
        $data['teacher_id'] = $teacher_id = $request->teacher_id;
        $data['teacher_info'] = EduTeacher_User::valid()->find($teacher_id);
        $data['teacherComments'] = EduTeacherComment_User::join('users', 'users.id', '=', 'edu_teacher_comments.created_by')
            ->select('edu_teacher_comments.*', 'users.name')
            ->where('edu_teacher_comments.teacher_id', $teacher_id)
            ->where('edu_teacher_comments.valid', 1)
            ->latest()->get();
        $data['professorRating'] = EduTeacherRating_Global::where('teacher_id', $teacher_id)->where('created_by', $authId)->first();
        return view('student.rateTeacher.teacherDetails', $data);
    }

    public function teacherCommentAction(Request $request)
    {
        $teacher_id = $request->teacher_id;
        $output = array();
        $validator = Validator::make($request->all(), [
            'comment' => 'required'
        ]);
        if ($validator->passes()) {
            EduTeacherComment_User::create([
                'teacher_id' => $request->teacher_id,
                'comment'    => $request->comment,
            ]);
            $output['messege'] = 'Comment has been Added';
            $output['msgType'] = 'success';
            $output['status'] = 1;
        } else {
            $output['messege'] = 'Failed! Comment Fields are Required';
            $output['msgType'] = 'danger';
            $output['status'] = 0;
        }
        return response($output);
    }
    public function teacherComments(Request $request)
    {
        $data['teacher_id'] = $teacher_id = $request->teacher_id;
        $data['teacherComments'] = EduTeacherComment_User::join('users', 'users.id', '=', 'edu_teacher_comments.created_by')
            ->select('edu_teacher_comments.*', 'users.name')
            ->where('edu_teacher_comments.teacher_id', $teacher_id)
            ->where('edu_teacher_comments.valid', 1)
            ->latest()->get();
        return view('student.rateTeacher.teacherComments', $data);
    }
    public function teacherRatingAction(Request $request)
    {
        $teacher_id = $request->teacher_id;
        $authId = Auth::id();
        $output = array();
        $validator = Validator::make($request->all(), [
            'rating' => 'required'
        ]);
        if ($validator->passes()) {
            $isRateExist = EduTeacherRating_User::where('teacher_id', $teacher_id)->where('created_by', $authId)->first();
            if ($isRateExist) {
                $isRateExist->update([
                    'teacher_id' => $request->teacher_id,
                    'rating'     => $request->rating
                ]);
            } else {
                EduTeacherRating_User::create([
                    'teacher_id' => $request->teacher_id,
                    'rating'     => $request->rating
                ]);
            }

            $output['messege'] = 'Rating has been Added';
            $output['msgType'] = 'success';
            $output['status'] = 1;
        } else {
            $output['messege'] = 'Failed! Rating Fields are Required';
            $output['msgType'] = 'danger';
            $output['status'] = 0;
        }
        return response($output);
    }

    public function removeComment(Request $request)
    {
        $id = $request->id;
        EduTeacherComment_User::valid()->find($id)->delete();
    }
}
