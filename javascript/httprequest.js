/*  
	AJAX Library
	
	File name: httprequest.js
	File description: The AJAX library, containing the ajax general routines, that is the HttpRequest class
	File author: Lens Kamdem
	File update date: 14/12/2015 at 10:21
*/

/* HttpRequest class */

function HttpRequest(sUrl, query, get_xml, request_type, feedback, page_element, fb_page_element)
{
	this.request = this.createXmlHttpRequest();
	if (request_type == "get")
	{
		var rand = parseInt(Math.random()*999999);
		if (query == "")
		{
			query = "?";
		}
		this.request.open("GET", sUrl + query + "&rand=" + rand, true);
	}
	else if (request_type == "post")
	{
		this.request.open("POST", sUrl, true);
		this.request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	}
	
	var tempRequest = this.request;
	function request_readystatechange()
	{
		if (tempRequest.readyState == 4)
		{
			if (tempRequest.status == 200)
			
			{
				var return_value = tempRequest.responseText;
				if (get_xml == "true")
				{
					return_value = tempRequest.responseXML;
					
				}
				try
				{
					document.getElementById(page_element).innerHTML = return_value;
				}
				catch(error)
				{
					try
					{
					document.getElementsByClassName(page_element).innerHTML = return_value;
					}
					catch(error)
					{
						/* do nothing */
					}
				}
				
			}
			else
			{ 
				try
				{
					document.getElementById(page_element).innerHTML = "Error: request could not be executed";
				}
				catch(error)
				{
					try
					{
						document.getElementsByCLassName(page_element).innerHTML = "Error: request could not be executed";
					}
					catch(error)
					{
						/* do nothing */
					}
				}
			}
		}
		else
		{
			try
			{
				document.getElementById(fb_page_element).innerHTML = feedback;
			}
			catch(error)
			{
				try
				{
					document.getElementByCLassName(fb_page_element).innerHTML = feedback;
				}
				catch(error)
				{
					/* do nothing */
			  	}
			}
		}
	}
	this.request.onreadystatechange = request_readystatechange;
}
HttpRequest.prototype.createXmlHttpRequest = function ()
{
	if (window.XMLHttpRequest)
	{
		var oHttp = new XMLHttpRequest();
		return oHttp;
	}
	else if (window.ActiveXObject)
	{
		var versions =
			[
				"MSXML2.XmlHttp.6.0",
				"MSXML2.XmlHttp.3.0"
			];
		for (var i = 0; i < versions.length; i++)
		{
			try
			{
				var oHttp = new ActiveXObject(versions[i]);
				return oHttp;
			}
			catch (error)
			{
			//do nothing here
			}
		}
	}
	return null;
}
HttpRequest.prototype.send = function (request_type, query)
{
	if (request_type == "get")
	{
		this.request.send(null);
	}
	else if (request_type == "post")
	{
		this.request.send(query);
	}
}

/* instantiating HttpRequest class */

function do_ajax(sUrl, query, get_xml, request_type, feedback, page_element, fb_page_element)
{
	var request = new HttpRequest(sUrl, query, get_xml, request_type, feedback, page_element, fb_page_element);
	request.send(request_type, query);
}