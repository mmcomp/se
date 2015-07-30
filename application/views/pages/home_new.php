<?php ?>
<div class="row" style="margin-top: 10px;">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-4">
                <form role="form" style="padding: 10px; background-color: #34363d;">
                    <div class="radio-inline" style="color: #fff;">
                        <label><input type="radio" name="optradio">یک طرفه</label>
                    </div>
                    <div class="radio-inline" style="color: #fff;">
                        <label><input type="radio" name="optradio">دو طرفه</label>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="sel1">
                            <option>مبدا</option>
                            <option>مشهد</option>
                            <option>تهران</option>
                            <option>اصفهان</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="sel1">
                            <option>مقصد</option>
                            <option>مشهد</option>
                            <option>تهران</option>
                            <option>اصفهان</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control dateValue2" placeholder="از تاریخ">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control dateValue2" placeholder="تا تاریخ">
                    </div>
                    <button type="submit" class="btn btn-block btn-success">جستجو</button>
                </form>
            </div>
            <div class="col-sm-8">
                <img class="img-responsive" width="400" height="300" src="<?php echo asset_url(); ?>images/img/slideshow1.png" alt="Chania" width="460" height="345"> 
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
</div>
