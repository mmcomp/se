<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!isset($_REQUEST['aztarikh']) || !isset($_REQUEST['tatarikh']) || !isset($_REQUEST['from_city']) || !isset($_REQUEST['to_city'])) {
    redirect('home');
}
$result_tmp = <<< RT
           <div class = "gh-search-result">
            <div class = "gh-search-result-right">
                <div class="gh-search-result-right-body">
                    <div class = "gh-search-result-logo"><img src="#asset_url##air_logo#"></div>
                    <span class = "gh-src">#from_city#<br>#fdate#</span><img class = "gh-arrow-img" src = "#asset_url#images/img/arrow.PNG"><span class = "gh-des">#to_city#<br>#fdate#</span>
                </div>
                <a href="#">جزئیات</a>
            </div>
            <div class = "gh-search-result-left"><p>#price# ریال </p><a href="#"><img src="#asset_url#images/img/continue.png"></a><br><span>#air_name#</span></div>
        </div>
RT;
$aztarikh = trim($_REQUEST['aztarikh']);
$tatarikh = trim($_REQUEST['tatarikh']);
$from_city = trim($_REQUEST['from_city']);
$to_city = trim($_REQUEST['to_city']);
$extra = 'extra';
if ($aztarikh != '' && $tatarikh != '' && $from_city != '' && $to_city != '') {
    $results_tmp = search_class::search($aztarikh, $tatarikh, $from_city, $to_city, $extra);
    $results = $results_tmp["data"];
    $flight_results = 'نتیجه ای یافت نشد.';
    if (count($results) > 0) {
        $flight_results = 0;
    }
    foreach ($results as $flight) {
        $res = str_replace("#from_city#", city_class::loadByIata($flight['from_city']), $result_tmp);
        $res = str_replace("#asset_url#", asset_url(), $res);
        $res = str_replace("#to_city#", city_class::loadByIata($flight['to_city']), $res);
        $res = str_replace("#fdate#", $flight['fdate'], $res);
        $res = str_replace("#price#", $this->inc_model->monize($flight['price']), $res);
        $res = str_replace("#air_name#", $flight['airline'], $res);
        $res = str_replace("#air_logo#", $flight['logo_url'], $res);
        $flight_results .= $res;
    }
} else {
    $flight_results = "<div class='gh-alert'>" . 'لطفا مقادیر را برای جستجو کامل وارد کنید.' . "</div>";
}
?>
<div class = "gh-middle">
    <div class = "gh-search-header">
        <div class = "gh-city-time-right"><?php echo city_class::loadByIata($from_city); ?>
            <br>
            <?php echo $this->inc_model->fixDate($aztarikh); ?>
        </div>
        <div class = "gh-city-time-img"><img src = "<?php echo asset_url(); ?>images/img/city-time.PNG"></div>
        <div class = "gh-city-time-left">
            <?php echo city_class::loadByIata($to_city); ?>
            <br>
            <?php echo $this->inc_model->fixDate($tatarikh); ?>
        </div>
        <a href = "<?php echo site_url(); ?>home">جستجوی مجدد</a>
    </div>
</div>
<!--middle-->
<div class = "gh-sp gh-border-radius">
    <div class = "gh-sp-extra-bar"></div>
    <div class = "gh-sp-right">
        <div class = "gh-right-header gh-border-radius">دریافت هشدار قیمت</div>
        <div class = "gh-left-header-first">توقف ها</div>
        <div class = "gh-sp-stops">
            <span>پرواز مستقیم<input type = "radio" name = "f-detile" value = "straigt" checked></span>
            <span>یک توقف<input type = "radio" name = "f-detile" value = "intrupt"></span>
        </div>
        <div class = "gh-left-header-other">زمان پرواز</div>
        <div class = "gh-sp-flight-time"></div>
        <div class = "gh-left-header-other">نام ایرلاین</div>
        <div class = "gh-sp-airline-name">
            <div class = "gh-sp-airline-name-sub">
                <span style = "border-left: 1px solid #9e9e9e;">انتخاب همه</span>
                <span>حذف همه</span>
            </div>
            <table>
                <tr>
                    <td>ایران ایر</td>
                    <td>154584</td>
                    <td><input type = "checkbox" name = "" value = ""></td>
                </tr>
                <tr>
                    <td>ماهان</td>
                    <td>154584</td>
                    <td><input type = "checkbox" name = "" value = ""></td>
                </tr>
                <tr>
                    <td>تابان</td>
                    <td>154584</td>
                    <td><input type = "checkbox" name = "" value = ""></td>
                </tr>
                <tr>
                    <td>زاگرس</td>
                    <td>154584</td>
                    <td><input type = "checkbox" name = "" value = ""></td>
                </tr>
                <tr>
                    <td>آتا</td>
                    <td>154584</td>
                    <td><input type = "checkbox" name = "" value = ""></td>
                </tr>
            </table>
        </div>
    </div>
    <div class = "gh-sp-left">
        <div class = "gh-sp-sort-bar">مرتب سازی بر اساس
            <select>
                <option value = "">قیمت پرواز</option>
                <option value = ""></option>
                <option value = ""></option>
                <option value = ""></option>
            </select>
            <span> تعداد نتایج : <?php echo count($results); ?></span>
        </div>
        <?php echo $flight_results ?>
    </div>
</div>
