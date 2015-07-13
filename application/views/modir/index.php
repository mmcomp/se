<?php
if($logged_in) {
    $mostRead='';
    $qu = "select id,name from types order by id";
    $res = $this->db->query($qu);
    foreach($res->result_array() as $r)
    {
        $mostRead.='<div style="border:solid 1px #ddd;padding:5px;" ><h3>'.$r['name'].'</h3></div>';
        $mostRead.=$this->visitor_model->drawMostRead($this->visitor_model->mostRead($r['id'],10),FALSE,TRUE);
    }     
?>

<div class="er-admin-contaner uk-container uk-container-center">
	<h2 class="er-admin-title">صفحه اصلی مدیریت</h2>
	<hr>
        <div>
            <?php echo $mostRead; ?>
        </div>
</div>
<?php 
}
else
    redirect ($base_url.'modir/login');