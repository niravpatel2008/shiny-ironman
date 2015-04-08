<footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-9" style="text-align: right; padding-right: 191px;">
                    &copy; <?=date('Y');?> All Rights Reserved.
                </div>
				<div class="col-sm-3" style="text-align: center;">
					<a href="<?=base_url()?>privacypolicy">Privacy Policy</a> | 
					<a href="<?=base_url()?>terms">Terms & Conditions</a> | 
					<a href="<?=base_url()?>faq">FAQ</a>
				</div>
            </div>
        </div>
    </footer><!--/#footer-->

    
    <script src="<?=public_path()?>js/bootstrap.min.js"></script>
    <script src="<?=public_path()?>js/jquery.isotope.min.js"></script>
    <script src="<?=public_path()?>js/jquery.prettyPhoto.js"></script>
    <script src="<?=public_path()?>js/main.js"></script>
	<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>