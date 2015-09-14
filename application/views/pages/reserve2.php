<?php 
$passengers = $_SESSION ['passengers'];
var_dump($passengers);
?>
<div class="container" style="margin: 10px auto;">
    <div class="row">
        <div class="col-sm-12 refvouch-body" style="margin-bottom: 10px;">
            <header>
                <div>
                    رفرنس : 
                    <span style="padding-left: 20px;">9HT18P</span>
                    واچر : 
                    <span>880576988</span>
                </div>
            </header>
        </div><!--reserve-countdown-->
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 hidden-sm hidden-xs flight-summery-body" style="margin-bottom: 10px;">
            <header>اطلاعات پرواز</header>
            <ul>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>مبدا : </span>مشهد</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>مقصد : </span>کوالالامپور</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>تاریخ : </span>1395/6/21</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>ایرلاین : </span>آسمان</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>شماره پرواز : </span>5698</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>ساعت خروج :</span>22:45</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>ساعت ورود : </span>5:45</li>
            </ul>
            <ul>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>مبدا : </span>کوالالامپور</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>مقصد : </span>مشهد</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>تاریخ : </span>1395/6/21</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>ایرلاین : </span>آسمان</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>شماره پرواز : </span>5698</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>ساعت خروج :</span>22:45</li>
                <li class="visible-lg-inline-block visible-md-inline-block"><span>ساعت ورود : </span>5:45</li>
            </ul>
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
                <a class="hidden-sm hidden-xs" href="#"><img src="<?php echo asset_url() ?>/images/img/saman.png"></a>
                <span class="visible-sm visible-xs" style="text-align: center; float: none; padding: 0;">
                    <a href="#"><img style="float: none; width: 120px;" src="<?php echo asset_url() ?>/images/img/mellat.png"></a>
                    <a href="#"><img style="float: none; width: 120px;" src="<?php echo asset_url() ?>/images/img/saman.png"></a>
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
                        <tr>
                            <td>1</td>
                            <td>adult</td>
                            <td>
                                مرد
                            </td>
                            <td>
                                حمیدرضا
                                <br>
                                Hamidreza
                            </td>
                            <td>
                                عبدی کاشانی
                                <br>
                                Abdi Kashani
                            </td>
                            <td>
                                12345678954689
                            </td>
                            <td>
                                1342-6-13
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>adult</td>
                            <td>
                                مرد
                            </td>
                            <td>
                                حمیدرضا
                                <br>
                                Hamidreza
                            </td>
                            <td>
                                عبدی کاشانی
                                <br>
                                Abdi Kashani
                            </td>
                            <td>
                                12345678954689
                            </td>
                            <td>
                                1342-6-13
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="visible-sm visible-xs table passenger-info-table-small">
                    <tr>
                        <td>ردیف</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>سن</td>
                        <td>adult</td>
                    </tr>
                    <tr>
                        <td>جنسیت</td>
                        <td>
                            مرد
                        </td>
                    </tr>
                    <tr>
                        <td>نام</td>
                        <td>
                            حمیدرضا
                            <br>
                            Hamidreza
                        </td>
                    </tr>
                    <tr>
                        <td>نام خانوادگی</td>
                        <td>
                            عبدی کاشانی
                            <br>
                            Abdi Kashani
                        </td>
                    </tr>
                    <tr>
                        <td>شماره ملی - شماره پاسپورت</td>
                        <td>
                            2545212365896
                        </td>
                    </tr>
                    <tr style="border-bottom: 2px solid #ddd;">
                        <td>تاریخ تولد</td>
                        <td>
                            1342-6-13
                        </td>
                    </tr>
                    <tr>
                        <td>ردیف</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>سن</td>
                        <td>adult</td>
                    </tr>
                    <tr>
                        <td>جنسیت</td>
                        <td>
                            مرد
                        </td>
                    </tr>
                    <tr>
                        <td>نام</td>
                        <td>
                            حمیدرضا
                            <br>
                            Hamidreza
                        </td>
                    </tr>
                    <tr>
                        <td>نام خانوادگی</td>
                        <td>
                            عبدی کاشانی
                            <br>
                            Abdi Kashani
                        </td>
                    </tr>
                    <tr>
                        <td>شماره ملی - شماره پاسپورت</td>
                        <td>
                            2545212365896
                        </td>
                    </tr>
                    <tr style="border-bottom: 2px solid #ddd;">
                        <td>تاریخ تولد</td>
                        <td>
                            1342-6-13
                        </td>
                    </tr>
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
                                0123456789
                            </td>
                            <td>
                                مشهد بلوار لادن خیابان ششم
                            </td>
                            <td>
                                gohar@gmail.com
                            </td>
                            <td>
                                من بسیار کارم درسته
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="visible-sm visible-xs passenger-extra-info-small">
                    <tr>
                        <td>تلفن همراه</td>
                        <td>
                            0123456789
                        </td>
                    </tr>
                    <tr>
                        <td>آدرس</td>
                        <td>
                            مشهد بلوار لادن خیابان ششم
                        </td>
                    </tr>
                    <tr>
                        <td>پست الکترونیک</td>
                        <td>
                            gohar@gmail.com
                        </td>
                    </tr>
                    <tr>
                        <td>ملاحظات</td>
                        <td>
                            من بسیار کارم درسته
                        </td>
                    </tr>
                </table>
            </div><!--passenger-info-box-->
        </div><!--passenger-info-body-->
    </div>
</div>