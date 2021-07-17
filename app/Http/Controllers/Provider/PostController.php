<?php

namespace App\Http\Controllers\Provider;

use DB;
use File;
use Helper;
use Validator;
use Illuminate\Http\Request;
use App\Models\EduPosts_Provider;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['all_posts'] = EduPosts_Provider::valid()->latest()->get();
        return view('provider.post.listData', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('provider.post.create');
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
            'title'   => 'required',
            'details' => 'required',
            'image'   => 'required'
        ]);

        if ($validator->passes()) {
            $mainFile = $request->image;
            $imgPath = 'uploads/post';
            $uploadResponse = Helper::getUploadedFileName($mainFile, $imgPath, 640, 426);
            if ($uploadResponse['status'] == 1) {
                EduPosts_Provider::create([
                    'title'   => $request->title,
                    'details' => $request->details,
                    'image'   => $uploadResponse['file_name'],
                ]);
                $output['messege'] = 'Post has been Created';
                $output['msgType'] = 'success';
            } else {
                $output['messege'] = $uploadResponse['errors'];
                $output['msgType'] = 'danger';
            }
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
        $data['post_info'] = EduPosts_Provider::valid()->find($id);
        return view('provider.post.update', $data);
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
            'title'   => 'required',
            'details' => 'required',
            'image'   => 'required'
        ]);

        if ($validator->passes()) {
            $post_info = EduPosts_Provider::find($id);
            if (isset($request->image)) {
                if ($request->image != $post_info->image) {
                    $mainFile = $request->image;
                    $imgPath = 'uploads/post';
                    $uploadResponse = Helper::getUploadedFileName($mainFile, $imgPath, 640, 426);
                    
                    if ($uploadResponse['status'] == 1) {
                        File::delete(public_path($imgPath.'/').$post_info->image);
                        File::delete(public_path($imgPath.'/thumb/').$post_info->image);
                        
                        $post_info->update([
                            'title'   => $request->title,
                            'details' => $request->details,
                            'image'   => $uploadResponse['file_name']
                        ]);
                        $output['messege'] = 'Course has been updated';
                        $output['msgType'] = 'success';
                    } else {
                        $output['messege'] = $uploadResponse['errors'];
                        $output['msgType'] = 'danger';
                    }
                } else {
                    $post_info->update([
                        'title'   => $request->title,
                        'details' => $request->details
                    ]);
                    $output['messege'] = 'Course has been updated';
                    $output['msgType'] = 'success';
                }
            } else {
                $post_info->update([
                    'title'   => $request->title,
                    'details' => $request->details
                ]);
                $output['messege'] = 'Course has been updated';
                $output['msgType'] = 'success';
            }
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
        $post = EduPosts_Provider::valid()->find($id);
        File::delete(public_path('uploads/post/').$post->image);
        File::delete(public_path('uploads/post/thumb/').$post->image);
        EduPosts_Provider::valid()->find($id)->delete();
    }
}
