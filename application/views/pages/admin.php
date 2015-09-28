<?php
if (!isset($_SESSION['user_id'])) {
    redirect("login");
}

function loadImage($id) {
    $i = (int) $_REQUEST['img_index'];
    $tables = array('ads_img', 'tour_img');
    $out = '---';
    $my = new mysql_class;
    $my->ex_sql("select url from " . $tables[$i] . " where id = $id", $q);
    if (isset($q[0])) {
        if (trim($q[0]['url']) != '') {
            $url = trim($q[0]['url']);
            $out = "<a href='$url' target='_blank'><img height='20px' src='$url' ></a>";
        }
    }
    return($out);
}

$menu = '';
$content = '';
$js = '';
$img_state = '';
if (isset($_REQUEST['menu'])) {
    $menu = $_REQUEST['menu'];
    $my = new mysql_class();
    $data = isset($_REQUEST['data']) ? $_REQUEST['data'] : '';
    if ((int) $_REQUEST['load'] == 1) {
        $my->ex_sql("select content from menu where title = '$menu'", $q);
        if (isset($q[0])) {
            $data = $q[0]['content'];
        }
    } else {
        $my->ex_sqlx("update menu set content = '$data' where title = '$menu'");
    }
    if (isset($_FILES['pic'])) {
        $tmp_target_path = "assets/images/ck_img";
        $ext = explode('.', basename($_FILES['pic']['name']));
        $ext = $ext[count($ext) - 1];
        if (strtolower($ext) == 'jpg' || strtolower($ext) == 'png' || strtolower($ext) == 'gif') {
            $target_path = $tmp_target_path . "/" . basename($_FILES['pic']['name']);
            if (move_uploaded_file($_FILES['pic']['tmp_name'], $target_path)) {
                $img_state = "URl = " . asset_url() . "images/ck_img/" . basename($_FILES['pic']['name']) . "<br/>";
            }
        }
    }
    $content = <<<PPPP
            <input id="menu" type="hidden" name="menu" value="$menu" >
            <input id="is_load" type="hidden" name="load" value="1" >
            <textarea id="mm-ck" name="data">$data</textarea>
            <input id="input-1" type="file" class="file" name="pic">
            $img_state
            <a style="margin-top: 5px; padding: 5px 33px;" class="btn btn-success btn-lg pull-left" href="#" onclick="saveData();">ذخیره</a>
PPPP;
    $js = 'CKEDITOR.replace("mm-ck");';
} elseif (isset($_REQUEST['img_index'])) {
    $i = (int) $_REQUEST['img_index'];
    $tables = array('ads_img', 'tour_img');
    if (isset($_FILES['pic'])) {
        $tmp_target_path = "assets/images/ck_img";
        $ext = explode('.', basename($_FILES['pic']['name']));
        $ext = $ext[count($ext) - 1];
        if (strtolower($ext) == 'jpg' || strtolower($ext) == 'png' || strtolower($ext) == 'gif') {
            $target_path = $tmp_target_path . "/" . basename($_FILES['pic']['name']);
            if (move_uploaded_file($_FILES['pic']['tmp_name'], $target_path)) {
                $img_state = asset_url() . "images/ck_img/" . basename($_FILES['pic']['name']);
                $my = new mysql_class;
                if ($i == 1) {
                    $query = "insert into " . $tables[$i] . " (url,tourtitle,tourcontent) values ('" . $img_state . "','" . $_REQUEST['tourtitle'] . "','" . $_REQUEST['tourcontent'] . "')";
                } else {
                    $query = "insert into " . $tables[$i] . " (url) values ('" . $img_state . "')";
                }
                $my->ex_sqlx($query);
            }
        }
    }
    $content = "<input type='hidden' name='img_index' id='img_index' value='$i' ><input id='input-1' type='file' class='file' name='pic'>";
    $gnames = array(
        array(
            "gname_ad" => array('table' => 'ads_img', 'div' => 'div_ad')
        ),
        array(
            "gname_tour" => array('table' => 'tour_img', 'div' => 'div_tour')
        ),
        array(
            "gname_rookeshi" => array('table' => 'rookeshi', 'div' => 'div_rookeshi')
        )
    );
    if (isset($gnames[$i])) {
        foreach ($gnames[$i] as $gname1 => $input1) {
            $input = $gnames[$i];
            //$gname1 = "gname_ad";
            //$input = array($gname1 => array('table' => 'ads_img', 'div' => 'div_ad'));
            $xgrid1 = new xgrid($input, site_url() . 'admin?');
            $xgrid1->eRequest[$gname1] = array("img_index" => $i);
            $xgrid1->pageRows[$gname1] = 10;
            $xgrid1->column[$gname1][0]['name'] = '';
            $xgrid1->canDelete[$gname1] = TRUE;

            if ($i == 0) {
                $xgrid1->column[$gname1][1] = $xgrid1->column[$gname1][0];
                $xgrid1->column[$gname1][1]['name'] = 'تصویر';
                $xgrid1->column[$gname1][1]['access'] = 1;
                $xgrid1->column[$gname1][1]['cfunction'] = array('loadImage');
                $xgrid1->column[$gname1][2]['name'] = '';
                $xgrid1->column[$gname1][3]['name'] = 'صفحه اصلی؟';
                $xgrid1->column[$gname1][3]['clist'] = array(
                    0 => 'نیست',
                    1 => 'است'
                );
                $xgrid1->column[$gname1][4]['name'] = 'ترتیب';
            } else if ($i == 1) {
                $content = '<input name="tourtitle" placeholder="موضوع" class="form-control" ><textarea name="tourcontent" placeholder="جزئیات" class="form-control" ></textarea>' . $content . '<button class="btn btn-danger pull-left">ثبت</button>';
                $xgrid1->column[$gname1][1]['name'] = 'موضوع';
                $xgrid1->column[$gname1][2]['name'] = 'جزئیات';
                $xgrid1->column[$gname1][3] = $xgrid1->column[$gname1][0];
                $xgrid1->column[$gname1][3]['name'] = 'تصویر';
                $xgrid1->column[$gname1][3]['access'] = 1;
                $xgrid1->column[$gname1][3]['cfunction'] = array('loadImage');
                $xgrid1->column[$gname1][4]['name'] = 'ترتیب';
            } else if ($i == 2) {
                $content = '';
                $xgrid1->column[$gname1][1]['name'] = 'منبع';
                $xgrid1->column[$gname1][1]['access'] = 1;
                $xgrid1->column[$gname1][2]['name'] = 'روکشی';
                $xgrid1->canDelete[$gname1] = FALSE;
            }
            $xgrid1->canAdd[$gname1] = FALSE;
            $xgrid1->canEdit[$gname1] = TRUE;
            $out = $xgrid1->getOut($_REQUEST);
            if ($xgrid1->done)
                die($out);
        }
        $js = <<<JSS
                var ggname_ad = '$gname1';
                var args = $xgrid1->arg;
                intialGrid(args);
JSS;
    }
}
?>
<div class="container-fluid">



    <div class="row">
        <h1 style=" display: block; color: #42d3dc; border-bottom: 1px solid #42d3dc; padding: 10px; width: 100%; text-align: center;">
            پنل مدیریتی تیکت یاب 
        </h1>
        <div class="col-sm-12" style="margin: 20px 0 100px 0;">
            <div class="col-sm-2"></div>
            <div class="col-sm 3 gh-admin">
                <ul style="list-style: none;">
                    <li style="color: #fff; border-bottom: 2px solid #fff;">
                        آپشن های مدیریت
                    </li>
                    <li>
                        <a href="#">محتوای منو</a>
                        <ul>
                            <li>
                                <a href="#" onclick="loadMenu('bakhshname');">بخشنامه ها</a>
                            </li>
                            <li>
                                <a href="#" onclick="loadMenu('history');">تاریخچه ایرلاین ها</a>
                            </li>
                            <li>
                                <a href="#" onclick="loadMenu('job');">کاریابی و استخدام</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" onclick="startAdd(0);">عکس های تبلیغات</a>
                    </li>
                    <li>
                        <a href="#" onclick="startAdd(1);">تورها</a>
                    </li>  
                    <li>
                        <a href="#" onclick="startAdd(2);">روکشی</a>
                    </li>  
                    <li>
                        <a href="<?php echo site_url() ?>login">خروج</a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-5" id="base">
                <form method="post" id="frm18" enctype="multipart/form-data">
                    <?php echo $content; ?>
                </form>
                <div id="div_ad"></div>
                <div id="div_tour"></div>
                <div id="div_rookeshi"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>

</div>

<script>
    function startAdd(i)
    {
        $("#frm18").html('<input id="img_index" type="hidden" name="img_index" value="' + i + '" />');
        $("#frm18").submit();
    }
    function loadMenu(menu)
    {
        $("#frm18").html('<input id="menu" type="hidden" name="menu" value="" /><input id="is_load" type="hidden" name="load" value="1" />');
        $("#is_load").val("1");
        $("#menu").val(menu);
        $("#frm18").submit();
    }
    function saveData()
    {
        if ($("#menu").val().trim() !== '')
        {
            $("#is_load").val("0");
            $("#frm18").submit();
        }
        else
        {
            alert('لطفا محتوی را انتخاب کنید');
        }
    }
<?php echo $js; ?>
</script>