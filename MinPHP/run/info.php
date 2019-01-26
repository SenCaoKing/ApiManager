<?php defined('API') or exit();?>
<!-- 接口详情列表与接口管理 start -->
<?php
$_VAL = I($_POST);
// 操作类型(add,delete,update)
$op = $_GET['op'];
$type = $_GET['type'];
// 添加接口
if($op == 'add'){
    if($type == 'do'){
        if(!is_supper()){ die('只有超级管理员才可对接口进行操作'); }
        $aid = I($_GET['tag']); // 所属分类
        if(empty($aid)){
            die('<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 所属分类不能为空');
        }
        $num = htmlspecialchars($_POST['num'], ENT_QUOTES); // 接口编号(为了把编号的前导0过滤掉。不用I方法过滤)
        $name = $_VAL['name']; // 接口名称
        $memo = $_VAL['memo']; // 备注
        $des  = $_VAL['des'];  // 描述
        $type = $_VAL['type']; // 请求方式
        $url  = $_VAL['url'];

        $parameter = serialize($_VAL['p']);
        $re = $_VAL['re']; // 返回值
        $lasttime = time(); // 最后操作时间
        $lastuid = session('id'); // 操作者id
        $isdel = 0; // 是否删除的标识
        $sql = "insert into api (
        `aid`,`num`,`name`,`des`,`url`,
        `type`,`parameter`,`re`,`lasttime`,
        `lastuid`,`isdel`,`memo`
        ) values (
        '{$aid}','{$num}','{$name}','{$des}','{$url}',
        '{$type}','{$parameter}','{$re}','{$lasttime}',
        '{$lastuid}','{$isdel}','{$memo}'
        )";
        $re = insert($sql);
        if($re){
            go(U(array('act' => 'api', 'tag' => $_GET['tag'])));
        }else{
            echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 添加失败</div>';
        }
    }
    // 修改接口
}else if($op == 'edit'){
    if(!is_supper()){ die('只有超级管理员才可对接口进行操作'); }

    // 此分类下的接口列表
}else{
    $sql = "select api.id,aid,num,url,name,des,parameter,memo,re,lasttime,lastuid,type,login_name 
    from api 
    left join user 
    on api.lastuid=user.id 
    where aid='{$_GET['tag']}' and api.isdel=0 
    order by ord desc,api.id desc";
    $list = select($sql);
}
?>
<?php if($op == 'add'){ ?>
    <!-- 添加接口 start -->
    <div style="border: 1px solid #ddd;">
        <div style="background: #f5f5f5; padding: 20px; position: relative;">
            <h4>添加接口<span style="font-size: 12px; padding-left: 20px; color: #a94442;">注:"此色"边框为必填项</span></h4>
            <div style="margin-left: 20px;">
                <form action="?act=api&tag=<?php echo $_GET['tag'];?>&type=do&op=add" method="post">
                    <h5>基本信息</h5>
                    <div class="form-group has-error">
                        <div class="input-group">
                            <div class="input-group-addon">接口编号</div>
                            <input type="text" class="form-control" name="num" placeholder="接口编号" required="required">
                        </div>
                    </div>
                    <div class="form-group has-error">
                        <div class="input-group">
                            <div class="input-group-addon">接口名称</div>
                            <input type="text" class="form-control" name="name" placeholder="接口名称" required="required">
                        </div>
                    </div>
                    <div class="form-group has-error">
                        <div class="input-group">
                            <div class="input-group-addon">请求地址</div>
                            <input type="text" class="form-control" name="url" placeholder="请求地址" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="des" class="form-control" placeholder="描述"></textarea>
                    </div>
                    <div class="form-group" required="required">
                        <select class="form-control" name="type">
                            <option value="GET">GET</option>
                            <option value="POST">POST</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <h5>请求参数</h5>
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="col-md-3">参数名</th>
                                <th class="col-md-2">必传</th>
                                <th class="col-md-2">缺省值</th>
                                <th class="col-md-4">描述</th>
                                <th class="col-md-1">
                                    <button type="button" class="btn btn-success" onclick="add()">新增</button>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="parameter">
                            <tr>
                                <td class="form-group has-error">
                                    <input type="text" class="form-control" name="p[name][]" placeholder="参数名" required="required">
                                </td>
                                <td>
                                    <select class="form-control" name="p[type][]">
                                        <option value="Y">Y</option>
                                        <option value="N">N</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="p[default][]" placeholder="缺省值"></td>
                                <td><textarea name="p[des][]" rows="1" class="form-control" placeholder="描述"></textarea></td>
                                <td><button type="button" class="btn btn-danger" onclick="del(this)">删除</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <h5>返回结果</h5>
                        <textarea name="re" rows="3" class="form-control" placeholder="返回结果"></textarea>
                    </div>
                    <div class="form-group">
                        <h5>备注</h5>
                        <textarea name="memo" rows="3" class="form-control" placeholder="备注"></textarea>
                    </div>
                    <button class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function add(){
            var $html = '<tr>' +
                '<td class="form-group has-error"><input type="text" class="form-control has-error" name="p[name][]" placeholder="参数名" required="required"></td>' +
                '<td>' +
                '<select class="form-control" name="p[type][]">' +
                '<option value="Y">Y</option> <option value="N">N</option>' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control" name="p[default][]" placeholder="缺省值"></td>' +
                '<td>' +
                '<textarea name="p[des][]" rows="1" class="form-control" placeholder="描述"></textarea>' +
                '</td>' +
                '<td>' +
                '<button type="button" class="btn btn-danger" onclick="del(this)">删除</button>' +
                '</td>' +
                '</tr>';
            $('#parameter').append($html);
        }
        function del(obj){
            $(obj).parents('tr').remove();
        }
    </script>
    <!-- 添加接口 end -->
<?php }else if($op == 'edit'){ ?>
    <!-- 修改接口 start -->

    <!-- 修改接口 end -->
<?php }else{ ?>
    <!-- 接口详细列表 start -->
    <?php if(count($list)){ ?>
        <?php foreach($list as $v){ ?>
            <div class="info_api" style="border: 1px solid #ddd; margin-bottom: 20px;" id="info_api_<?php echo md5($v['id']);?>">
                <div style="background: #f5f5f5; padding: 20px; position: relative;">
                    <div class="textshadow" style="position: absolute; right: 0; top:  4px; right: 8px;">
                        最后修改者：<?php echo $v['login_name'];?> &nbsp;<?php echo date('Y-m-d H:i:s', $v['lasttime']);?>&nbsp;
                        <button class="btn btn-danger btn-xs" onclick=" ">delete</button>&nbsp;
                        <button class="btn btn-info btn-xs" onclick=" ">edit</button>&nbsp;
                    </div>
                    <h4 class="textshadow"><?php echo $v['name'];?></h4>
                    <p>
                        <b>编号&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: red;"><?php echo $v['num'];?></span></b>
                    </p>
                    <div>
                        <kbd><?php echo $v['type'];?></kbd> - <kbd><?php echo $v['url'];?></kbd>
                    </div>
                </div>
                <?php if(!empty($v['des'])){ ?>
                    <div class="info">
                        <?php echo $v['des'];?>
                    </div>
                <?php } ?>
                <div style="background: #ffffff; padding: 20px;">
                    <h5 class="textshadow">请求参数</h5>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="col-md-3">参数名</th>
                            <th class="col-md-2">必传</th>
                            <th class="col-md-2">缺省值</th>
                            <th class="col-md-5">描述</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $parameter = unserialize($v['parameter']);
                        $pnum = count($parameter['name']);
                        ?>
                        <?php for($i=0; $i<$pnum; $i++){ ?>
                            <tr>
                                <td><?php echo $parameter['name'][$i];?></td>
                                <td><?php if($parameter['type'][$i] == 'Y'){echo '<span style="color: red;">Y</span>';}else{echo '<span style="color: green;">N</span>';}?></td>
                                <td><?php echo $parameter['default'][$i];?></td>
                                <td><?php echo $parameter['des'][$i];?></td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div>
                <?php if(!empty($v['re'])){ ?>
                    <div style="background: #ffffff; padding: 20px;">
                        <h5 class="textshadow">返回值</h5>
                        <pre><?php echo $v['re'];?></pre>
                    </div>
                <?php } ?>
                <?php if(!empty($v['memo'])){ ?>
                    <div style="background: #ffffff; padding: 20px;">
                        <div class="textshadow">备注</div>
                        <pre style="background: honeydew;"><?php echo $v['memo'];?></pre>
                    </div>
                <?php } ?>
            </div>
            <!-- 接口详细列表 end -->
        <?php } ?>
    <?php } else { ?>
        <div style="font-size: 16px;">
            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 此分类下还没有任何接口
        </div>
    <?php } ?>
    <script type="text/javascript">
    </script>
<?php } ?>
<!-- 接口详情列表与接口管理 end -->