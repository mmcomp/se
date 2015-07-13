<?php
session_start();
$number1 = rand(1,10);
$angle = rand(-20,20);
$_SESSION["hs_number2"] = $number1;
$my_img = imagecreate( 25, 25 );
$background = imagecolorallocate( $my_img, 255, 255, 255 );
$text_colour = imagecolorallocate( $my_img, 0, 0, 0 );
$line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
imagestring( $my_img, 5, 5, 5,(string)$number1,
  $text_colour );
imagesetthickness ( $my_img, 5 );
imageline( $my_img, 30, 45, 165, 45, $line_colour );

header( "Content-type: image/png" );
$rotation = imagerotate($my_img,$angle , imageColorAllocateAlpha($my_img, 255, 255, 255, 127));
imagepng($rotation );
imagecolordeallocate( $line_color );
imagecolordeallocate( $text_color );
imagecolordeallocate( $background );
imagedestroy( $my_img );
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

