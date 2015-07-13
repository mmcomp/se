    <!-- container closed -->
    <div class="row">
        <div class="">
            <div class="hs-default hs-padding hs-border" >
                <div class="row hs-footer_menu" >
                    <div class='col-sm-4' >
                        <img src="<?php echo asset_url() ?>img/footer_logo.png" >
                        <ul class="hs-horizontal" >
                            <li>
                                <span class="glyphicon glyphicon-check" ></span>
                                <a href="<?php echo site_url(); ?>aboutus" >
                                درباره ما
                                </a>
                            </li>
                            <li>
                                <span class="glyphicon glyphicon-envelope" ></span>
                                <a href="<?php echo site_url(); ?>contactus" >
                                 ارتباط با ما
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class='col-sm-4' >
                        <div class="text-center">
                                ما را دنبال کنید   
                        </div>
                        <div class="text-center hs-font400" > 
                                <a href="http://www.facebook.com/" target="_blank" >
                                    <i class="fa fa-facebook-square"></i>
                                </a>
                                <a href="#" >
                                    <i class="fa fa-google-plus-square"></i>
                                </a>
                            
                                <a href="http://instagram.com/" target="_blank" >
                                    <i class="fa fa-instagram"></i>
                                </a> 
                        </div>   
                    </div>
                    <div class='col-sm-4' >
                            به ما بپیوندید
                        <form method="POST" action="<?php echo site_url();?>members" >
                        <div class="hs-margin-up-down">
                            <input type="text" name="newemail" class="hs-margin-left" placeholder="ایمیل شما"  style="color: #4c4c4c;line-height: normal;direction:ltr;height: 31px;" >
                            <input type="submit" value="عضویت"  style="height: 31px;color: #4c4c4c;" >
                        </div>
                        </form>
                    </div>
                </div>
                <div class="text-center hs-margin-up-down hs-footer" >
                                    کلیه حقوق این وب سایت متعلق به شرکت دنیاسیر است

                </div>
                <hr/>
                <div class="text-center hs-footer" >
                    توسعه و پشتیبانی توسط گوهر
                </div>
            </div>
        </div>
    </div>
    <script src=" <?php echo asset_url().'js/bootstrap.min.js' ?>" ></script>
    <script src=" <?php echo asset_url().'js/tooltip.js' ?>" ></script>
    <script src=" <?php echo asset_url().'js/select2.min.js' ?>" ></script>
    <script>
        var is_mobil = <?php echo $this->agent->is_mobile()?'true':'false'; ?>;
    </script>
    <?php
        $select_css_arr=array();
        if(isset($page_addr) && $page_addr=='home')
        {
            echo '<script src="'.asset_url().'js/home.js" ></script>';
        }    
        if(isset($page_addr) && in_array($page_addr,$select_css_arr) )
        {        
            echo '<script src="'.asset_url().'js/bootstrap-select.min.js" ></script>';
            echo '<script> var site_url="'.site_url().$page_addr.'";';
            echo 'var site_url="'.site_url().$page_addr.'";</script>';
            echo '<script src="'.asset_url().'js/sub_pages.js" ></script>';
        }  
    ?>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            $('select').select2({
                dir: "rtl"
            });
            if(typeof $('.selectpicker').selectpicker !=='undefined')
            {    
                $('.selectpicker').selectpicker({
                    width:'auto'
                });
            }
            $(".dateValue2").datepicker({
                numberOfMonths: 2,
                showButtonPanel: true
            });
            $(".same").each(function(id,feild){
                $(feild).blur(function(e){
                    var str = $(feild).val();
                    var cName = $(feild).prop('class').split(' ');
                    var frase = '';
                    var is_master = false;
                    for(var i = 0;i < cName.length;i++)
                    {
                        if($.trim(cName[i]).split('_')[0]==='same' && $.trim(cName[i]).split('_').length===2)
                            if($.trim(cName[i]).split('_')[1]==='master')
                                is_master = true;
                            else
                                frase = $.trim(cName[i]).split('_')[1];
                    }
                    if(is_master)
                        $(".same_"+frase).val(str);
                });
            });
            $($("[name='s_code_melli']")[0]).focus();
        });
        function openDialog(header,content,okbtn,cancelbtn,fn)
        {
            $("#myModalLabel").html(header);
            if(content)
                $("#myModalBody").html(content);
            $("#myModalOk").html(okbtn);
            $("#myModalOk").prop('onclick',null).off('click');
            if(typeof fn === 'function')
            {
                $("#myModalOk").click(function(){
                    fn();
                    $("#myModal").modal("hide");
                });
            }
            else
            {
                $("#myModal").modal("hide");
            }
            $("#myModalCancel").html(cancelbtn);
            $("#myModal").modal("show");
        }
        var search_flight_data;
        function searchParvaz()
        {
            var aztarikh = $("#s_aztarikh").val().trim();
            var tatarikh = $("#s_tatarikh").val().trim();
            var mabda_id = $("#s_mabda_id").val();
            var maghsad_id = $("#s_maghsad_id").val();
            var p = {
                "aztarikh" : aztarikh,
                "tatarikh" : tatarikh,
                "mabda_id" : mabda_id,
                "maghsad_id" : maghsad_id
            };
            if(aztarikh!=='' && tatarikh !== '' && mabda_id!=='' && maghsad_id !=='')
            {
                $("#stat").show();
                $.getJSON("<?php echo site_url() ?>http_service",p,function(res){
                    $("#stat").hide();
                    $("#parvaz_res").html(res.html);
                    search_flight_data = res.obj;
                    console.log(res);
                }).fail(function(){
                    alert("خطا در دسترسی به سرور");
                    $("#stat").hide();
                });
            }
            else
            {
                alert('اطلاعات را کامل کنید');
            }
        }
        function selectParvaz(i)
        {
            console.log(search_flight_data[i]);
        }
     </script>
</body>
</html>
