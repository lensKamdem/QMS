<?php
/*  File name: ass_get_course.php
	File description: Ajax server side script get course request
	File author: Lens Kamdem
	File update date: 20/10/2015 at 15:13
*/
include "include_fns_lib.php";
session_start();

/* if user has a session */
auth_check_session();
output_header('Course');

output_view_stats();
output_view_course();

output_scripts();
output_footer();

?>