<?php
namespace Home\Controller;
use Think\Controller;
class TeacherController extends Controller {
    public function t1(){
        $this->assign('name', $_SESSION['name']);
        $this->display();
    }

    public function t2(){
        $this->assign('name', $_SESSION['name']);
        $this->display();
    }

    public function t3(){
        $this->assign('name', $_SESSION['name']);
        $this->display();
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

        $this->assign('tea', $_SESSION['tea']);
        $this->assign('name', $_SESSION['name']);
        $this->assign('course', $course);
        $this->display();
    }

    public function classMark(){
        if(I('post.')){
            $creditSum = 0;
            $sum = 0;
            $class = I('post.class');
            $connstd = M('student');

            $where1 = array('class' => $class);
            $std = $connstd->where($where1)->select();
            foreach($std as $item1){
                $sid = $item1['sid'];
                $where2 = array('sid' => $sid);
                $connsel = M('select');
                $sel = $connsel->where($where2)->select();

                foreach($sel as $item2){
                    $cid = $item2['cid'];
                    $conncor = M('course');
                    $where3 = array('cid' => $cid);
                    $cor = $conncor->where($where3)->select();

                    foreach($cor as $item3){
                        $credit = $item3['credit'];
                        $creditSum += $credit;
                        $sum += ($credit * $item2['mark']);
                    }
                }
            }

            $classAve = $sum / $creditSum;
        }

        $this->assign('name', $_SESSION['name']);
        $this->assign('class', $class);
        $this->assign('classAve', round($classAve, 2));
        $this->display();
        //print_r($classAve);
    }

    public function studentMark(){
        $creditSum = 0;
        $sum = 0;
        if(I('post.')){
            $sid = I('post.sid');
            $connstd = M('student');
            $where1 = array('sid' => $sid);
            $sname = $connstd->where($where1)->getField('sname');
            $connsel = M('select');
//            $sel = $connsel->where($where1)->select();
//            foreach($sel as $item){
//                $cid = $item['cid'];
//                $where2 = array('cid' => $cid);
//                $conncor = M('course');
//                $credit = $conncor->where($where2)->getField('credit');
//                $creditSum += $credit;
//                $sum += ($credit * $item['mark']);
//            }
            $studentAve = $connsel->where('sid = '.$sid)
                            ->join('course on course.cid = select.cid')
                            ->field('sum(credit * mark)/sum(credit)')
                            ->select();

           // $studentAve = round($sum / $creditSum, 2);
            $this->assign('studentAve', round($studentAve[0]['sum(credit * mark)/sum(credit)'],2));
            $this->assign('sname', $sname);
        }

        $this->assign('name', $_SESSION['name']);
        $this->display();
        //print_r($studentAve);
    }

    public function courseMark(){
//        if(I('post.')){
//            $grade = I('grade');
//
//        }
        $conntea = M('teacher');
        $tid = $_SESSION['id'];
        $where1 = array('tid' => $tid);
        $tname = $conntea->where($where1)->getField('tname');
        $concor = M('course');
        $where2 = array('tname' => $tname);
        $cid = $concor->where($where2)->getField('cid');
        $cname = $concor->where($where2)->getField('cname');
//        $where3 = array('cid' => $cid);
        $connsel = M('select');
//        $mark = $connsel->where($where3)->select();

        $where3['cid'] = $cid;
        $where3['mark'] = array('lt', 60);
        $a = $connsel->where($where3)->count();

        $where3['mark'] = array(array('egt', 60),array('lt', 70));
        $b = $connsel->where($where3)->count();

        $where3['mark'] = array(array('egt', 70),array('lt', 80));
        $c = $connsel->where($where3)->count();

        $where3['mark'] = array(array('egt', 80),array('lt', 90));
        $d = $connsel->where($where3)->count();

        $where3['mark'] = array(array('egt', 90),array('lt', 100));
        $e = $connsel->where($where3)->count();

        $where3['mark'] = array('eq', 100);
        $f = $connsel->where($where3)->count();

        $where4['cid'] = $cid;
        $average = $connsel->where($where4)->avg('mark');

//        $sum = 0;
//        $i = 0;
//        $a = 0;
//        $b = 0;
//        $c = 0;
//        $d = 0;
//        $e = 0;
//        $f = 0;
//        foreach($mark as $value){
//            $sum += $value['mark'];
//            $mark = $value['mark'];
//            if($mark < 60){
//                $a += 1;
//            }elseif($mark < 70){
//                $b += 1;
//            }elseif($mark < 80){
//                $c += 1;
//            }elseif($mark < 90){
//                $d += 1;
//            }elseif($mark < 100){
//                $e += 1;
//            }elseif($mark == 100){
//                $f += 1;
//            }
//            $i += 1;
//        }
//
//        $average = $sum / $i;

        $this->assign('a', $a);
        $this->assign('b', $b);
        $this->assign('c', $c);
        $this->assign('d', $d);
        $this->assign('e', $e);
        $this->assign('f', $f);

        $this->assign('name', $_SESSION['name']);
        $this->assign('cname', $cname);
        $this->assign('average', round($average, 2));
        $this->display();
    }

