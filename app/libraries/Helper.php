<?php

use App\Model\EduStudent_Teacher;
use App\Model\EduCourseAssignClass_Provider;
use Carbon\Carbon;

class Helper {

	static $googleKey = 'AIzaSyC2Um1RKYtS32dKJn00CmmmhWQPfW6nAGU';

    public static function getYoutubeVideoTitle($video_id)
    {
        $json = self::file_get_content_curl('https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key=AIzaSyC2Um1RKYtS32dKJn00CmmmhWQPfW6nAGU&part=snippet');
        $ytdata = json_decode($json);
        if(!empty($ytdata->items)) {
            return $ytdata->items[0]->snippet->title;
        } else {
            return "";
        }
    }
    public static function getYoutubeVideoDuration($video_id) {
        $json = self::file_get_content_curl('https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key=AIzaSyC2Um1RKYtS32dKJn00CmmmhWQPfW6nAGU&part=contentDetails');
        $ytdata = json_decode($json);
        if(empty($ytdata->items)) {
            return 0;
        } else {
            $duration = $ytdata->items[0]->contentDetails->duration;
            $duration = new DateInterval($duration);
            $duration = ($duration->h*3600+$duration->i*60+$duration->s);
            return $duration;
        }
    }
    public static function file_get_content_curl ($url) 
    {
        // Throw Error if the curl function does'nt exist.
        if (!function_exists('curl_init')){ 
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public static function getUploadedFileName($mainFile, $imgPath, $reqWidth=0, $reqHeight=0)
    {
        $fileExtention = $mainFile->extension();
        $fileOriginalName = $mainFile->getClientOriginalName();

        $validExtentions = array('jpeg', 'jpg', 'png', 'gif');
        $path = public_path($imgPath);
        $currentTime = time();
        $fileName = $currentTime.'.'.$fileExtention;
        
        if (in_array($fileExtention, $validExtentions)) {
            $imgDimention = true; 
            if ($reqWidth > 0 || $reqHeight > 0) {
                $imgSizeArr = getimagesize($mainFile);
                $imgWidth = $imgSizeArr[0];
                $imgHeight = $imgSizeArr[1];
                if ($reqWidth > 0 && $reqHeight > 0 && ($imgWidth != $reqWidth || $imgHeight != $reqHeight)) {
                    $imgDimention = false;
                    $dimentionErrMsg = "Image size must be ".$reqWidth."px * ".$reqHeight."px";
                } elseif ($reqWidth > 0 && $imgWidth != $reqWidth) {
                    $imgDimention = false;
                    $dimentionErrMsg = "Image width must be ".$reqWidth."px";
                } elseif ($reqHeight > 0 && $imgHeight != $reqHeight) {
                    $imgDimention = false;
                    $dimentionErrMsg = "Image height must be ".$reqHeight."px";
                }
            } 

            if ($imgDimention) {
                $mainFile->move($path, $fileName);
                //create instance
                $img = Image::make($path.'/'.$fileName);
                //resize image
                $img->resize(80, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($path.'/thumb/'.$fileName);
                
                $output['status'] = 1;
                $output['file_name'] = $fileName;
            } else {
                $output['errors'] = $dimentionErrMsg;
                $output['status'] = 0;
            }

        } else {
            $output['errors'] = $fileExtention.' File is not support';
            $output['status'] = 0;
        }
        return $output;

    }

    public static function getUploadedAttachmentName($mainFile, $validPath)
    {
        $fileExtention = $mainFile->extension();
        $fileOriginalName = $mainFile->getClientOriginalName();
        $file_size 	= $mainFile->getSize();
        $validExtentions = array('zip','pdf', 'doc', 'docx', 'jpeg', 'jpg', 'png');
        $path = public_path($validPath);
        $currentTime = time();
        $fileName = $currentTime.'.'.$fileExtention;

        if($file_size<=5242880) {
            if (in_array($fileExtention, $validExtentions)) {
                $mainFile->move($path, $fileName);
        
                $output['status']             = 1;
                $output['file_name']          = $fileName;
                $output['file_original_name'] = $fileOriginalName;
                $output['file_extention']     = $fileExtention;
                $output['file_size']          =  $file_size;
    
            } else {
                $output['errors'] = $fileExtention.' File is not support';
                $output['status'] = 0;
            }
        } else {
            $output['errors'] = $file_size.'size is too large !!!';
            $output['status'] = 0;
        }
        
        return $output;

    }

    public static function dateYMD($date){
        $date = date_create($date);
        return $date = date_format($date,"Y-m-d");
    }

    public static function timeHi24($time){    
        $time = date("H:i", strtotime($time));
        return $time;
    }
    public static function timeHis($time){    
        $time = DateTime::createFromFormat('g:i A', $time);
        $time = $time->format('H:i:s');
    }

    public static function timeGia($time){  // calculate am,pm  
        $time = DateTime::createFromFormat('H:i:s', $time);
        return $time = $time->format('g:i A');
    }

    public static function secondsToTime($seconds) {
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);

        return $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
    }
    public static function timeToSecond($time) {
        $full_array = explode(":", $time);
        $counter =  count($full_array);
        if($counter == 2){
            $seconds = $full_array[0]*60 + $full_array[1];
            return $seconds;
        }else if($counter == 3){
            $seconds = $full_array[0]*3600 + $full_array[1]*60 + $full_array[2];
            return $seconds;
        }else{
            return $time;
        }
        // $diff = $diff[0]*3600 + $diff[1]*60 + $diff[0];
    }

    public static function generateAutoID($table_name,$generate_field){
        $check = DB::table($table_name)->get();
        if(count($check) > 0){
            $sl_no = DB::table($table_name)->where('valid', 1)->max($generate_field)+1;
        }else{
            $sl_no = 1;
        }
        return $sl_no;
    }

    public static function dayName($day_dt){
        switch ($day_dt) {
            case "0":
                return "Sunday";
                break;
            case "1":
                return "Monday";
                break;
            case "2":
                return "Tuesday";
                break;            
            case "3":
                return "Wednesday";
                break;            
            case "4":
                return "Thursday";
                break;            
            case "5":
                return "Friday";
                break;
            case "6":
                return "Saturday";
                break;

            default:
                return "";
        }
    }

    //For showing file size
	public static function fileSizeConvert($bytes) {
		$bytes = floatval($bytes);
		$arBytes = array(
			0 => array(
				"UNIT" => "TB",
				"VALUE" => pow(1024, 4)
			),
			1 => array(
				"UNIT" => "GB",
				"VALUE" => pow(1024, 3)
			),
			2 => array(
				"UNIT" => "MB",
				"VALUE" => pow(1024, 2)
			),
			3 => array(
				"UNIT" => "KB",
				"VALUE" => 1024
			),
			4 => array(
				"UNIT" => "B",
				"VALUE" => 1
			),
		);
		if($bytes > 0) {
			foreach($arBytes as $arItem) {
				if($bytes >= $arItem["VALUE"]) {
					$result = $bytes / $arItem["VALUE"];
					$result = strval(round($result, 2))." ".$arItem["UNIT"];
					break;
				}
			}
			return $result;
		} else {
			return 0;
		}

    }
    
    //For showing file Thumb
	public static function getFileThumb($file_ext) {

            // if($file_ext=='jpg' || $file_ext=='jpeg' || $file_ext=='png' || $file_ext=='gif' || $file_ext=='mp4' || $file_ext=='mp3') {
            if($file_ext=='doc' || $file_ext=='docx') {
                $thumb ='file_icon/doc.png';
            } else if($file_ext=='ppt' || $file_ext=='pptx') {
                $thumb ='file_icon/ppt.png';
            } else if($file_ext=='xls' || $file_ext=='xlsx') {
                $thumb ='file_icon/xls.png';
            } else if($file_ext=='zip' || $file_ext=='rar' || $file_ext=='tar') {
                $thumb ='file_icon/zip.png';
            } else if($file_ext=='pdf') {
                $thumb ='file_icon/pdf.png';
            } else if($file_ext=='csv') {
                $thumb ='file_icon/csv.png';
            } else if($file_ext=='txt') {
                $thumb ='file_icon/txt.png';
            } else if($file_ext=='mp4') {
                $thumb ='file_icon/mp4.jpg';
            } else if($file_ext=='mp3') {
                $thumb ='file_icon/mp3.jpg';
            } else {
                $thumb = 'file_icon/zip.png'; //default
            }
            return $thumb;
    }
    
    public static function studentInfo($id){
        $student_info = DB::table('users')->where('id',$id)->where('valid',1)->first();
        return $student_info;
    }

    public static function getRemainingHours($created_at)
    {
        // if (isset($created_at)) {
        //     $remaining_hours = Carbon::now()->diffInHours(Carbon::parse($created_at));
        // } else {
        //     $remaining_hours = 0;
        // }
        // return $remaining_hours;
        if (isset($created_at)) {
            $today = date('Y-m-d H:i:s');
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $today);

            $days = $startDate->diffInDays($endDate);
            $hours = $startDate->copy()->addDays($days)->diffInHours($endDate);
            $minutes = $startDate->copy()->addDays($days)->addHours($hours)->diffInMinutes($endDate);
            $remaining_hours = $days.' Days '.$hours.' Hours '.$minutes.' Minutes'; 
        } else {
            $remaining_hours = '0 Days 0 Hours 0 Minutes';
        }
        return $remaining_hours;
    }
    
}