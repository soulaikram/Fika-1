<html>
<head>
    <title>My Form</title>
</head>
<body>

<?php echo validation_errors(); ?>

<?php echo form_open('form'); ?>


<h5>Username</h5>
<input type="text" name="username" value="" size="20" />

<h5>Password</h5>
<input type="password" name="password" value="" size="20" />

<h5>Password Confirm</h5>
<input type="password" name="passconf" value="" size="20" />

<h5>Email Address</h5>
<input type="text" name="email" value="" size="20" />

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>
