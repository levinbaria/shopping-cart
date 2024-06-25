<?php
// Logging out the user
session_start();
echo "<script>
 confirm('Do you want to Logout?')
</script>";
session_destroy();
header( 'location: index.php' );
