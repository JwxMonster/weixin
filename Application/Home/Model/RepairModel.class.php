<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-11
 * Time: 16:45
 */

namespace Home\Model;


use Think\Model;

class RepairModel extends Model
{
    protected $_validate = array(
        array('name', 'require', '姓名不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('tel', 'require', '电话不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('address', 'require', '地址不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('problem', 'require', '保修问题不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
        // $Repair->numbers = uniqid(date("Ymd"));
        //array('numbers','uniqid(date("Ymd"))',self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        //array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_INSERT),
    );
}