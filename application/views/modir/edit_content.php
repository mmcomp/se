<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$id = ($this->input->get_post('content_id')!==FALSE)?(int)$this->input->get_post('content_id'):-1;
        $msg='';
	if($this->input->get('labels_ajax')!==FALSE)
	{
		$ou = $this->labels_model->getLabelsByName($this->input->get('labels_ajax'));
		die($ou);
	}
	if($this->input->get('loadLabels')!==FALSE)
	{
		$ou = $this->labels_model->getLabelsByContent((int)$this->input->get('loadLabels'));
		die(json_encode($ou));
	}
	if($this->input->get('del_labaels_contents_id')!==FALSE)
	{
		$ou = $this->labels_model->deleteLabelsByContents((int)$this->input->get('del_labaels_contents_id'));
		die($ou>0?'ok':'nok');
	}
        if($this->input->get('del_labael_id')!==FALSE && $this->input->get('del_contents_id')!==FALSE )
        {
            $ou = $this->labels_model->deleteLabelByLabel_id((int)$this->input->get('del_labael_id'),(int)$this->input->get('del_contents_id'));
            die($ou>0?'ok':'nok');
        }
	if($this->input->get('add_labael_id')!==FALSE && $this->input->get('add_contents_id')!==FALSE  )
	{
		$ou = $this->labels_model->addLabelsByContents((int)$this->input->get('add_labael_id'),(int)$this->input->get('add_contents_id'));
		die("$ou");
	}
        if($this->input->get_post('uploaded')!==FALSE)
        {
            $file_name = 'assets/images/files/'.$this->input->get_post('uploaded');
            die($this->contents_model->addPic($id,$file_name));
        }
        if($this->input->get_post('loadPic')!==FALSE)
        {
            $ou = $this->contents_model->loadPic($id);
            die(json_encode($ou));
        }
        if($this->input->get('del_pic')!==FALSE)
        {
            $pic_id = (int)$this->input->get('del_pic');
            $ou = $this->contents_model->delPic($pic_id);
            die("$ou");
        }
        if($this->input->get('shakes_pic')!==FALSE)
        {
            $pic_id = (int)$this->input->get('shakes_pic');
            $c_id=(int)$this->input->get('content_id');
            $ou = $this->contents_model->setShakhes($pic_id,$c_id);
            die("$ou");
        }
        if($this->input->get('newLabel')!==FALSE)
        {
            $new_label =trim($this->input->get('newLabel'));
            $new_alias = str_replace(' ','-',$new_label);
            $ou = $this->labels_model->add($new_label,$new_alias);
            die("$ou");
        }    
        $content =$this->contents_model->getContentsById($id);
	if($this->input->post('type_id')!==FALSE)
	{
                $tmp = new stdClass();
                $shenasname=array();
                foreach($this->input->post() as $key=>$val)
                {
                    $tt = explode('_',$key);
                    if($tt[0]=='sh')
                    {
                        if($tt[1]=='Start' || $tt[1]=='End')
                        {    
                            if($this->input->post($tt[1].'_jalali')!==FALSE)
                            {        
                                $val = $this->contents_model->hamed_jalalitomiladi(str_replace('-','/', $val));
                            }    
                        }
                        
                        $shenasname[$tt[1]] = strip_quotes(strip_tags($val));
                    }    
                }
                $tmp->id = $this->input->post('content_id');
                $tmp->name =$this->input->post('name');
                $tmp->alias = $this->input->post('alias');
                $tmp->html_title = $this->input->post('html_title');
                $tmp->body_content = $this->input->post('body_content');
                $tmp->meta_key = $this->input->post('meta_key');
                $tmp->meta_discription = $this->input->post('meta_discription');
                $tmp->author = $this->input->post('author');
                $tmp->creator =((int)$this->input->post('creator')==-1)?$this->se_model->getUser():(int)$this->input->post('creator');
                $tmp->show_creator = ($this->input->post('show_creator')!==FALSE)?1:0;
                $tmp->type_id = $this->input->post('type_id');
                $tmp->footer_type = $this->input->post('footer_type');
                $tmp->create_date =$this->contents_model->hamed_jalalitomiladi($this->input->post('create_date'));
              	if($this->form_validation->run()==FALSE)
		{
			//
		}
		else
		{
                    $now = date("Y-m-d H:i:s");
                    if($tmp->id>0)
                    {    
                        $tmp->modifire = $this->se_model->getUser();
                        $tmp->modify_date = $now;
                        $tmp->en = $content->en ;
                    }
                    else
                    {    
                        $tmp->modifire = -1;
                        $tmp->create_date = $now;
                        $tmp->modify_date = $now;
                        $tmp->en = 0;
                    }
                    
                    $sa = $this->contents_model->save($tmp);
                    if(count($shenasname)>0)
                    {    
                        $this->project_extra_model->save($shenasname,$id,1);
                    }    
                    if($tmp->id<0 && $sa>0)
                    {    
                        $id = $sa;
                        $content =$this->contents_model->getContentsById($id);
                    }
                    $msg = '<div class="uk-alert uk-alert-success" >ثبت با موفقیت انجام شد</div>';
		}
	}
	
	if(isset($tmp))
	{
		foreach($tmp as $key=>$val)
		{	
			$content->$key = $val;
		}
	}
		
