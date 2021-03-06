<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>查询结果</title>

    <!-- Bootstrap Core CSS -->
    <link href="/course/Public/html/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/course/Public/html/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/course/Public/html/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/course/Public/html/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#"><?php echo ($name); ?>，你好</a>
            <a class="navbar-brand" href="<?php echo U('Login/logout');?>">注销</a>
            <a class="navbar-brand" href="<?php echo U('Teacher/t3');?>">返回</a>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">

                <div style="margin: 60px 30px 30px 30px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>课程信息</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" style="width: 100%">
                                    <form action="courseinfo" method="post">
                                        <input type="text" style="width:30%" name="key" class="form-control" placeholder="课程编号，课程名称">
                                    </form>
                                    <br />
                                    <thead>
                                    <tr>
                                        <th>课程编号</th>
                                        <th>课程名称</th>
                                        <th>教师</th>
                                        <th>学分</th>
                                        <th>适于班级</th>
                                        <th>取消年份</th>
                                        <th>删除</th>
                                        <th>修改</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($course)): $i = 0; $__LIST__ = $course;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$course): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($course["cid"]); ?></td>
                                            <td><?php echo ($course["cname"]); ?></td>
                                            <td><?php echo ($course["tname"]); ?></td>
                                            <td><?php echo ($course["credit"]); ?>学分</td>
                                            <td><?php echo ($course["grade"]); ?>级</td>
                                            <td><?php echo ($course["cancelyear"]); ?>年</td>
                                            <td><a href="<?php echo U('Home/Teacher/cordelete');?>?cid=<?php echo ($course["cid"]); ?>">删除</a></td>
                                            <td><a href="<?php echo U('Home/Teacher/courseModify');?>?cid=<?php echo ($course["cid"]); ?>">修改</a></td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                                <a href="courseAdd.html"><button type="button" class="btn btn-lg btn-default">Add</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="/course/Public/html/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/course/Public/html/js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="/course/Public/html/js/plugins/morris/raphael.min.js"></script>
<script src="/course/Public/html/js/plugins/morris/morris.min.js"></script>
<script src="/course/Public/html/js/plugins/morris/morris-data.js"></script>

</body>

</html>