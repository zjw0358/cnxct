<?php 
// +----------------------------------------------------------------------
// | ThinkPHP                                                             
// +----------------------------------------------------------------------
// | Copyright (c) 2008 http://thinkphp.cn All rights reserved.      
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>                                  
// +----------------------------------------------------------------------
// $Id: ProviderManager.class.php 18 2009-06-16 03:16:13Z cfc4nPHP $

/**
 +------------------------------------------------------------------------------
 * 认证委托管理器
 +------------------------------------------------------------------------------
 * @category   ORG
 * @package  ORG
 * @subpackage  RBAC
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: ProviderManager.class.php 18 2009-06-16 03:16:13Z cfc4nPHP $
 +------------------------------------------------------------------------------
 */
class ProviderManager extends Base
{//类定义开始

    /**
     +----------------------------------------------------------
     * 认证后的用户信息
     +----------------------------------------------------------
     * @var mixed
     * @access protected
     +----------------------------------------------------------
     */
    protected $data;

    /**
     +----------------------------------------------------------
     * 取得委托管理类实例
     * 
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @return mixed 返回委托管理类
     +----------------------------------------------------------
     */
    public static function getInstance() 
    {
        $param = func_get_args();
        return get_instance_of(__CLASS__,'connect',$param);
    }

    /**
     +----------------------------------------------------------
     * 加载委托管理
     * 
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @param mixed $authProvider 委托方式
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    public function connect($authProvider='') 
    {
        $providerPath = dirname(__FILE__).'/Provider/';
        $authProvider = empty($authProvider)? C('USER_AUTH_PROVIDER'):$authProvider;
        if (require_cache( $providerPath . $authProvider . '.class.php'))    
                $provider = new $authProvider();
        else 
            throw_exception(L('_NOT_SUPPORT_PROVIDER_').': ' .$authProvider);
        return $provider;
    }
}//类定义结束
?>