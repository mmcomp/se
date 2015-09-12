<?php
    session_destroy();
    session_start();
    $out = '';
    if(isset($_REQUEST['username']))
    {
        $out = 'نام کاربری یا رمز عبور اشتباه است';
        $my = new mysql_class;
        $my->ex_sql("select id,password from login where username = '".$_REQUEST['username']."'", $q);
        if(isset($q[0]))
        {
            if($q[0]['password'] == $_REQUEST['password'])
            {
                $_SESSION['user_id'] = (int)$q[0]['id'];
                redirect("admin");
            }
        }
    }
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            
            <form  method="post" style="width: 300px; margin: 100px auto !important; border: 1px solid gray; padding: 30px; border-radius: 5px; background-color: #eee;">
                <h1 style="font-size: 16px; text-align: center; color: red; padding-bottom: 5px;"><?php echo $out; ?></h1>
                <input class="form-control" style="width: 100%; margin-bottom: 10px;" type="text" name="username" placeholder="نام کاربری">
                <input class="form-control" style="width: 100%; margin-bottom: 10px;" type="password" name="password" placeholder="رمز عبور">
                <button style="border-color: gray;" type="submit" class="btn btn-default">ورود</button>
            </form>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>