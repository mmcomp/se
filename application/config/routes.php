<?php
/*
    $route['modir/(:any)'] = 'modir/view/$1';
    $route['modir'] = 'modir';
    $route['news/(:any)'] = 'news/view/$1';
    $route['news'] = 'news';
 * 
 */
    $route['default_controller'] = 'pages/view';
    $route['(:any)'] = 'pages/view/$1';
    