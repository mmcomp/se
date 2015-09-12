<?php
if (isset($_REQUEST['adult'])) {
    $res = new reserve_class();
    $adult = (int) $_REQUEST['adult'];
    $child = (int) $_REQUEST['child'];
    $inf = (int) $_REQUEST['inf'];
    $flight_id = (int) $_REQUEST['sel_flight_id'];
    $flight_id = 192; //Test
    $ncap = (int) $_REQUEST['ncap'];
    $out = $res->preReserve(-10, 724, $flight_id, $ncap, 0, 0, $adult, $child, $inf);
    if ($out->error->error_code == 0) {
        $voucher_id = $out->voucher_id;
        redirect('passenger?voucher_id=' . $voucher_id);
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
                                        #ftime#
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>#to_city#</td>
                        <td style="background-color: #f0f0f0; width:35%;">
                            <p style="font-size: 18px;">#price# تومان</p>
                            <p><button type="button" class="btn btn-info btn-md" onclick="startResv(#flight_id# ,#ncap#);">ادامه</button><br></p>
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
    foreach ($results as $flight) {
        $res = str_replace("#from_city#", city_class::loadByIata($flight['from_city']), $result_tmp);
        $res = str_replace("#asset_url#", asset_url(), $res);
        $res = str_replace("#to_city#", city_class::loadByIata($flight['to_city']), $res);
        $res = str_replace("#fdate#", $flight['fdate'], $res);
        $res = str_replace("#flight_id#", $flight['flight_id'], $res);
        $res = str_replace("#ncap#", $flight['class'], $res);
        $res = str_replace("#ftime#", $flight['ftime'], $res);
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
                        <div data-toggle="collapse" data-target="#NULL1" class="gh-filter-header">زمان پرواز</div>
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
                                            <form style="width: 100%" method="post">
                                                <input type="hidden" id="sel_flight_id" name="sel_flight_id">
                                                <input type="hidden" id="sel_class" name="ncap">

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
                                                <button style="width: 100%;" class="btn btn-success pull-left">ثبت</button>
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

    var aztarikh = '<?php echo $aztarikh; ?>';
    var tatarikh = '<?php echo $tatarikh; ?>';
    var from_city = '<?php echo $from_city; ?>';
    var to_city = '<?php echo $to_city; ?>';
    var way = '<?php echo $way; ?>';
    function startResv(flight_id, ncap) {
        $("#sel_flight_id").val(flight_id);
        $("#sel_class").val(ncap);
        $("#myModal").modal("show");
    }

</script>