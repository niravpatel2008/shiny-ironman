<?php
$flash_arr = $this->session->flashdata('flash_arr');
echo $flash_arr['flash_msg'];
?>
<!--<h2>Signin</h2>
<form action="" method="post">
    <table>
        <tr>
            <td>Email:</td>
            <td><input type="text" name="email" id="email" value="<?= set_value('email'); ?>" ><?= form_error('email') ?></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" id="password"><?= form_error('password') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Submit"></td>
        </tr>
    </table>
</form>
-->
<div id="">
	<form name="login-form" class="login-form" method="post" id="frmLogin" name="frmLogin">

		<!--HEADER-->
		<div class="header">
			<h1>Login</h1>
		</div>
		<!--END HEADER-->
		
		<!--CONTENT-->
		<div class="content">
		
		<input name="email" title="User Name" type="text" class="input username validate[required]" value="<?= set_value('email'); ?>" id="email" placeholder="User Name" /><?= form_error('email') ?>
		
		<input name="password" id="password" title="Password" type="password" class="input password validate[required]" value="" placeholder="Password" /><?= form_error('password') ?>
		</div>
		
		<!--END CONTENT-->
		
		<!--FOOTER-->
		<div class="footer">
		<button type="button" class="btn btn-primary btn-lg"  id="btnLogin" name="btnLogin" title="Login" onclick="javascript:userSignup('frmLogin');">Login</button>
		<a href="<?=base_url()?>index/forgetpassword/" id="" class="frgtLink" title="Forget Password">Forget Password</a>
		</div>
		<!--END FOOTER-->

	</form>
</div>
<!--GRADIENT--><div class="gradient"></div><!--END GRADIENT-->

<script type="text/javascript">
$(document).ready(function() {
	$("#frmLogin").validationEngine();
});
</script>
