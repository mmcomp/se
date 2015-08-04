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
                        <td>#from_city#<br>#fdate# #ftime#</td>
                        <td style="padding: 0;"><img src="#asset_url#images/img/arrow.PNG"></td>
                        <td>#to_city#<br>&nbsp;&nbsp;&nbsp;</td>
                        <td style="background-color: #f0f0f0;">
                            <p style="font-size: 18px;">#price# ریال</p>
                            <p><a href="#">ادامه</a><br></p>
                            <p style="font-size: 10px; color: #568fb9">#air_name#</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
RT;
$aztarikh = trim($_REQUEST['aztarikh']);
$tatarikh = trim($_REQUEST['tatarikh']);
$from_city = trim($_REQUEST['from_city']);
$to_city = trim($_REQUEST['to_city']);
$extra = 'extra';
$results = array();
if ($aztarikh != '' && $tatarikh != '' && $from_city != '' && $to_city != '') {
    $results_tmp = search_class::search($aztarikh, $tatarikh, $from_city, $to_city, $extra);
    $results = $results_tmp["data"];
    $flight_results = "<div style='padding:10px; color:red;font-size:18px; font-family:yekan;'>" . 'نتیجه ای یافت نشد.' . "</div>";
    if (count($results) > 0) {
        $flight_results = 0;
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
        $flight_results .= $res;
    }
} else {
    $flight_results = "<div style='padding:10px; color:red;font-size:18px; font-family:yekan;'>" . 'لطفا مقادیر را برای جستجو کامل وارد کنید.' . "</div>";
}
?>]
<div class="container">
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-2"></div>
        <div class="col-sm-8 gh-sp-header gh-border-radius">
            <div class="row">
                <div class="col-sm-8">
                    <table>
                        <tr>
                            <td class="gh-src-des"><?php echo $from_city; ?></td>
                            <td><img src="<?php echo asset_url(); ?>images/img/left-small.png"></td>
                            <td class="gh-src-des"><?php echo $to_city; ?></td>
                        </tr>
                        <tr>
                            <td class="gh-date">94/11/27</td>
                            <td><img src="<?php echo asset_url(); ?>images/img/dash.png"></td>
                            <td class="gh-date">94/11/28</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-3 gh-sp-home"><a href="<?php echo site_url(); ?>">جستجوی مجدد</a></div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>

<div class="row"style="margin-top: 15px; padding: 5px;">
    <div class="col-sm-2"></div>


    <div class="gh-sp-body col-sm-8 gh-border-radius">
        <div class="row" style="padding: 5px;">

            <!--search filter-->
            <div class="col-sm-4">
                <div class="row">
                    <div class="gh-alert">
                        <a class="gh-border-radius" href="#"><img src="<?php echo asset_url(); ?>images/img/alert.PNG">دریافت هشدار قیمت</a>
                    </div>
                </div>
                <div class="row">
                    <div data-toggle="collapse" data-target="#stops" class="gh-filter-header" style="margin-top: 10px;">توقف ها</div>
                </div>
                <div class="row">
                    <div id="stops" class="collapse gh-onetwo-way">
                        <p>پرواز مستقیم<input type="checkbox" name="optradio"></p>
                        <p>یک توقف<input type="checkbox" name="optradio"></p>
                    </div>
                </div>

                <div class="row">
                    <div data-toggle="collapse" data-target="#NULL1" class="gh-filter-header" style="margin-top: 10px;">زمان پرواز</div>
                </div>
                <div class="row">
                </div>
                <div class="row">
                    <div data-toggle="collapse" data-target="#al" class="gh-filter-header" style="margin-top: 10px;">نام ایرلاین</div>
                </div>
                <div class="row">
                    <div id="al" class="collapse gh-air-list">
                        <ul>
                            <li>ایران ایر<input type="checkbox"></li>
                            <li>ماهان<input type="checkbox"></li>
                            <li>تابان<input type="checkbox"></li>
                            <li>زاگرس<input type="checkbox"></li>
                            <li>آتا<input type="checkbox"></li>
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
                        <select>
                            <option value = "">قیمت پرواز</option>
                            <option value = ""></option>
                            <option value = ""></option>
                            <option value = ""></option>
                        </select>
                        <span class="pull-left">تعداد نتایج : <?php echo count($results); ?></span>
                    </div>
                </div>
                <?php echo $flight_results; ?>
                <!--
                <div class="row" style="margin-top: 10px; padding-right: 5px;">
                    <div class="col-sm-12 gh-no-padding">
                        <div class="gh-sr-result col-sm-12 gh-no-padding">
                            <table>
                                <tr>
                                    <td>مبدا<br>18:35</td>
                                    <td style="padding: 0;"><img src="<?php echo asset_url(); ?>images/img/arrow.PNG"></td>
                                    <td>مقصد<br>22:45</td>
                                    <td style="background-color: #f0f0f0;">
                                        <p style="font-size: 18px;">150000 ریال</p>
                                        <p><a href="#">ادامه</a><br></p>
                                        <p style="font-size: 10px; color: #568fb9">نام ایرلاین</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                -->
            </div>
            <!--search result-->

        </div>
    </div>


    <div class="col-sm-2"></div>
</div>