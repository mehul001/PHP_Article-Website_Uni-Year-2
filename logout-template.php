<?php
unset($_SESSION['loggedin']);
echo '<p>Please Wait - You Will Shortly Be Redirected To The Homepage</p>';
header("Refresh: 2;url=index");
?>