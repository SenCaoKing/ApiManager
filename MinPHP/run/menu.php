<?php defined('API') or exit('https://baidu.com');?>
<!-- 导航 -->



<div class="form-group">
    <input type="text" class="form-control" id="searchcate" onkeyup="" placeholder="search here">
</div>
<div class="list">
    <ul class="list-unstyled">

        <form action="?act=cate" method="post">
            <li class="menu" id="info">
                <a href="">
                    会员登录
                </a>
                <br>

                <br>


                <div style="float: right; margin-right: 16px;">
                    &nbsp;<button class="btn btn-danger btn-xs" name="op" value="delete" onclick="javascript:return confirm('您确认要删除吗？')">delete</button>
                    &nbsp;<button class="btn btn-info btn-xs" name="op" value="edit">edit</button>
                </div>
                <br>

                <hr>
            </li>

            <span class="keyword" id="">111</span>

        </form>

    </ul>
</div>

<form action="?act=cate" method="post">


    <div style="float: right; margin-right: 20px;">
        <button class="btn btn-success" name="op" value="add">新建分类</button>
    </div>

</form>



<div class="form-group">
    <input type="text" class="form-control" id="searchapi" placeholder="search here" onkeyup="">
</div>
<div class="list">
    <ul class="list-unstyled" style="padding: 10px;">

        <li class="menu" id="api ">
            <a href=" ">
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>

            </a>
        </li>

        <span class="keyword" id=" "></span>


    </ul>
</div>
<form action="?act=api " method="post">


    <div style="float: right; margin-right: 20px;">
        <input type="hidden" value="" name="aid">
        <button class="btn btn-success">新建接口</button>
    </div>

</form>

<!-- jquery  -->
<script type="text/javascript">
    
</script>