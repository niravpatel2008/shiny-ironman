<?php
//echo '<pre>';print_r($this->session->userdata['front_session']);
//print_r($this->front_session);
$flash_arr = $this->session->flashdata('flash_arr');
//echo $flash_arr['flash_msg'];
$packageArr = getPackages();

?>

<section id="dashboard">
		<div class="box_care">
			<div class="center welcome">
				<h3>Welcome : <?php echo $user->u_fname." ".$user->u_lname; ?></h3>
			</div>
			<div class="gap">
				<div class="center">
				<h4>Give 24/7 support to your customer</h4>
				<h4>Grow your business with us</h4>
				</div>
				<div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">5</div>
                                        <div>Agents!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">12</div>
                                        <div>Pending users!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">124</div>
                                        <div>New Chats!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">13</div>
                                        <div>Support Tickets!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
				<div class="row">
					<div class=" col-sm-6">
					<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title">Account detail</h3>
							</div>
							<div class="panel-body">
							<div class="col-md-12">
								<b> Your account url :</b><a href="http://<?php echo $user->up_subdomain?>.chat.com" target="_blank"> <?php echo $user->up_subdomain?>.chat.com</a>
							</div>
							<div class="col-md-12">
								<b> Username :</b> <?php echo $user->up_subdomain;?>
							</div>
							<div class="col-md-12">
								<b> Your Plan :</b> <?=$packageArr[$user->up_package_id]['name']?>
							</div>
							<div class="col-md-12">
								<b> Plan Expiry date :</b> <?php echo $user->up_package_expiry_date?>
							</div>
								</div>
					</div>
					</div>
					<div class=" col-sm-6">
					<div class="panel panel-warning">
							<div class="panel-heading">
								<h3 class="panel-title">Profile</h3>
							</div>
							<div class="panel-body">
							<div class="col-md-12">
								<b> Email :</b> <?php echo $user->u_email;?>
							</div>
							<div class="col-md-12">
								<b> Username :</b> <?php echo $user->u_phone;?>
							</div>
							<div class="col-md-12">
								<b> Website :</b> <?php echo $user->up_website;?>
							</div>
							<div class="col-md-12">
								<b> Status :</b> <?php if($user->u_active==1) { echo "Active"; } else { echo "Inactive"; } ?>
							</div>
								</div>
					</div>
					</div>
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
po.src = '//<?php echo $user->up_subdomain?>.chat.com/index.php/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true?r='+refferer+'&l='+location;
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>	</textarea>
			<p>you can also create your custom setting for user chat box.</p>
			
			
			</div>
			<div style="clear:both;"></div>
		</div><!--/.box-->
	</div><!--/.container-->
</section>
