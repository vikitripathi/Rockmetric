<html>
<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	
	<title></title>
</head>
<body>
	<!-- To  show no of visists day wise of this current week (ongoing) using gogle charts-->
	<div id="chart_div" style="width: 900px; height: 500px;"></div>
	<div id="test"></div>
	<script type="text/javascript">
	
	      google.load("visualization", "1", {packages:["corechart"]});
	      google.setOnLoadCallback(drawChart);
	      
	      
	  
	      function drawChart() {
		      $.post(											// Load data from the server using a HTTP POST request.	
				"piwik.php", 
				function(data){								//success callback function
					//console.log(data);						//JS debugging
					var data=new google.visualization.DataTable(data);
	        
			        var options = {
			          title: 'Rockmetric unique visitors trend over the week',
			          hAxis: {title: 'day',  titleTextStyle: {color: '#333'}},
			          vAxis: {minValue: 0},
			          width:1300,
			          height:900
			        };

			        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			        chart.draw(data, options);

				},"json");		
	        // var data = google.visualization.arrayToDataTable([		
	        //   ["Day", "Unique Visitors", "Actions"],	          
	        //   ["2013",  1000,      400],
	        //   ["201",  1170,      460],
	        //   ["2015",  660,       1120],
	        //   ["2016",  1030,      540]
	        // ]);

	        //var test=fetchData();
	        
	      }
	      //other functions  and call

	  //     function fetchData(){
	  //     		var data2=[];
	  //     		// var data2=[		
	  //       //   ['Day', 'Unique Visitors', 'Actions'],	          
	  //       //   ['2013',  1000,      400],
	  //       //   ['2014',  1170,      460],
	  //       //   ['2015',  660,       1120],
	  //       //   ['2016',  1030,      540]
	  //       // ];
	  //       var data3=[];
			// 	$.post(											// Load data from the server using a HTTP POST request.	
			// 		"piwik.php",  								//check return data type JSON
			// 		function(data){								//success callback function
			// 			console.log(data);
			// 			console.log(JSON.parse(data))						//JS debugging
			// 			console.log(JSON.parse(data)[0].nb_actions);
			// 			//data3=new array(JSON.parse(data).length+1);
			// 			//data3[0]=new Array(7);
			// 			data3[0]=["Day","Total Visistors","Unique Visitors","Total Actions","Total Users","Bounce Count","Total Visit Length"];
			// 			data2[0] = new Array(3);
			// 			data2[0]=['Day', 'Unique Visitors', 'Actions'];
						
			// 			// for(d in JSON.parse(data)){
			// 			// 	data3[i] = new Array(7);
			// 			// 	data3[i+1][0]=d.label;
			// 			// 	data3[i+1][1]=d.nb_visits;
			// 			// 	data3[i+1][2]=d.nb_uniq_visitors;
			// 			// 	data3[i+1][3]=d.nb_actions;
			// 			// 	data3[i+1][4]=d.nb_users;
			// 			// 	data3[i+1][5]=d.bounce_count;
			// 			// 	data3[i+1][6]=d.sum_visit_length;
			// 			// }
						
			// 			console.log(data2);
			// 			var day=["2013","2014","2015","2016"];
			// 			var uv=[1000,1170,660,1030];
			// 			var ac=[400,460,1120,540];
			// 			for (var i = 0; i <4; i++) {
			// 				data2[i+1] = new Array(3);
			// 				data2[i+1][0]=day[i];
			// 				data2[i+1][1]=uv[i];
			// 				data2[i+1][2]=ac[i];								
			// 			};	
			// 			//data2=JSON.parse(data);
			// 			//$("#test").html(data);
			// 			//data1=data;
			// 		})
			// 	//$("#display_results").html() in console to debug
			// 	return data2;	
			// }
 </script> 
</body>
</html>
