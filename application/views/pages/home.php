<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<!--search and slideshow-->
<div class="gh-search_slideshow">
    <div class="gh-search_slideshow-right gh-border-radius">
        <div class="gh-search-box gh-border-radius">
            <div class="gh-search-box-title">
                <ul>
                    <li><a href="#">جستجوی پرواز</a></li>
                    <li><a href="#">جستجوی هتل</a></li>
                </ul>
            </div>
            <form method="post" action="<?php echo site_url(); ?>search">
                <input type="radio" name="way" value="one-way" checked>یک طرفه
                <input type="radio" name="way" value="two-ways">دو طرفه
                <span>مبدا <select name="from_city">
                        <option value="">شهر</option>
                        <?php echo city_class::loadAll(); ?>
                    </select></span>
                <span>مقصد <select name="to city">
                        <option value="">شهر</option>
                        <?php echo city_class::loadAll(); ?>
                    </select></span>
                <span>از تاریخ<input class="dateValue2" type="text" name="aztarikh"></span>
                <span>تا تاریخ<input class="dateValue2" type="text" name="tatarikh"></span>
                <span><input type="submit" value="جستجو"></span>
            </form>
        </div>
    </div>
    <div class="gh-search_slideshow-left"><img class="gh-border-radius" src="<?php echo asset_url(); ?>images/img/slideshow1.png"></div>
</div>
<!--middle-->
<div class="gh-middle">
    <div class="gh-middle-right gh-border-radius">
        <header>تبلیغات ویژه</header>
        <ul>
            <li><a href="#"><img src="<?php echo asset_url(); ?>images/img/ads1.png"></a></li>
            <li><a href="#"><img src="<?php echo asset_url(); ?>images/img/ads2.png"></a></li>
            <li><a href="#"><img src="<?php echo asset_url(); ?>images/img/ads3.png"></a></li>
        </ul>
    </div>
    <div class="gh-middle-left">
        <div class="gh-middle-left-row">
            <div class="gh-right"><img src="<?php echo asset_url(); ?>images/img/outside-tour.png"><p>تورهای خارجی </p><a href="#">مشاهده جزئیات ...</a></div>
            <div class="gh-left"><img src="<?php echo asset_url(); ?>images/img/outside-hotel.png"><p>هتل های خارجی</p><a href="#">مشاهده جزئیات ...</a></div>
        </div>
        <div class="gh-middle-left-row">
            <div class="gh-right"><img src="<?php echo asset_url(); ?>images/img/inside-tour.png"><p>تورهای داخلی </p><a href="#">مشاهده جزئیات ...</a></div>
            <div class="gh-left"><img src="<?php echo asset_url(); ?>images/img/inside-hotel.png"><p>هتل های داخلی </p><a href="#">مشاهده جزئیات ...</a></div>
        </div>
    </div>
</div>