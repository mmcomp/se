<?php
$dat = 0;
if (isset($_REQUEST['dat'])) {
    $dat = (int) $_REQUEST['dat'];
}
$result_fare = search_class::loadLowFare($dat);
$results = $result_fare["data"];
foreach ($results as $i => $res) {
    $results[$i]['from_city_small'] = city_class::loadByIata($res['from_city']);//$this->inc_model->substrH(city_class::loadByIata($res['from_city']), 5);
    $results[$i]['to_city_small'] = city_class::loadByIata($res['to_city']);//$this->inc_model->substrH(city_class::loadByIata($res['to_city']), 5);
    $results[$i]['from_city_name'] = city_class::loadByIata($res['from_city']);
    $results[$i]['to_city_name'] = city_class::loadByIata($res['to_city']);
    $results[$i]['price_monize'] = $this->inc_model->monize($res['price']);
}
$sign = ($dat < 0) ? ' - ' : ' + ';
$dat = abs($dat);
$result_fare['tarikh'] = perToEnNums(jdate("d-m-Y", strtotime(date("Y-m-d") . $sign . $dat . ' day')));
$result_fare["data"] = $results;
if (isset($_REQUEST['dat'])) {
    die(json_encode($result_fare));
}
?>
<div class="container-fluid" style="margin-top: 10px;">

    <!--***search-box and slide show***-->
    <div class="row">
        <div class="col-sm-2"></div>
        <!--search-box-lg-->
        <div class="col-sm-3 gh-search-box hidden-xs hidden-sm hidden-md" style="margin-left: 6px; ">
            <ul class="nav nav-tabs">
                <li class="active"><a style="cursor: pointer;" data-toggle="tab" href="#flight-search">جستجوی پرواز</a></li>
                <li><a data-toggle="tab" href="#hotel-search">جستجوی هتل</a></li>
            </ul>
            <div class="tab-content">
                <div id="flight-search" class="tab-pane fade in active">
                    <div class="form-group">
                        <form method="post" action="search.php">
                            <span style="padding: 10px;">یک طرفه<input type="radio" name="way" value="one" checked=""> </span>
                            <span style="padding: 10px;">دو طرفه<input type="radio" name="way" value=""></span>
                            <table>
                                <tr>
                                    <td>مبدا</td>
                                    <td id="tatarikh-td" style="width: 100%;">
                                        <select style="width: 100%;" class="gh-city" id="sel1" name="from_city" onchange="fn(this);">
                                            <option value=""></option>
                                            <?php echo city_class::loadAll(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>مقصد</td>
                                    <td id="tatarikh-td" style="width: 100%;">
                                        <select style="width: 100%;" class="gh-city" id="sel2" name="to_city">
                                            <option value=""></option>
                                            <?php echo city_class::loadAll(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>از تاریخ</td>
                                    <td id="aztarikh-td" style="width: 100%;"><input type="text" name="aztarikh" class="form-control dateValue2" id="aztarikh" placeholder="از تاریخ"></td>
                                </tr>
                                <tr>
                                    <td>تا تاریخ</td>
                                    <td id="tatarikh-td" style="width: 100%;"><input type="text" name="tatarikh" class="form-control dateValue2" id="tatarikh" placeholder="تا تاریخ"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><button style="background-color: #baeb30; color: #4d5059; font-family: yekan; font-size: 20px;" type="submit" class="btn btn-block">جستجو</button></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <div id="hotel-search" class="tab-pane fade"></div>
            </div>
        </div>
        <!--search-box-->
        <!--search-box-xs-sm-md-->
        <div class="col-sm-8 gh-search-box visible-xs visible-sm visible-md" style="margin-right: 3px;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#flight-search-small">جستجوی پرواز</a></li>
                <li><a data-toggle="tab" href="#hotel-search-small">جستجوی هتل</a></li>
            </ul>
            <div class="tab-content">
                <div id="flight-search-small" class="tab-pane fade in active">
                    <div class="form-group">
                        <form method="post" action="search.php">
                            <span style="padding: 10px;">یک طرفه<input  type="radio" name="way" value="one" checked=""> </span>
                            <span style="padding: 10px;">دو طرفه<input type="radio" name="way" value=""></span>
                            <table>
                                <tr>
                                    <td>مبدا</td>
                                    <td id="tatarikh-td" style="width: 100%;">
                                        <select style="width: 100%;" class="gh-city form-control" id="sel1" name="from_city" onchange="fn(this);">
                                            <option value=""></option>
                                            <?php echo city_class::loadAll(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>مقصد</td>
                                    <td id="tatarikh-td" style="width: 100%;">
                                        <select style="width: 100%;" class="gh-city" id="sel2" name="to_city">
                                            <option value=""></option>
                                            <?php echo city_class::loadAll(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>از تاریخ</td>
                                    <td id="aztarikh-td" style="width: 100%;"><input type="text" name="aztarikh" class="form-control dateValue2" id="aztarikh" placeholder="از تاریخ"></td>
                                </tr>
                                <tr>
                                    <td>تا تاریخ</td>
                                    <td id="tatarikh-td" style="width: 100%;"><input type="text" name="tatarikh" class="form-control dateValue2" id="tatarikh" placeholder="تا تاریخ"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><button style="background-color: #baeb30; color: #4d5059; font-family: yekan; font-size: 20px;" type="submit" class="btn btn-block">جستجو</button></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <div id="hotel-search-small" class="tab-pane fade"></div>
            </div>
        </div>
        <!--search-box-xs-sm-md-->
        <!--slide-show-->
        <div class="col-sm-5 gh-slideshow hidden-xs hidden-sm hidden-md">
            <img class="img-responsive" src="<?php echo asset_url(); ?>images/img/slideshow.png">
        </div>
        <!--slide-show-->
        <div class="col-sm-2"></div>
    </div>
    <!--***search-box and slide show***-->
</div>

<div class="container-fluid" style="background-color: #f4f4f4; margin-top: 10px; padding-bottom: 10px;">
    <!--***ads and offer and wtf***-->
    <div class="row" style="padding-top: 10px;">
        <div class="col-sm-2"></div>
        <!--ads-box-->
        <div class="col-sm-2 gh-ads-box hidden-xs hidden-sm hidden-md" style="margin-left: 6px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 gh-ads-header"><p>تبلیغات ویژه</p></div>
                </div>
                <img class="img-responsive" src="<?php echo asset_url(); ?>images/img/ads1.png">
                <img class="img-responsive" src="<?php echo asset_url(); ?>images/img/ads2.png">
                <img class="img-responsive" src="<?php echo asset_url(); ?>images/img/ads3.png">
            </div>
        </div>
        <!--ads-box-->

        <!--offer and wtf-lg-->
        <div class="col-sm-6 hidden-md hidden-sm hidden-xs" style="padding: 0;">
            <!--offer-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 gh-offer-box">
                        <div class="gh-offer-header">
                            <p>
                                ارزان ترین نرخ در : 
                                <span class="tat"><?php echo jdate("d-m-Y"); ?></span>
                            </p>
                        </div>
                        <table>
                            <tr>
                                <td rowspan="2"><a href="javascript:backFare();" ><span style="font-size: 20px; color: red; cursor: pointer;" class="glyphicon glyphicon-chevron-right"></span></a></td>
                                <td>
                                    <div id="fl_large_0" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[0]['from_city_name']; ?> - <?php echo $results[0]['to_city_name']; ?>">
                                            <?php echo $results[0]['from_city_small']; ?> - <?php echo $results[0]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[0]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_large_1" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[1]['from_city_name']; ?> - <?php echo $results[1]['to_city_name']; ?>">
                                            <?php echo $results[1]['from_city_small']; ?> - <?php echo $results[1]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[1]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_large_2" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[2]['from_city_name']; ?> - <?php echo $results[2]['to_city_name']; ?>">
                                            <?php echo $results[2]['from_city_small']; ?> - <?php echo $results[2]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[2]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_large_3" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[3]['from_city_name']; ?> - <?php echo $results[3]['to_city_name']; ?>">
                                            <?php echo $results[3]['from_city_small']; ?> - <?php echo $results[3]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[3]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td rowspan="2"><a href="javascript:nextFare();" ><span style="font-size: 20px; color: red; cursor: pointer;" class="glyphicon glyphicon-chevron-left"></span></a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="fl_large_4" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[4]['from_city_name']; ?> - <?php echo $results[4]['to_city_name']; ?>">
                                            <?php echo $results[4]['from_city_small']; ?> - <?php echo $results[4]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[4]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_large_5" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[5]['from_city_name']; ?> - <?php echo $results[6]['to_city_name']; ?>">
                                            <?php echo $results[5]['from_city_small']; ?> - <?php echo $results[5]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[5]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_large_6" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[6]['from_city_name']; ?> - <?php echo $results[6]['to_city_name']; ?>">
                                            <?php echo $results[6]['from_city_small']; ?> - <?php echo $results[6]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[6]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_large_7" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[7]['from_city_name']; ?> - <?php echo $results[7]['to_city_name']; ?>">
                                            <?php echo $results[7]['from_city_small']; ?> - <?php echo $results[7]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[7]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!--offer-->
            <!--wtf-box-->
            <div class="container-fluid" style="margin-top: 10px;">
                <div class="row gh-wtf-box">
                    <div class="col-sm-6" style="padding-right: 0;">
                        <div style="border: 1px solid #34363d; border-radius: 5px;">
                            <img width="100%" src="<?php echo asset_url(); ?>images/img/img1.png">
                            <p style="padding: 5px 10px;">تورهای داخلی<a href="#">جزئیات بیشتر</a></p>
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 0;">
                        <div style="border: 1px solid #34363d; border-radius: 5px;">
                            <img width="100%" src="<?php echo asset_url(); ?>images/img/img1.png">
                            <p style="padding: 5px 10px;">تورهای ویژه<a href="#">جزئیات بیشتر</a></p>
                        </div>
                    </div>
                </div>
                <!--wtf-box-->
            </div>
            <!--offer and wtf-lg-->
            <div class="col-sm-2"></div>
        </div>
        <!--***ads and offer and wtf***-->

        <!--offer and wtf-md-sm-xs-->
        <div class="col-sm-8 visible-md visible-sm visible-xs">
            <!--offer-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 gh-offer-box">
                        <div class="gh-offer-header">
                            <p>
                                ارزان ترین نرخ در : 
                                <span class="tat"><?php echo jdate("d-m-Y"); ?></span>
                            </p>
                        </div>

                        <table>
                            <tr>
                                <td onclick="backFare();" rowspan="2"><span style="font-size: 20px; color: red; cursor: pointer;" class="glyphicon glyphicon-chevron-right"></span></td>
                                <td>
                                    <div id="fl_small_0" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[0]['from_city_name']; ?> - <?php echo $results[0]['to_city_name']; ?>">
                                            <?php echo $results[0]['from_city_small']; ?> - <?php echo $results[0]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[0]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_small_1" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[1]['from_city_name']; ?> - <?php echo $results[1]['to_city_name']; ?>">
                                            <?php echo $results[1]['from_city_small']; ?> - <?php echo $results[1]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[1]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_small_2" class="gh-offer-cell hidden-xs">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[2]['from_city_name']; ?> - <?php echo $results[2]['to_city_name']; ?>">
                                            <?php echo $results[2]['from_city_small']; ?> - <?php echo $results[2]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[2]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_small_3" class="gh-offer-cell hidden-sm hidden-xs">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[3]['from_city_name']; ?> - <?php echo $results[3]['to_city_name']; ?>">
                                            <?php echo $results[3]['from_city_small']; ?> - <?php echo $results[3]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[3]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td onclick="nextFare();" rowspan="2"><span style="font-size: 20px; color: red; cursor: pointer;" class="glyphicon glyphicon-chevron-left"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="fl_small_4" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[4]['from_city_name']; ?> - <?php echo $results[4]['to_city_name']; ?>">
                                            <?php echo $results[4]['from_city_small']; ?> - <?php echo $results[4]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[4]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_small_5" class="gh-offer-cell">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[5]['from_city_name']; ?> - <?php echo $results[5]['to_city_name']; ?>">
                                            <?php echo $results[5]['from_city_small']; ?> - <?php echo $results[5]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[5]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_small_6" class="gh-offer-cell hidden-xs">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[6]['from_city_name']; ?> - <?php echo $results[6]['to_city_name']; ?>">
                                            <?php echo $results[6]['from_city_small']; ?> - <?php echo $results[6]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[6]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 
                                <td>
                                    <div id="fl_small_7" class="gh-offer-cell hidden-sm hidden-xs">
                                        <header data-toggle="tooltip" data-original-title="<?php echo $results[7]['from_city_name']; ?> - <?php echo $results[7]['to_city_name']; ?>">
                                            <?php echo $results[7]['from_city_small']; ?> - <?php echo $results[7]['to_city_small']; ?>
                                        </header>
                                        <span><?php echo $results[7]['price_monize']; ?> تومان</span>
                                    </div>
                                </td> 

                            </tr>
                        </table>

                    </div>
                </div>
            </div>
            <!--offer-->
        </div>
        <!--offer and wtf-lg-md-sm-sx-->
    </div>
</div>
