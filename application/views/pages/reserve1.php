<?php
$voucher_id = $_SESSION['voucher_id'];
$refrence_id = $_SESSION['refrence_id'];
$data = $_SESSION['data'];
$adl = (int) $_SESSION['adl'];
$chd = (int) $_SESSION['chd'];
$inf = (int) $_SESSION['inf'];
$price = $_SESSION['price'];
$flight_info2 = NULL;
$rookeshi2 = 0;
$flight_info = json_decode($data);
$rookeshi = rookeshi_class::get($flight_info->source_id);
if (isset($_SESSION['data2'])) {
    $data2 = $_SESSION['data2'];
    $flight_info2 = json_decode($data2);
    $rookeshi2 = rookeshi_class::get($flight_info2->source_id);
}
if (!isset($_SESSION['state'])) {
    redirect("home");
} else {
    if ((int) $_SESSION['state'] == 2) {
        redirect("reserve2");
    } else if ((int) $_SESSION['state'] != 1) {
        redirect("home");
    }
}
$time = (int) $_SESSION['time'];
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}
$start_time = $_SESSION['start_time'];
$now = time();
if ($now - $start_time > $time) {
    redirect("home?err=زمان به پایان رسید");
}
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
    var_dump($passenger);
    if ($sabt_passenger['err']['code'] == 0) {
        $_SESSION ['passengers'] = $passengers;
        $_SESSION['address'] = $address;
        $_SESSION['email'] = $email;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['extra_info'] = $extra_info;
        $_SESSION['state'] = 2;
        redirect('reserve2');
    } else {
        $err = 'در ثبت رزرو شما خطایی رخ داده است. لطفا مجددا تلاش فرمایید.';
        //redirect('home?err=' . $err);
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
                <input name="fname[]" type="text" placeholder="فارسی" class="inp1 lname">
                <input name="fname_en[]" style="direction: ltr" type="text" placeholder="EN" class="inp1 lname">
            </td>
            <td>
                <input name="lname[]" type="text" placeholder="فارسی" class="inp1 lname">
                <input name="lname_en[]" style="direction: ltr" type="text" placeholder="EN" class="inp1 lname">
            </td>
            <td>
                <input name="shomare_melli[]" type="text" class="inp1 shomare_melli_passport">
                <input name="passport_engheza[]" type="text" placeholder="انقضای پاسپورت" title="بصورت : روز-ماه-سال" class="inp1 passport_engheza">
            </td>
            <td><input name="birthday[]" type="text" title="بصورت : روز-ماه-سال" placeholder=" روز-ماه-سال" class="inp1 birthday"></td>
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
                    <input name="fname[]" type="text" placeholder="فارسی" class="inp2 lname">
                    <input name="fname_en[]" style="direction: ltr" type="text" placeholder="EN" class="inp2 lname">
                </td>
            </tr>
            <tr>
                <td>نام خانوادگی</td>
                <td>
                    <input name="lname[]" type="text" placeholder="فارسی" class="inp2 lname">
                    <input name="lname_en[]" style="direction: ltr" type="text" placeholder="EN" class="inp2 lname">
                </td>
            </tr>
            <tr>
                <td>شماره ملی - شماره پاسپورت</td>
                <td>
                    <input name="shomare_melli[]" type="text" class="inp2 shomare_melli_passport">
                    <input name="passport_engheza[]" type="text" placeholder="تاریخ انقضای پاسپورت" title="بصورت : 25-11-1395" class="inp2 passport_engheza">
                </td>
            </tr>
            <tr style="border-bottom: 2px solid #ddd;">
                <td>تاریخ تولد</td>
                <td><input name="birthday[]" type="text" title="بصورت : روز-ماه-سال" placeholder=" روز-ماه-سال" class="inp2 birthday"></td>
            </tr>
ghh;

$adl_bill = '';
$chd_bill = '';
$inf_bill = '';

$b_adl_bill = '';
$b_chd_bill = '';
$b_inf_bill = '';

//parvaz raft price
$adl_tax = 0;
$chd_tax = 0;
$inf_tax = 0;
$adl_price = $price['adult_price'] + $rookeshi;
$chd_price = $price['child_price'] + $rookeshi;
$inf_price = $price['inf_price'] + $rookeshi;
$adl_total_price = ($adl_tax + $adl_price) * $adl;
$chd_total_price = ($chd_tax + $chd_price) * $chd;
$inf_total_price = ($inf_tax + $inf_price) * $inf;
$total_price = $adl_total_price + $chd_total_price + $inf_total_price;


//parvaz bargasht price
$b_adl_tax = 0;
$b_chd_tax = 0;
$b_inf_tax = 0;
$b_adl_price = $price['badult_price'] + $rookeshi2;
$b_chd_price = $price['bchild_price'] + $rookeshi2;
$b_inf_price = $price['binf_price'] + $rookeshi2;
$b_adl_total_price = ($b_adl_tax + $b_adl_price) * $adl;
$b_chd_total_price = ($b_chd_tax + $b_chd_price) * $chd;
$b_inf_total_price = ($b_inf_tax + $b_inf_price) * $inf;
$b_total_price = $adl_total_price + $chd_total_price + $inf_total_price + $b_adl_total_price + $b_chd_total_price + $b_inf_total_price;

$_SESSION['tprice'] = (isset($_SESSION['data2']))?$b_total_price:$total_price;
$_SESSION['aprice'] = $price['total_price'];

if ($adl != 0) {
    $adl_bill = <<<mmgh
        <tr>
            <td>
                پرواز رفت
                (adult)
            </td>
            <td>
                $adl نفر
            </td>
            <td>
               $adl_price تومان
            </td>
            <td>
               $adl_tax
            </td>
            <td>
                $adl_total_price تومان
            </td>
        </tr>
mmgh;

    $b_adl_bill = <<<mmgh
        <tr>
            <td>
             پرواز برگشت
                (adult)
            </td>
            <td>
                $adl نفر
            </td>
            <td>
                $b_adl_price تومان
            </td>
            <td>
               $b_adl_tax
            </td>
            <td>
                $b_adl_total_price تومان
            </td>
        </tr>
mmgh;
}

if ($chd != 0) {
    $chd_bill = <<<mmgh
        <tr>
            <td>
               پرواز رفت
                (child)
            </td>
            <td>
                $chd نفر
            </td>
            <td>
                $chd_price تومان
            </td>
            <td>
               $chd_tax
            </td>
            <td>
                $chd_total_price تومان
            </td>
        </tr>
mmgh;

    $b_chd_bill = <<<mmgh
        <tr>
            <td>
                پرواز برگشت
                (child)
            </td>
            <td>
                $chd نفر
            </td>
            <td>
                $b_chd_price تومان
            </td>
            <td>
               $b_chd_tax
            </td>
            <td>
                $b_chd_total_price تومان
            </td>
        </tr>
mmgh;
}
if ($inf != 0) {
    $inf_bill = <<<mmgh
        <tr>
            <td>
               پرواز رفت
                (infant)
            </td>
            <td>
                $inf نفر
            </td>
            <td>
                $inf_price تومان
            </td>
            <td>
               $inf_tax
            </td>
            <td>
                $inf_total_price تومان
            </td>
        </tr>
mmgh;

    $b_inf_bill = <<<mmgh
        <tr>
            <td>
                پرواز برگشت
                (infant)
            </td>
            <td>
                $inf نفر
            </td>
            <td>
                $b_inf_price تومان
            </td>
            <td>
               $b_inf_tax
            </td>
            <td>
                $b_inf_total_price تومان
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
                            <th>مالیات</th>
                            <th>قابل پرداخت</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>جمع</td>
                            <td>0</td>
                            <td>
                                <?php
                                if ($flight_info2 != NULL) {
                                    echo $b_total_price . ' تومان';
                                } else {
                                    echo $total_price . ' تومان';
                                }
                                ?>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php echo $adl_bill; ?>
                        <?php echo $chd_bill; ?>
                        <?php echo $inf_bill; ?>
                    </tbody>
                    <?php if ($flight_info2 != NULL) { ?>
                        <tbody>
                            <?php echo $b_adl_bill; ?>
                            <?php echo $b_chd_bill; ?>
                            <?php echo $b_inf_bill; ?>
                        </tbody>
                    <?php } ?>
                </table>

                <button onclick="sabt(1);" class="visible-lg visible-md">ثبت رزرو</button>
                <button onclick="sabt(0);" class="visible-sm visible-xs">ثبت رزرو</button>
                <form action="home">
                    <button class="">لغو رزرو</button>
                </form>

            </div><!--payment-box-->
        </div><!--payment-body-->
    </div>
</div>
<script>
    var all = <?php echo (int) $_SESSION['time']; ?>;
    var start_time = <?php echo $_SESSION['start_time']; ?>;
    var d = new Date();
    var std = new Date(start_time);
    var current_time = parseInt(d.getTime() / 1000, 10);
    function sabt(i) {
        $(".warn").remove();
        if (i === 1) {
            var ok = true;
            $(".inp1").each(function (id, feild) {

                if ($(feild).hasClass("lname"))
                {
                    if (String($(feild).val()).length < 3)
                    {
                        $(feild).after("<div style='color:red;' class='warn'>" + 'این فیلد باید کامل وارد شود' + "</div>");
                        ok = false;
                    }
                }
                if ($(feild).hasClass("shomare_melli_passport"))
                {
                    if (String($(feild).val()).length < 10)
                    {
                        $(feild).after("<div style='color:red;' class='warn'>" + 'این فیلد باید کامل وارد شود' + "</div>");
                        ok = false;
                    }
                }
                if ($(feild).hasClass("birthday"))
                {
                    if (String($(feild).val()).length < 10)
                    {
                        $(feild).after("<div style='color:red;' class='warn'>" + 'این فیلد باید کامل وارد شود' + "</div>");
                        ok = false;
                    }
                }
            });
            if (ok === true)
            {
                $("#form_large").submit();
            }
        }
        else {
            var ok = true;
            $(".inp2").each(function (id, feild) {

                if ($(feild).hasClass("lname"))
                {
                    if (String($(feild).val()).length < 3)
                    {
                        $(feild).after("<div style='color:red;' class='warn'>" + 'این فیلد باید کامل وارد شود' + "</div>");
                        ok = false;
                    }
                }
                if ($(feild).hasClass("shomare_melli_passport"))
                {
                    if (String($(feild).val()).length < 10)
                    {
                        $(feild).after("<div style='color:red;' class='warn'>" + 'این فیلد باید کامل وارد شود' + "</div>");
                        ok = false;
                    }
                }
                if ($(feild).hasClass("birthday"))
                {
                    if (String($(feild).val()).length < 10)
                    {
                        $(feild).after("<div style='color:red;' class='warn'>" + 'این فیلد باید کامل وارد شود' + "</div>");
                        ok = false;
                    }
                }
            });
            if (ok === true)
            {
                $("#form_small").submit();
            }
        }
    }
    var timer;
    function createTime(inp)
    {
//        console.log(inp);
        var m = (inp - (inp % 60)) / 60;
        var s = inp % 60;
        if (m < 10)
            m = '0' + m;
        if (s < 10)
            s = '0' + s;
        return(m + ':' + s);
    }
    function fn()
    {
        d = new Date();
        current_time = parseInt(d.getTime() / 1000, 10);

        if (current_time - start_time > all)
        {
            $(".container").html('<a href="<?php echo site_url(); ?>home?err=پایان مهلت ورود اطلاعات">بازگشت</a>');
            alert('مهلت شما به پایان رسید');
            window.location = '<?php echo site_url(); ?>home?err=پایان مهلت';
        }
        else
        {
            $("#time").html(createTime(all - current_time + start_time));
            setTimeout(function () {
                fn();
            }, 1000);
        }



    }
    $(document).ready(function () {
        fn();
    });
</script>