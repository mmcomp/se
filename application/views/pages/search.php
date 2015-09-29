<?php
$tmpp = '';
if (isset($_REQUEST['adult'])) {
    $res = new reserve_class();
    $adl = (int) $_REQUEST['adult'];
    $chd = (int) $_REQUEST['child'];
    $inf = (int) $_REQUEST['inf'];
    $class_ghimat = $_REQUEST ['class_ghimat'];
    $ip = getenv("REMOTE_ADDR");
    if (!$ip) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    if (!$ip) {

        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!$ip) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    $agency_id = ((int) $_REQUEST['agency_id']).','.((int) $_REQUEST['agency_id2']);
    $source_id = ((int) $_REQUEST['source_id']).','.((int) $_REQUEST['source_id2']);
    $flight_id = ((int) $_REQUEST['sel_flight_id']).','.((int) $_REQUEST['sel_flight_id2']);
    $flight_id = '191,191';//'191,191'; //Test
    $agency_id = '724,724';//'724,724'; //Test
    $source_id = '1,1';//'1,1';//Test
    $ncap = ((int) $_REQUEST['ncap']).','.((int) $_REQUEST['ncap2']);
    $ncap = '1,1';//'1,1'; //test
    $out = $res->preReserve($source_id, $flight_id, $ncap, $class_ghimat, $adl, $chd, $inf, $ip, $agency_id);
    $data = urlencode(trim($_REQUEST['sel_data']));
    $data2 = urlencode(trim($_REQUEST['sel_data2']));
//    echo "prereserve result:<br/>";
//    var_dump($out);
//    die();
    if ($out['err']['code'] == 0) {
        $voucher_id = $out['voucher_id'];
        $refId = $out['refrence_id'];
        $_SESSION['voucher_id'] = $voucher_id;
        $_SESSION['refrence_id'] = $refId;
        $_SESSION['data'] = rawurldecode($data);
        $_SESSION['adl'] = $adl;
        $_SESSION['chd'] = $chd;
        $_SESSION['inf'] = $inf;
        if($data2!='')
        {
            $_SESSION['data2'] = rawurldecode($data2);
        }
        $_SESSION['price'] = $out['price'];
        $_SESSION['time'] = 600;
        $_SESSION['state'] = 1;
        redirect('reserve1');
    } else {
        $tmpp = <<< tt
        <div class="row">
             <div class="col-sm-2"></div>
             <div class="col-sm-8 alert alert-danger">
               <h1>خطا در رزرو</h1>
             </div>
             <div class="col-sm-2"></div>
        </div>
tt;
    }
}

$my = new mysql_class ();
$query = "SELECT * FROM ads_img WHERE is_home=0 ORDER BY tartib";
$my->ex_sql($query, $images);
$adsRes = "";
foreach ($images as $out) {
    $url = $out ['url'];
    $tmp = "<img class='img-responsive' src=\"%url%\">";
    $adsRes .= str_replace("%url%", $url, $tmp);
}

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!isset($_REQUEST['aztarikh']) || !isset($_REQUEST['tatarikh']) || !isset($_REQUEST['from_city']) || !isset($_REQUEST['to_city'])) {
    redirect('home');
}
$result_tmp = <<< RT
    <div class="row" style="margin-top: 5px; padding:0;">
        <div class="col-sm-12" style="padding:0;">
            <div class="gh-sr-result col-sm-12" style="padding:0 5px 0 0;">
                <table>
                    <tr>
                        <td>#from_city#</td>
                        <td style="padding: 0;">
                            <table>
                                <tr>
                                    <td>
                                        #fdate#
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="#asset_url#images/img/arrow.PNG">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        #ftime# -> #ltime#
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>#to_city#</td>
                        <td style="background-color: #f0f0f0; width:35%;">
                            <p style="font-size: 18px;">#price# تومان</p>
                            <p><button type="button" class="btn btn-info btn-md" onclick="startResv(#index#,#flight_id# ,#ncap#, '#class_ghimat#' , #source_id#, #agency_id#);">ادامه</button><br></p>
                            <p style="font-size: 12px; color: #568fb9">#air_name##icon#</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
