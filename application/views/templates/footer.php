<!--footer-->
<div class="container-fluid">
    <div class="row gh-footer-bar hidden-xs hidden-sm">
        <div class="col-sm-3"></div>
        <div class="col-sm-3 gh-gmap" style=" text-align: center;">
            <img src="<?php echo asset_url(); ?>images/img/add.png" style="position: absolute; margin-top: -30px; margin-right: -10px; z-index: 10;">
            <div id="map_canvas1" style="padding: 70px 120px; border: 1px solid #42d3dc;"></div>
        </div>
        <div id="myAnchor" class="gh-con-us col-sm-3">
            <img src="<?php echo asset_url(); ?>images/img/tell.png" style="position: absolute; margin-top: -40px; margin-right: 30px;">
            Tel : 38080
            <br>
            Reservation : 38080
            <br>
            Fax : 38080
            <br>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
<div class="gh-footer-bar-mob visible-xs visible-sm">
    <div class="container-fluid">
        <div class="row gh-footer-bar">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="gh-con-us-mob">
                    Tel : 38080
                    <br>
                    Reservation : 38080
                    <br>
                    Fax : 38080
                    <br>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
</div>
<!--footer-->
<!--sub-footer-->
<div class="container-fluid" style="background-color: #f4f4f4; text-align: center; padding: 5px; font-family: tahoma; font-size: 15px;">
    Copyright 2015 Gohar Group - All rights reserved
</div>
<!--sub-footer-->

