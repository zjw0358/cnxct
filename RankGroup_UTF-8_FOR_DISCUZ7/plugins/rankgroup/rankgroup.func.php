<?php
/*
	$Author$
	$Date$
	$URL$
	$Rev$
*/



/*
  $uid          $discuz_uid
  $rankgroupid  组别ID
  return      bool
*/
function edit_user_rankgroup($uid,$rankgroupid) 
	{
		global $db,$tablepre;

		$sql = "UPDATE {$tablepre}members SET rankgroupid = {$rankgroupid} WHERE uid = {$uid} ";
		$query = $db->query($sql);
		if(!$query) 
		{
			return false;
		}
		else
		{
			return true;
		}		 
	}



/*
  $uid          $discuz_uid
  return        用户members中的rankgroupid
*/
function get_user_rankgroup($uid) 
	{
		global $db,$tablepre;
		$sql = "SELECT rankgroupid FROM {$tablepre}members WHERE uid = ".$uid;
		$query = $db->query($sql);
		while($rs = $db->fetch_row($query)) 
			{
				$rankgroupid = $rs['0'];
			}
		return $rankgroupid;
	}


/*
  $uid          $discuz_uid
  return        用户members中的rankgroupid
*/
function get_rankgroup() 
	{
		global $db,$tablepre,$discuz_uid;
		$sql = "SELECT * FROM {$tablepre}rankgroup WHERE gid = 0 AND closed = 1 ";
		$query = $db->query($sql);
		while($rs = $db->fetch_array($query)) 
			{		
			$ranks = get_rankgroup_class($rs['id']);
			$rs['ranks'] = $ranks;
			$user_rankgroupid = get_user_rankgroup($discuz_uid);
			if($user_rankgroupid == $rs['id']) 
				{
					$rs['check'] = "checked";
				}
			$rankgroup[] = $rs;	
			}
		return $rankgroup;
	}


/*
  获取值为gid,且{$tablepre}rank中的rankid 相等的所有ganme值
  $id          对应rankgroup表中的gid
  return        array
*/
function get_rankgroup_class($id) 
	{
		global $db,$tablepre;
		$sql = "SELECT rg.*, r.* FROM {$tablepre}rankgroup rg, {$tablepre}ranks r WHERE rg.rankid = r.rankid AND rg.gid = {$id} ORDER BY r.postshigher ASC";
		$query = $db->query($sql);
		while($rs = $db->fetch_array($query)) 
			{
				$ranks[] = $rs;
			}
		return $ranks;
	}



/*  space.php中用到的函数 get_rankgroup_name */


/*
  获取用户的头衔角色名称
  $id          用户members中的rankgroupid
  return       array
*/
function get_rankgroup_name($rankgroupid,$rankid) 
{
	global $db,$tablepre;
	$sql = "SELECT gname FROM {$tablepre}rankgroup WHERE gid = {$rankgroupid} AND rankid = {$rankid}";
	$query = $db->query($sql);
	while($rs = $db->fetch_array($query)) 
	{
		$result = $rs['gname'];
	}
	return $result;
}




/*  rankgroup_admin.php中用到的函数  */

/*
 获取所有父级分类,或者所有子级分类的结果
*/

function get_rankgroup_allname($gid) 
{
	global $db,$tablepre;
	$sql = "SELECT * FROM {$tablepre}rankgroup WHERE gid = {$gid}";
	$query = $db->query($sql);
	while($rs = $db->fetch_array($query)) 
	{
		if($rs['closed'] == 1) {
			$rs['check'] ='Yes';
		}
		else {
			$rs['check'] ='No';
		}
		$result[] = $rs;
	}
	return $result;
}


/*
  由rankgroup表中的gid字段的值获取父级分类的组名
  $gid          rankgroup表中的gid
  return       父级分类的组名ganme
*/
function get_rankgroup_fname($gid) 
{
	global $db,$tablepre;
	$sql = "SELECT gname FROM {$tablepre}rankgroup WHERE id = {$gid}";
	$query = $db->query($sql);
	while($rs = $db->fetch_array($query)) 
	{
		$result = $rs['gname'];
	}
	return $result;
}

/*
  获取ranks表中的ranks等级
  return     array
*/
function get_ranks_level() 
{
	global $db,$tablepre;
	$sql = "SELECT * FROM {$tablepre}ranks ORDER BY postshigher ASC";
	$query = $db->query($sql);
	while($rs = $db->fetch_array($query)) 
	{
		$result[] = $rs;
	}
	return $result;
}

