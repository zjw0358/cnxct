
			类百度知道多组头衔角色插件 FOR DISCUZ7(UTF-8)

1,如果的viewthread.php,space.php,include/cache.func.php三个文件没有修改过,请备份这三个文件
  然后,直接覆盖所有文件!(也可以不覆盖这三个文件,参照6 7 8步骤来做)

2,到控制面板后台 导入discuz_plugin_rankgroup.txt!

3,将cdb_rankgroup.sql导入数据库,其中注意更改表的前缀{$tablepre},我的是默认的"cdb_"!


4,到{$tablepre}members 表中,添加一字段,字段名为 rankgroupid  
  或者直接mysql执行 ALTER TABLE `cdb_members` ADD `rankgroupid` SMALLINT( 6 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '等级组';
  其中注意更改表的前缀{$tablepre}

5,后台-->用户-->发帖级别数-->将"级别头衔"改为从"一级"到"十级"或者更多,"发贴数高于"要从0开始增加,其他随便!



------------------------------------------------------------------------------------------------------------
#####如果覆盖了所有文件,请跳过6 7 8三个步骤###

6,打开viewthread.php
  380行 mf.customstatus, mf.spacename  后面,添加          , m.rankgroupid         注意空格以及逗号!
  536行 $post['authortitle'] = $rank['ranktitle'];  改为
					if($post['rankgroupid'] == 0) {
						$post['rankgroupid'] = 1;
							}
					$post['authortitle'] = $rank['rankgroup'][$post['rankgroupid']]['gname'];



7,打开 space.php 
  在 require_once './include/common.inc.php';下一行 加入
  require_once DISCUZ_ROOT.'./plugins/rankgroup/rankgroup.func.php';
  38行左右 r.stars AS rankstars 后面加入    , r.rankid        注意空格 逗号!!
  82行$postperday = $timestamp - $member['regdate'] > 86400 ? round(86400 * $member['posts'] / ($timestamp - $member['regdate']), 2) : $member['posts'];
  后面加入$member['ranktitle'] = get_rankgroup_name($member['rankgroupid'],$member['rankid']);


8,打开include/cache.func.php 
  350行$cols = 'ranktitle, postshigher, stars, color';改成$cols = 'ranktitle, postshigher, stars, color, rankid';
  914行while($rank = $db->fetch_array($query)) {  
  下面加入

  /* Start */
					$rankgroup = array();
					$sqlrg = "select gid , gname from {$tablepre}rankgroup WHERE rankid = ".$rank['rankid'];
					$queryrg = $db->query($sqlrg);
					while($rs = $db->fetch_array($queryrg))
						{					
								$rankgroup[$rs['gid']] = $rs;
						}
					$rank['rankgroup'] = $rankgroup;
					unset($rankgroup);
  /* End */
------------------------------------------------------------------------------------------------------------------




9,保存! 登录管理员到后台,更新数据,缓存即可!

10,如果有疑问,欢迎大家回帖告诉在下,在下尽快修改!   http://www.cnxct.com/cnxct/229这里有详细的使用说明



BY CFC4N   cfc4nphp#gmail.com  www.cnxct.com  2009-06-02 13:12

