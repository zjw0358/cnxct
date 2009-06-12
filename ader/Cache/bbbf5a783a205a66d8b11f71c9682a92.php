<form method="post" action="/google_svn_cnxct/ader/index.php/Index/insert">
<p><?php echo (L("name")); ?>:<input name="name" type="text" ></p>
<p><?php echo (L("email")); ?>:<input name="email" type="text" ></p>
<p><?php echo (L("website")); ?>:<input name="website" type="text" ></p>
<p><?php echo (L("content")); ?>:<input name="content" type="text"></p>
<p><?php echo (L("hidden")); ?>:<input name="hidden" type="checkbox"></p>
<p><input type="submit" value="<?php echo (L("submit")); ?>"></p>
<?php if(C("TOKEN_ON")):?><input type="hidden" name="<?php echo C("TOKEN_NAME");?>" value="<?php echo Session::get(C("TOKEN_NAME")); ?>"/><?php endif;?></form>