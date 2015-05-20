<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->

<div class="register-container container" style="width:540px;margin:0 auto;">
	<div class="row">
		
		<div class="register span6">
			<!--<form action="" method="post">-->
			<form id="frmComplaint" name="frmComplaint" method="post" accept-charset="UTF-8">
				<h2>Complaint box</h2>
				<label for="firstname"><span class="red">* </span>Subdomain</label>
				<input type="text" placeholder="enter your subdomain..." name="subdomain" id="subdomain" class="validate[required]" value="<?= set_value('subdomain'); ?>"><?= my_form_error('subdomain') ?>
				
				<label for="lastname"><span class="red">* </span>Name</label>
				<input type="text" placeholder="enter your name..." name="name" class="validate[required]" id="name" value="<?= set_value('name'); ?>" ><?= my_form_error('name') ?>
				
				<label for="email"><span class="red">* </span>Email</label>
				<input type="text" name="email" placeholder="enter your email..." class="validate[required,custom[email]]" id="email" value="<?= set_value('email'); ?>" ><?= my_form_error('email') ?>

				<label for="phone">Phone</label>
				<input type="text" placeholder="enter your phone no..." name="phone" id="phone" value="<?= set_value('phone'); ?>" maxlength="12"><?= my_form_error('phone') ?>

				<label for="subdomain"><span class="red">* </span>Comment</label>
				<textarea name="comment" id="comment" placeholder="enter your comment..." class="validate[required] form-control" ><?= set_value('comment'); ?></textarea><?= my_form_error('subdomain') ?>
				<button type="submit" class="btn btn-primary btn-lg"  id="btnCompUser" name="btnCompUser" title="Submit complain">SUBMIT</button>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$("#frmComplaint").validationEngine();
});
</script>
