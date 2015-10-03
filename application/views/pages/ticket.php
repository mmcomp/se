<?php
    //echo $p1;
    $out = reserve_class::tickets((int)$p1);
    $pr = '';
    foreach ($out['tickets'] as $ticket)
    {
        $pr .= $ticket;
    }
?>
<iframe class="print"><?php echo $pr; ?></iframe>