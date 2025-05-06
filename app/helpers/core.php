<?php

if ( ! function_exists('asset'))
{
    function asset($file)
    {
        return url('assets/'.$file);
    }
}

if ( ! function_exists('checkAge'))
{
    function checkAge($date)
    {
        $old = new DateTime($date);
        $today = new DateTime('today');

        return $today->diff($old)->y;
    }
}

if ( ! function_exists('css'))
{
    function css($file)
    {
        return asset('css/'.$file.'.css');
    }
}

if ( ! function_exists('dateToSql'))
{
    function dateToSql($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}

if ( ! function_exists('friendlyUrl'))
{
    function friendlyUrl($string = '')
    {
        $lower = strtolower($string);
        $replace = preg_replace('#[^0-9a-z]+#i', '-', $lower);

        return trim($replace, '-');
    }
}

if ( ! function_exists('get'))
{
    function get($name)
    {
        return isset($_GET[$name]) ? $_GET[$name] : '';
    }
}

if ( ! function_exists('image'))
{
    /**
     * Cari file gambar di beberapa prefix (03_,04_,05_) atau langsung nama file.
     * Kalau tidak ada satupun, pakai no-image.jpg.
     */
    function image(string $file): string
    {
        // // sesuaikan folder image produk-mu
        // $baseUrl = url('images/');            
        // $basePath = $_SERVER['DOCUMENT_ROOT'] . '/images/'; 

        // // urutan coba: file apa adanya, 03_, 04_, 05_
        // $candidates = [
        //     $file,
        //     '03_'.$file,
        //     '04_'.$file,
        //     '05_'.$file,
        // ];

        // foreach ($candidates as $f) {
        //     if (is_file($basePath . $f)) {
        //         return $baseUrl . $f;
        //     }
        // }
        // // fallback
        // return $baseUrl . 'no-image.jpg';
        return url('images/'.$file);
    }
}

if( ! function_exists('imageResize'))
{
    function imageResize($original_image, $dest_image, $dest_width, $dest_height, $forceSize = false)
    {
        $img_type = '';

        switch (strtolower(substr(basename($original_image), (strrpos(basename($original_image), '.')+1))))
        {
            case 'jpg':
            case 'jpeg':
                if (imagetypes() & IMG_JPG) {
                    $img_type = 'jpg';
                }
                break;
            case 'gif':
                if (imagetypes() & IMG_GIF) {
                    $img_type = 'gif';
                }
                break;
            case 'png':
                if (imagetypes() & IMG_PNG) {
                    $img_type = 'png';
                }
                break;
        }

        if ( ! empty($img_type))
        {
            list($orig_width, $orig_height) = getimagesize($original_image);

            $width  = $dest_width;
            $height = $dest_height;
            $factor = max(($orig_width / $width), ($orig_height / $height));

            if ($forceSize)
            {
                $width = $dest_width;
            }
            else
            {
                $width  = round($orig_width / $factor);
                $height = round($orig_height / $factor);
            }

            $x = 0;
            $y = 0;
            $im_p = @imagecreatetruecolor($dest_width, $dest_height);
            @imagealphablending($im_p, true);
            $color = @imagecolortransparent($im_p, imagecolorallocatealpha($im_p, 255, 255, 255, 127));
            @imagefill($im_p, 0, 0, $color);
            @imagesavealpha($im_p, true);

            if ($forceSize)
            {
                $width = round($orig_width * $dest_height / $orig_height);
                if ($width < $dest_width)
                {
                    $x = floor(($dest_width - $width) / 2);
                }
            }
            else
            {
                $x = floor(($dest_width - $width) / 2);
                $y = floor(($dest_height - $height) / 2);
            }

            switch ($img_type) {
                case 'jpg':
                    $im = @imagecreatefromjpeg($original_image);
                    break;
                case 'gif':
                    $im = @imagecreatefromgif($original_image);
                    break;
                case 'png':
                    $im = @imagecreatefrompng($original_image);
                    break;
            }

            @imagecopyresampled($im_p, $im, $x, $y, 0, 0, $width, $height, $orig_width, $orig_height);

            switch ($img_type) {
                case 'jpg':
                    @imagejpeg($im_p, $dest_image);
                    break;
                case 'gif':
                    @imagegif($im_p, $dest_image);
                    break;
                case 'png':
                    @imagepng($im_p, $dest_image);
                    break;
            }

            @imagedestroy($im_p);
            @imagedestroy($im);
            @chmod($dest_image, 0777);
            return true;
        }

        return false;
    }
}

if ( ! function_exists('img'))
{
    function img($file)
    {
        return asset('img/'.$file);
    }
}

if ( ! function_exists('isUploaded'))
{
    function isUploaded($field = '')
    {
        if (isset($_FILES[$field]) && $_FILES[$field]['size'] > 0 && $_FILES[$field]['error'] == 0)
        {
            return true;
        }

        return false;
    }
}

if ( ! function_exists('js'))
{
    function js($file)
    {
        return asset('js/'.$file.'.js');
    }
}

if ( ! function_exists('post'))
{
    function post($name)
    {
        return isset($_POST[$name]) ? $_POST[$name] : '';
    }
}

if ( ! function_exists('price'))
{
    function price($value)
    {
        return number_format($value, 0, ',', '.');
    }
}

if ( ! function_exists('redirect'))
{
    function redirect($url)
    {
        header('Location: '.$url, true, 303);
        die();
    }
}

if ( ! function_exists('sessave'))
{
    function sessave($name, $value = '')
    {
        if (is_array($name))
        {
            foreach ($name as $key => $val)
            {
                /*foreach ($name as $key => $val)
                {
                    $_SESSION[$key] = $val;
                }*/
                var_dump($key);
            }
        }
        else
        {
            $_SESSION[$name] = $value;
        }
    }
}

if ( ! function_exists('session'))
{
    function session($name, $default = '')
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }
}

if ( ! function_exists('sortAssociativeArrayByKey'))
{
    function sortAssociativeArrayByKey($array, $key, $direction = 'ASC')
    {
        usort($array, function ($a, $b) use ($key, $direction) {
            $comparison = $a[$key] <=> $b[$key];
            return ($direction === 'DESC') ? -$comparison : $comparison;
        });
        return $array;
    }
}

if ( ! function_exists('url'))
{
    function url($uri = '')
    {
        return BASEURL.$uri;
    }
}