<h2>Change password</h2>
<form action="" method="post">
    <table>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" id="password"><?= form_error('password') ?></td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td><input type="password" name="password2" id="password2"><?= form_error('password2') ?></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Submit"></td>
        </tr>
    </table>
</form>
