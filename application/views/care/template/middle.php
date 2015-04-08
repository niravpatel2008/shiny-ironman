
<div id="wrapper">
<?php
$this->load->view('care/template/nav_bar');
$this->load->view("care/".$this->router->fetch_class()."/".$view); 
?>
</div>

