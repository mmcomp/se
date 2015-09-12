<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$menu = $_REQUEST['menu'];
$my = new mysql_class();
$my->ex_sql("select content from menu where title = '$menu'", $q);
if (isset($q[0])) {
    $data = $q[0]['content'];
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8"><?php echo $data; ?></div>
        <div class="col-sm-2"></div>
    </div>
</div>