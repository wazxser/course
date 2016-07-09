<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        $type = I('get.type');

        if($type == "student"){
            $typeid = "学号";
            $_SESSION['type'] = "student";
            $_SESSION['typeid'] = $typeid;
        }elseif($type == "teacher"){
            $typeid = "教工号";
            $_SESSION['type'] = "teacher";
            $_SESSION['typeid'] = $typeid;
        }

        if(empty($type)){
            $type = $_SESSION['type'];
            $typeid = $_SESSION['typeid'];
        }

        session_start();

        if( I('post.') ) {
            $logid = I('post.logid');
            $pwd = I('post.pwd');
            $yanzhengma = I('yanzhengma');
            if($type == "student"){
                $conn = M('student');
                $where = array('sid' => $logid, 'password' => $pwd);
            }
            else{
                $conn = M('teacher');
                $where = array('tid' => $logid, 'password' => $pwd);
            }

            if (empty($logid) or empty($pwd)) {
                echo "<script>alert('请输入用户名和密码');</script>";
                echo "<script>window.location.href='http://localhost/course/index.php/Home/Login/index?type=$type';</script>";
            }
            else {
                if(empty($yanzhengma)){
                    echo "<script>alert('请输入验证码');</script>";
                    echo "<script>window.location.href='http://localhost/course/index.php/Home/Login/index?type=$type';</script>";
                }else{
                    if(!$this->check_verify($yanzhengma)){
                        echo '<script>alert("验证码错误");</script>';
                        echo "<script>window.location.href='http://localhost/course/index.php/Home/Login/index?type=$type';</script>";
                    }
                    else{
                        $result = $conn->where($where)->find();
                        if ($result == null) {
                            echo "<script>alert('登入信息有误');</script>";
                            echo "<script>window.location.href='http://localhost/course/index.php/Home/Login/index?type=$type';</script>";
                        } else {
                            echo "<script>alert('登录成功');</script>";
                            $_SESSION['id'] = $logid;
                            if($type == "student"){
                                $_SESSION['name'] = $conn->where($where)->getField('sname');
                                echo "<script>window.location.href='http://localhost/course/index.php/Home/Student/index';</script>";
                            }else{
                                $right = $conn->where($where)->getField('right');
                                $_SESSION['name'] = $conn->where($where)->getField('tname');
                                if($right == "t1"){
                                    $_SESSION['tea'] = "t1";
                                    echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/t1';</script>";
                                }
                                elseif($right == "t2"){
                                    $_SESSION['tea'] = "t2";
                                    echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/t2';</script>";
                                }
                                else{
                                    $_SESSION['tea'] = "t3";
                                    echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/t3';</script>";
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->assign('typeid', $typeid);
        $this->assign('type', $type);
        $this->show();
    }

    public function dologin(){
        session_start();
        $type = $this->index();
        $logid = I('post.logid');
        $pwd = I('post.pwd');

        if(empty($logid)){
            $this->error('用户名不能为空');
        }

        if(empty($pwd)){
            $this->error('密码不能为空');
        }

        if($type == "Student"){
            $_SESSION['type'] = "student";
            $conn = M('student');
            $where = array('sid' => $logid, 'password' => $pwd);
        }
        else{
            $_SESSION['type'] = "teacher";
            $conn = M('teacher');
            $where = array('tid' => $logid, 'password' => $pwd);
        }

        $result = $conn->where($where)->find();

        if($result != null){
            $_SESSION['id'] = $logid;
            if($type == "Student"){
                $this->success('登录成功', "{:U('Student/index')");
            }
            else{
                $this->success('登录成功', "{:U('Teacher/index')");
            }
        }
        else{
            $this->error('信息有误', "{:U('Login/index'}");
        }
    }

    public function logout(){
        session_destroy();
        echo "<script>window.location.href='http://localhost/course/index.php/Home/Index/index';</script>";
    }


    public function verify(){
        $verify = new \Think\Verify();
        $verify->fontSize = 35;
        $verify->length = 5;
        $verify->useNoise = false;
        $verify->codeSet = "0123456789qwertyuioplkjhgfdsazxcvbnm";
        ob_end_clean();
        $verify->entry();
    }

    public function check_verify($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }
}