<!--footer-->
<div class="container-fluid">
    <div class="row gh-footer-bar hidden-xs hidden-sm" style="margin-top: 15px;">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-4 gh-gmap pull-right">
                                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=fa"></script>
                                <script src="http://kharido.ir/OtherPage/GoogleMapsInYourSite.js.aspx?idObjectMap=62374" type="text/javascript"></script> 
                                <div id="map_canvas" style="padding: 70px 120px; border: 1px solid #42d3dc"></div>
                            </div>
                            <div class="gh-con-us pull-left">
                                Tel : (+9851) 3855 91 29-31
                                <br>
                                Reservation : 0915 822 6800
                                <br>
                                Fax : (+9851) 3342 77 17
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
<div class="gh-footer-bar-mob visible-xs visible-sm">
    <div class="container-fluid">
        <div class="row gh-footer-bar">
            <div class="col-sm-2"></div>
            <div class="col-sm-8"> 
                <div class="gh-con-us-mob pull-left">
                    Tel : (+9851) 3855 91 29-31
                    <br>
                    Reservation : 0915 822 6800
                    <br>
                    Fax : (+9851) 3342 77 17
                    <br>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row gh-footer-bar">
            <div class="col-sm-2"></div>
            <div class="col-sm-8"> 
                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=fa"></script>
                <script src="http://kharido.ir/OtherPage/GoogleMapsInYourSite.js.aspx?idObjectMap=62379" type="text/javascript"></script>  
                <div id="map_canvas" style="display: block; width: 100%; padding: 50px 0; border: 1px solid #42d3dc;"></div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</div>
<!--footer-->
<script>
    var tat = '<input type="text" name="tatarikh" class="form-control" id="tatarikh" placeholder="تا تاریخ">';
    var aztarikhLimit;
    $(".dateValue2").pDatepicker({
        format: "YYYY-MM-DD",
        maxDate: <?php echo strtotime(date("Y-m-d") . ' - 1 day') . '000'; ?>,
        altFieldFormatter : function(ff){
            var obj = $(this.inputElem[0]);
            if(obj.prop('id')==='aztarikh')
            {
                aztarikhLimit = ff;
                                
            }
        },
        onSelect : function(){
            var obj = $(this.inputElem[0]);
            if(obj.prop('id')==='aztarikh')
            {
                $("#tatarikh").remove();
                obj.parent().next().append(tat);
                $("#tatarikh").pDatepicker({
                    format: "YYYY-MM-DD",
                    maxDate: aztarikhLimit,
                    minDate : 0,
                    timePicker: {
                        enabled: false
                    },
                    autoClose : true
                });
                var azta = $("#aztarikh").val().split('-');
                $("#tatarikh").pDatepicker("setDate",[parseInt(azta[0],10),parseInt(azta[1],10),parseInt(azta[2],10),0,0]);
            }
            
        },
        minDate: 0,
        timePicker: {
            enabled: false
        },
        autoClose : true
    });
    $('.gh-city').select2({
        dir: "rtl"
    }).on("select2-selecting",function(){
        console.log('a');
        /*
        $('.select2-search').on("keydown", function(e) {
            console.log(e.keyCode);
        });
        */
    });
    /*
     $(".dateValue2").datepicker({
     numberOfMonths: 2,
     showButtonPanel: true
     });
     */
</script>
</body>
</html>

