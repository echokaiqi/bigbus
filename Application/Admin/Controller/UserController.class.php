<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use Think\Page;
use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class UserController extends AdminController {

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){

    $nickname       =   I('nickname');
    $map['status']  =   array('egt',0);

    if(is_numeric($nickname)){
        $map['uid|nickname']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
    }else{
        $map['nickname']    =   array('like', '%'.(string)$nickname.'%');
    }
    if($_SESSION['bus_admin']['place']['place']>0) $map['place']=$_SESSION['bus_admin']['place']['place'];
    $grop = 1;

    $list   = $this->lists('Member', $map);
//        echo "<pre/s>";
//        print_r($list);die;
    int_to_string($list);
    $uid = UID;
        $group =  $_SESSION['bus_admin']['group_id'];
        $group =(int)$group;
        $group>2? $grop=2:$grop>3?$grop=3:true;


        $this->assign('grop',$grop);
        $this->assign("uid",$uid);
        $this->assign('_list', $list);
        $this->meta_title = '用户信息';
        $this->display();
}
/*
 * 会员信息
 * */
    public function detail(){
        $m=M('home_member');
        $where='id>0';
        $p=getpage($m,$where,5);

        $data = $m
            ->field("id,username,mobile,sex,balance,score,level,reg_time")
            ->order('id asc')
            ->select();
        for($i=0;$i<count($data);$i++){
            $data[$i]['reg_time'] = date(' Y-m-d H:i:s',$data[$i]['reg_time']);
            $page=$p->show();
        }

        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->display();
}
/*
 * 会员行为
 * */
    public function behavior(){
        isset($_GET['pid'])?
            $where=array('a.pid'=>$_GET['pid']):
            isset($_GET['uid'])?
                $where=array('a.uid'=>$_GET['uid']):
                $where = " a.id>=1";

        $data = M('ride')
            ->alias(' a ')
            ->field(' a.*,b.name,c.username ')
            ->join(' left join bus_detail as b on b.id = a.pid ')
            ->join(' left join bus_home_member as c on c.id = a.uid ')
            ->where($where)
            ->order(' time desc ')
            ->select();

        for($i=0;$i<count($data);$i++){
            $data[$i]['time'] = date(' Y-m-d H:i:s',$data[$i]['time']);
        }

        $this->assign('data',$data);
        $this->display();
    }



    /**
     * 修改昵称初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updateNickname(){
        $nickname = M('Member')->getFieldByUid(UID, 'nickname');
        $this->assign('nickname', $nickname);
        $this->meta_title = '修改昵称';
        $this->display('updatenickname');
    }

    /**
     * 修改昵称提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitNickname(){
        //获取参数
        $nickname = I('post.nickname');
        $password = I('post.password');
        empty($nickname) && $this->error('请输入昵称');
        empty($password) && $this->error('请输入密码');

        //密码验证
        $User   =   new UserApi();
        $uid    =   $User->login(UID, $password, 4);
        ($uid == -2) && $this->error('密码不正确');

        $Member =   D('Member');
        $data   =   $Member->create(array('nickname'=>$nickname));
        if(!$data){
            $this->error($Member->getError());
        }

        $res = $Member->where(array('uid'=>$uid))->save($data);

        if($res){
            $user               =   session('user_auth');
            $user['username']   =   $data['nickname'];
            session('user_auth', $user);
            session('user_auth_sign', data_auth_sign($user));
            $this->success('修改昵称成功！');
        }else{
            $this->error('修改昵称失败！');
        }
    }

    /**
     * 修改密码初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updatePassword(){
        $this->meta_title = '修改密码';
        $this->display('updatepassword');
    }

    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitPassword(){
        //获取参数
        $password   =   I('post.old');
        empty($password) && $this->error('请输入原密码');
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error('请输入新密码');
        $repassword = I('post.repassword');
        empty($repassword) && $this->error('请输入确认密码');

        if($data['password'] !== $repassword){
            $this->error('您输入的新密码与确认密码不一致');
        }

        $Api    =   new UserApi();
        $res    =   $Api->updateInfo(UID, $password, $data);
        if($res['status']){
            $this->success('修改密码成功！');
        }else{
            $this->error($res['info']);
        }
    }

    /**
     * 用户行为列表
     * @author huajie <banhuajie@163.com>
     */
    public function action(){
        //获取列表数据
        $Action =   M('Action')->where(array('status'=>array('gt',-1)));
        $list   =   $this->lists($Action);
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->assign('_list', $list);
        $this->meta_title = '用户行为';
        $this->display();
    }

    /**
     * 新增行为
     * @author huajie <banhuajie@163.com>
     */
    public function addAction(){
        $this->meta_title = '新增行为';
        $this->assign('data',null);
        $this->display('editaction');
    }

    /**
     * 编辑行为
     * @author huajie <banhuajie@163.com>
     */
    public function editAction(){
        $id = I('get.id');
        empty($id) && $this->error('参数不能为空！');
        $data = M('Action')->field(true)->find($id);

        $this->assign('data',$data);
        $this->meta_title = '编辑行为';
        $this->display('editaction');
    }

    /**
     * 更新行为
     * @author huajie <banhuajie@163.com>
     */
    public function saveAction(){
        $res = D('Action')->update();
        if(!$res){
            $this->error(D('Action')->getError());
        }else{
            $this->success($res['id']?'更新成功！':'新增成功！', Cookie('__forward__'));
        }
    }

    /**
     * 会员状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        if( in_array(C('USER_ADMINISTRATOR'), $id)){
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['uid'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('Member', $map );
                break;
            case 'resumeuser':
                $this->resume('Member', $map );
                break;
            case 'deleteuser':
                $this->delete('Member', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }

    public function add($username = '', $password = '', $repassword = '', $email = ''){
        if(IS_POST){
            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }

            /* 调用注册接口注册用户 */
            $_SESSION['bus_admin']['place']['place']<=0?$place = 1:$place=$_SESSION['bus_admin']['place']['place'];

            $User   =   new UserApi;
            $uid    =   $User->register($username, $password, $email);
            if(0 < $uid){ //注册成功
                $user = array('uid' => $uid, 'nickname' => $username, 'status' => 1,'place'=>$place);
                if(!M('Member')->add($user)){
                    $this->error('用户添加失败！');
                } else {
                    $this->success('用户添加成功！',U('index'));
                }
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $this->meta_title = '新增用户';
            $this->display();
        }
    }

    /*
     * 管理员的公司调度
     * */

    public function userSend(){
        if(IS_POST){
            $data= I('post.');
            $member =array(
                'uid'=>$data['uid'],
                'place'=>$data['place']
            );
            if(M('member')->save($member)){
                $ucmem = array(
                    'id'=>$data['uid'],
                    'place'=>$data['place']
                );
                if(M('ucenter_member')->save($ucmem)){
                    $gromem = array(
                        'uid'=>$data['uid'],
                        'group_id'=>$data['group']
                    );
                    if(M('auth_group_access')->save($gromem)){
                        $this->success('派遣成功！',U('index'));
                    }else{
                        $this->error('派遣失败!');
                    }
                }else{
                    $this->error('管理员修改失败');
                }
            }else{
                $this->error('用户修改失败');
            }
        }
        if(isset($_GET['uid'])){
            $id = array( 'uid'=>$_GET['uid']);
//            header( 'Content-Type:text/html;charset=utf-8 ');
//            echo "<pre />";
//            print_r($id);die;
            //派遣的人员
            $data = M('member')->where($id)->find();

            //派遣的公司
            $place = M('place')->field(' id,title')->select();

            //派遣的部门
            $group = M('auth_group')->field(' id, title')->where(' id>1 ')->select();

            $this->assign('data',$data);
            $this->assign('place',$place);
            $this->assign('group',$group);
        }
        $this->display();
    }

    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被禁止注册！'; break;
            case -3:  $error = '用户名被占用！'; break;
            case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }

}