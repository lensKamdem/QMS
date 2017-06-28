/*	
	JAVASCRIPT FUNCTIONS LIBRARY
	
	File name: javascript_fns_lib.php
	File description: non ajax javascript function library
	File author: Lens kamdem
	File update date: 14/12/2015 at 10:25
*/
function javascript_display_duration(course,field,level,test,hours,mins)
{
/*  It displays the duration of the event e.g the test
	Input: hours,mins "int"; return: null
*/	
/* format and display time */
  
   /* to make divs not null */
  var h = '0' + hours;
  var m = mins;
  if (mins < 10)
  {
     m = '0' + mins;
  }
  var time = h + ':' + m + ' H';
  time = "<p>" + time + "</p>";
  /* output duration */
  document.getElementById("time_anime").innerHTML = time;
  mins--;
  if (mins == -1)
  {
    mins = 59;
	hours--;
  }
  /* if time is not 0, show time */
  if((hours !=0) &&(mins != -1))
  {
		var dur_id = setTimeout(javascript_display_duration,60000,course,field,level,test,hours,mins);
		/* save id */
		document.data.time.value = dur_id;
	}
	else
	{
		/* if time is 0, move to test result page */
		var answer = document.data.answer.value;
		var counter = docuent.questionnaire.counter.value;
		do_ajax('ass_test_result.php','?answer=' + answer + '&counter=' + counter + '&field=' + field + '&level=' + level + '&course=' + course + '&test=' + test,'false','post','<p>Wait Loading...</p>','test_page','test_page');
	}
}

