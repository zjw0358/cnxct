<?php
/*
	Date:2008-11-21
	$Id: rankgroup.php   cfc4n $
	$ 类百度知道多头衔角色插件 UTF-8 $
*/
require_once './include/common.inc.php';
require_once DISCUZ_ROOT.'./plugins/rankgroup/rankgroup.func.php';
@include language('rankgroup', 0, './plugins/rankgroup/');

if(!$discuz_uid) {
	showmessage('not_loggedin', NULL, 'HALTED');
}

$action = !empty($action) ? $action : '';

if($action == 'save') 
	{
		if(submitcheck('rankgroupsubmit')) 
		{
			$edit = edit_user_rankgroup($discuz_uid,$rankgroupid);
			$type = 'save';
		}
	}

$rankgroup = get_rankgroup();
$user_rankgroupid = get_user_rankgroup($discuz_uid);

include template('rankgroup');
?>