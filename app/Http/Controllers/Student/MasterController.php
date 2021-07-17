<?php

namespace App\Http\Controllers\Student;

use Auth;
use Helper;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EduPosts_User;
use App\Http\Controllers\Controller;

class MasterController extends Controller
{
    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('student.login');
    }
    public function loginStep()
    {
        return view('student.loginStep');
    }
    public function home(){
        $authId = Auth::id();
        $current_date = date('Y-m-d');
        $data['userInfo'] = User::where('valid', 1)->find($authId);

        $data['all_posts'] = EduPosts_User::valid()->latest()->get();
        return view('student.home', $data);

    }

}
