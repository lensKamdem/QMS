<?php
/*  File name: view_test_question.php
	 File description: It outputs the test questions
	 File author:m Lens Kamdem
	 File update date: 09/12/2015 at 9:07
*/
include "include_fns_lib.php";
session_start();

/* if user has a session */
auth_check_session();

/* get test information */
$test = test_get_a_test_info($_GET['test']);
$course = test_get_a_course_info($_GET['course']);
$question = test_get_test_question($_GET['test']);
/* get each question respond */
for($i=0;$i < stripslashes($test['no_questions']);$i++)
{
$answers = explode("|",stripslashes($question[$i]['answers']));
$A[$i] = $answers[0];
$B[$i] = $answers[1];
$C[$i] = $answers[2];
$D[$i] = $answers[3];
}
$c = stripslashes($test['no_questions']);
		
output_header("Test questions");		

/* Questionnaire div */
echo "<div id=\"test_page\">";



echo	"	<hgroup>
				<h2>Test</h2>
				<h3>".stripslashes($course['name'])." ".stripslashes($test['name'])."</h3>
			</hgroup>";
/* questions form */			
echo	"<form method=\"post\" name=\"questionnaire\">
			<input type=\"hidden\" name=\"counter\" />
			<fieldset>
				<legend></legend>";
	
			echo "<p id=\"statement\"></p>";
			echo "<figure>
							<img />
					</figure>";
			echo "<ul>";
			$label = explode(",","A,B,C,D");
			$count = 0;
			for($i=1;$i<=4;$i++)
			{
				echo "<li id=\"opt_".$i."\"><label>".$label[$count]."</label>
						<input type=\"radio\" name=\"answer\" onclick=\"ans = '".$label[$count]."'; \" value=\"".$label[$count]."\" ></li>";
				$count++;
			}
	echo 		"</ul>
			</fieldset>
			<input type=\"button\" value=\"Ok\" class=\"button\" onclick=\"javascript_get_test_question('".$_GET['course']."','".$_GET['field']."','".$_GET['level']."','".$_GET['test']."',statment,attach,opt_a,opt_b,opt_c,opt_d,".$_GET['no_quest'].",".$_GET['dur'].",".$_GET['min'].",".$_GET['sec'].")\" />
		</form>";
/* time bar */
echo "<div id=\"time_bar\">
			<div id=\"time_anime\">
			</div>
			<div id=\"chrono_anime\">
			</div>
		</div>";
echo "<form name=\"data\">
			<input type=\"hidden\" name=\"chrono\" />
			<input type=\"hidden\" name=\"time\" />
			<input type=\"hidden\" name=\"answer\" value=\"\"/>
		</form>";		
echo "</div>";

output_scripts();	

/* *** Page script *** */
/* Store test data in client server variable */
echo "<script type=\"text/javascript\" language=\"javascript\">
				var statment = new Array(";
				for($i=0;$i < $c-1;$i++){ echo "'".stripslashes($question[$i]['quest_statement'])."',";} echo "'".stripslashes($question[$c-1]['attach'])."'";
				echo ");";
		echo "var attach = new Array(";
				for($i=0;$i < $c-1;$i++){ echo "'".stripslashes($question[$i]['attach'])."',";} echo "'".stripslashes($question[$c-1]['attach'])."'";
				echo ");";
		echo "var opt_a = new Array(";
				for($i=0;$i < $c-1;$i++){ echo "'".stripslashes($A[$i])."',";} echo "'".stripslashes($A[$c-1])."'";
				echo ");";
		echo "var opt_b = new Array(";
				for($i=0;$i < $c-1;$i++){ echo "'".stripslashes($B[$i])."',";} echo "'".stripslashes($B[$c-1])."'";
				echo ");";
		echo "var opt_c = new Array(";
				for($i=0;$i < $c-1;$i++){ echo "'".stripslashes($C[$i])."',";} echo "'".stripslashes($C[$c-1])."'";
				echo ");";
		echo "var opt_d = new Array(";
				for($i=0;$i < $c-1;$i++){ echo "'".stripslashes($D[$i])."',";} echo "'".stripslashes($D[$c-1])."'";
				echo ");";
echo "</script>";

echo "<script type=\"text/javascript\" language=\"javascript\">
		javascript_output_test_data(statment,attach,opt_a,opt_b,opt_c,opt_d,1);
		 javascript_display_duration('".$_GET['course']."','".$_GET['field']."','".$_GET['level']."','".$_GET['test']."',".$_GET['hours'].",".$_GET['mins'].");
		 javascript_display_chrono('".$_GET['course']."','".$_GET['field']."','".$_GET['level']."','".$_GET['test']."',statment,attach,opt_a,opt_b,opt_c,opt_d,".$_GET['dur'].",".$_GET['dur'].",".$_GET['no_quest'].",".$_GET['min'].",".$_GET['sec'].");
		</script>";
/* END of script */		
output_footer();

?>