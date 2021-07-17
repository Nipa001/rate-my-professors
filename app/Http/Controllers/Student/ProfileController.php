<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\EduStudent_User;
use App\Models\EduStudentPracticeTime_User;
use App\Models\EduAssignBatchStudent_User;
use Illuminate\Support\Facades\Hash;

use Auth;
use Validator;
use Helper;
use File;

class ProfileController extends Controller
{
    public function index()
    {
    	$authId = Auth::id();
    	$data['student_info'] = EduStudent_User::valid()->find($authId);
        return view('student.profile')->with($data);
    }

    public function updateProfile(Request $request,$id){

    	$validator = Validator::make($request->all(), [
            'name'     => 'required',
            'sur_name' => 'required',
            'phone'    => 'required',
        ]);
        if ($validator->passes()) {
            $student_user = EduStudent_User::valid()->find($id);

            if (isset($request->student_image)) {

                if ($request->student_image != $student_user->image) {
                    $mainFile = $request->student_image;
                    $imgPath = 'uploads/studentProfile';
                    $uploadResponse = Helper::getUploadedFileName($mainFile, $imgPath, 640, 426);
                    
                    if ($uploadResponse['status'] == 1) {
                        File::delete(public_path($imgPath.'/').$student_user->image);
                        File::delete(public_path($imgPath.'/thumb/').$student_user->image);
                        
                        EduStudent_User::find($id)->update([
                            'image'    => $uploadResponse['file_name'],
                            'name'     => $request->name,
                            'sur_name' => $request->sur_name,
	                        'address'  => $request->address,
	                        'phone'    => $request->phone
                        ]);


                        $output['messege'] = 'Your Profile has been updated';
                        $output['msgType'] = 'success';
                    } else {
                        $output['messege'] = $uploadResponse['errors'];
                        $output['msgType'] = 'danger';
                    }
                } else {
                    EduStudent_User::find($id)->update([
                        'name'     => $request->name,
                        'sur_name' => $request->sur_name,
                        'address'  => $request->address,
                        'phone'    => $request->phone
                    ]);
                    $output['messege'] = 'Your Profile has been updated';
                    $output['msgType'] = 'success';
                }
            } else {
                    EduStudent_User::find($id)->update([
                        'name'     => $request->name,
                        'sur_name' => $request->sur_name,
                        'address'  => $request->address,
                        'phone'    => $request->phone
                    ]);
                $output['messege'] = 'Your Profile has been updated';
                $output['msgType'] = 'success';
            }
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    public function updatePassword(Request $request,$id){

    	$validator = Validator::make($request->all(), [
            'password'   => 'required',
        ]);

        if ($validator->passes()) {

            if(!empty($request->password)){

                EduStudent_User::find($id)->update([
                    'password'    => Hash::make($request->password),
               ]);

            }
            
            $output['messege'] = 'Your password has been updated';
            $output['msgType'] = 'success';

            return redirect()->back()->with($output);

        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    public function updatePracticeTime(Request $request){

        $type = $request->type; // 1 = stop , 2 = resume
        $hours = $request->hours;
        $minutes = $request->minutes;
        $seconds = $request->seconds;
        $current_date = date('Y-m-d');
        $authId = Auth::id();

        $student_info = EduAssignBatchStudent_User::valid()->where('is_running', 1)->where('active_status', 1)->first();

        $duration_of_sec = (int)$hours*60*60+(int)$minutes*60+$seconds; 

        $practice_info = EduStudentPracticeTime_User::where('student_id',$authId)
            ->where('course_id',$student_info->course_id)
            ->where('batch_id',$student_info->batch_id)
            ->whereDate('date', '=', $current_date)
            ->first();

        $output = [];

        if(!empty($practice_info))
        {

            EduStudentPracticeTime_User::find($practice_info->id)->update([
                'total_time' => $duration_of_sec,
                'resume_time'=> 0
            ]);

            $output['msg'] = 'total time update';
        }
        else
        {
            EduStudentPracticeTime_User::create([
                'student_id' => $authId,
                'course_id'  => $student_info->course_id,
                'batch_id'   => $student_info->batch_id,
                'date'       => $current_date,
                'total_time' => $duration_of_sec,
                'resume_time'=> 0
            ]);

            $output['msgType'] = 'total time create';
        }

        // if($type == 1) // 1 = stop 
        // {
        //     if(!empty($practice_info))
        //     {
        //         $resume_value = $duration_of_sec - $practice_info->resume_time;

        //         EduStudentPracticeTime_User::find($practice_info->id)->update([
        //             'total_time' => $practice_info->total_time + $resume_value,
        //             'resume_time'=> 0
        //         ]);

        //         $output['msg'] = 'total time update';
        //     }
        //     else
        //     {
        //         EduStudentPracticeTime_User::create([
        //             'student_id' => $authId,
        //             'course_id'  => $student_info->course_id,
        //             'batch_id'   => $student_info->batch_id,
        //             'date'       => $current_date,
        //             'total_time' => $duration_of_sec,
        //             'resume_time'=> 0
        //         ]);

        //         $output['msgType'] = 'total time create';
        //     }
        // }
        // if($type == 2)
        // {
        //     if(!empty($practice_info))
        //     {
        //         EduStudentPracticeTime_User::find($practice_info->id)->update([
        //             'resume_time'=> $duration_of_sec,
        //         ]);
        //         $output['msgType'] = 'resume time update';
        //     }

        // }
        // if($type == 3){
        //     if(!empty($practice_info))
        //     {
        //         EduStudentPracticeTime_User::find($practice_info->id)->update([
        //             'total_time' => $duration_of_sec,
        //             'resume_time'=> $duration_of_sec
        //         ]);
                
        //     }else {
        //         EduStudentPracticeTime_User::create([
        //             'student_id' => $authId,
        //             'course_id'  => $student_info->course_id,
        //             'batch_id'   => $student_info->batch_id,
        //             'date'       => $current_date,
        //             'total_time' => $duration_of_sec,
        //             'resume_time'=> $duration_of_sec
        //         ]);
        //     }
        //     $output['msg'] = 'total time update';
        // }
        return response($output);

    }
}
