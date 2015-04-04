<?php
//echo '<pre>';print_r($this->session->userdata['front_session']);
//print_r($this->front_session);
$flash_arr = $this->session->flashdata('flash_arr');
//echo $flash_arr['flash_msg'];
$packageArr = getPackages();

?>

<section id="dashboard">
	<div class="container">
		<div class="box">
			<div class="center welcome">
				<h3>Welcome : <?php echo $user->u_fname." ".$user->u_lname; ?></h3>
			</div>
			<div class="gap">
				<div class="center">
				<h4>Give 24/7 support to your customer</h4>
				<h4>Grow your business with us</h4>
				</div>
				<h3>Account detail</h3>
				<div class="col-md-12">
					<b> Your account url :</b><a href="abc.chat.com" target="_blank"><?php echo $user->u_subdomain?>.chat.com</a>
				</div>
				<div class="col-md-12">
					<b> Username :</b> <?php echo $user->u_email;?>
				</div>
				<div class="col-md-12">
					<b> Your Plan :</b> <?=$packageArr[$user->u_package_id]['name']?>
				</div>
				<div class="col-md-12">
					<b> Plan Expiry date :</b> <?php echo $user->u_package_expiry_date?>
				</div>
				<div class="col-md-11 code">
			<p>Copy the code from the below textarea to the page where you want your status to appear</p>
			<textarea name="chatcode" rows="14" class="form-control" id="chatcode"><script type="text/javascript">
var LHCChatOptions = {};
LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
var refferer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
po.src = '//<?php echo $user->u_subdomain?>.chat.com/index.php/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true?r='+refferer+'&l='+location;
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>	</textarea>
			<p>you can also create your custom setting for user chat box.</p>
			<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. </p>

			
			</div>
			<div style="clear:both;"></div>
		</div><!--/.box-->
	</div><!--/.container-->
</section>
<section id="purchasePlan">
        <div class="container">
            <div class="box">
                <div class="center">
                    <h2 style="color:#258dc8;">My Plan Detail</h2>
                </div><!--/.center-->   
                <div id="pricing-table" class="row">
                   <div class="col-sm-1"></div>
                    <div class="col-sm-6">
                        <ul class="plan right-tic">
                            <li class="plan-name">Premium</li>
                            <li>Real-time chat</li>
                            <li>Unlimited chats</li>
                            <li>Files upload</li>
                            <li>Chat transcript send by mail</li>
							<li>Chat transcript print</li>
							<li>Chats archive</li>
							<li>Users blocking</li>
							<li>Visits tracking</li>
							<li>Online users map</li>
							<li>Chats statistic generation, top chats</li>
							<li>Resume chat after user closed chat</li>
							<li>All chats in single window with tabs interface</li>
							<li>Option to prefill form fields</li>
							<li>Option to send transcript to users e-mail</li>
							<li>Online users tracking, including geo detection</li>
							<li>Windows, Linux and Mac native applications.</li>
							<li>Sounds on pending chats and new messages</li>
							<li>Option for operator set online or offline mode</li>
							<li>Option to see what user is typing before he sends a message</li>
                        </ul>
                    </div><!--/.col-sm-4-->
                </div> 
				<div class="col-sm-2"></div>
				<div class="col-sm-6">
				<a href="#" class="btn btn-primary btn-lg">Upgrade your plan</a>
				</div>
				<div style="clear:both;"></div>
            </div> 
			
        </div>
    </section>