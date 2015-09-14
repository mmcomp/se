<?php
$_SESSION['refrence_id'] = NULL;
$_SESSION['voucher_id'] = NULL;
$_SESSION['data'] = NULL;
$_SESSION['adl'] = NULL;
$_SESSION['chd'] = NULL;
$_SESSION['inf'] = NULL;
$_SESSION['data2'] = NULL;
$_SESSION['gdata'] = NULL;
$_SESSION['passengers'] = NULL;

$err = '';
if(isset($_REQUEST['err']) && trim($_REQUEST['err']))
{
    $e = trim($_REQUEST['err']);
    $err = <<<ERR
            alert('$e');
ERR;
}
$my = new mysql_class ();
$query = "SELECT * FROM ads_img WHERE is_home=1 ORDER BY tartib";
$my->ex_sql($query, $outs);
$adsRes = "";
foreach ($outs as $out) {
    $url = $out ['url'];
    $tmp = "<img class='img-responsive' src=\"%url%\">";
    $adsRes .= str_replace("%url%", $url, $tmp);
}

$tour_tmp = <<<TTMP
                <div class="col-sm-6" style="#padding# margin-bottom:5px;">
                    <div style="border: 1px solid #34363d; border-radius: 5px;">
                        <img src="#url#" width="100%" > 
                        <p style="padding: 5px 10px;">#tourtitle#<span style="float:left; color: #33a0d7; cursor: pointer;" onclick="toggleDet(this);">جزئیات بیشتر</span></p>
                    </div>
                    <div style="#padding# border: 1px solid #34363d; border-radius: 5px;position:absolute; top:0px; width:96%; height:100%;background:white;display:none;">
                        <div style="padding: 10px;">
                            #tourcontent#
                        </div>
                        <span style="position:absolute; bottom:15px; left:15px; cursor: pointer; color: #33a0d7;" onclick="$(this).parent().slideUp();">خروج</spana>
                    </div>
                </div>
TTMP;
$querytour = "SELECT * FROM tour_img ORDER BY tartib";
$my->ex_sql($querytour, $outstour);
$tourRes = "";
foreach ($outstour as $i => $outtour) {
    $tmp = str_replace("#url#", $outtour['url'], $tour_tmp);
    $tmp = str_replace("#tourtitle#", $outtour['tourtitle'], $tmp);
    $tmp = str_replace("#tourcontent#", $outtour['tourcontent'], $tmp);
    $tmp = str_replace("#padding#", (($i % 2 == 0) ? 'padding-right: 0;' : 'padding-left: 0;'), $tmp);
    $tourRes .= $tmp;
}

$dat = 0;
if (isset($_REQUEST['dat'])) {
    $dat = (int) $_REQUEST['dat'];
}
$results = array();

$result_fare = search_class::loadLowFare($dat);
if (isset($result_fare["data"])) {
    $results = $result_fare["data"];
    foreach ($results as $i => $res) {
        $results[$i]['from_city_small'] = city_class::loadByIata($res['from_city']); //$this->inc_model->substrH(city_class::loadByIata($res['from_city']), 5);
        $results[$i]['to_city_small'] = city_class::loadByIata($res['to_city']); //$this->inc_model->substrH(city_class::loadByIata($res['to_city']), 5);
        $results[$i]['from_city_name'] = city_class::loadByIata($res['from_city']);
        $results[$i]['to_city_name'] = city_class::loadByIata($res['to_city']);
        $results[$i]['price_monize'] = $this->inc_model->monize($res['price']);
    }
}
for ($i = 0; $i < 8; $i++) {
    if (!isset($results[$i])) {
        $results[$i]['from_city_small'] = '----';
        $results[$i]['to_city_small'] = '----';
        $results[$i]['from_city_name'] = '----';
        $results[$i]['to_city_name'] = '----';
        $results[$i]['price_monize'] = '----';
    }
}
$sign = ($dat < 0) ? ' - ' : ' + ';
$dat = abs($dat);
$result_fare['tarikh'] = $this->inc_model->perToEnNums(jdate("d-m-Y", strtotime(date("Y-m-d") . $sign . $dat . ' day')));
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
        <div class="col-lg-3 col-md-8 col-sm-12 col-xs-12 gh-search-box" style="margin-left: 6px; ">
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
                                    <td style="width: 100%;">
                                        <select style="width: 100%;" class="gh-city" id="sel1" name="from_city" onchange="fn(this);">
                                            <option value=""></option>
                                            <?php echo city_class::loadAll(); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>مقصد</td>
                                    <td style="width: 100%;">
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
                    <div class="col-sm-12 gh-ads-header"><p>تبلیغات ویژه</div>
                    <?php echo $adsRes; ?>
                </div>
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
            <div class="container-fluid" style="margin-top: 5px;padding: 0px;">
                <?php echo $tourRes; ?>
            </div>
            <!--wtf-box-->

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
<script>
    function toggleDet(dobj)
    {
        var obj = $(dobj).parent().parent().next();
        obj.slideDown();
    }
    <?php echo $err; ?>
</script>