function javascript_display_chrono(course,field,level,test,statment,attach,opt_a,opt_b,opt_c,opt_d,duration,real_duration,num_questions,min,sec)
{
/*  It displays the chrono or duration of each question
	Input: duration "int"; return: null
*/
		 /* display */
		 var chrono = min + ':' + sec;
		if (sec < 10)
		{
			chrono = min + ':0' + sec;
		}
		if (min < 10)
		{
			chrono = '0' + min + ':' + sec;
			if (sec < 10)
			{
				chrono = '0' + min + ':0' + sec;
			}
		}
		var chrono = "<p>" + chrono + "</p>";
		document.getElementById("chrono_anime").innerHTML = chrono;
		/* Set parameters */
		sec--;
		if (sec == -1)
		{
			sec = 59;
			min--;
		}  
		duration--;
		/* if chrono is not at 0, show chrono */
		if (duration != -1)
		{
			var chrono_id = setTimeout(javascript_display_chrono,1000,course,field,level,test,statment,attach,opt_a,opt_b,opt_c,opt_d,duration,real_duration,num_questions,min,sec);
			/* save id */
			document.data.chrono.value = chrono_id;
		}
		else
		{
		/* get answer */
		var answers = document.questionnaire.answer;
		var choice = "";
		for(var i = 0;i < answers.length;i++)
		{
			if(answers[i].checked == true)
			{
				choice = answers[i].value;
				break;
			}
		}
		/* if no answer */
		if(choice == "")
		{
			choice = "NOT";
		}
		/* save answers */
		 var answer = document.data.answer.value;
		 answer += choice + "|";
		document.data.answer.value = answer;
		/* get counter */
		var counter = document.questionnaire.counter.value;
		
			/* if chrono is 0 */
			if (counter == num_questions)
			{
				/* clear time id */
				var dur_id = document.data.time.value;
				clearTimeout(dur_id);
				/* go to test result */
				do_ajax('ass_test_result.php','?answer=' + answer + '&counter=' + counter + '&field=' + field + '&level=' + level + '&course=' + course + '&test=' + test,'false','post','<p>Wait Loading...</p>','test_page','test_page');
			}
			else
			{
				/* clear previous chrono id */
				var chrono_id = document.data.chrono.value;
				clearTimeout(chrono_id);
				/* increment counter */
				counter++;
				document.questionnaire.counter.value = counter;
				/* output next question */
				javascript_output_test_data(statment,attach,opt_a,opt_b,opt_c,opt_d,counter);
				/* restart chrono */
				javascript_display_chrono(course,field,level,test,statment,attach,opt_a,opt_b,opt_c,opt_d,duration,real_duration,num_questions,min,sec);
			}
			
		}
}
function javascript_validate_login()
{
  var name = document.login.user_name.value;
  var code = document.login.code.value;
  
  if ((code == "") && (name ==""))
  {
    document.getElementById('error_msg').innerHTML = "<p id=\"login_error\">Note: You did not filled the form </p>";
  }
  else if (name == "")
  {
    document.getElementById('error_msg').innerHTML = "<p id=\"login_error\">Note: You did not filled the name</p>";
  }
  else if (code == "")
  {
    document.getElementById('error_msg').innerHTML = "<p id=\"login_error\">Note: You did not filled the code</p>";
  } 
  else
  {
		var query = "?name=" + name + "&code=" + code;
		window.location.href = "main.php" + query;
	}
  
}
function javascript_add_question(count)
{
	/* <p><b>Q i</b></p> */
	var para = document.createElement("p");
	var bold = document.createElement("b");
	var text = document.createTextNode("Q" + count);
	bold.appendChild(text);
	para.appendChild(bold);
	/* question statement */
	var list1 = document.createElement("li");
	var textarea = document.createElement("textarea");
	var label1 = document.createElement("label");
	var text1 = document.createTextNode("Question statement");
	label1.appendChild(text1);
	label1.setAttribute("id","quest_stat");
	textarea.setAttribute("id","statement_" + count);
	textarea.setAttribute("rows","5");
	textarea.setAttribute("cols","50");
	list1.appendChild(label1);
	list1.appendChild(textarea);
	
	/* file upload */
	var list2 = document.createElement("li");
	var input1 = document.createElement("input");
	var input2 = document.createElement("input");
	var input3 = document.createElement("input");
	var label2 = document.createElement("label");
	var text2 = document.createTextNode("Add image");
	list2.setAttribute("id","upload");
	label2.appendChild(text2);
	label2.setAttribute("id","up_lab");
	input1.setAttribute("type","hidden");
	input1.setAttribute("name","MAX_FILE_SIZE");
	input1.setAttribute("value","5000000");
	list2.appendChild(input1);
	label2.setAttribute("for","file");
	list2.appendChild(label2);
	input2.setAttribute("type","file");
	input2.setAttribute("id","file_" + count);
	input2.setAttribute("name","file");
	input2.setAttribute("class","upload_file");
	list2.appendChild(input2);
	var file = document.getElementsByClassName("upload_file").value;
	var br1 = document.createElement("br");
	input3.setAttribute("type","button");
	input3.setAttribute("name","upload_button");
	input3.setAttribute("value","Upload");
	input3.setAttribute("onclick","do_ajax('ass_upload_file.php','?MAX_FILE_SIZE=5000000&i=" + count + "&file=" + file + "','callback_output_text','false','post','<p>Loading...</p>','','upload')");

	list2.appendChild(input3);
	
	/* answer  and valid answer */
	var label3 = document.createElement("label");
	var text3 = document.createTextNode("A");
	var list3 = document.createElement("li");
	var input4 = document.createElement("input");
	label3.appendChild(text3);
	list3.appendChild(label3);
	input4.setAttribute("type","text");
	input4.setAttribute("id","A_" + count);
	list3.appendChild(input4);
	
	var list4 = document.createElement("li");
	var label4 = document.createElement("label");
	var text4 = document.createTextNode("B");
	var input5 = document.createElement("input");
	label4.appendChild(text4);
	list4.appendChild(label4);
	input5.setAttribute("type","text");
	input5.setAttribute("id","B_" + count);
	list4.appendChild(input5);
	var list5 = document.createElement("li");
	var label5 = document.createElement("label");
	var text5 = document.createTextNode("C");
	var input6 = document.createElement("input");
	label5.appendChild(text5);
	list5.appendChild(label5);
	input6.setAttribute("type","text");
	input6.setAttribute("id","C_" + count);
	list5.appendChild(input6);
	
	var list6 = document.createElement("li");
	var label6 = document.createElement("label");
	var text6 = document.createTextNode("D");
	var input7 = document.createElement("input");
	label6.appendChild(text6);
	list6.appendChild(label6);
	input7.setAttribute("type","text");
	input7.setAttribute("id","D_" + count);
	list6.appendChild(input7);
	
	var list7 = document.createElement("li");
	var label7 = document.createElement("label");
	var text7 = document.createTextNode("Answer");
	var input8 = document.createElement("input");
	var br2 = document.createElement("br");
	label7.appendChild(text7);
	list7.appendChild(label7);
	input8.setAttribute("type","text");
	input8.setAttribute("id","answer_" + count);
	list7.appendChild(input8);
	list7.appendChild(br2);
	
	
	/* add to "ul" element */
	var ul = document.getElementById("questions");
	ul.appendChild(para);
	ul.appendChild(list1);
	ul.appendChild(list2);
	ul.appendChild(list3);
	ul.appendChild(list4);
	ul.appendChild(list5);
	ul.appendChild(list6);
	ul.appendChild(list7);
}
function javascript_save_test(count,test_info)
{
	var questions = "";
	var question_statement = document.getElementById('statement_1' ).value;
		var A = document.getElementById('A_1').value;
		var B = document.getElementById('B_1').value;
		var C = document.getElementById('C_1').value;
		var D = document.getElementById('D_1').value;
		var answers = A +'|' + B +'|' + C + '|' + D;
		var valid_answer = document.getElementById('answer_1').value;
		var attach = document.getElementById('file_1').value;
	questions += 'statement_1=' + encodeURI(question_statement) + '&answers_1=' + encodeURI(answers) + 
							'&valid_answer_1=' + encodeURI(valid_answer) + '&file_1=' + encodeURI(attach);
	for (var i = 2;i <= count;i++)
	{
		question_statement = document.getElementById('statement_' + i).value;
		A = document.getElementById("A_" + i).value;
		B = document.getElementById('B_' + i).value;
		C = document.getElementById('C_' + i).value;
		D = document.getElementById('D_' + i).value;
		answers = A +'|' + B +'|' + C + '|' + D;
		valid_answer = document.getElementById('answer_' + i).value;
		attach = document.getElementById('file_' + i).value;
		questions += '&statement_' + i + '=' + encodeURI(question_statement) + '&answers_'+ i + '=' + encodeURI(answers) + 
							'&valid_answer_'+ i + '=' + encodeURI(valid_answer) + '&file_'+ i + '=' + encodeURI(attach);
	}
	var test_name = document.questionnaire.test_name.value;
	var test_description = document.questionnaire.test_description.value;
	var test_topics = document.questionnaire.test_topics.value;
	var test_duration = document.questionnaire.test_duration.value;
	questions += '&test_name=' + encodeURI(test_name) + '&test_description=' + encodeURI(test_description) + '&test_topics=' + 
						encodeURI(test_topics) + '&test_duration=' + encodeURI(test_duration) + '&no_questions=' + encodeURI(count);
	questions += test_info;
	
	/* do_ajax('ass_get_test.php',questions,'callback_output_text','false','post','<p>Loading...</p>','principal','button'); */
	window.location.href = "ass_get_test.php?questions" + questions;
}
function javascript_do_add_question()
{
	question_counter++;
	var count = question_counter;
	
	var ul = document.getElementById("questions");
	var hr = document.createElement("hr");
	ul.appendChild(hr);
	
	javascript_add_question(count);
}

