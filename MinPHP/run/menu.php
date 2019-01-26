<?php defined('API') or exit('https://baidu.com');?>
<!-- 导航 -->
<?php if($act != 'api' && $act != 'sort'){
    $list = select('select * from cate where isdel=0 order by addtime desc');
?>
    <div class="form-group">
        <input type="text" class="form-control" id="searchcate" onkeyup="search('cate', this)" placeholder="search here">
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
<?php } else {
    $sql = "select * from api where aid = '{$_GET['tag']}' and isdel='0' order by ord desc, id desc";
    $list = select($sql);?>
    <div class="form-group">
        <input type="text" class="form-control" id="searchapi" placeholder="search here" onkeyup="search('api', this)">
    </div>
    <div class="list">
        <ul class="list-unstyled" style="padding: 10px;">
            <?php foreach($list as $v){ ?>
                <li class="menu" id="api_<?php echo md5($v['id']);?>">
                    <a href="<?php echo U(array('act' => 'api', 'tag' => $_GET['tag']));?>#info_api_<?php echo md5($v['id']);?>" id="<?php echo 'menu_' . md5($v['id]']);?>">
                        <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                        <?php echo $v['name'];?>
                    </a>
                </li>
                <!-- 接口关键字(js通过此关键字进行模糊查找) start -->
                <span class="keyword" id="<?php echo md5($v['id']);?>"><?php echo $v['name'].'<|-|>'.$v['num'].'<|-|>'.$v['des'].'<|-|>'.$v['memo'].'<|-|>'.$v['parameter'].'<|-|>'.$v['url'].'<|-|>'.$v['type'].'<|-|>'.strtolower($v['type']);?></span>
                <!-- 接口关键字(js通过此关键字进行模糊查找) end -->
            <?php } ?>
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
<!-- jquery模糊查询 start -->
<script>
    function search(type, obj){
        var $find = $.trim($(obj).val()); // 得到搜索内容
        if(type == 'cate'){ // 对接口分类进行搜索操作
            if($find != ''){
                $(".menu").hide();
                // 找到符合关键字的对象
                var $keywordobj = $(".keyword:contains('"+$find+"')");
                $keywordobj.each(function(i) {
                    var menu_id = $($keywordobj[[i]]).attr('id');
                    $("#info_"+menu_id).show();
                });
            }else{
                $(".menu").show(); // 在没有搜索内容的情况下，左侧导航菜单 全部 显示
            }
        }else if(type == 'api'){ // 对接口进行搜索操作
            if($find != ''){
                $(".menu").hide(); // 左侧导航菜单隐藏
                $(".info_api").hide();
                // 找到符合关键字的对象
                var $keywordobj = $(".keyword:contains('"+$find+"')");
                $keywordobj.each(function(i) {
                    var menu_id = $($keywordobj[i]).attr('id');
                    $("#api_"+menu_id).show(); // 左侧导航菜单 部分隐藏
                    $("#info_api_"+menu_id).show(); // 接口详情 部分 隐藏
                });
            }else{
                $(".menu").show(); // 在没有搜索内容的情况下，左侧导航菜单 全部 显示
                $(".info_api").show(); // 在没有搜索内容的情况下，接口详情 全部 显示
            }
        }
    }
</script>
<!-- jquery模糊查询 end -->
<!-- end -->