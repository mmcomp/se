<?php
$voucher_id = $_SESSION['voucher_id'];
$refrence_id = $_SESSION['refrence_id'];
echo $refrence_id;
$data = $_SESSION['data'];
$adl = (int) $_SESSION['adl'];
$chd = (int) $_SESSION['chd'];
$inf = (int) $_SESSION['inf'];
$gdata = $_SESSION['gdata'];
$flight_info2 = NULL;
if (isset($_SESSION['data2'])) {
    $data2 = $_SESSION['data2'];
    $flight_info2 = json_decode($data2);
}
$flight_info = json_decode($data);
/*
 * TEST
  $gdata = array(
  'total_price' => 10000,
  'adult_price' => 100,
  'child_price' => 50,
  'inf_price' => 25,
  'total_off' => 10000,
  'adult_off' => 100,
  'child_off' => 50,
  );
  $adl = 2;
  $chd = 0;
  $inf = 1;
  $voucher_id = '724001445';
  $refrence_id = '27';
  $data = '{"id":"10018732","source_id":"1","agency_id":"-1","from_city":"MHD","to_city":"THR","flight_number":"6223","flight_id":"2","fdate":"1394-07-04","ftime":"15:00","ltime":"16:15","typ":"0","capacity":"5","class_ghimat":"Y","class":"1","buy_time":"10","airline":"تابان","airplane":"B737-400","description":"","extra":"0","excurrency":"1","extrad":"","price":185000,"currency":"1","public":"0","poursant":"1","day":"0","add_price":"0","tax":"0","taxd":"","no_public":"0","open_price":"0","open_price_currency":"0","agency_site":"www.darvishibooking.ir","bfid":"0","target_capa":"0","tell_time":"60"}';
 */
if (isset($_REQUEST['gender'])) {
    $gender = $_REQUEST ['gender'];
    $fname = $_REQUEST ['fname'];
    $fname_en = $_REQUEST ['fname_en'];
    $lname = $_REQUEST ['lname'];
    $lname_en = $_REQUEST ['lname_en'];
    $shomare_melli = $_REQUEST ['shomare_melli'];
    $passport_engheza = $_REQUEST ['passport_engheza'];
    $birthday = $_REQUEST ['birthday'];
    $mobile = $_REQUEST ['mobile'];
    $address = $_REQUEST ['address'];
    $email = $_REQUEST ['email'];
    $extra_info = $_REQUEST ['extra_info'];
    $age = $_REQUEST ['age'];
    $passengers = array();
    foreach ($gender as $i => $g) {
        $passenger = array(
            "gender" => $gender[$i],
            "age" => $age[$i],
            "fname" => $fname[$i],
            "fname_en" => $fname_en[$i],
            "lname" => $lname[$i],
            "lname_en" => $lname_en[$i],
            "shomare_melli" => $shomare_melli[$i],
            "passport_engheza" => $passport_engheza[$i],
            "birthday" => $birthday[$i]
        );
        $passengers[] = $passenger;
    }
    $sabt_passenger = reserve_class::passengers($refrence_id, $passengers, $mobile, $email, $address, $extra_info);
    if ($sabt_passenger['err']['code'] == 0) {
        $_SESSION ['passengers'] = $passengers;
        redirect('reserve2');
    } else {
        $err = 'در ثبت رزرو شما خطایی رخ داده است. لطفا مجددا تلاش فرمایید.';
//        redirect('home?err=' . $err);
        var_dump($sabt_passenger);
    }
}

$tr = <<<mmcomp
         <tr>
            <td>#no#</td>
            <td>#age#<input type="hidden" value="#age#" name="age[]"></td>
            <td>
                <select name="gender[]">
                    <option value="1">مرد</option>
                    <option value="0">زن</option>
                </select>
            </td>
            <td>
                <input name="fname[]" type="text" placeholder="فارسی">
                <input name="fname_en[]" style="direction: ltr" type="text" placeholder="EN">
            </td>
            <td>
                <input name="lname[]" type="text" placeholder="فارسی">
                <input name="lname_en[]" style="direction: ltr" type="text" placeholder="EN">
            </td>
            <td>
                <input name="shomare_melli[]" type="text">
                <input name="passport_engheza[]" type="text" placeholder="انقضای پاسپورت" title="بصورت : روز-ماه-سال">
            </td>
            <td><input name="birthday[]" type="text" title="بصورت : روز-ماه-سال" placeholder="بصورت : روز-ماه-سال"></td>
        </tr>
mmcomp;

