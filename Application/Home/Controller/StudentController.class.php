<?php
namespace Home\Controller;
use Think\Controller;
class StudentController extends Controller {
    public function index(){
        $this->assign('name', $_SESSION['name']);
        $this->show();
    }

    public function info(){
        $connstd = M('student');
        $where1 = array('sid' => $_SESSION['id']);
        $student = $connstd->where($where1)->select();
        $this->assign('student', $student);

        $connsel = M('select');
        $cidarr = $connsel->where($where1)->select();

        $select = array();

        foreach($cidarr as $value){
            $cid = $value['cid'];
            $year['year'] = $value['year'];
            $conncor = M('course');
            $where2 = array('cid' => $cid);
            $selarr = $conncor->where($where2)->select();
            $selarr[0]['year'] = $year['year'];
            $select = array_merge($select, $selarr);
        }

        $this->assign('name', $_SESSION['name']);
        $this->assign("select", $select);
        $this->assign("year", $year);
        $this->display();
//        print_r($select);
    }

    public function course(){
        if(I('post.')){

            $cid = I('post.cid');
            $cname = I('post.cname');

            if(!empty($cid)){
                $where1 = array('cid' => $cid);
                $conncor = M('course');
                $course = $conncor->where($where1)->select();
                $connsel = M('select');
                $count = $connsel->where($where1)->count();

                $course[0]['count'] = $count;
            }
            elseif(!empty($cname)){
                $where2 = array('cname' => $cname);
                $conncor = M('course');
                $course = $conncor->where($where2)->select();
                $cid = $conncor->where($where2)->getField('cid');
                $where1 = array('cid' => $cid);
                $connsel = M('select');
                $count = $connsel->where($where1)->count();
                $course[0]['count'] = $count;
            }
            else{
                echo "<script>alert('请输入查询信息');</script>";
            }
        }

        $this->assign('name', $_SESSION['name']);
        $this->assign('course', $course);
        $this->display();
    }

    public function mark(){
        if(I('post.')){
            $cid = I('post.cid');
            $cname = I('post.cname');

            if(!empty($cid)){
                $where1 = array('cid' => $cid, 'sid' => $_SESSION['id']);
                $connsel = M('select');
                $mark = $connsel->where($where1)->select();
                if(!$mark){
                    echo "<script>alert('未选择该门课程');</script>";
                }
                $where2 = array('cid' => $cid);
                $conncor = M('course');
                $cname = $conncor->where($where2)->getField('cname');
                $mark[0]['cname'] = $cname;
            }
            elseif(!empty($cname)){
                $where2 = array('cname' => $cname);
                $conncor = M('course');
                $cid = $conncor->where($where2)->getField('cid');
                $where1 = array('cid' => $cid, 'sid' => $_SESSION['id']);
                $connsel = M('select');
                $mark = $connsel->where($where1)->select();
                if(!$mark){
                    echo "<script>alert('未选择该门课程');</script>";
                }
                $mark[0]['cname'] = $cname;
            }
            else{
                echo "<script>alert('请输入查询信息');</script>";
            }
        }

        $this->assign('name', $_SESSION['name']);
        $this->assign('mark', $mark);
        $this->display();
    }

    public function pwd(){
        $conn = M('student');
        if(I('post.')){
            $pwd = I('pwd');
            $pwdcon = I('pwdcon');
            if($pwd != $pwdcon){
                echo "<script>alert('两次密码不一致');</script>";
            }
            else{
                $save['password'] = $pwd;
                $where = array('sid' => $_SESSION['id']);
                $result = $conn->where($where)->save($save);
                if($result){
                    echo "<script>alert('修改成功');</script>";
                }
                else{
                    echo "<script>alert('修改失败');</script>";
                }
            }
        }
        $this->display();
    }

    public function select(){
        $conncor = M('course');
        $connstd = M('student');
        $connsel = M('select');
        $year = date('Y');
        $where['cancelyear'] = array('gt', $year);
        $inyear = $connstd->where('sid ='.$_SESSION['id'])->getField('inyear');
        $where['grade'] = $inyear;
        $courseitem = $conncor->where($where)->select();

        $course = array();
        $i = 0;
        $add = true;
        foreach($courseitem as $item){
            $where['sid'] = $_SESSION['id'];
            $selcid = $connsel->where($where)->select();
            foreach($selcid as $item1){
                if($item['cid'] == $item1['cid']){
                    $add = false;
                }
            }
            if($add){
                $course[$i] = $item;
            }
            $i = $i + 1;
        }

        $this->assign('name', $_SESSION['name']);
        $this->assign('course', $course);
        $this->display();
//        print_r($selcid);
//        echo '<br />';
//        print_r($courseitem);
//        echo '<br />';
//        print_r($course);
    }

    function selectAdd(){
        $success = true;
        $conncor = M('course');
        $connstd = M('student');
        $connsel = M('select');
        $year = date('Y');
        if(I('post.')){
            $is = I('post.id');
            foreach($is as $item){
                $addSel['cid'] = $item;
                $addSel['sid'] = $_SESSION['id'];
                $addSel['year'] = $year;

                $result = $connsel->add($addSel);
                if(!$result){
                    $success = false;
                }
            }

            //print_r($addSel);
            if($success){
                echo "<script>alert('选课成功');</script>";
            }
            else{
                echo "<script>alert('操作失败');</script>";
            }
            echo "<script>window.location.href='http://localhost/course/index.php/Home/Student/select';</script>";
        }
    }
}