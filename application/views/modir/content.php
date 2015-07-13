<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $page_number = $this->input->get_post('page')?$this->input->get_post('page'):1;
    if($this->input->get('publish_ids')!==FALSE)
    {
        if($this->input->get('publish_ids')!='')
        {
            $this->contents_model->set_publish($this->input->get('publish_ids'),1);
            die('ok');
        }    
        else
            die('no_input');
    }
    if($this->input->get('unpublish_ids')!==FALSE)
    {
        if($this->input->get('unpublish_ids')!='')
        {
            $this->contents_model->set_publish($this->input->get('unpublish_ids'),0);
            die('ok');
        }    
        else
            die('no_input');
    }
    if($this->input->get('delete_ids')!==FALSE)
    {
        if($this->input->get('delete_ids')!='')
        {
            $this->contents_model->delete_content($this->input->get('delete_ids'));
            die('ok');
        }    
        else
            die('no_input');
    }
    $se_types_id = 0;
    $content_name='';
    $en=-1;
    if($this->input->get('se_types_id')!==FALSE)
    {
        $se_types_id = (int)$this->input->get('se_types_id');
        $content_name = $this->input->get('se_name');
        $en = (int)$this->input->get('se_en');
    }    
?>
<script>
    var base_url = "<?php echo base_url().'modir/content' ?>";
    var stat="<?php echo asset_url(); ?>img/stat.gif";
</script>
<div class="er-admin-contaner uk-container uk-container-center">
	<h2 class="er-admin-title">مدیریت مطالب</h2>
	<hr>
	
	<!-- Menu -->
	<a class="uk-button uk-button-success uk-button-small" href="<?php echo base_url().'modir/edit_content'; ?>"><i class="er-icon uk-icon-plus"></i>جدید</a>
	<!-- <li><a href="#" onclick="edit_item();" >ویرایش</a></li> -->
	<a class="uk-button uk-button-primary uk-button-small" href="#" onclick="publish_item(true);"><i class="er-icon uk-icon-check-square-o"></i>انتشار</a>
	<a class="uk-button uk-button-small" href="#" onclick="publish_item(false);"><i class="er-icon uk-icon-minus-square-o"></i>عدم انتشار</a>
	<a class="uk-button uk-button-danger uk-button-small" href="#" onclick="delete_item();"><i class="er-icon uk-icon-close"></i>حذف</a>
	<a class="er-float-left uk-button uk-button-primary uk-button-small" href="../modir" ><i class="er-icon uk-icon-chevron-right"></i>بازگشت</a>
        
	<!-- ClearFix -->
	<div class="uk-clearfix"></div>
	<hr>
        
	<!-- List -->
	<div class="uk-width-1-1" data-uk-margin>
		<form class="uk-form">
                    بخش:
                    <select class="" id="se_types_id" name="se_types_id" >
                            <?php echo $this->types_model->getTypes('select',$se_types_id); ?>
                    </select>
                    نام:
                    <input name="se_name" id="se_name" value="<?php echo $content_name; ?>" >
                    وضعیت:
                    <select name="se_en" id="se_en" >
                        <option <?php echo $en==-1?'selected="selected"':''; ?> value="-1" >همه</option>
                        <option <?php echo $en==0?'selected="selected"':''; ?> value="0" >منتشر نشده</option>
                        <option <?php echo $en==1?'selected="selected"':''; ?> value="1" >انتشار یافته</option>
                    </select>
                    <button class="uk-button uk-button-primary uk-button-small" >جستجو</button>
                    <a href="#" onclick="clear_inp();" class="uk-button uk-button-primary uk-button-small" >پاکسازی</a>
		</form>
	</div>
        
	<!-- List Table -->
	<?php echo $this->contents_model->getContentsByTypeTable($se_types_id,$content_name,$en,$page_number); ?>
</div>
<script src="<?php echo asset_url(); ?>js/content.js"></script>