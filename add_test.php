<?php
/*  File name: add_test.php
	File description: It outputs the add test page
	File author: Lens kamdem
	File update date: 09/11/2015 at 10:39
*/
include "include_fns_lib.php";
session_start();

/* if user has a session */
auth_check_session();
output_header('Add test');

output_add_test();

output_scripts();
/* *** Page script *** */
echo "<script type=\"text/javascript\">
			question_counter = 1;
			javascript_add_question(question_counter);
			var test_info = '&field=' + encodeURI('".$_GET['field']."') + '&level=' + encodeURI('".$_GET['level']."') + '&course=' + encodeURI('".$_GET['course']."');
		</script>";
output_footer();

?>