    public function studentinfo(){
        $conn = M('student');
        $student = $conn->select();

        if(I('post.key')) {
            $key = I('post.key');

            $where['sid'] = array('like', '%' . $key . '%');
            $where['sname'] = array('like', '%' . $key . '%');
            $where['_logic'] = 'or';

            $student = $conn->where($where)->select();
            if ($student == null) {
                echo '<script>alert("无查找结果");</script>';
                $student = $conn->select();
            }
        }

        $this->assign('student', $student);

        $this->assign('name', $_SESSION['name']);
        $this->display();
    }

    public function courseinfo(){
        $conn = M('course');
        $course = $conn->select();

        if(I('post.key')) {
            $key = I('post.key');

            $where['cid'] = array('like', '%' . $key . '%');
            $where['cname'] = array('like', '%' . $key . '%');
            $where['_logic'] = 'or';

            $course = $conn->where($where)->select();
            if ($course == null) {
                echo '<script>alert("无查找结果");</script>';
                $course = $conn->select();
            }
        }

        $this->assign('course', $course);
        $this->assign('name', $_SESSION['name']);
        $this->display();
    }

    public function selectinfo(){
        $conn = M('select');
        $select = $conn->select();
        //$select = array();
//        foreach($select as $item){
//            $where['cid'] = $item['cid'];
//            $conncor = M('course');
//            $cname = $conncor->where($where)->getField('cname');
//            $item['cname'] = $cname;
//            $item1 = $item;
//            $select = array_merge($select, $item);
//            print_r($item);
//        }

        if(I('post.key')) {
            $key = I('post.key');

            $where['cid'] = array('like', '%' . $key . '%');
            $where['sid'] = array('like', '%' . $key . '%');
            $where['_logic'] = 'or';

            $select = $conn->where($where)->select();
            if ($select == null) {
                echo '<script>alert("无查找结果");</script>';
                $select = $conn->select();
            }
        }

        $this->assign('select', $select);
        $this->assign('name', $_SESSION['name']);
        $this->display();
        //print_r($select);
    }

    public function stddelete(){
        $conn = M('student');
        $sid = I('get.sid');
        $result = $conn->where('sid = '.$sid)->delete();
        if($result){
            echo "<script>alert('删除成功');</script>";
        }else{
            echo "<script>alert('删除失败');</script>";
        }
        echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/studentinfo';</script>";
    }

    public function cordelete(){
        $conn = M('course');
        $cid = I('get.cid');
        $result = $conn->where('cid = '.$cid)->delete();
        if($result){
            echo "<script>alert('删除成功');</script>";
        }else{
            echo "<script>alert('删除失败');</script>";
        }
        echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/courseinfo';</script>";
    }

    public function seldelete(){
        $conn = M('select');
        $id = I('get.id');
        $result = $conn->where('id = '.$id)->delete();
        if($result){
            echo "<script>alert('删除成功');</script>";
        }else{
            echo "<script>alert('删除失败');</script>";
        }
        echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectinfo';</script>";
    }

    public function studentModify(){
        $sid = I('get.sid');
        $conn = M('student');
        $student = $conn->where('sid = '.$sid)->select();

        $this->assign('sid', $sid);
        $this->assign('sname', $student[0]['sname']);
        $this->assign('inage', $student[0]['inage']);
        $this->assign('inyear', $student[0]['inyear']);
        $this->assign('class', $student[0]['class']);

        if(I('post.')){
            $save['sname'] = $cname = I('post.sname');
            $save['inage'] = $tname = I('post.inage');
            $save['inyear'] = $credit = I('post.inyear');
            $save['class'] = $year = I('post.class');

            $result = $conn->where('sid = '.$sid)->save($save);
            if($result){
                echo "<script>alert('修改成功');</script>";
                echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/studentModify?sid=$sid';</script>";
            }
            else{
                echo "<script>alert('修改失败');</script>";
            }
        }
        $this->assign('name', $_SESSION['name']);
        $this->display();
    }

