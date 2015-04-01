<?php
//echo '<pre>';print_r($this->session->userdata['front_session']);
//print_r($this->front_session);
$flash_arr = $this->session->flashdata('flash_arr');
echo $flash_arr['flash_msg'];
?>