/*
 获取rankgroup表与ranks表rankid相等的子级分类的结果
 $gid rankgroup表中的gid
 return  Array
*/

function get_rankgroup_name_rankid($gid) 
{
	global $db,$tablepre;
	$sql = "SELECT r.*, rg.* FROM {$tablepre}ranks r, {$tablepre}rankgroup rg WHERE r.rankid = rg.rankid AND rg.gid = {$gid} ORDER BY rg.id ASC";
	$query = $db->query($sql);
	while($rs = $db->fetch_array($query)) 
	{
		$result[] = $rs;
	}
	return $result;
}

/*
 遍历查询rankgroup表是否有id为 $id 的数组
 $id rankgroup表中的id
 return  bool
*/

function query_rankgroup($id) 
{
	global $db,$tablepre;
	$sql = "SELECT * FROM {$tablepre}rankgroup WHERE id = {$id}";
	$query = $db->query($sql);
	$num = $db->num_rows($query);
	if($num > 0) 
	{
		return true;
	}
	else
	{
		return false;
	}
}

/*
 遍历删除rankgroup表gid为 $id 的数组
 $id rankgroup表中的id
 return  Array
*/

function del_rankgroup($id) 
{
	global $db,$tablepre;
	$sql = "DELETE FROM {$tablepre}rankgroup WHERE id = {$id}";
	$gsql = "DELETE FROM {$tablepre}rankgroup WHERE gid = {$id}";
	$query = $db->query($sql);
	$groups = $db->affected_rows();
	$gquery = $db->query($gsql);
	$sons = $db->affected_rows();
	$rs['0'] = $groups;
	$rs['1'] = $sons;
	return $rs;
}

/*
 添加rankgroup
 $rankgroup 为数组
 return  bool
*/

function add_rankgroup($rankgroup) 
{
	global $db,$tablepre;
	$sql = "INSERT INTO {$tablepre}rankgroup (`id`, `gid`, `gname`, `rankid`, `imgurl`, `closed`)";
	$sql .= " VALUES (NULL, '{$rankgroup['gid']}', '{$rankgroup['rankgroup_gname']}', '{$rankgroup['rankid']}',";
	$sql .= " '{$rankgroup['imgurl']}', '{$rankgroup['active']}')";
	$query = $db->query($sql);
	$rows = $db->affected_rows();
	if($rows > 0) {
		return true;
	}
	else
	{
		return false;
	}
}

/*
 查询rankgroup中是否存在提交的头衔角色
 $gid,$rankid 
 return  存在:true,不存在:false
*/

function query_add_rankgroup($gid,$rankid) 
{
	global $db,$tablepre;
	$sql = "SELECT * FROM {$tablepre}rankgroup WHERE gid = {$gid} AND rankid = {$rankid}";
	$query = $db->query($sql);
	$rows = $db->num_rows($query);
	if($rows > 0) {
		return true;
	}
	else
	{
		return false;
	}
}

/*
	获取id为$id的所有信息
	$id int
	return array
*/
function get_rankgroup_info($id) 
{
	global $db,$tablepre;
	$sql = "SELECT * FROM {$tablepre}rankgroup WHERE id = {$id} LIMIT 0,1";
	$query = $db->query($sql);
	while($rs = $db->fetch_array($query)) 
	{
		$result = $rs;
	}
	return $result;
}

/*
	获取ranks表中rankid为$rankid的ranktitle
	$rankid int
	return ranktitle
*/
function get_ranktitle($rankid) 
{
	global $db,$tablepre;
	$sql = "SELECT ranktitle FROM {$tablepre}ranks WHERE rankid = {$rankid}";
	$query = $db->query($sql);
	while($rs = $db->fetch_array($query)) 
	{
		$ranktitle = $rs['ranktitle'];
	}
	return $ranktitle;
}


/*
 添加rankgroup
 $rankgroup 为数组
 return  bool
*/

function update_rankgroup($rankgroup) 
{
	global $db,$tablepre;
	$sql = "UPDATE {$tablepre}rankgroup  SET gid = '{$rankgroup['gid']}',";
	$sql .= " gname = '{$rankgroup['rankgroup_gname']}', rankid = '{$rankgroup['rankid']}',";
	$sql .= " imgurl = '{$rankgroup['imgurl']}', closed = '{$rankgroup['active']}'";
	$sql .= " WHERE id = {$rankgroup['id']}";
	$query = $db->query($sql);
	$rows = $db->affected_rows();
	if($rows > 0) {
		return true;
	}
	else
	{
		return false;
	}
}
?>