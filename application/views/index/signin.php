<?php
    $flash_arr = $this->session->flashdata('flash_arr');
    echo $flash_arr['flash_msg'];
?>
<h2>Signin</h2>
<form action="" method="post">
    <table>
        <tr>
            <td>Email:</td>
            <td><input type="text" name="email" id="email" value="<?=set_value('email'); ?>" ><?=form_error('email') ?></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="text" name="password" id="password"><?=form_error('password') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Submit"></td>
        </tr>
    </table>
</form>
