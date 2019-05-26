<?php

session_start ();

// Destroys variables from $_SESSION
session_unset ();

// Destroys $_SESSION
session_destroy ();

// Leads user to homepage
header("location: index.php"); //stay on same page
exit;