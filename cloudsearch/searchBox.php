
<html>
<head>
<title>Search Box with suggestion from AWS stream</title>
<style type="text/css" >
	#main {
	padding: 10px;
	margin: 100px;
	margin-left: 300px;
	color: Green;
	border: 1px dotted;
	width: 520px;
	}
	#display_results {
	color: red;
	background: #CCCCFF;
	}
</style>
<script type="text/javascript "src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

<script type='text/javascript'>
	$(document).ready(function(){
		$("#display_results").slideUp(); 		    //The .slideUp() method animates the height of the matched elements,  the default duration of  400 milliseconds is used. 
		$("#button_find").click(function(event){	//Bind an event handler to the "click" JavaScript event
		event.preventDefault();							
		query_search();							//rather this function would be invoked
		});
		$("#search_query").keyup(function(event){	//Bind an event handler to the "keyup" JavaScript event,
		event.preventDefault();						//the default action of the event will not be triggered.
		search_ajax_way();							
		});
		// $("#display_results").click(function(event){	//Bind an event handler to the "click" JavaScript event
		// event.preventDefault();							
		// 						//rather this function would be invoked
		// });


	});

	function query_search() {
		var search_this=$("#search_query").val();
		$.post(											// Load data from the server using a HTTP POST request.	
			"querySearch.php", {							//Pages fetched with POST are never cached
				searchit : search_this					//data to be posted
			}, 
			function(data){								//success callback function
				console.log(data);						//JS debugging
				$("#search_results").html(data);
			})
		// body...
	}


	//jQuery's Ajax methods return a superset of the XMLHTTPRequest(XHR) object
	//can use  jquery serialize to direclty send form data over http post
	function search_ajax_way(){
		$("#display_results").show();
		var search_this=$("#search_query").val();		//Get the current value of the first element in the set of matched elements or set the value of every matched element.
		$.post(											// Load data from the server using a HTTP POST request.	
			"suggest.php", {							//Pages fetched with POST are never cached
				searchit : search_this					//data to be posted
			}, 
			function(data){								//success callback function
				console.log(data);						//JS debugging
				$("#display_results").html(data);
			})
		//$("#display_results").html() in console to debug
	}
</script>
</head>

<body>
<div id="main">
<h1>Type your query here!</h1>
<p></p>
<form id="searchform" method="post">

<label>Enter :</label>
<input type="text" name="search_query" id="search_query" placeholder="What You Are Looking For?" size="50"/>
<input type="submit" value="Search" id="button_find" />

</form>
<div id="display_results"></div>
<br/>
<br/>
<h1>The search results<br></h1>
<div id="search_results"></div>
</div>

</body>
</html> 
