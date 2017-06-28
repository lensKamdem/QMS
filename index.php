<?php
/*  File name: index.php
	File description: Its the default page where users login.
	File author: Lens Kamdam
	File update date: 10/10/2015 at 16:48
*/
include "include_fns_lib.php";
session_start();

output_header('login');
output_login_form(false);
output_scripts();
output_footer();

?>