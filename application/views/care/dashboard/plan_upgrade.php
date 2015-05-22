
<div class="register-container container" style="width:540px;margin:0 auto;">
	<div class="row">
		<div class="register span6">

			<form id="frmPlanUpgrade" name="frmPlanUpgrade" method="post">
				<h2>Upgrade Plan</h2>
				<input type="hidden" id="hdnUid" name="hdnUid" value="<?=$user->u_id;?>" />
				<label for="name">Name : <?= $user->u_fname." ".$user->u_lname; ?> </label>
				<br/><br/>
				<label for="username"> Username : <?php echo $user->u_email;?></label><br/><br/>

				<label for="plan">Select Plan</label>
				<select id="planSelect" name="planSelect">
					<?php
					foreach ($packages as $k=>$item)
					{
					$selected = '';
					if($user->u_package_id == $item['id'])
						$selected='selected';
					?>
						<option value="<?= $item['id'];?>" <?=$selected;?>><?= $item['name']." - $".$item['price']." for ".$item['duration'];?></option>
					<?php }?>
				</select>

				<button type="submit" class="btn btn-primary btn-lg"  id="btnUpgradePlan" name="btnUpgradePlan" title="Upgrade Plan">Upgrade Plan</button>
			</form>
		</div>
	</div>
</div>