RT;
$flight_types = array(
    0 => "",
    1 => "tell.gif",
    2 => "tour.gif",
    3 => "twoway.gif",
    4 => "",
    5 => "",
    6 => "",
    7 => "time.png",
    8 => ""
);
$is_ajax = isset($_REQUEST['isajax']);
$aztarikh = trim($_REQUEST['aztarikh']);
$tatarikh = trim($_REQUEST['tatarikh']);
$from_city = trim($_REQUEST['from_city']);
$to_city = trim($_REQUEST['to_city']);
$way = trim($_REQUEST['way']);
$extra = 'extra';
$airlines_ul = array();
$results = array();
$tmppp = '';
if ($aztarikh != '' && $tatarikh != '' && $from_city != '' && $to_city != '') {
    $results_tmp = search_class::search($aztarikh, $tatarikh, $from_city, $to_city, $extra, isset($_REQUEST['airlines']) ? $_REQUEST['airlines'] : array(), isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'all', $way);
    $results = $results_tmp["data"];
    $flight_results = "<div style='padding:10px; color:red;font-size:18px; font-family:yekan;'>" . 'نتیجه ای یافت نشد.' . "</div>";
    if (count($results) > 0) {
        $flight_results = '';
    }
    foreach ($results as $index => $flight) {
        $res = str_replace("#from_city#", city_class::loadByIata($flight['from_city']), $result_tmp);
        $res = str_replace("#asset_url#", asset_url(), $res);
        $res = str_replace("#to_city#", city_class::loadByIata($flight['to_city']), $res);
        $res = str_replace("#fdate#", $flight['fdate'], $res);
        $res = str_replace("#flight_id#", $flight['flight_id'], $res);
        $res = str_replace("#ncap#", $flight['class'], $res);
        $res = str_replace("#source_id#", $flight['source_id'], $res);
        $res = str_replace("#class_ghimat#", $flight['class_ghimat'], $res);
        $res = str_replace("#agency_id#", $flight['agency_id'], $res);
        $res = str_replace("#ftime#", $flight['ftime'], $res);
        $res = str_replace("#ltime#", $flight['ltime'], $res);
        $res = str_replace("#index#", $index, $res);
        $res = str_replace("#price#", $this->inc_model->monize($flight['price']), $res);
        $res = str_replace("#air_name#", $flight['airline'], $res);
        //$res = str_replace("#air_logo#", $flight['logo_url'], $res);
        $res = str_replace("#site#", $flight['agency_site'], $res);
        $flight_typ = (isset($flight_types[$flight['typ']]) && $flight_types[$flight['typ']] != '') ? '<img style="padding-right:5px;" src="' . asset_url() . 'images/img/' . $flight_types[$flight['typ']] . '" />' : '';
        $res = str_replace("#icon#", $flight_typ, $res);
        $flight_results .= $res;
        if (!in_array($flight['airline'], $airlines_ul)) {
            $airlines_ul[] = $flight['airline'];
        }
    }
    $airline_translate = array(
        array(
            "ایران ایر", "IRAN AIR"
        ),
        array(
            "ماهان", "ماهان", "MAHAN"
        ),
        array(
            "تابان", "TABAN"
        ),
        array(
            "زاگرس", "ZAGROS"
        ),
        array(
            "آتا", "اتا", "ATA"
        ),
        array(
            "کیش ایر"
        )
    );
    if (count($airlines_ul) == 0) {
        //    $airlines_ul = '';
    } else {
        $tmppp = '<ul>';
        for ($i = 0; $i < count($airlines_ul); $i++) {
            $airline_det = '';
            foreach ($airline_translate as $airl) {
                foreach ($airl as $airl_det) {
                    if ($airlines_ul[$i] == $airl_det) {
                        $airline_det = implode("|", $airl);
                    }
                }
            }
            $tmppp .= '<li>' . $airlines_ul[$i] . '<input type="checkbox" value="' . $airline_det . '" checked></li>';
        }
        $tmppp .= '<ul>';
        //$airlines_ul = $tmppp;
    }
} else {
    $flight_results = "<div style='padding:10px; color:red;font-size:18px; font-family:yekan;'>" . 'لطفا مقادیر را برای جستجو کامل وارد کنید.' . "</div>";
}
if ($is_ajax) {
    die($flight_results);
}
?>
<div class="container-fluid" style="margin-top: 10px;">
    <?php echo $tmpp; ?>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8 gh-sp-header gh-border-radius">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-8">
                        <table>
                            <tr>
                                <td class="gh-src-des"><?php echo city_class::loadByIata($from_city); ?></td>
                                <td><img style="padding-left: 3px;" src="<?php echo asset_url(); ?>images/img/left-small.png"></td>
                                <td class="gh-src-des"><?php echo city_class::loadByIata($to_city); ?></td>
                            </tr>
                            <tr>
                                <td class="gh-date"><?php echo $aztarikh; ?></td>
                                <td><img style="padding-left: 3px;" src="<?php echo asset_url(); ?>images/img/dash.png"></td>
                                <td class="gh-date"><?php echo $tatarikh; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3 gh-sp-home"><a href="<?php echo site_url(); ?>">جستجوی مجدد </a></div>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
