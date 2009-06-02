<?php
/*
	[Cfc4n!] (C)2001-2008 
	
	$Id: admin.inc.php  2008-11-21 cfc4n $
*/
require_once './include/common.inc.php';
require_once DISCUZ_ROOT.'./plugins/rankgroup/rankgroup.func.php';
include language('rankgroup', 0, './plugins/rankgroup/');

if(!$discuz_uid || $adminid != 1) {
	showmessage('not_loggedin', NULL, 'HALTED');
}

$action = !empty($action) ? $action : 'view';

if($action == 'editsave'|| $action == 'add') 
	{
		$rankgroup = $_POST;
		$rankgroup['rankid'] = !empty($rankgroup['rankid']) ? $rankgroup['rankid'] : '';
		$rankgroup['imgrul'] = !empty($rankgroup['imgrul']) ? $rankgroup['imgrul'] : '';
		if(submitcheck('rankgroup_edit')) 
		{
			if(!empty($rankgroup['rankgroup_gname'])) 
			{	
				$result = update_rankgroup($rankgroup);					
			}
			else
			{
				$rankgroup_name_empty = true;
			}
//			include template('rankgroup_admin_add');
		}
		elseif(submitcheck('rankgroup_add')) 
		{
			if(!empty($rankgroup['rankgroup_gname'])) 
			{
				if($rankgroup['gid'] == 0) 
				{
					$rankgroup['rankid'] = 0;
					$result = add_rankgroup($rankgroup);
				}
				else
				{
					$is_exits = query_add_rankgroup($rankgroup['gid'],$rankgroup['rankid']);
					if(!$is_exits)
					{
						$rankgroup['active'] = 1;
						$result = add_rankgroup($rankgroup);
					}
					else
					{
						$rankgroup_son_exist = true;
					}
				}
			}
			else
			{
				$rankgroup_name_empty = true;
			}
//			include template('rankgroup_admin_add');
		}
		else
		{
			showmessage('undefined_action', NULL, 'HALTED');
		}
	}
elseif($action == 'del')
{
	$id = intval($id);
	if($id > 0 ) 
	{
		if(query_rankgroup($id)) 
		{
			$rows = del_rankgroup($id);
		}
		else
		{
			$no_rankgroupid = true;
		}
//		include template('rankgroup_admin_del');
	}
	else
	{
		showmessage('undefined_action', NULL, 'HALTED');
	}
}
elseif($action == 'view')
{
	$gid = !empty($gid) ? intval($gid) : '0';
	if($gid > '0') {
		$fname = get_rankgroup_fname($gid);
		$rankgroup = get_rankgroup_name_rankid($gid);
		$ranks_level = get_ranks_level();
	}
	else
	{
		$rankgroup = get_rankgroup_allname($gid);
	}
//	include template('rankgroup_admin_view');
}
elseif($action == 'edit')
{
	$id = !empty($id) ? intval($id) : '0';
	if($id > 0) 
	{
		$rankgroup_info = get_rankgroup_info($id);
		$ranktitle = get_ranktitle($rankgroup_info['rankid']);
		$ranks_level = get_ranks_level();
//		include template('rankgroup_admin_edit');
	}
	else
	{
		showmessage('undefined_action', NULL, 'HALTED');
	}
}
else
{
	showmessage('undefined_action', NULL, 'HALTED');
}
include template('rankgroup_admin');
?>