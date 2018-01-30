<?php

use Illuminate\Support\Facades\Validator;

if (!function_exists('getLanguageList')) {
    function getLanguageList() 
    {
        return [
            'zh-TW' => '繁体中文',
            'zh-CN' => '简体中文',
            'en'    => '英文',
        ];
    }
}

if (!function_exists('transformContentImageSrc')) {
    function transformContentImageSrc($content)
    {
        $dom = new \DomDocument();
        $dom->loadHtml(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));    
        $images = $dom->getElementsByTagName('img');
        if($images->length > 0) {
            foreach ($images as $key => $image) {
                $path = asset($image->getAttribute('src'));
                $image->removeAttribute('src');
                $image->setAttribute('src', $path);
            }
        }
        return $dom->saveHTML();
    }
}

if (!function_exists('processContent')) {
    function processContent($content)
    {
        if(preg_match("/^<!DOCTYPE/", $content)) {
            preg_match("/<body[^>]*>(.*?)<\/body>/is", $content, $matches);
            $content = $matches[1];
        }
        $content = preg_match("/^<div>.*<\/div>$/is", $content)? $content : "<div>{$content}</div>";
        $dom = new \DomDocument();
        $dom->loadHtml(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));    
        $images = $dom->getElementsByTagName('img');
        if ($images->length > 0) {
            foreach($images as $key => $image) {
                if(! preg_match("/^data:image\/.+;base64/", $image->getAttribute('src'))) {
                    continue;
                }
                list($file_extension, $file) = processImage($image->getAttribute('src'));
                $image_name = "/uploads/article/".time()."{$key}.{$file_extension}";
                checkDirectoryExists(public_path()."/uploads/article/");   
                file_put_contents(public_path()."{$image_name}", $file);
                $image->removeAttribute('src');
                $image->setAttribute('src', $image_name);
            }
            // 只存div標籤內容
            $content = $dom->saveHTML($dom->getElementsByTagName('div')->item(0));
        }
        return $content;
    }
}

if (!function_exists('checkDirectoryExists')) {
    function checkDirectoryExists($path)
    {
        if(!is_dir($path)) {
            mkdir($path, 0775, true);
        }
        return $path;
    }
}

if (!function_exists('getImageName')) {
    function processImage($image)
    {
        list($type, $data) = explode(';', $image);
        $file_extension = explode('/', $type)[1];
        $file = base64_decode(explode(',', $data)[1]);
        return [
            $file_extension, $file
        ];
    }
}

if (!function_exists('getFileInfo')) {
    function getFileInfo($file) 
    {
        if($file instanceOf \Illuminate\Http\UploadedFile) {
            list($width, $height) = getimagesize($file);
            return [
                'extension' => $file->getClientOriginalExtension(),
                'mime_type' => $file->getClientMimeType(),
                'size'      => formatSizeUnits($file->getClientSize()),
                'width'     => "{$width} px",
                'height'    => "{$height} px",
            ];
        }
        return [];
    }
}

if (!function_exists('formatSizeUnits')) {
    function formatSizeUnits($size)
    {	
        // 1024的次方
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;	
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}

if (!function_exists('checkDateFormat')) {
    function checkDateFormat($date)
    {
        $rules = ['date' => 'date_format: "Y-m-d"'];
        $messages = ['date.date_format' => '日期格式错误，范例：Y-M-D'];
        $validator = Validator::make(['date' => $date], $rules, $messages);
        if($validator->fails()) {
            return ['result' => false, 'error' => $validator->errors()->first('date')];
        }
        return ['result' => true];
    }
}

if (!function_exists('successOutput')) {
    function successOutput($data)
    {
        return ['RetCode' => 1, 'RetVal' => $data];
    }
}

if (!function_exists('errorOutput')) {
    function errorOutput($message)
    {
        return ['RetCode' => 0, 'RetMsg' => $message];
    }
}

if (!function_exists('replaceTimeColon')) {
    function replaceTimeColon($time)
    {
        $time = str_replace(':','',$time);
        if(strLen($time) < 4) {
            $time = str_pad($time,4,"0",STR_PAD_LEFT);
        }
        return $time;
    }
}

if (!function_exists('UniqueRandomNumbersWithinRange')) {
    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}

