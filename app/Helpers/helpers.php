<?php

use Illuminate\Support\Facades\Validator;

/**
 * 語系列表
 */
if (!function_exists('getLanguageList')) {
    function getLanguageList() 
    {
        return [
            'tw' => '繁体中文',
            'cn' => '简体中文',
            'en' => '英文',
        ];
    }
}

/**
 * 轉換文章內容的圖片連結
 */
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

/**
 * 處理 html 的圖片內容
 */
if (!function_exists('processContent')) {
    function processContent($content)
    {
        //  取得 body 標籤內的內容
        if(preg_match("/^<!DOCTYPE/", $content)) {
            preg_match("/<body[^>]*>(.*?)<\/body>/is", $content, $matches);
            $content = $matches[1];
        }
        // 檢查內容是否有 div 標籤
        $content = preg_match("/^<div>.*<\/div>$/is", $content)? $content : "<div>{$content}</div>";
        // 用 php-dom 加載 html 
        $dom = new \DomDocument();
        $dom->loadHtml(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));    
        // 取得 img 標籤的圖片內容，進行 base64 解碼後，將圖片內容儲存回 html 標籤內
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

/**
 * 檢查資料夾是否存在
 */
if (!function_exists('checkDirectoryExists')) {
    function checkDirectoryExists($path)
    {
        if(!is_dir($path)) {
            mkdir($path, 0775, true);
        }
        return $path;
    }
}

/**
 * 將圖片用 base64 解構
 */
if (!function_exists('processImage')) {
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

/**
 * 取得上傳圖片的資訊
 */
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

/**
 * 換算圖片大小的單位
 */
if (!function_exists('formatSizeUnits')) {
    function formatSizeUnits($size)
    {	
        // 1024的次方
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;	
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}

/**
 * 檢查日期格式
 */
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

/**
 * 成功回應
 */
if (!function_exists('successOutput')) {
    function successOutput($data)
    {
        return ['RetCode' => 1, 'RetVal' => $data];
    }
}

/**
 * 錯誤回應
 */
if (!function_exists('errorOutput')) {
    function errorOutput($message)
    {
        return ['RetCode' => 0, 'RetMsg' => $message];
    }
}

/**
 * 替換時間的分號或將時間長度補足為四碼
 */
if (!function_exists('replaceTimeColon')) {
    function replaceTimeColon($time, $replace = false)
    {
        $time = str_pad($time, 5, "0", STR_PAD_LEFT);
        if($replace) {
            $time = str_replace(':', '', $time);
        }
        return $time;
    }
}

/**
 * 亂數產生器
 */
if (!function_exists('UniqueRandomNumbersWithinRange')) {
    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}

/**
 * 取出日期範圍的開始與結束的日期 
 */
if (!function_exists('breakupDateRange')) {
    function breakupDateRange($time) {
        list($start, $end) = explode('-', $time);
        return [
            trim($start), trim($end)
        ];
    }
}

