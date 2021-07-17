<?php

namespace App\Http\Controllers\Teacher;

use Auth;
use Validator;

use App\Models\EduTeachers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EduTeacherRating_Global;

class MasterController extends Controller
{
    public function getLogin()
    {
        return view('teacher.login');
    }
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:8'
        ]);
        $data = array(
            'email'          => $request->email,
            'password'       => $request->password,
            'email_verified' => 1,
            'status'         => 'Active',
            'valid'          => 1
        );
        if (Auth::guard('teacher')->attempt($data)) {
            return redirect()->route('teacher.home');
        } else {
            return redirect()->route('teacher.login')->with('error', 'Email or password is not correct.');
        }
    }
    public function logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher.login');

    }
    public function home(){
        $authId = Auth::guard('teacher')->id();
        $data['userInfo'] = EduTeachers::where('valid', 1)->find($authId);
        $data['myTotalRating'] = EduTeacherRating_Global::valid()->where('teacher_id', $authId)->count();
        return view('teacher.home', $data);

    }

}
