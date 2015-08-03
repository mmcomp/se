<!-- Footer Here -->

<!--Foooter End-->
    <script>
        $(".dateValue2").pDatepicker({
            format : "YYYY-MM-DD",
            maxDate : 1438630200000,
            minDate : 0,
            timePicker : {
                enabled : false
            },
            onSelect : function(inp)
            {
                console.log(this,inp);
                return(inp);
            }
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