    public function courseModify(){
        $cid = I('get.cid');
        $conn = M('course');
        $course = $conn->where('cid = '.$cid)->select();

        $this->assign('cid', $cid);
        $this->assign('cname', $course[0]['cname']);
        $this->assign('tname', $course[0]['tname']);
        $this->assign('credit', $course[0]['credit']);
        $this->assign('grade', $course[0]['grade']);
        $this->assign('cancelyear', $course[0]['cancelyear']);

        if(I('post.')){
            $save['cname'] = $cname = I('post.cname');
            $save['tname'] = $tname = I('post.tname');
            $save['credit'] = $credit = I('post.credit');
            $save['year'] = $year = I('post.year');
            $save['cancelyear'] = $cancelyear = I('post.cancelyear');

            $result = $conn->where('cid = '.$cid)->save($save);
            if($result){
                echo "<script>alert('修改成功');</script>";
                echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/courseModify?cid=$cid';</script>";
            }
            else{
                echo "<script>alert('修改失败');</script>";
            }
        }
        $this->assign('name', $_SESSION['name']);
        $this->display();
    }

    public function selectModify(){
        $bool = true;
        $conncor = M('course');
        $connstd = M('student');
        $course = $conncor->select();
        $student = $connstd->select();

        $id = I('get.id');
        $conn = M('select');
        $select = $conn->where('id = '.$id)->select();

        $this->assign('id', $id);
        $this->assign('sid', $select[0]['sid']);
        $this->assign('cid', $select[0]['cid']);
        $this->assign('year', $select[0]['year']);
        $this->assign('mark', $select[0]['mark']);

        if(I('post.')) {
            $save['cid'] = $cid = I('post.cid');
            $save['sid'] = $sid = I('post.sid');
            $save['year'] = $year = I('post.year');
            $save['mark'] = $mark = I('post.mark');
//            $cancelyear = $conncor->where('cid ='. $cid)->getField('cancelyear');
//            if($year > $cancelyear){
//                echo "<script>alert('该课程已取消');</script>";
//            }
//            else{
//                $result = $conn->where('id = '.$id)->save($save);
//                if($result){
//                    echo "<script>alert('修改成功');</script>";
//                    echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectModify?id=$id';</script>";
//                }
//                else{
//                    echo "<script>alert('修改失败');</script>";
//                }
//            }
//        }

            foreach ($student as $item1) {
                if ($item1['sid'] == $sid) {
                    foreach ($course as $item2) {
                        if ($item2['cid'] == $cid) {
                            $cancelyear = $conncor->where('cid = ' . $cid)->getField('cancelyear');
                            if ($year >= $cancelyear) {
                                echo "<script>alert('该门课程已取消');</script>";
                                echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectModify?id=$id';</script>";
                            } else {
                                $wherestd = array('sid' => $sid);
                                $inyear = $connstd->where($wherestd)->getField('inyear');
                                $wherecor = array('cid' => $cid);
                                $grade = $conncor->where($wherecor)->getField('grade');
                                if ($inyear > $grade) {
                                    echo "<script>alert('该学生未到达适合年级');</script>";
                                    echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectModify?id=$id';</script>";
                                } else {
//                                    $conn = M('select');
//                                    $select = $conn->select();
//                                    foreach ($select as $item) {
//                                        if ($sid == $item['sid'] && $cid == $item['cid']) {
//                                            $bool = false;
//                                            echo "<script>alert('该学生已选过该门课程');</script>";
//                                            echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectModify?id=$id';</script>";
//                                        }
//                                    }
                                    //if ($bool) {
                                        $result = $conn->where('id = ' . $id)->save($save);
                                        if ($result) {
                                            echo "<script>alert('修改成功');</script>";
                                            echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectModify?id=$id';</script>";
                                        } else {
                                            echo "<script>alert('修改失败');</script>";
                                            echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectModify?id=$id';</script>";
                                        }
                                   // }
                                }
                            }
                        }
                    }
                    echo "<script>alert('该课程不存在');</script>";
                    echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectModify?id=$id';</script>";
                }
            }
            echo "<script>alert('该学生不存在');</script>";
            echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectModify?id=$id';</script>";
        }
        $this->assign('name', $_SESSION['name']);
        $this->display();
    }

