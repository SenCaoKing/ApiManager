<!-- 登录与退出 start -->
<?php defined('API') or exit('https://baidu.com');?>
<?php
$type = I($_GET['type']);
// 登录
if($type == 'do'){
    $_VAL = I($_POST);
    
}



?>
<div style="border: 1px solid #ddd;">
    <div style="background: #f5f5f5; padding: 20px; position: relative;">
        <h4>登录</h4>
        <div>
            <form action="?act=login&type=do" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="登录名">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="pwd" placeholder="密码">
                </div>
                <button class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<!-- 登录与退出 end -->