function javascript_output_test_data(statement,attach,A,B,C,D,counter)
{
	/* set counter */
	document.questionnaire.counter.value = counter;
	/* output question number */
	var leg = document.getElementsByTagName("legend")
	leg[0].innerHTML = "Question " + counter;
	/* output question statement */
	document.getElementById("statement").innerHTML = statement[counter-1];
	/* output attach's image */
	if(attach[counter-1] != "")
	{
		var img = document.getElementsByTagName("img");
		img[0].setAttribute("src",attach[counter-1]);
	}
	/* output answers */
	var li_a = document.getElementById("opt_1");
	var li_b = document.getElementById("opt_2");
	var li_c = document.getElementById("opt_3");
	var li_d = document.getElementById("opt_4");
	
	if(counter > 1)
	{
		li_a.removeChild(li_a.childNodes[3]);
		li_b.removeChild(li_b.childNodes[3]);
		li_c.removeChild(li_c.childNodes[3]);
		li_d.removeChild(li_d.childNodes[3]);
	}
	
	var t1 = document.createTextNode(A[counter-1]);
	var t2 = document.createTextNode(B[counter-1]);
	var t3 = document.createTextNode(C[counter-1]);
	var t4 = document.createTextNode(D[counter-1]);
	li_a.appendChild(t1);
	li_b.appendChild(t2);
	li_c.appendChild(t3);
	li_d.appendChild(t4);			
}
function javascript_get_test_question(course,field,level,test,statment,attach,opt_a,opt_b,opt_c,opt_d,no_quest,duration,min,sec)
{
	/* get answer */
		var answers = document.questionnaire.answer;
		var choice = "";
		for(var i = 0;i < answers.length;i++)
		{
			if(answers[i].checked == true)
			{
				choice = answers[i].value;
				break;
			}
		}
		/* if no answer */
		if(choice == "")
		{
			choice = "NOT";
		}
		/* save answers */
		 var answer = document.data.answer.value;
		 answer += choice + "|";
		document.data.answer.value = answer;
	
	/* get chrono ids */
	var time_id = document.data.time.value;
	var chrono_id = document.data.chrono.value;
	
	var counter = document.questionnaire.counter.value;
	/* clear previous chrono */
	clearTimeout(chrono_id);
	
	if(counter == no_quest)
	{
		/* clear All chrono's setTimeout */
		clearTimeout(time_id);
		clearTimeout(chrono_id);
		/* go to test result */
				do_ajax('ass_test_result.php','?answer=' + answer + '&counter=' + counter + '&field=' + field + '&level=' + level + '&course=' + course + '&test=' + test,'false','get','<p>Wait Loading...</p>','test_page','test_page');
	}
	else
	{
		counter++;
		document.questionnaire.counter.value = counter;
		/* output next question */
		javascript_output_test_data(statment,attach,opt_a,opt_b,opt_c,opt_d,counter);
		/* restart counter */
		javascript_display_chrono(course,field,level,test,statment,attach,opt_a,opt_b,opt_c,opt_d,duration,duration,no_quest,min,sec);
	}
}
function javascript_goto(url,query)
{
	window.location.href = url + query;
}
