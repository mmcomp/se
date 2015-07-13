<!DOCTYPE html>
<html>
<head>
	<?php
		$asset_url = asset_url();
		$this->load->helper('html');
		$this->load->helper('url');
		$meta = array(
			array('name' => 'robots', 'content' => 'no-cache'),
			array('name' => 'description', 'content' => 'ستاوین'),
			array('name' => 'keywords', 'content' => 'معماری'),
			array('name' => 'robots', 'content' => 'no-cache'),
			array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
		);
		echo meta($meta);
        ?>
	<title>ستاوین شبکه معماری ایران-مدیریت</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	
	<script src=" <?php echo $asset_url.'js/jquery-1.11.1.min.js' ?>" ></script>
        <script src=" <?php echo $asset_url.'js/grid.js' ?>" ></script>
        <script src=" <?php echo $asset_url.'js/cal/jalali.js' ?>" ></script>
        <script src=" <?php echo $asset_url.'js/cal/calendar.js' ?>" ></script>
        <script src=" <?php echo $asset_url.'js/cal/calendar-setup.js' ?>" ></script>
        <script src=" <?php echo $asset_url.'js/cal/lang/calendar-fa.js' ?>" ></script>
	<script src="<?php echo $asset_url; ?>js/uikit.min.js"></script>
        <?php
            if(isset($has_ckeditor) && $has_ckeditor) // if in edit_content ckedotr is activeted
                echo '<script src="'.$asset_url.'js/ckeditor/ckeditor.js"></script>';
        ?>
        
	<link rel="stylesheet" href="<?php echo $asset_url; ?>css/admin.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $asset_url; ?>css/uikit.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $asset_url; ?>css/xgrid.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $asset_url; ?>js/cal/skins/aqua/theme.css" type="text/css" />        
	<?php
	if(!(isset($logged_in) && $logged_in) ) // if in login page  include login.css
		echo '<link rel="stylesheet" href="'.$asset_url.'css/login.css" type="text/css" />'
	?>
	
</head>
<body>

	<div class="uk-grid">
		<!-- Top Logo -->
		<div class="er-toplogo uk-width-1-1">
			<a href="<?php echo base_url(); ?>"><img src="<?php echo asset_url(); ?>img/logo.png" alt="ستاوین، ..." /></a>
		</div>
		
		<!-- Top Menu -->
                <?php 
                if(isset($logged_in) && $logged_in)
                {    
                ?>
		<div class="er-topmenu uk-width-1-1">
			<div class="uk-container uk-container-center">
				<div class="uk-navbar-attached">
				
					<ul class="uk-navbar-nav">
						<li><a href="<?php echo base_url()?>modir"><i class="er-admin-menu-icon uk-icon-ellipsis-v"></i>صفحه اصلی مدیریت</a></li>
						<li><a href="<?php echo base_url()?>modir/content"><i class="er-admin-menu-icon uk-icon-file-o"></i>مدیریت مطالب</a></li>
						<li><a href="<?php echo base_url()?>modir/labels"><i class="er-admin-menu-icon uk-icon-tag"></i>مدیریت برچسبها</a></li>
						<li><a href="<?php echo base_url()?>modir/amar"><i class="er-admin-menu-icon uk-icon-area-chart"></i> آمار</a></li>
						<li><a href="<?php echo base_url()?>modir/labels_daste"><i class="er-admin-menu-icon uk-icon-area-tag"></i> دسته بندیهای برچسب</a></li>                                                                                                
                                                <li><a href="<?php echo base_url()?>modir/comments"><i class="er-admin-menu-icon uk-icon-area-tag"></i> دیدگاهها</a></li>  
					</ul>
					<div class="uk-navbar-flip">
						<ul class="uk-navbar-nav">
							<li><a href="<?php echo base_url()?>modir/logout"><i class="er-admin-menu-icon uk-icon-sign-out"></i>برون رفت</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
                <?php 
                }
                ?>
	</div><!-- end .uk-grid -->