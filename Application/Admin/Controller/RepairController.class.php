<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-10
 * Time: 14:12
 */

namespace Admin\Controller;


class RepairController extends AdminController
{
    public function index(){
        /*$lists = M('Repair')->select();
        $this->assign('index', $lists);
        //$this->meta_title = '报修管理';
        $this->display();*/
        $lists=M('Repair');
        $lists->page('1,5')->select();
        //var_dump($lists);exit;
        $this->assign('index',$lists);
        $this->display();

    }

    public function add(){
        if(IS_POST){
            $Menage = D('Repair');
            $data = $Menage->create();
          //var_dump($_POST);exit;
            if($data){
                $Menage->create_time = time();
                $Menage->status = 1;
                $Menage->numbers = uniqid(date("Ymd"));
                $id = $Menage->add();
                if($id){
                    $this->success('新增成功', U('index'));
                    //记录行为
                    action_log('update_repair', 'repair', $id, UID);
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Menage->getError());
            }
        } else {
            $pid = i('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = M('Channel')->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info',null);
            // $this->meta_title = '新增导航';
            $this->display('edit');
        }
    }

    public function edit($id = 0){
        if(IS_POST){
            $Menage = D('Repair');
            $data = $Menage->create();
            if($data){
                if($Menage->save()){
                    //记录行为
                    action_log('update_repair', 'repair', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Menage->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Repair')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $pid = i('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = M('Repair')->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            $this->display('');
        }
    }


    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('Repair')->where($map)->delete()){
            //记录行为
            action_log('update_repair', 'repair', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
}