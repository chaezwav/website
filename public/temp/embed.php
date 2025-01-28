<?php

$title = "Hi!!";
$content = "I'm a cool image generator!";
$regular_font = '/var/www/dev.koehn.lol/public/static/fonts/Vercetti-Regular.ttf';
$bold_font = '/var/www/dev.koehn.lol/public/static/fonts/MoralerspaceArgon-Bold.ttf';

$img = imagecreatetruecolor(1200, 630);
$pink = imagecolorallocate($img, 255, 179, 193);
$gray = imagecolorallocate($img, 127, 132, 142);
$black = imagecolorallocate($img, 16, 16, 16);
imagefilledrectangle($img, 0, 0, 1200, 630, $black);
imagefttext($img, 80, 0, 200, 160, $pink, $bold_font, $title);
imagefttext($img, 80, 0, 80, 100, $pink, $bold_font, "公園");


// //handle wrapping
// $length_limit = 200;
// $content = substr($content, 0, $length_limit);
// $content = wordwrap($content, 35, "\n", true);
// $lines = explode("\n", $content);

// $i = 0;
// foreach ($lines as $line) {
//     imagefttext($img, 24, 0, 50, 160 + $i, $gray, $regular_font, $line);
//     $i += 50;
// }

header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);