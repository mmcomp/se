<!DOCTYPE html>
<html>
    <head>
        <?php
        $this->load->helper('html');
        $this->load->helper('url');

        $this->load->library('user_agent');

        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser(); //.' '.$this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }
        if (strtolower($agent) != 'chrome') {
            //die('NOK');
        }
//echo $agent;
//echo $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)

        echo meta($meta);
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
        <?php echo $title; ?>
        </title>
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
        <script src=" <?php echo asset_url() . 'js/jquery-1.11.1.min.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/bootstrap.min.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/grid.min.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/bootstrap-datepicker.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/bootstrap-datepicker.fa.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/fileinput.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/select2.min.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/jquery.PrintArea.js' ?>"></script>
        <script src=" <?php echo asset_url() . 'js/persian-date.js' ?>" ></script>
        <script src=" <?php echo asset_url() . 'js/persian-datepicker.min.js' ?>" ></script>
<?php
if (isset($has_ckeditor) && $has_ckeditor) { // if in edit_content ckedotr is activeted
    echo '<script src="' . asset_url() . 'js/ckeditor/ckeditor.js"></script>' . "\n";
}
?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row gh-header-bar">
                <div class="col-sm-2"></div>
                <div class="gh-no-padding col-sm-4"><img src="<?php echo asset_url(); ?>images/img/logo.png"/></div>
                <div class="col-sm-6"></div>
            </div>
        </div>
