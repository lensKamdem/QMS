<?php
/*  File name: ass_get_test.php
	File description: Ajax server side get test request script
	File author: Lens Kamdem
	File update date: 20/10/2015 at 15:42
*/
include "include_fns_lib.php";
session_start();

/* if user has a session */
auth_check_session();
output_header("Test");

output_view_stats();
output_view_test();

output_scripts();
output_footer();

?>