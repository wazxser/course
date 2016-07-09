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
            <a class="navbar-brand" href="<?php echo U('Teacher/t2');?>">返回</a>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">

                <div style="margin: 60px 30px 30px 30px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>查询</h3>
                        </div>
                        <div class="panel-body">
                            <style type="text/css">
                                input{
                                    margin: 0px 0px 0px 260px;
                                }
                                label{
                                    margin: 0px 0px 0px 260px;
                                }
                                button{
                                    margin: 0px 0px 10px 260px;
                                }
                            </style>
                            <form role="form" action="classMark" method="post">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>输入所要查询的班级:</label>
                                        <input style="width:410px;" type="text" name="class" class="form-control">
                                    </div>
                                    <br />

                                    <div class="form-group col-lg-12">
                                        <input type="hidden" name="save" value="contact">
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">

                <div style="margin: 60px 30px 30px 30px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>班级加权平均成绩</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" style="width: 100%">
                                    <h3><?php echo ($class); ?>班：<?php echo ($classAve); ?></h3>
                                </table>
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