?>
<script>
        var cur_url = "<?php echo base_url(); ?>";
        var base_url = cur_url+"modir/edit_content";
        var assets_url = "<?php echo asset_url(); ?>";
	var stat=assets_url+"img/stat.gif";
	var content_id =<?php echo $id; ?>;
        var dataAll=[];
</script>
<script src="<?php echo asset_url(); ?>js/edit_content.js"></script>
<script src="<?php echo asset_url(); ?>js/jquery.iframe-transport.js"></script>
<script src="<?php echo asset_url(); ?>js/jquery.ui.widget.js"></script>
<script src="<?php echo asset_url(); ?>js/jquery.fileupload.js"></script>
<div class="er-admin-contaner uk-container uk-container-center" data-uk-margin>
        <?php echo $msg; ?>
	<div class="uk-grid" data-uk-margin>
		
		<!-- List -->
		<div class="uk-width-1-1" data-uk-margin>
		
			<!-- admin Content -->
			<h2 class="er-admin-title"><?php echo ($content->name==''?'مطلب جدید':$content->name); ?></h2>
			<hr>
			
			<!-- Menu -->
			<a class="uk-button uk-button-success uk-button-small" href="#" onclick='$("#submit_frm").click();' ><i class="er-icon uk-icon-save"></i>ذخیره</a>
			<a class="er-float-left uk-button uk-button-primary uk-button-small" href="../modir/content" ><i class="er-icon uk-icon-chevron-right"></i>بازگشت</a>
			
			<!-- ClearFix -->
			<div class="uk-clearfix"></div>
			<hr>
			
			<!-- Tab Links -->
			<ul class="uk-tab" data-uk-tab data-uk-switcher="{connect:'#edit_tab'}">
			    <li class="uk-active"><a href="">اطلاعات کلی</a></li>
			    <li><a href="">جزییات</a></li>
                            <li><a href="">برچسب های خاص</a></li>
                            <li><a href="">اطلاعات شناسنامه ای</a></li>
			    <li><a href="">گالری تصاویر</a></li>
			</ul>
			
			<?php echo form_open(base_url().'modir/edit_content',array('id'=>'form1', 'class' => 'uk-form uk-form-horizontal')); ?>
			<!-- Tab Contents -->
			<ul id="edit_tab" class="uk-switcher">
				<li class="uk-margin-large-bottom uk-margin-top">
					<input type="hidden" id="content_id" name="content_id" value="<?php echo $content->id; ?>" >
					<div class="uk-form-row">
						<label class="uk-form-label" for="type_id">بخش:</label>
						<div class="uk-form-controls">
							<select id="type_id" name="type_id" >
								<?php echo $this->types_model->getTypes('select',$content->type_id); ?>
							</select>
						</div>
						<?php echo form_error('type_id'); ?>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="name">عنوان مطلب:</label>
						<div class="uk-form-controls">
							<input onblur="generate_alias();" type="text" id="name" name="name" value="<?php echo $content->name ?>" placeholder="عنوان مطلب" class="uk-width-1-1 uk-form-large" />
						</div>
						<?php echo form_error('name'); ?>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="alias">نام مستعار (آدرس یکتا):</label>
						<div class="uk-form-controls">
							<input onblur="correct_alias();" type="text" id="alias" name="alias" value="<?php echo $content->alias ?>" placeholder="نام مستعار (آدرس یکتا)" class="uk-width-1-1" />
						</div>
						<?php echo form_error('alias'); ?>
					</div>
					<div class="uk-form-row">
						<?php echo form_error('body_content'); ?>
						<textarea style="margin:10px;" id="body_content" name="body_content" ><?php echo $content->body_content; ?></textarea>
					</div>
				</li>
				<li class="uk-margin-large-bottom uk-margin-top">
					<div class="uk-form-row">
						<label class="uk-form-label" for="html_title">سرتیتر بالای صفحه:</label>
						<div class="uk-form-controls">
							<input type="text" id="html_title" name="html_title" value="<?php echo $content->html_title; ?>" placeholder="سرتیتر بالای صفحه" class="uk-width-1-1" />
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="meta_key">Meta Keyes:</label>
						<div class="uk-form-controls">
							<input type="text" id="meta_key" name="meta_key" value="<?php echo $content->meta_key ?>"  class="uk-width-1-1" />
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="meta_discription">Meta Discription:</label>
						<div class="uk-form-controls">
							<input type="text" id="meta_discription" name="meta_discription" value="<?php echo $content->meta_discription; ?>" class="uk-width-1-1" />
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="author">نویسنده:</label>
						<div class="uk-form-controls">
                                                    <input type="text" id="author" name="author" value="<?php echo $content->author; ?>" placeholder="نویسنده" />
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">تولید کننده:</label>
						<div class="uk-form-controls">
                                                    <select name="creator" >
                                                        <option value="-1">انتخاب</option>
                                                        <?php echo $this->users_model->loadAdminUsers($content->creator); ?>
                                                    </select>
                                                    <span style="font-size: 70%;" >
                                                     نمایش 
                                                    </span>
                                                    <input type="checkbox" id="show_creator" name="show_creator" <?php echo ($content->show_creator==1)?'checked="checked"':''; ?> >
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="create_date">تاریخ تولید:</label>
						<div class="uk-form-controls">
							<input type="text" id="create_date" name="create_date" value="<?php echo jdate("Y/m/d",strtotime($content->create_date)); ?>" />
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">آخرین ویرایشگر:</label>
						<div class="uk-form-controls">
							<?php   
							$tmp1 = $this->users_model->getUser($content->modifire);
							echo $tmp1->fname.' '.$tmp1->lname;
							?>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="modify_date">تاریخ ویرایش:</label>
						<div class="uk-form-controls">
							<input type="text" id="modify_date" name="modify_date" value="<?php echo jdate("Y/m/d",strtotime($content->modify_date)); ?>" />
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="modify_date">متن انتهایی:</label>
                                                <select id="footer_type" name="footer_type">
                                                    <?php echo $this->footer_type_model->getOption($content->footer_type); ?>
                                                </select>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="labels_ids">برچسب‌ها:</label>
						<div class="uk-form-controls">
							<?php if($id>0){ ?>
							<div class="er-label-dropdown-parrent">
								<input id="labels_ajax" />
                                                                <a href="#" onclick="addLabel();" ><i class="er-icon uk-icon-save"></i></a>
								<div id="ser_span" class="er-label-dropdown"></div>
							</div>
							<?php }else{ ?>
							پس از ذخیره مطلب، برچسب را اضافه نمایید
							<?php } ?>
							
							<?php if($id>0){ ?>
							<div class="er-modir-lables-list" id="labels_all"></div>
							<?php } ?>
						</div>
					</div>
					<div class="uk-form-row">
						<input type="hidden" value="<?php echo $id; ?>" name="content_id" id="content_id" >
					</div>
				</li>
                                <li class="uk-margin-large-bottom uk-margin-top">
                                    <?php echo $this->labels_model->loadlabelsView($content->id,$content->type_id); ?>
                                </li>
                                <li class="uk-margin-large-bottom uk-margin-top">
                                    <?php echo $this->project_extra_model->view($content->id,$content->type_id); ?>
                                </li>
				<li class="uk-margin-large-bottom uk-margin-top">
					<div>
			            <!-- The fileinput-button span is used to style the file input field as button -->
			            <?php if($id>0){ ?>
		                <div class="uk-margin-large-bottom">
			                <span> افزودن تصویر ...</span>
			                <!-- The file input field used as target for the file upload widget -->
			                <input id="fileupload" type="file" name="files[]" multiple>
                            <input type="button" class="uk-button uk-button-success uk-button-small" id="save_btn" disabled="disabled" onclick="sendIndex(0);" value="ذخیره" >
                            <span id="upload_khoon" ></span>
			           </div>
		               
		               <div id="pics" >
		                </div>
			            <?php }else{ ?>
			            <div>
			                 پس از ذخیره مطلب تصاویر راتخصیص دهید.
			            </div>
			            <?php } ?>
			            
			            <br>
			            <br>
			            <!-- The global progress bar -->
			            <div id="progress" class="progress">
	                		<div class="progress-bar progress-bar-success"></div>
			            </div>
			            <!-- The container for the uploaded files -->
			            <div id="files" class="files"></div>
			            <div id="edit_khoon" style="padding-bottom:10px;" ></div>
			        </div>
				</li>
			</ul>
			<?php
			echo form_button(array('name' => 'submit', 'type' => 'submit', 'id' => 'submit_frm', 'value' => 'true', 'content' => 'ذخیره', 'class' => 'uk-button uk-button-success uk-margin-large-bottom er-button er-float-left'));
			echo form_close(); 
			echo form_fieldset_close();
			?>
		</div>
	</div>
        
</div>
<span id="khoon"></span>