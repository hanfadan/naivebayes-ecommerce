<?php

if (!function_exists('price')) {
    function price($value): string
    {
        return number_format((float) $value, 0, ',', '.');
    }
}

if (!function_exists('checkAge')) {
    function checkAge(string $date): int
    {
        $old   = new DateTime($date);
        $today = new DateTime('today');
        return (int) $today->diff($old)->y;
    }
}

if (!function_exists('friendlyUrl')) {
    function friendlyUrl(string $string = ''): string
    {
        $lower   = strtolower($string);
        $replace = preg_replace('#[^0-9a-z]+#i', '-', $lower);
        return trim($replace, '-');
    }
}

if (!function_exists('dateToSql')) {
    function dateToSql(string $date): string
    {
        return date('Y-m-d', strtotime($date));
    }
}

if (!function_exists('productImage')) {
    function productImage(string $prefix, string $image): string
    {
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }
        return asset('images/' . $prefix . $image);
    }
}

if (!function_exists('imageResize')) {
    function imageResize(string $original, string $dest, int $w, int $h, bool $forceSize = false): bool
    {
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $map = ['jpg' => IMG_JPG, 'jpeg' => IMG_JPG, 'gif' => IMG_GIF, 'png' => IMG_PNG];

        if (!isset($map[$ext]) || !(imagetypes() & $map[$ext])) {
            return false;
        }

        [$origW, $origH] = getimagesize($original);
        $factor = max($origW / $w, $origH / $h);
        $newW   = $forceSize ? $w : (int) round($origW / $factor);
        $newH   = $forceSize ? $h : (int) round($origH / $factor);
        $x = (int) floor(($w - $newW) / 2);
        $y = (int) floor(($h - $newH) / 2);

        $canvas = imagecreatetruecolor($w, $h);
        imagealphablending($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
        imagefill($canvas, 0, 0, $transparent);
        imagesavealpha($canvas, true);

        $src = match ($ext) {
            'gif'  => imagecreatefromgif($original),
            'png'  => imagecreatefrompng($original),
            default => imagecreatefromjpeg($original),
        };

        imagecopyresampled($canvas, $src, $x, $y, 0, 0, $newW, $newH, $origW, $origH);

        match ($ext) {
            'gif'  => imagegif($canvas, $dest),
            'png'  => imagepng($canvas, $dest),
            default => imagejpeg($canvas, $dest),
        };

        imagedestroy($canvas);
        imagedestroy($src);
        chmod($dest, 0777);

        return true;
    }
}
