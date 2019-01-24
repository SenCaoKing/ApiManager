<?php defined('API') or exit('https://baidu.com');?>
<!-- 导航 -->
<?php if($act != 'api'){
    $list = select('select * from cate where isdel=0 order by addtime desc');
?>
    <div class="form-group">
        <input type="text" class="form-control" id="searchcate" onkeyup="  " placeholder="search here">
    </div>
    <div class="list">
        <ul class="list-unstyled">
            <?php foreach($list as $v){ ?>
            <form action="?act=cate" method="post">
                <li class="menu" id="info_<?php echo $v['aid'];?>">
                    <a href="<?php echo U(array('act' => 'api', 'tag' => $v['aid']));?>">
                        <?php echo $v['cname'] ?>
                    </a>
                    <br>
                    <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $v['cdesc'];echo "<input type='hidden' name='aid' value='{$v['aid']}'>";?>
                    <br>
                    <?php if(is_supper()){ ?>
                        <!-- 只有超级管理员才可以对分类进行操作 -->
                        <div style="float: right; margin-right: 16px;">
                            &nbsp;<button class="btn btn-danger btn-xs" name="op" value="delete" onclick="javascript:return confirm('您确认要删除吗？')">delete</button>
                            &nbsp;<button class="btn btn-info btn-xs" name="op" value="edit">edit</button>
                        </div>
                        <br>
                    <?php } ?>
                    <hr>
                </li>
                <!-- 接口分类关键字(js通过此关键字进行模糊查找) start -->
                <span class="keyword" id="<?php echo $v['aid'];?>"><?php echo $v['cdesc'] . '<|-|>' . $v['cname'];?></span>
                <!-- 接口分类关键字(js通过此关键字进行模糊查找) end -->
            </form>
            <?php } ?>
        </ul>
    </div>

    <form action="?act=cate" method="post">
        <?php if(is_supper()){ ?>
            <!-- 只有超级管理员才可以添加分类 -->
            <div style="float: right; margin-right: 20px;">
                <button class="btn btn-success" name="op" value="add">新建分类</button>
            </div>
        <?php } ?>
    </form>
<?php } else { ?>


    <div class="form-group">
        <input type="text" class="form-control" id="searchapi" placeholder="search here" onkeyup="  ">
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
    <form action="?act=api&tag=<?php echo $_GET['tag'];?>&op=add" method="post">
        <?php if(is_supper()){ ?>
            <!-- 只有超级管理员才可以添加接口 -->
            <div style="float: right; margin-right: 20px;">
                <input type="hidden" value="<?php echo $_GET['tag']?>" name="aid">
                <button class="btn btn-success">新建接口</button>
            </div>
        <?php } ?>
    </form>
<?php } ?>

<!-- jquery  -->
<script type="text/javascript">

</script>