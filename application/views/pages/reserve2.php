<?php
$voucher_id = $_SESSION['voucher_id'];
$voucher = $voucher_id[0] . ((count($voucher_id) == 2) ? '-' . $voucher_id[1] : '');
$refrence_id = $_SESSION['refrence_id'];
$passengers = $_SESSION ['passengers'];
$data = $_SESSION['data'];
$data2 = $_SESSION['data2'];
$adl = (int) $_SESSION['adl'];
$chd = (int) $_SESSION['chd'];
$inf = (int) $_SESSION['inf'];
$price = $_SESSION['price'];
$mobile = $_SESSION['mobile'];
$address = $_SESSION['address'];
$extra_info = $_SESSION['extra_info'];
$email = $_SESSION['email'];
$flight_info = json_decode($data);
$flight_info2 = json_decode($data2);
$user_id = -1;
if (isset($_REQUEST['bank'])) {
    $SamanMID = "10156488";
    $url = "http://185.55.225.70/saman/purchase.php";
    $url = "http://185.55.225.70/ticketyab/reserve3";
    $out = new stdClass();
    $out->form = '';
    $out->id = '';
    if (isset($_SESSION['tprice'])) {
        $tprice = (int) $_SESSION['tprice'];
        $aprice = (int) $_SESSION['aprice'];
        if ($tprice > 1000) {
            $tprice = 1000;
            $my = new mysql_class;
            $ln = $my->ex_sqlx("insert into reserve (refrence_id,total_asli,total_moshtari,user_id) values ($refrence_id,$aprice,$tprice,$user_id)", FALSE);
            $rid = $my->insert_id($ln);
            $my->close($ln);
            $frm = <<<FORM
                <form method="post" action="https://sep.shaparak.ir/Payment.aspx" id="frmsaman$tprice">
                    <input name="ResNum"  type="hidden"  value="$rid">
                    <input name="Amount"  type="hidden"  value="$tprice">
                    <input name="MID" value="$SamanMID" type="hidden"/><br>
                    <input name="RedirectURL" value="$url" type="hidden"/>
                </form>
FORM;
            $out->form = $frm;
            $out->id = "frmsaman$tprice";
        }
    }
    die(json_encode($out));
}
$tr = <<<mmcomp
<tr>
    <td>#no#</td>
    <td>#age#</td>
    <td>
        #gender#
    </td>
    <td>
        #fname#
        <br>
        #fname_en#
    </td>
    <td>
        #lname#
        <br>
        #lname_en#
    </td>
    <td>
        #shomare_melli#
    </td>
    <td>
        #birthday#
    </td>
</tr>
mmcomp;

$trs = <<<mmcompp
<tr>
    <td>ردیف</td>
    <td>#no#</td>
</tr>
<tr>
    <td>سن</td>
    <td>#age#</td>
</tr>
<tr>
    <td>جنسیت</td>
    <td>
        #gender#
    </td>
</tr>
<tr>
    <td>نام</td>
    <td>
        #fname#
        <br>
        #fname_en#
    </td>
</tr>
<tr>
    <td>نام خانوادگی</td>
    <td>
        #lname# 
        <br>
        #lname_en#
    </td>
</tr>
<tr>
    <td>شماره ملی - شماره پاسپورت</td>
    <td>
        #shomare_melli#
    </td>
</tr>
<tr style="border-bottom: 2px solid #ddd;">
    <td>تاریخ تولد</td>
    <td>
        #birthday#
    </td>
</tr>
mmcompp;

$tr_large = '';
$tr_small = '';
$no = 1;
for ($i = 0; $i < count($passengers); $i++) {
    $tr_tmp = $tr;
    $trs_tmp = $trs;
    $tr_tmp = str_replace('#no#', $i + 1, $tr_tmp);
    $trs_tmp = str_replace('#no#', $i + 1, $trs_tmp);
    $tr_tmp = str_replace('#age#', $passengers[$i]['age'], $tr_tmp);
    $trs_tmp = str_replace('#age#', $passengers[$i]['age'], $trs_tmp);
    $tr_tmp = str_replace('#fname#', $passengers[$i]['fname'], $tr_tmp);
    $trs_tmp = str_replace('#fname#', $passengers[$i]['fname'], $trs_tmp);
    $tr_tmp = str_replace('#gender#', ($passengers[$i]['gender'] == 1) ? 'آقا' : 'خانوم', $tr_tmp);
    $trs_tmp = str_replace('#gender#', ($passengers[$i]['gender'] == 1) ? 'آقا' : 'خانوم', $trs_tmp);
    $tr_tmp = str_replace('#fname_en#', $passengers[$i]['fname_en'], $tr_tmp);
    $trs_tmp = str_replace('#fname_en#', $passengers[$i]['fname_en'], $trs_tmp);
    $tr_tmp = str_replace('#lname#', $passengers[$i]['lname'], $tr_tmp);
    $trs_tmp = str_replace('#lname#', $passengers[$i]['lname'], $trs_tmp);
    $tr_tmp = str_replace('#lname_en#', $passengers[$i]['lname_en'], $tr_tmp);
    $trs_tmp = str_replace('#lname_en#', $passengers[$i]['lname_en'], $trs_tmp);
    $tr_tmp = str_replace('#shomare_melli#', $passengers[$i]['shomare_melli'], $tr_tmp);
    $trs_tmp = str_replace('#shomare_melli#', $passengers[$i]['shomare_melli'], $trs_tmp);
    $tr_tmp = str_replace('#birthday#', $passengers[$i]['birthday'], $tr_tmp);
    $trs_tmp = str_replace('#birthday#', $passengers[$i]['birthday'], $trs_tmp);
    $tr_large .= $tr_tmp;
    $tr_small .= $trs_tmp;
    //$tr_small.=$trs_tmp;
    $no++;
}
?>

