<?php

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

