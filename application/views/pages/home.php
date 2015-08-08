<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 gh-no-padding">
                        <form class="gh-search-form gh-border-radius" method="post" action="search.php">
                            <div class="dropdown">
                                <button class="btn btn-block dropdown-toggle gh-no-border gh-search-at" type="button" data-toggle="dropdown">انتخاب جستجو <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">جستجوی پرواز</a></li>
                                    <li class="disabled"><a href="#">جستجوی هتل</a></li>
                                    <li class="disabled"><a href="#">جستجوی تور</a></li>
                                </ul>
                            </div>
                            <div class="radio-inline" style="color: #fff;">
                                <label><input type="radio" name="way" value="one" checked="">یک طرفه</label>
                            </div>
                            <div class="radio-inline" style="color: #fff;">
                                <label><input type="radio" name="way" value="two">دو طرفه</label>
                            </div>
                            <br>
                            <div class="form-group">
                                <select class="form-control gh-city" id="sel1" name="from_city" onchange="fn(this);">
                                    <?php echo city_class::loadAll('THR'); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control gh-city" id="sel1" name="to_city">
                                    <?php echo city_class::loadAll('MHD'); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="aztarikh" class="form-control dateValue2" value="1439365284000" id="aztarikh" placeholder="از تاریخ">
                            </div>
                            <div class="form-group">
                                <input type="text" name="tatarikh" class="form-control dateValue2" id="tatarikh" placeholder="تا تاریخ">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-success" style="font-size: 20px; font-family: yekan; color: #4d5059;">جستجو</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-8 gh-slideshow hidden-xs"><img class="img-responsive gh-border-radius" src="<?php echo asset_url(); ?>images/img/slideshow.png"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 gh-no-padding">
                        <div class="gh-ads-header"><p>تبلیغات ویژه</p></div>
                        <div class="gh-ads-body">
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
                    <div class="col-sm-8 gh-wtf-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="thumbnail">
                                    <img src="<?php echo asset_url(); ?>images/img/place2.png">
                                    <span>تورهای خارجی
                                        <a href="#">جزئیات بیشتر</a>
                                    </span> 
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="thumbnail">
                                    <img src="<?php echo asset_url(); ?>images/img/hotel2.png">
                                    <span>هتل های خارجی
                                        <a href="#">جزئیات بیشتر</a>
                                    </span> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="thumbnail">
                                    <img src="<?php echo asset_url(); ?>images/img/place1.png">
                                    <span>تورهای داخلی
                                        <a href="#">جزئیات بیشتر</a>
                                    </span> 
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="thumbnail">
                                    <img src="<?php echo asset_url(); ?>images/img/hotel1.png">
                                    <span>هتل های داخلی
                                        <a href="#">جزئیات بیشتر</a>
                                    </span> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>