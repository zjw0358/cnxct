<?php
/*
	Date:Guestbook
	$Id: .php   cfc4n $
*/

class GuestbookModel extends Model {
protected $_validate = array(
	array('name','require','{%lang_name_is_require}',1),
	array('email','email','{%lang_email_is_error}',2),
	array('website','url','{%lang_website_is_error}',2),
	array('content','require','{%lang_content_is_error}'),
	);

protected $_auto = array(
	array('uip','get_client_ip','ADD','function'),
	array('hidden','0','ALL'),
	);
}

?>