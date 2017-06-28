<?php
/*  File name: main.php
	File description: The principal script where application's operation takes place
	File author: Lens Kamdem
	File update date: 14/12/2015 at 11:28
	
*/
include "include_fns_lib.php";
session_start();
 
/* if user has a session */
	auth_check_session();
	output_header('Fields');
	
	output_view_stats();
	output_view_field();
	
	output_scripts();
	output_footer();

?>


   