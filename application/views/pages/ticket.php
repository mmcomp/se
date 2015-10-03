<?php

//echo $p1;
$out = reserve_class::tickets((int) $p1);
$pr = '';
if (isset($out['tickets'])) {
    foreach ($out['tickets'] as $ticket) {
        $pr .= $ticket;
    }
} else {
    $pr = "بلیت مورد نظر پیدا نشد";
}
echo $pr;
