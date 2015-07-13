<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $page_number = $this->input->get('page')?$this->input->get('page'):1;
    $sname = $this->input->get('sname')?$this->input->get('sname'):'';
    if($this->input->get('delete_ids')!==FALSE)
    {
        if($this->input->get('delete_ids')!='')
        {
            $this->labels_model->delete($this->input->get('delete_ids'));
            die('ok');
        }    
        else
            die('no_input');
    }
    if($this->input->get('new_name')!==FALSE &&  $this->input->get('new_alias')!==FALSE )
    {
        if($this->input->get('new_name')!='')
        {
            $name = $this->input->get('new_name');
            $alias = $this->input->get('new_alias')==''?$name:$this->input->get('new_alias');
            $alias = str_replace(' ','-', $alias);
            if($this->labels_model->add($name,$alias)>0)
                $ou='ok';
            else
                $ou='duplicate';
            die($ou);
        }    
        else
            die('data_error');
    }
    if($this->input->get('edit_name')!==FALSE &&  $this->input->get('edit_alias')!==FALSE && $this->input->get('edit_id')!==FALSE )
    {
        if($this->input->get('edit_name')!='')
        {
            $name = $this->input->get('edit_name');
            $alias = $this->input->get('edit_alias')==''?$name:$this->input->get('edit_alias');
            $labels_type_id = $this->input->get('labels_type_id');
            $labels_daste_id = $this->input->get('labels_daste_id');
            $id = $this->input->get('edit_id');
            $alias = str_replace(' ','-', $alias);
            if($this->labels_model->edit($id,$name,$alias,$labels_daste_id,$labels_type_id)>0)
                $ou='ok';
            else
                $ou='duplicate';
            die($ou);
        }    
        else
            die('data_error');
    }
?>
<script>
    var base_url = "<?php echo base_url().'modir/labels' ?>";
    var stat="<?php echo asset_url(); ?>img/stat.gif";
</script>
<script src="<?php echo asset_url(); ?>js/labels.js"></script>

<div class="er-admin-contaner uk-container uk-container-center" id="top_div">
	<h2 class="er-admin-title">مدیریت برچسب‌ها</h2>
	<hr>
	
	<span id="khoon"></span>
	
	<!-- Menu -->
        <form class="uk-form uk-margin-small-top" id="sfrm" >
	<a class="uk-button uk-button-danger uk-button-small" href="#" onclick="delete_item();"><i class="er-icon uk-icon-close"></i>حذف</a>
            <input type="text" id="sname" name="sname" value="<?php echo $sname; ?>" placeholder="جستجوی نام" >
            <button class="uk-button uk-button-primary uk-button-small" >جستجو</button>
            <a class="uk-button uk-button-primary uk-button-small" href="#" onclick="$('#sname').val('');$('#sfrm').submit();" >پاکسازی</a>
	<a class="er-float-left uk-button uk-button-primary uk-button-small" href="../modir" ><i class="er-icon uk-icon-chevron-right"></i>بازگشت</a>
        </form>
	<!-- ClearFix -->
	<div class="uk-clearfix" ></div>
	<hr>
        
	<!-- List -->
	<div class="uk-width-1-1" data-uk-margin>
	
		<div>
			<form class="uk-form uk-margin-bottom">
                            <input onblur="generate_alias();" type="text" id="new_name" placeholder="نام" >
			    <input onblur="correct_alias();" type="text" id="new_alias" placeholder="نام مستعار" >
			    <button class="uk-button uk-button-success" onclick="save_label();" >ثبت جدید</button>
			</form>
		</div>
		
		<?php echo $this->labels_model->getLabelsTable($page_number,$sname); ?>
	</div>
</div>