    public function courseAdd(){
        $bool = true;
        if(I('post.')){
            $add['cid'] = $cid = I('post.cid');
            $add['cname'] = $cname = I('post.cname');
            $add['tname'] = $tname = I('post.tname');
            $add['credit'] = $credit = I('post.credit');
            $add['grade'] = $grade = I('post.grade');
            $add['cancelyear'] = $cancelyear = I('post.cancelyear');
            if(empty($cid) || empty($cname) || empty($tname) || empty($credit) || empty($grade)){
                echo "<script>alert('请填写完整的课程信息');</script>";
            }
            else{
                if(strlen($cid) != 7){
                    echo "<script>alert('课程编号不符合要求');</script>";
                }
                else{
                    $conn = M('course');
                    $course = $conn->select();
                    foreach($course as $item){
                        if($cid == $item['cid']){
                            $bool = false;
                            echo "<script>alert('课程编号已占用');</script>";
                            echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/courseAdd';</script>";
                        }
                    }
                    if($bool){
                        $result = $conn->add($add);
                        if($result){
                            echo "<script>alert('添加成功');</script>";
                        }
                        else{
                            echo "<script>alert('添加失败');</script>";
                        }
                    }
                }
            }
        }
        $this->assign('name', $_SESSION['name']);
        $this->display();
    }

    public function studentAdd(){
        $bool = true;
        if(I('post.')) {
            $add['sid'] = $sid = I('post.sid');
            $add['sname'] = $sname = I('post.sname');
            $add['inage'] = $inage = I('post.inage');
            $add['inyear'] = $inyear = I('post.inyear');
            $add['class'] = $class = I('post.class');
            $add['sex'] = $sex = I('post.sex');
            $add['password'] = '123';
            if (empty($sid) || empty($sname) || empty($inage) || empty($inyear) || empty($class) || empty($sex)) {
                echo "<script>alert('请填写完整的学生信息');</script>";
            } else {
                if($inage > 50 || $inage < 10){
                    echo "<script>alert('学生年龄不符合要求');</script>";
                }
                else{
                    if(strlen($sid) != 10){
                        echo "<script>alert('学号长度不符合要求');</script>";
                    }
                    else{
                        $conn = M('student');
                        $student = $conn->select();
                        foreach($student as $item){
                            if($sid == $item['sid']){
                                $bool = false;
                                echo "<script>alert('学号已占用');</script>";
                                echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/studentAdd';</script>";
                            }
                        }
                        if($bool){
                            $result = $conn->add($add);
                            if ($result) {
                                echo "<script>alert('添加成功');</script>";
                            } else {
                                echo "<script>alert('添加失败');</script>";
                            }
                        }
                    }
                }
            }
        }
        $this->assign('name', $_SESSION['name']);
        $this->display();
    }

    public function selectAdd(){
        $bool = true;
        $conncor = M('course');
        $connstd = M('student');
        $course = $conncor->select();
        $student = $connstd->select();
        if(I('post.')) {
            $add['sid'] = $sid = I('post.sid');
            $add['cid'] = $cid = I('post.cid');
            $add['year'] = $year = I('post.year');
            $add['mark'] = $mark = I('post.mark');
            if (empty($sid) || empty($cid) || empty($year)) {
                echo "<script>alert('请填写完整的选课信息');</script>";
            } else {
                foreach($student as $item1){
                    if($item1['sid'] == $sid){
                        foreach($course as $item2){
                            if($item2['cid'] == $cid){
                                $cancelyear = $conncor->where('cid = '.$cid)->getField('cancelyear');
                                if($year >= $cancelyear){
                                    echo "<script>alert('所选课程已取消');</script>";
                                    echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectAdd';</script>";
                                }
                                else{
                                    $wherestd = array('sid' => $sid);
                                    $inyear = $connstd->where($wherestd)->getField('inyear');
                                    $wherecor = array('cid' => $cid);
                                    $grade = $conncor->where($wherecor)->getField('grade');
                                    if($inyear > $grade){
                                        echo "<script>alert('该学生未到达适合年级');</script>";
                                        echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectAdd';</script>";
                                    }
                                    else{
                                        $conn = M('select');
                                        $select = $conn->select();
                                        foreach($select as $item){
                                            if($sid == $item['sid'] && $cid == $item['cid']){
                                                $bool = false;
                                                echo "<script>alert('该学生已选过该门课程');</script>";
                                                echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectAdd';</script>";
                                            }
                                        }
                                        if($bool){
                                            $result = $conn->add($add);
                                            if ($result) {
                                                echo "<script>alert('添加成功');</script>";
                                                echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectAdd';</script>";
                                            }
                                            else {
                                                echo "<script>alert('添加失败');</script>";
                                                echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectAdd';</script>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        echo "<script>alert('该课程不存在');</script>";
                        echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectAdd';</script>";
                    }
                }
                echo "<script>alert('该学生不存在');</script>";
                echo "<script>window.location.href='http://localhost/course/index.php/Home/Teacher/selectAdd';</script>";
            }
        }
        $this->assign('name', $_SESSION['name']);
        $this->display();
    }
}