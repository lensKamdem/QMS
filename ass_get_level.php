<?php
/*  File name: ass_get_level.php
	File description: Ajax server side get level request script 
	File author: Lens Kamdem
	File update date: 15/10/2015 at 23:30
*/
include "include_fns_lib.php";
session_start();

/* if user has a session */
auth_check_session();
output_header('Levels');

output_view_stats();
output_view_level();

output_scripts();
output_footer();

?>