<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Drag & Drop</title>
<!--<link href="../style.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery-ui.js"></script>
<style>
ul {
	padding:0px;
	margin: 0px;
}
#response {
	padding:10px;
	background-color:#FFFFFF;
	border:2px solid #396;
	margin-bottom:20px;
}
#list li {
	margin: 0 0 3px;
	padding:8px;
	background-color:#cccccc;
	color:#fff;
	list-style: none;
}
</style>
<script type="text/javascript">
$(document).ready(function(){ 	
	  function slideout(){
  setTimeout(function(){
  $("#response").slideUp("slow", function () {
      });
    
}, 2000);}
	
    $("#response").hide();
	$(function() {
	$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			
			var order = $(this).sortable("serialize") + '&update=update'; 
			$.post("updateList.php", order, function(theResponse){
				$("#response").html(theResponse);
				$("#response").slideDown('slow');
				slideout();
			}); 															 
		}								  
		});
	});

});	
</script>
</head>
<body>
<div id="container">
  <div id="list">

    <div id="response"> </div>
    <ul>
      <?php
                $refcode = $_REQUEST['refcode'];
                include("../../conf/connectdb.php.inc");
				$query  = "SELECT pic_id, pic_name FROM archive_pic WHERE obj_refcode = '$refcode' ORDER BY listorder ASC";
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{					
				$id = stripslashes($row['pic_id']);
				$name = stripslashes($row['pic_name']);					
		?>
	  <form name='form1' action='xx.php' method='post'>
      <li id="arrayorder_<?php echo $id ?>"><?php echo $id?> <?php #echo $name; ?>
      <?php echo "<img src ='../../pic/thumb/thumb-$name' height='50'>"; ?>
       <input type ='text' name='text'>
       <input type='submit' name='submit' value='submit'>
       </form>
        <!--<div class="clear"></div>-->
      </li>
      <?php } ?>
    </ul>
  </div>
</div>


</body>
</html>
