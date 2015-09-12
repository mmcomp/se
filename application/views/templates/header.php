<!DOCTYPE html>
<html>
    <head>
        <?php
        $this->load->helper('html');
        $this->load->helper('url');
        echo meta($meta);
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?php echo $title; ?>
        </title>
        <link rel="icon" href="<?php echo asset_url(); ?>images/img/fav.png" type="image/png" sizes="16x16">
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap-rtl.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/crm.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/stylesheet.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap-select.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/select2.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/xgrid.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/fileinput.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap-datepicker.min.css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/persian-datepicker.css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/gh-reserve.css" />
        <script src=" <?php echo asset_url() . 'js/jquery-1.11.1.min.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/bootstrap.min.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/grid.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/bootstrap-datepicker.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/bootstrap-datepicker.fa.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/fileinput.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/select2.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/jquery.PrintArea.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/persian-date.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/persian-datepicker.min.js' ?>" ></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=fa"></script>
        <?php
        if (isset($has_ckeditor) && $has_ckeditor) { // if in edit_content ckedotr is activeted
            echo '<script src="' . asset_url() . 'js/ckeditor/ckeditor.js"></script>' . "\n";
        }
        ?>
    </head>
    <body>
        <div class="container-fluid" style="border-top: 2px solid #42d3dc;">

            <!--***header-bar***-->
            <div class="row gh-header-bar">
                <div class="col-sm-2"></div>
                <!--logo-->
                <div class="col-sm-3">
                    <img src="<?php echo asset_url(); ?>images/img/logo.png"/>
                </div>
                <!--logo-->
                <!--reserve and icons-->
                <div class="col-sm-5">
                    <ul class="list-inline">
                        <li> <img class="pull-left" src="<?php echo asset_url(); ?>images/img/reserve.png"/></li>
                        <li><a href="#"><img class="pull-left" src="<?php echo asset_url(); ?>images/img/icon1.png"/></a></li>
                        <li> <a href="#"><img class="pull-left" src="<?php echo asset_url(); ?>images/img/icon3.png"/></a></li>
                        <li><a href="#"><img class="pull-left" src="<?php echo asset_url(); ?>images/img/icon2.png"/></a></li>
                    </ul>
                </div>
                <!--reserve and icons-->
                <div class="col-sm-2"></div>
            </div>
            <!--***header-bar***-->

            <!--***sub-header***-->
            <div class="row gh-sub-header" >
                <div class="col-sm-2"></div>
                <!--menu-large-->
                <div class="col-sm-8 gh-menu-large hidden-sm hidden-xs">
                    <ul>
                        <li><a href="<?php echo site_url(); ?>">صفحه اصلی</a></li>
                        <li><a href="#">اطلاعات پرواز</a></li>
                        <li><a href="<?php site_url(); ?> action?menu=bakhshname">بخشنامه ها</a></li>
                        <li><a href="<?php site_url(); ?> action?menu=history">تاریخچه ایرلاین ها</a></li>
                        <li><a href="<?php site_url(); ?> action?menu=job">کاریابی و استخدام</a></li>
                        <li><a class="scroll" href="#myAnchor">ارتباط با ما</a></li>
                    </ul>
                </div>
                <!--menu-large-->
                <!--menu-small-->
                <div class="dropdown col-sm-8 gh-menu-small visible-sm visible-xs">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">منو <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">صفحه اصلی</a></li>
                        <li><a href="#">اطلاعات پرواز</a></li>
                        <li><a href="#">بخشنامه ها</a></li>
                        <li><a href="#">تاریخچه ایرلاین ها</a></li>
                        <li><a href="#">کاریابی و استخدام</a></li>
                        <li><a href="#myAnchor">ارتباط با ما</a></li>
                    </ul>
                </div>
                <!--menu-small-->
                <div class="col-sm-2"></div>
            </div>
            <!--***sub-header***-->

            <div class="row gh-subheader-divider"></div>

        </div>