<div class="container" style="margin: 10px auto;">
    <div class="row">
        <div class="col-sm-12 refvouch-body" style="margin-bottom: 10px;">
            <header>
                <div>
                    رفرنس : 
                    <span style="padding-left: 20px;"><?php echo $refrence_id ?></span>
                    واچر : 
                    <span><?php echo $voucher ?></span>
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
        <div class="col-lg-12 col-md-12 col-sm-8 col-xs-12 financial-info-body" style="margin-bottom: 10px;">
            <header>اطلاعات مالی</header>
            <div class="financial-info-box">
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>قیمت کل</th>
                                <th>کمیسیون</th>
                                <th>قابل پرداخت</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>480.000 تومان</td>
                                <td>0 تومان</td>
                                <td>480.000 تومان</td>
                            </tr>
                        </tbody>
                    </table>
                    <button>لغو رزرو</button>
                </div>
                <span class="visible-lg visible-md">
                    در صورت تمایل به پرداخت از طریق شبکه شتاب لطفا<br>
                    از این سامانه اقدام نمایید.
                    <br>
                    اگر ظرف 15 دقیقه پرداخت صورت نگیرد رزرو شما<br>
                    توسط سیستم لغو می گردد.
                </span>
                <span class="visible-sm visible-xs" style="width: 100%; padding: 0; text-align: center;">
                    در صورت تمایل به پرداخت از طریق شبکه شتاب لطفا<br>
                    از این سامانه اقدام نمایید.
                    <br>
                    اگر ظرف 15 دقیقه پرداخت صورت نگیرد رزرو شما<br>
                    توسط سیستم لغو می گردد.
                </span>
                <a class="hidden-sm hidden-xs" href="#"><img src="<?php echo asset_url() ?>/images/img/mellat.png"></a>
                <a class="hidden-sm hidden-xs" onclick="sendBankSaman();" href="#"><img src="<?php echo asset_url() ?>/images/img/saman.png"></a>
                <span class="visible-sm visible-xs" style="text-align: center; float: none; padding: 0;">
                    <a href="#"><img style="float: none; width: 120px;" src="<?php echo asset_url() ?>/images/img/mellat.png"></a>
                    <a  onclick="sendBankSaman();" href="#"><img style="float: none; width: 120px;" src="<?php echo asset_url() ?>/images/img/saman.png"></a>
                </span>
            </div><!--passenger-info-box-->
        </div><!--financial-info-body-->
        <div class="col-lg-12 col-md-12 col-sm-8 col-xs-12 passenger-info-body" style="margin-bottom: 10px;">
            <header>اطلاعات مسافران</header>
            <div class="passenger-info-box">
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

                <table class="visible-sm visible-xs table passenger-info-table-small">
                    <?php echo $tr_small ?>
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
                            <td>
                                <?php echo $mobile ?>                            
                            </td>
                            <td>
                                <?php echo $address ?>
                            </td>
                            <td>
                                <?php echo $email ?>
                            </td>
                            <td>
                                <?php echo $extra_info ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="visible-sm visible-xs passenger-extra-info-small">
                    <tr>
                        <td>تلفن همراه</td>
                        <td>
                            <?php echo $mobile ?>
                        </td>
                    </tr>
                    <tr>
                        <td>آدرس</td>
                        <td>
                            <?php echo $address ?>
                        </td>
                    </tr>
                    <tr>
                        <td>پست الکترونیک</td>
                        <td>
                            <?php echo $email ?>
                        </td>
                    </tr>
                    <tr>
                        <td>ملاحظات</td>
                        <td>
                            <?php echo $extra_info ?>
                        </td>
                    </tr>
                </table>
            </div><!--passenger-info-box-->
        </div><!--passenger-info-body-->
    </div>
</div>
<script>
    function sendBankSaman() {
        $.getJSON('<?php echo site_url(); ?>reserve2?bank=bank', function (res) {
            console.log(res);
            if (typeof res.form !== 'undefined' && res.form !== '')
            {
                $(document.body).append(res.form);
                $("#" + res.id).submit();
            }
            else
            {
                window.location = '<?php echo site_url(); ?>home?err=خطا در ارتباط با بانک لطفا مجددا سعی نمایید';
            }
        });
    }
</script>