<div class="container-fluid" style="margin: 10px 0;">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-2" style="padding-right:0; padding-left:10px;">
            <div class="gh-ads-body hidden-xs" style="border: none;">
                <div class="gh-ads-img">
                    <?php echo $adsRes; ?>
                </div>
            </div>
        </div>
        <div class="gh-sp-body col-sm-6 gh-border-radius">
            <div class="row" style="padding: 5px;">
                <!--search filter-->
                <div class="col-sm-4">
                    <div class="row">
                        <div class="gh-alert" style="font-size:16px;">
                            <a class="gh-border-radius" href="#"><img src="<?php echo asset_url(); ?>images/img/alert.PNG">دریافت هشدار قیمت</a>
                        </div>
                    </div>
                    <div class="row">
                        <div data-toggle="collapse" data-target="#stops" class="gh-filter-header" style="margin-top: 5px;">توقف ها</div>
                    </div>
                    <div class="row">
                        <div id="stops" class="collapse in gh-flyght-mode">
                            <ul style="margin: 0;">
                                <li> پرواز مستقیم<input type="checkbox" name="optradio" checked disabled></li>
                                <li>  یک توقف<input type="checkbox" name="optradio" disabled></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <!--<div data-toggle="collapse" data-target="#NULL1" class="gh-filter-header">زمان پرواز</div>-->
                    </div>
                    <div class="row"></div>
                    <div class="row">
                        <div data-toggle="collapse" data-target="#al" class="gh-filter-header">نام ایرلاین</div>
                    </div>
                    <div class="row">
                        <div id="al" class="collapse in gh-air-list">
                            <?php echo $tmppp; ?>

                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header gh-modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">تعداد مسافران</h4>
                                        </div>
                                        <div class="modal-body" style="overflow: hidden;">
                                            <form id="frm1361" style="width: 100%" method="post">
                                                <input type="hidden" id="sel_flight_id" name="sel_flight_id">
                                                <input type="hidden" id="sel_class" name="ncap">
                                                <input type="hidden" id="sel_class_ghimat" name="class_ghimat">
                                                <input type="hidden" id="sel_source_id" name="source_id">
                                                <input type="hidden" id="sel_agency_id" name="agency_id">
                                                <input type="hidden" id="sel_flight_id2" name="sel_flight_id2">
                                                <input type="hidden" id="sel_class2" name="ncap2">
                                                <input type="hidden" id="sel_class_ghimat2" name="class_ghimat2">
                                                <input type="hidden" id="sel_source_id2" name="source_id2">
                                                <input type="hidden" id="sel_agency_id2" name="agency_id2">

                                                <input type="hidden" id="sel_data" name="sel_data" >
                                                <input type="hidden" id="sel_data2" name="sel_data2" >

                                                <input type="hidden" class="aztarikh" name="aztarikh" value="<?php echo $aztarikh; ?>">
                                                <input type="hidden" class="tatarikh" name="tatarikh" value="<?php echo $tatarikh; ?>">
                                                <input type="hidden" id="to_city" name="to_city" value="<?php echo $to_city; ?>">
                                                <input type="hidden" id="from_city" name="from_city" value="<?php echo $from_city; ?>">
                                                <input type="hidden" id="way" name="way" value="<?php echo $way; ?>">

                                                <ul style="width: 100%; font-size: 12px;">
                                                    <li>
                                                        بزرگسال
                                                        <select name="adult">
                                                            <option>
                                                                1
                                                            </option>
                                                            <option>
                                                                2
                                                            </option>
                                                            <option>
                                                                3
                                                            </option>
                                                            <option>
                                                                4
                                                            </option>
                                                            <option>
                                                                5
                                                            </option>
                                                            <option>
                                                                5
                                                            </option>
                                                            <option>
                                                                6
                                                            </option>
                                                            <option>
                                                                7
                                                            </option>
                                                            <option>
                                                                8
                                                            </option>
                                                            <option>
                                                                9
                                                            </option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        کودک ۲ - ۱۲ سال
                                                        <select name="child">
                                                            <option>
                                                                0
                                                            </option>
                                                            <option>
                                                                1
                                                            </option>
                                                            <option>
                                                                2
                                                            </option>
                                                            <option>
                                                                3
                                                            </option>
                                                            <option>
                                                                5
                                                            </option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        نوزاد ۰ - ۲
                                                        <select name="inf">
                                                            <option>
                                                                0
                                                            </option>
                                                            <option>
                                                                1
                                                            </option>
                                                            <option>
                                                                2
                                                            </option>
                                                            <option>
                                                                3
                                                            </option>
                                                            <option>
                                                                4
                                                            </option>
                                                            <option>
                                                                5
                                                            </option>
                                                            <option>
                                                                6
                                                            </option>
                                                            <option>
                                                                7
                                                            </option>
                                                            <option>
                                                                8
                                                            </option>
                                                            <option>
                                                                9
                                                            </option>
                                                        </select>
                                                    </li>
                                                </ul>
                                                <button onclick="$(this).prop('disabled', true);
                                                        $('#frm1361').submit();" style="width: 100%;" class="btn btn-success pull-left">ثبت</button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!--search filter-->
                <!--search result-->
                <div class="col-sm-8">
                    <div class="row" style="padding-right: 5px;">
                        <div class="gh-sr-header" style="font-size: 12px;">
                            مرتب سازی بر اساس  
                            <select class="mm-sort-type" onchange="sortFlight();">
                                <option value = "all">پیش فرض</option>
                                <option value = "price">قیمت پرواز</option>
                                <option value = "fdate">تاریخ</option>
                            </select>

                            <span class="pull-left" style="padding-top:7px;">تعداد نتایج : <?php echo count($results); ?></span>
                        </div>
                    </div>
                    <div class="mm-res-ha">
                        <?php echo $flight_results; ?>
                    </div>
                </div>
                <!--search result-->
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
<script>
    var results = <?php echo json_encode($results); ?>;
    var aztarikh = '<?php echo $aztarikh; ?>';
    var tatarikh = '<?php echo $tatarikh; ?>';
    var from_city = '<?php echo $from_city; ?>';
    var to_city = '<?php echo $to_city; ?>';
    var way = '<?php echo $way; ?>';
    var selected_count = 0;
    var selected_index = [];
    function startResv(index, flight_id, ncap, class_ghimat, source_id, agency_id) {
        //console.log(results[index]);
        if ((way !== 'one' && selected_count === 0) || (way === 'one'))
        {
            selected_count++;
            $("#sel_flight_id").val(flight_id);
            $("#sel_source_id").val(source_id);
            $("#sel_class").val(ncap);
            $("#sel_agency_id").val(agency_id);
            $("#sel_class_ghimat").val(class_ghimat);
            $("#sel_data").val(JSON.stringify(results[index]));
            selected_index.push(index);
            if (way === 'one')
            {
                $("#myModal").modal("show");
                selected_count = 0;
                selected_index = [];
            }
        }
        else if (way !== 'one')
        {
            var raft = results[ selected_index[0]];
            var bargasht = results[index];
            if (raft.from_city === bargasht.to_city && raft.to_city === bargasht.from_city)
            {
                selected_count++;
                $("#sel_flight_id2").val(flight_id);
                $("#sel_source_id2").val(source_id);
                $("#sel_class2").val(ncap);
                $("#sel_agency_id2").val(agency_id);
                $("#sel_class_ghimat2").val(class_ghimat);
                $("#sel_data2").val(JSON.stringify(results[index]));
                selected_index = [];
                $("#myModal").modal("show");
                selected_count = 0;
                selected_index = [];
            }
            else
            {
                alert('پرواز ها می بایست رفت و برگشت باشند');
            }
        }
    }

</script>