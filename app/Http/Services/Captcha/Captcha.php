<?php

namespace App\Http\Services\Captcha;

class Captcha
{
    private $width;
    private $height;
    private $code;
    private $image;

    public function __construct($width = 120, $height = 50)
    {
        $this->width = $width;
        $this->height = $height;
        $this->code = $this->generateCode();
        $this->image = $this->createImage();
    }


    private function generateCode()
    {
        $code = '';
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $outLength = rand(6, 8);
        for ($i = 0; $i <= $outLength; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }
        return $code;
    }

    private function createImage()
    {
        $image = imagecreatetruecolor($this->width, $this->height);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 210, 15, 15);
        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $white);
        for ($i = 0; $i < 100; $i++) {
            imagesetpixel($image, rand(0, $this->width - 5), rand(0, $this->height - 5), $black);
        }
        $fontSize = 14;
        $x = rand(0, $this->width - $fontSize * strlen($this->code));
        $y = rand(16, $this->height - $fontSize);
        $font = '../public/frontend/fonts/iransans/woff/IRANSansWeb(FaNum)_Bold.woff';
        imagettftext($image, $fontSize, 0, $x, $y, $black, $font, $this->code);
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getImage()
    {
        return $this->image;
    }
}

$captcha = new Captcha();
session(['captcha_code' => $captcha->getCode()]);
$captcha->getImage();