$trs = <<<ghh
            <tr>
                <td>ردیف</td>
                <td>#no#</td>
            </tr>
            <tr>
                <td>سن</td>
                <td>#age#<input type="hidden" value="#age#" name="age[]"></td>
            </tr>
            <tr>
                <td>جنسیت</td>
                <td>
                    <select name="gender[]">
                        <option value="1">مرد</option>
                        <option value ="0">زن</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>نام</td>
                <td>
                    <input name="fname[]" type="text" placeholder="فارسی">
                    <input name="fname_en[]" style="direction: ltr" type="text" placeholder="EN">
                </td>
            </tr>
            <tr>
                <td>نام خانوادگی</td>
                <td>
                    <input name="lname[]" type="text" placeholder="فارسی">
                    <input name="lname_en[]" style="direction: ltr" type="text" placeholder="EN">
                </td>
            </tr>
            <tr>
                <td>شماره ملی - شماره پاسپورت</td>
                <td>
                    <input name="shomare_melli[]" type="text">
                    <input name="passport_engheza[]" type="text" placeholder="تاریخ انقضای پاسپورت" title="بصورت : 25-11-1395">
                </td>
            </tr>
            <tr style="border-bottom: 2px solid #ddd;">
                <td>تاریخ تولد</td>
                <td><input name="birthday[]" type="text" title="بصورت : روز-ماه-سال" placeholder="بصورت : روز-ماه-سال"></td>
            </tr>
ghh;

