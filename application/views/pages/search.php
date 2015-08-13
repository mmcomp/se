<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!isset($_REQUEST['aztarikh']) || !isset($_REQUEST['tatarikh']) || !isset($_REQUEST['from_city']) || !isset($_REQUEST['to_city'])) {
    redirect('home');
}
$result_tmp = <<< RT
    <div class="row" style="margin-top: 10px; padding-right: 5px;">
        <div class="col-sm-12 gh-no-padding">
            <div class="gh-sr-result col-sm-12 gh-no-padding">
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
                        <td style="background-color: #f0f0f0;">
                            <p style="font-size: 18px;">#price# تومان</p>
                            <p><a target='_blank' href="#site#">انتخاب</a><br></p>
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
$results = array();
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
        $res = str_replace("#ftime#", $flight['ftime'], $res);
        $res = str_replace("#price#", $this->inc_model->monize($flight['price']), $res);
        $res = str_replace("#air_name#", $flight['airline'], $res);
        $res = str_replace("#air_logo#", $flight['logo_url'], $res);
        $res = str_replace("#site#", $flight['agency_site'], $res);
        $flight_typ = (isset($flight_types[$flight['typ']]) && $flight_types[$flight['typ']] != '') ? '<img style="padding-right:5px;" src="' . asset_url() . 'images/img/' . $flight_types[$flight['typ']] . '" />' : '';
        $res = str_replace("#icon#", $flight_typ, $res);
        $flight_results .= $res;
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
                                <td><img src="<?php echo asset_url(); ?>images/img/left-small.png"></td>
                                <td class="gh-src-des"><?php echo city_class::loadByIata($to_city); ?></td>
                            </tr>
                            <tr>
                                <td class="gh-date"><?php echo $aztarikh; ?></td>
                                <td><img src="<?php echo asset_url(); ?>images/img/dash.png"></td>
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
        <div class="col-sm-2 gh-no-padding">
            <div class="gh-ads-body hidden-xs" style="border: none;">
                <div class="gh-ads-img">
                    <img class="img-responsive" src="<?php echo asset_url(); ?>images/img/ads1.png">
                </div>
                <div class="gh-ads-img">
                    <img class="img-responsive" src="<?php echo asset_url(); ?>images/img/ads2.png">
                </div>
                <div class="gh-ads-img">
                    <img class="img-responsive" src="<?php echo asset_url(); ?>images/img/ads3.png">
                </div>
            </div>
        </div>
        <div class="gh-sp-body col-sm-6 gh-border-radius">
            <div class="row" style="padding: 5px;">
                <!--search filter-->
                <div class="col-sm-4">
                    <div class="row">
                        <div class="gh-alert">
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
                            <ul>
                                <li>ایران ایر<input type="checkbox" value="ایران ایر|IRAN AIR"></li>
                                <li>ماهان<input type="checkbox" value="ماهان|ماهان|MAHAN"></li>
                                <li>تابان<input type="checkbox" value="تابان|TABAN"></li>
                                <li>زاگرس<input type="checkbox" value="زاگرس|ZAGROS"></li>
                                <li>آتا<input type="checkbox" value="آتا|اتا|ATA|"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--search filter-->
                <!--search result-->
                <div class="col-sm-8">
                    <div class="row" style="padding-right: 5px;">
                        <div class="gh-sr-header">
                            مرتب سازی بر اساس  
                            <select class="mm-sort-type" onchange="sortFlight();">
                                <option value = "all">پیش فرض</option>
                                <option value = "price">قیمت پرواز</option>
                                <option value = "fdate">تاریخ</option>
                            </select>

                            <span class="pull-left">تعداد نتایج : <?php echo count($results); ?></span>
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
</script>
