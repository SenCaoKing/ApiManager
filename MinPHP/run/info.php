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
}
?>
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
                                <button type="button" class="btn btn-success" onclick="  ">新增</button>
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
                            <td><button type="button" class="btn btn-danger" onclick="  ">删除</button></td>
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

</script>
<!-- 添加接口 end -->

<!-- 接口详情列表与接口管理 end -->