<script>
    var curdate = '<?php echo $this->inc_model->perToEnNums(jdate("Y-m-d")); ?>';
    var tat = '<input type="text" name="tatarikh" class="form-control" id="tatarikh" placeholder="تا تاریخ">';
    var aztarikhLimit;
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        var initLat = 36.3278668291708;
        var initLng = 59.4744628295302;
        var initZoom = 16;
        var initidObjectMap = 62374;
        function initialize1() {
            var latlng = new google.maps.LatLng(initLat, initLng);
            var myOptions = {zoom: initZoom, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP};
            var map = new google.maps.Map(document.getElementById("map_canvas1"), myOptions);
            marker = new google.maps.Marker({position: latlng, map: map, draggable: false});
        }
        function initialize2() {
            var latlng = new google.maps.LatLng(initLat, initLng);
            var myOptions = {zoom: initZoom, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP};
            var map = new google.maps.Map(document.getElementById("map_canvas2"), myOptions);
            marker = new google.maps.Marker({position: latlng, map: map, draggable: false});
        }
        initialize1();
        initialize2();
    });
    $(".dateValue2").pDatepicker({
        format: "YYYY-MM-DD",
        maxDate: <?php echo strtotime(date("Y-m-d") . ' - 1 day') . '000'; ?>,
        altFieldFormatter: function (ff) {
            var obj = $(this.inputElem[0]);
            if (obj.prop('id') === 'aztarikh')
            {
                aztarikhLimit = ff;

            }
        },
        onSelect: function () {
            var obj = $(this.inputElem[0]);
            if (obj.prop('id') === 'aztarikh')
            {
                $("#tatarikh").remove();
                //obj.parent().next().append(tat);
                $("#tatarikh-td").append(tat);
                $("#tatarikh").pDatepicker({
                    format: "YYYY-MM-DD",
                    maxDate: aztarikhLimit,
                    minDate: 0,
                    timePicker: {
                        enabled: false
                    },
                    autoClose: true
                });
                var azta = $("#aztarikh").val().split('-');
                $("#tatarikh").pDatepicker("setDate", [parseInt(azta[0], 10), parseInt(azta[1], 10), parseInt(azta[2], 10), 0, 0]);
            }

        },
        minDate: 0,
        timePicker: {
            enabled: false
        },
        autoClose: true
    });
    var currr = curdate.split('-');
    try
    {
        $("#tatarikh").pDatepicker("setDate", [parseInt(currr[0], 10), parseInt(currr[1], 10), parseInt(currr[2], 10), 0, 0]);
    }
    catch (e)
    {
    }
    try
    {
        $("#aztarikh").pDatepicker("setDate", [parseInt(currr[0], 10), parseInt(currr[1], 10), parseInt(currr[2], 10), 0, 0]);
    }
    catch (e)
    {
    }
    $('#sel1').select2({
        dir: "rtl",
        placeholder: "مبدا"
    });
    $('#sel2').select2({
        dir: "rtl",
        placeholder: "مقصد"
    });
    //$('.gh-city').chosen();
    /*
     $(".dateValue2").datepicker({
     numberOfMonths: 2,
     showButtonPanel: true
     });
     */
    $(".gh-air-list input:checkbox").each(function (id, field) {
        $(field).click(function () {
            searchAgain($(this));
        });
    });
    function sortFlight()
    {
        searchAgain();
    }
    var loading_img = '<img class="mm-loading" src="<?php echo asset_url(); ?>images/img/loading.gif" />';
    function searchAgain()
    {
        $(".mm-loading").remove();
        var airlines = [];
        var loadAirline;
        var field;
        $(".gh-air-list input:checkbox").each(function (id, field) {
            if ($(field).prop('checked'))
            {
                //console.log($(field).val());
                airlines.push($(field).val());
                loadAirline = $(field);
            }
        });
        if (!loadAirline)
        {
            loadAirline = $(field);
        }
        var sort = $(".mm-sort-type").val();
        $(".mm-sort-type").after(loading_img);
        loadAirline.after(loading_img);
        //if(airlines.length>0)
        {
            var p = {
                'airlines': airlines,
                'aztarikh': aztarikh,
                'tatarikh': tatarikh,
                'from_city': from_city,
                'to_city': to_city,
                'way': way,
                'isajax': true,
                'sort': sort
            };

            $.get('<?php echo site_url(); ?>search', p, function (res) {
                //console.log(res);
                $(".mm-res-ha").html(res);
                $(".mm-loading").remove();
            }).fail(function () {
                $(".mm-loading").remove();
                alert('خطا در ارتباط با سرور');
            });
        }
    }
    var fareIndex = 0;
    var maxFare = 4;
    function backFare()
    {
        if (fareIndex > 0)
        {
            fareIndex--;
            loadFare();
        }
    }
    function nextFare()
    {
        if (maxFare > fareIndex)
        {
            fareIndex++;
            loadFare();
        }
    }
    function loadFare()
    {
        var p = {
            "dat": fareIndex
        };
        $.getJSON("<?php echo site_url(); ?>home", p, function (res) {
            console.log(res);
            var dat = res.data;
            $(".tat").html(res.tarikh);
            for (var i = 0; i < 8; i++)
            {
                if (dat[i])
                {
                    $("#fl_large_" + i).find("header").html(dat[i].from_city_small + ' - ' + dat[i].to_city_small);
                    $("#fl_large_" + i).find("span").html(dat[i].price_monize + ' تومان');
                    $("#fl_small_" + i).find("header").html(dat[i].from_city_small + ' - ' + dat[i].to_city_small);
                    $("#fl_small_" + i).find("span").html(dat[i].price_monize + ' تومان');
                    $("#fl_large_" + i).find("header").tooltip('hide').attr('data-original-title', dat[i].from_city_name + ' - ' + dat[i].to_city_name).tooltip();
                    $("#fl_small_" + i).find("header").tooltip('hide').attr('data-original-title', dat[i].from_city_name + ' - ' + dat[i].to_city_name).tooltip();
                }
                else
                {
                    $("#fl_large_" + i).find("header").html('');
                    $("#fl_large_" + i).find("span").html('');
                    $("#fl_small_" + i).find("header").html('');
                    $("#fl_small_" + i).find("span").html('');
                }
            }
        });
    }
    $('a.scroll').click(function () {
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top
        }, 500);
        return false;
    });
</script>
</body>
</html>

