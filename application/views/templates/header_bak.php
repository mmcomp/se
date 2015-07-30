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
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap-rtl.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/crm.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap-select.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/select2.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/xgrid.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/fileinput.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap-datepicker.min.css" />
        <link rel="stylesheet" href="<?php echo asset_url(); ?>css/stylesheet.css" type="text/css" />
        <script src=" <?php echo asset_url() . 'js/jquery-1.11.1.min.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/grid.min.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/bootstrap-datepicker.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/bootstrap-datepicker.fa.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/fileinput.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/jquery.PrintArea.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/javascript.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/jquery.color.js' ?>"></script>
        <?php
        if (isset($has_ckeditor) && $has_ckeditor) { // if in edit_content ckedotr is activeted
            echo '<script src="' . asset_url() . 'js/ckeditor/ckeditor.js"></script>' . "\n";
        }
        ?>
    </head>
    <body>
        <!--header-->
        <div class="gh-header-bar">
            <div class="gh-header-body">
                <div class="gh-header-body-right">
                    <div class="gh-logo"><img src="<?php echo asset_url(); ?>images/img/logo.png"></div>
                </div>
                <div class="gh-header-body-left">
                    <div class="gh-header-info"></div>
                    <div class="gh-quick-contact"><img src="<?php echo asset_url(); ?>images/img/q-c-bg.PNG"><p>0915 822 6800</p></div>
                </div>
            </div>
        </div>
