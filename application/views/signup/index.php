<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->

<div class="register-container container" style="width:540px;margin:0 auto;">
	<div class="row">
		
		<div class="register span6">
			<!--<form action="" method="post">-->
			<form id="frmSignup" name="frmSignup" method="post">
				<h2>REGISTER</h2>
				<label for="firstname">First Name</label>
				<input type="text" placeholder="enter your first name..." name="fname" id="fname" value="<?= set_value('fname'); ?>" class="validate[required]"><?= my_form_error('fname') ?>
				
				<label for="lastname">Last Name</label>
				<input type="text" placeholder="enter your first name..." name="lname" class="validate[required]" id="lname" value="<?= set_value('lname'); ?>" ><?= my_form_error('lname') ?>
				
				<label for="email">Email</label>
				<input type="text" name="email" placeholder="enter your email..." class="validate[required,custom[email]]" id="email" value="<?= set_value('email'); ?>" ><?= my_form_error('email') ?>

				<label for="password">Password</label>
				<input type="password" id="password" name="password" class="validate[required]" placeholder="choose a password..."><?= my_form_error('password'); ?>

				<label for="password2">Confirm Password</label>
				<input type="password" id="password2" name="password2" class="validate[required,equals[password]]" placeholder="Enter password again..."><?= my_form_error('password2'); ?>

				<label for="phone">Phone</label>
				<input type="text" placeholder="enter your phone no..." name="phone" id="phone" value="<?= set_value('phone'); ?>" maxlength="12"><?= my_form_error('phone') ?>

				<label for="website">Website</label>
				<input type="text" name="website" id="website" placeholder="enter your website..." class="validate[url]" value="<?= set_value('website'); ?>" ><?= my_form_error('website') ?>

				<label for="plan">Select Plan</label>
				<select id="planSelect" name="planSelect">
					<?php
					foreach ($packages as $item) {?>
						<option value="<?= $item->id;?>"><?= $item->name." - $".$item->price." for ".$item->duration;?></option>
					<?php }?>
				</select>

				
				<button type="button" class="btn btn-primary btn-lg"  id="btnRegUser" name="btnRegUser" title="Register" onclick="javascript:userSignup('frmSignup');">REGISTER</button>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$("#frmSignup").validationEngine();
});
</script>