$adl_bill = '';
$chd_bill = '';
$inf_bill = '';
if ($adl != 0) {
    $adl_bill = <<<mmgh
        <tr>
            <td>
                پرواز
                (adult)
            </td>
            <td>
                $adl نفر
            </td>
            <td>
                1000 تومان
            </td>
            <td>
               1212
            </td>
            <td>
                1212142 تومان
            </td>
        </tr>
mmgh;
}
if ($chd != 0) {
    $chd_bill = <<<mmgh
        <tr>
            <td>
                پرواز
                (child)
            </td>
            <td>
                $chd نفر
            </td>
            <td>
                564547 تومان
            </td>
            <td>
               57676
            </td>
            <td>
                69769769 تومان
            </td>
        </tr>
mmgh;
}
if ($inf != 0) {
    $inf_bill = <<<mmgh
        <tr>
            <td>
                پرواز
                (infant)
            </td>
            <td>
                $inf نفر
            </td>
            <td>
               5657578 تومان
            </td>
            <td>
                43463
            </td>
            <td>
                1000 تومان
            </td>
        </tr>
mmgh;
}
$tr_large = '';
$tr_small = '';
$no = 1;
for ($i = 0; $i < $adl; $i++) {
    $tr_tmp = $tr;
    $trs_tmp = $trs;
    $tr_tmp = str_replace('#no#', $no, $tr_tmp);
    $tr_tmp = str_replace('#age#', 'adult', $tr_tmp);
    $trs_tmp = str_replace('#no#', $no, $trs_tmp);
    $trs_tmp = str_replace('#age#', 'adult', $trs_tmp);
    $tr_large .= $tr_tmp;
    $tr_small.=$trs_tmp;
    $no++;
}
for ($i = 0; $i < $chd; $i++) {
    $tr_tmp = $tr;
    $trs_tmp = $trs;

    $tr_tmp = str_replace('#no#', $no, $tr_tmp);
    $tr_tmp = str_replace('#age#', 'child', $tr_tmp);
    $trs_tmp = str_replace('#no#', $no, $trs_tmp);
    $trs_tmp = str_replace('#age#', 'child', $trs_tmp);
    $tr_large .= $tr_tmp;
    $tr_small.=$trs_tmp;
    $no++;
}
for ($i = 0; $i < $inf; $i++) {
    $tr_tmp = $tr;
    $trs_tmp = $trs;
    $tr_tmp = str_replace('#no#', $no, $tr_tmp);
    $tr_tmp = str_replace('#age#', 'infant', $tr_tmp);
    $trs_tmp = str_replace('#no#', $no, $trs_tmp);
    $trs_tmp = str_replace('#age#', 'infant', $trs_tmp);
    $tr_large .= $tr_tmp;
    $tr_small.=$trs_tmp;
    $no++;
}
?>
<div class="container" style="margin: 10px auto;">
    <div class="row">
        <div class="col-sm-12 countdown-body" style="margin-bottom: 10px;">
            <header>
                <div>
                    زمان باقی مانده رزرو
                    <span id="time">10:00</span>
                </div>
            </header>
        </div><!--reserve-countdown-->
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 hidden-sm hidden-xs flight-summery-body" style="margin-bottom: 10px;">
            <header>اطلاعات پرواز</header>
            <ul>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>مبدا : </span><?php echo $flight_info->from_city; ?></li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>مقصد : </span><?php echo $flight_info->to_city; ?></li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>تاریخ : </span><?php echo $flight_info->fdate; ?></li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>ایرلاین : </span><?php echo $flight_info->airline; ?></li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>شماره پرواز : </span><?php echo $flight_info->flight_number; ?></li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>ساعت خروج :</span><?php echo $flight_info->ftime; ?></li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>ساعت ورود : </span><?php echo $flight_info->ltime; ?></li>
            </ul>
            <?php if ($flight_info2 != NULL) { ?>
                <ul>
                    <li class="visible-lg-inline-block visible-md-inline-block"><span>مبدا : </span><?php echo $flight_info2->from_city; ?></li>
                    <li class="visible-lg-inline-block visible-md-inline-block"><span>مقصد : </span><?php echo $flight_info2->to_city; ?></li>
                    <li class="visible-lg-inline-block visible-md-inline-block"><span>تاریخ : </span><?php echo $flight_info2->fdate; ?></li>
                    <li class="visible-lg-inline-block visible-md-inline-block"><span>ایرلاین : </span><?php echo $flight_info2->airline; ?></li>
                    <li class="visible-lg-inline-block visible-md-inline-block"><span>شماره پرواز : </span><?php echo $flight_info2->flight_number; ?></li>
                    <li class="visible-lg-inline-block visible-md-inline-block"><span>ساعت خروج :</span><?php echo $flight_info2->ftime; ?></li>
                    <li class="visible-lg-inline-block visible-md-inline-block"><span>ساعت ورود : </span><?php echo $flight_info2->ltime; ?></li>
                </ul>
            <?php } ?>
        </div><!--flight-summery-large-->
        <div class="col-sm-4 col-xs-12 hidden-lg hidden-md flight-summery-body">
            <header>اطلاعات پرواز</header>
            <ul style="text-align: right;">
                <li class="visible-sm-inline-block visible-xs-block"><span>مبدا : </span>مشهد</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>مقصد : </span>کوالالامپور</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>تاریخ : </span>1395/6/21</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>ایرلاین : </span>آسمان</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>شماره پرواز : </span>5698</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>ساعت خروج :</span>22:45</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>ساعت ورود : </span>5:45</li>
            </ul>
            <ul style="text-align: right;">
                <li class="visible-sm-inline-block visible-xs-block"><span>مبدا : </span>کوالالامپور</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>مقصد : </span>مشهد</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>تاریخ : </span>1395/6/21</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>ایرلاین : </span>آسمان</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>شماره پرواز : </span>5698</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>ساعت خروج :</span>22:45</li>
                <li class="visible-sm-inline-block visible-xs-block"><span>ساعت ورود : </span>5:45</li>
            </ul>
        </div><!--flight-summery-small-->
        <div class="col-lg-12 col-md-12 col-sm-8 col-xs-12 passenger-info-body" style="margin-bottom: 10px;">
            <header>اطلاعات مسافران</header>
            <div class="passenger-info-box">
                <form method="post" id="form_large">
                    <table class="visible-lg visible-md table passenger-info-table-large">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>سن</th>
                                <th>جنسیت</th>
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>شماره ملی - شماره پاسپورت</th>
                                <th>تاریخ تولد</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $tr_large ?>
                        </tbody>
                    </table>
                    <table class="visible-lg visible-md passenger-extra-info-large">
                        <thead>
                            <tr>
                                <th>تلفن همراه</th>
                                <th>آدرس</th>
                                <th>پست الکترونیک</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input name="mobile" type="text"></td>
                                <td><input name="address" type="text"></td>
                                <td><input name="email" type="text"></td>
                                <td><input name="extra_info" type="text"></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <form method="post" id="form_small">
                    <table class="visible-sm visible-xs table passenger-info-table-small">
                        <?php echo $tr_small; ?>
                    </table>
                    <table class="visible-sm visible-xs passenger-extra-info-small">
                        <tr>
                            <td>تلفن همراه</td>
                            <td><input name="mobile" type="text"></td>
                        </tr>
                        <tr>
                            <td>آدرس</td>
                            <td><input name="address" type="text"></td>
                        </tr>
                        <tr>
                            <td>پست الکترونیک</td>
                            <td><input name="email" type="text"></td>

                        </tr>
                        <tr>
                            <td>ملاحظات</td>
                            <td><input name="extra_info" type="text"></td>
                        </tr>
                    </table>
                </form>
            </div><!--passenger-info-box-->
        </div><!--passenger-info-body-->
    </div>
    <div class="row">
        <div class="payment-body col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
            <header>شرح پرداخت</header>
            <div class="payment-box">
                <table class="table">
                    <thead>
                        <tr>
                            <th>شرح</th>
                            <th>تعداد</th>
                            <th>قیمت واحد</th>
                            <th>کمیسیون</th>
                            <th>قابل پرداخت</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>جمع</td>
                            <td>0</td>
                            <td>480.000 تومان</td>
                        </tr>
                    </tfoot>
                    <tbody>
<!--                            <tr>
                            <td>
                                پرواز
                                (adult)
                            </td>
                            <td>
                                2 نفر
                            </td>
                            <td>
                                120.000 تومان
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                240.000 تومان
                            </td>
                        </tr>-->
                        <?php echo $adl_bill; ?>
                        <?php echo $chd_bill; ?>
                        <?php echo $inf_bill; ?>
                    </tbody>
                </table>
                <button onclick="sabt(1);" class="visible-lg visible-md">ثبت رزرو</button>
                <button onclick="sabt(0);" class="visible-sm visible-xs">ثبت رزرو</button>
                <a href="<?php echo site_url(); ?>home">لغو رزرو</a>

            </div><!--payment-box-->
        </div><!--payment-body-->
    </div>
</div>
<script>
    function sabt(i) {
        if (i === 1) {
            $("#form_large").submit();
        }
        else {
            $("#form_small").submit();
        }
    }
</script>