<?php

namespace App\Http\Controllers\Provider;

use DB;
use Helper;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EduUniversity_Provider;
use App\Models\EduTeacherRating_Global;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['universities'] = EduUniversity_Provider::valid()->latest()->get();
        return view('provider.university.listData', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('provider.university.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'varsity_name' => 'required',
            'district'     => 'required',
            'country'      => 'required'
        ]);

        if ($validator->passes()) {
            EduUniversity_Provider::create([
                'varsity_name' => $request->varsity_name,
                'district'     => $request->district,
                'country'      => $request->country,
                'address'      => $request->address
            ]);
            $output['messege'] = 'University has been Added';
            $output['msgType'] = 'success';
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['universityInfo'] = EduUniversity_Provider::valid()->find($id);
        return view('provider.university.update', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'varsity_name' => 'required',
            'district'     => 'required',
            'country'      => 'required'
        ]);

        if ($validator->passes()) {
            EduUniversity_Provider::find($id)->update([
                'varsity_name' => $request->varsity_name,
                'district'     => $request->district,
                'country'      => $request->country,
                'address'      => $request->address
            ]);
            $output['messege'] = 'University has been updated';
            $output['msgType'] = 'success';
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EduUniversity_Provider::valid()->find($id)->delete();
    }

    public function teacherRatingList()
    {
        $data['all_ratings'] = EduTeacherRating_Global::join('edu_teachers', 'edu_teachers.id', '=', 'edu_teacher_ratings.teacher_id')
            ->join('users', 'users.id', '=', 'edu_teacher_ratings.created_by')
            ->select('edu_teacher_ratings.*', 'edu_teachers.name as teacher_name', 'users.name as student_name')
            ->where('edu_teacher_ratings.valid', 1)
            ->get();
        return view('provider.university.ratingListData', $data);
    }
}
