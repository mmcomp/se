<div class="hs-margin-up-down" >
<?php
        if ( ! defined('BASEPATH')) exit('No direct script access allowed');
        echo $this->contents_model->loadMainMenu(FALSE);
        $mostRead = $this->visitor_model->drawMostRead($this->visitor_model->mostRead(6,15)); 
?>
</div>
<div class="row" >
    <div class="col-sm-8" >
        <div class="hs-border hs-perpul hs-padding hs-nav-justify" >
            <span class="glyphicon glyphicon-ok"></span>
           رویدادها
            <div class="hs-float-left" >
                <span class="glyphicon glyphicon-chevron-down"></span>
            </div>
        </div>
        <div class="hs-border hs-margin-up-down hs-padding" >
            
            <!-- <ul class="hs-ul" > -->
                <?php
                    echo $this->contents_model->type_loadContent($page_addr,6,$page,15);
                ?>   
            <!-- </ul> -->
        </div>
    </div>    
    <div class="col-sm-2" >
        <div>
            <div class="hs-perpul hs-border hs-padding" >
                <small>
                پربازدید ترین‌های
                رویدادها
                </small>
            </div>
            <div class="hs-border hs-padding hs-margin-up-down" >
                <?php echo $mostRead; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-2" >
        <?php echo $this->ad_model->loadAllAds(); ?>
    </div>
</div>
