<?php
require('connect.php');
error_reporting(0);

session_name('tzLogin');
session_set_cookie_params(2*7*24*60*60);
session_start();

$id=$_SESSION['id'];
$usr=$_SESSION['usr'];
?>
<?php if(!isset($_SESSION['usr'])) {
	header("location: login.php");
} ?>
<?php
if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe'])
{
	// If you are logged in, but you don't have the tzRemember cookie (browser restart)
	// and you have not checked the rememberMe checkbox:

	$_SESSION = array();
	session_destroy();

	// Destroy the session
}
if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();

	header("Location: login.php");
	exit;
}
?>
<!------------------ End Get Session ------------------>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Digital Archive | จดหมายเหตุดิจิตัล</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
<!-----  header  --------->
        <header class="header">
						<?php
						if($_SESSION['id'])
						{
						############## Menu  Login Already ############
						include('header.php');
						}
						?>
        </header>
						<!---- End of header  -------->
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
							<?php
							if($_SESSION['id'])
							{
								require('connect.php');
								$sql = "select * from tz_members where id = '$id'   ";
								$query= mysqli_query($link,$sql) or die("Can't Query");
								$result= mysqli_fetch_array($query);
								echo "<img src ='../../pic/profile/profile-$result[mem_pic]' class='img-circle' alt='User Image'>";
							}
							?>
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $_SESSION['usr'] ? $_SESSION['usr'] : 'Guest';?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="index.php" method="post" role="search" name="form1" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="s" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
						<!-----  Menu --------->
						<?php
						if($_SESSION['id'])
						{
						############## Menu  Login Already ############
						include('menu.php');
						}
						?>
						<!---- End of Menu -------->
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
						ข่าวและกิจกรรม
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">ข่าวและกิจกรรม</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Main row -->
                    <div class="row">
						<div class="col-md-12">


<!--------------   Process -->
    <?php
	if($_SESSION['id'])
	{
   	##############  Login Already ############
	//echo "<h1> You are registered and logged in!</h1>";
//echo "ไอดีที่ถูกส่งมาคือ ".$id."<br> ชื่อผู้ใช้คือ ".$usr;
//including the database connection file
include("connect.php");



$sql6 = " SELECT `permission` from `tz_members` where id = '$id' ";

            $query6 =  mysqli_query($link,$sql6);
            while($row6 = mysqli_fetch_array($query6,MYSQLI_ASSOC))
            {
                $permission= $row6['permission'];
               // $osm_lname= $row1['LNAME'];
            }
        
//echo "per ".$permission."<br> ชื่อผู้ใช้คือ ".$usr;
//including the database connection file
//require('connect.php');

////////// Check User /////////



if($permission == 'user')
		{
		echo "you don't have permission";
		die();
        }
        
$newsid=$_REQUEST['newsid'];
$editnews =$_REQUEST['editnews'];
$picnum =$_REQUEST['picnum'];
$delpic =$_REQUEST['delpic'];

$sql = "select * from archive_news where news_id = '$newsid' ";
$query=mysqli_query($link,$sql) or die("Can't Query");
$num_rows=mysqli_num_rows($query);
	for ($i=0; $i<$num_rows; $i++) {
    $result=mysqli_fetch_array($query);
    $title = $result[news_title];
    $detail = $result[news_detail];
    $publish = $result[news_publish];
    $myfile1 = $result[news_pics];
    $myfile2 = $result[news_pics2];
    $myfile3 = $result[news_pics3];
    $myfile4 = $result[news_pics4];
    $myfile5 = $result[news_pics5];
	$news_ref_link = $result['news_ref_link'];
    } 
if($delpic == '1')
{
echo "
<div id='alert-message' class='alert alert-success alert-dismissable'>
	<i class='fa fa-check'></i>
	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	ลบภาพเสร็จสิ้น
</div>";

$sql = "select * from archive_news where news_id = '$newsid' ";
$query=mysqli_query($link,$sql) or die("Can't Query");
$num_rows=mysqli_num_rows($query);
	for ($i=0; $i<$num_rows; $i++) {
    $result=mysqli_fetch_array($query);
    $title = $result[news_title];
    $detail = $result[news_detail];
    $myfile1 = $result[news_pics];
    $myfile2 = $result[news_pics2];
    $myfile3 = $result[news_pics3];
    $myfile4 = $result[news_pics4];
    $myfile5 = $result[news_pics5];
		$news_ref_link = $result['news_ref_link'];
    }
}        
        
if($editnews == '1')
{
$title =$_REQUEST['title'];
$detail =$_REQUEST['detail'];
$publish =$_REQUEST['publish'];
$news_ref_link = $_REQUEST['ref_link'];
;
echo "
<div id='alert-message' class='alert alert-success alert-dismissable'>
	<i class='fa fa-check'></i>
	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	แก้ไขข่าวและกิจกรรมเสร็จสิ้น
</div>";

######## UPload FILE 1 ###########
if($_FILES['file1']['name'] !='')
{
//$target_path = "../../pic/news/";
$target_path = "pic/news/";
$target_path = $target_path . basename( $_FILES['file1']['name']);
$myfile1 = $_FILES['file1']['name'];
if(move_uploaded_file($_FILES['file1']['tmp_name'], $target_path)) {
    //echo "The file ".  basename( $_FILES['file1']['name']).
    //" has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}
}

######## UPload FILE 2 ###########
if($_FILES['file2']['name'] !='')
{
$target_path = "../../pic/news/";
$target_path = $target_path . basename( $_FILES['file2']['name']);
$myfile2 = $_FILES['file2']['name'];
if(move_uploaded_file($_FILES['file2']['tmp_name'], $target_path)) {
    //echo "The file ".  basename( $_FILES['file1']['name']).
    //" has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}
}


######## UPload FILE 3 ###########
if($_FILES['file3']['name'] !='')
{
$target_path = "../../pic/news/";
$target_path = $target_path . basename( $_FILES['file3']['name']);
$myfile3 = $_FILES['file3']['name'];
if(move_uploaded_file($_FILES['file3']['tmp_name'], $target_path)) {
    //echo "The file ".  basename( $_FILES['file1']['name']).
    //" has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}
}


######## UPload FILE 4 ###########
if($_FILES['file4']['name'] !='')
{
$target_path = "../../pic/news/";
$target_path = $target_path . basename( $_FILES['file4']['name']);
$myfile4 = $_FILES['file4']['name'];
if(move_uploaded_file($_FILES['file4']['tmp_name'], $target_path)) {
    //echo "The file ".  basename( $_FILES['file1']['name']).
    //" has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}
}


######## UPload FILE 5 ###########
if($_FILES['file5']['name'] !='')
{
$target_path = "../../pic/news/";
$target_path = $target_path . basename( $_FILES['file5']['name']);
$myfile5 = $_FILES['file5']['name'];
if(move_uploaded_file($_FILES['file5']['tmp_name'], $target_path)) {
    //echo "The file ".  basename( $_FILES['file1']['name']).
    //" has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}
}

$sql = "UPDATE archive_news SET `news_title` = '$title', `news_detail` = '$detail', `news_publish` = '$publish'
, `news_ref_link` = '".$_REQUEST['ref_link']."'
 WHERE `archive_news`.`news_id` = '$newsid' LIMIT 1 ;";
$query=mysqli_query($link,$sql) or die("Can't Query");
header("location: editnews.php?newsid=".$result['news_id']."");
}
 

        
else {
      
  }
        
echo "<div class='box box-primary'>"; // Start box-primary
echo "<form class='form-horizontal' role='form' name='form1' method='post' action='editnews.php?newsid=".$result['news_id']."' enctype='multipart/form-data'>";
echo "<div class='box-body'>"; // Start box-body

echo "<div class='form-group'>";
echo "<label class='col-sm-2 control-label'>หัวข้อข่าวและกิจกรรม</label>";
echo "<div class='col-sm-10'>";
echo "<input class='form-control' type='text' name ='title' value='$title'>";
echo "</div>";
echo "</div>";

echo "<div class='form-group'>";
echo "<label class='col-sm-2 control-label'>การเผยแพร่</label>";
echo "<div class='col-sm-10'>";   

if($publish == '0')
{
echo "<input class='form-control' type='radio' name ='publish' value='0' checked> ไม่เผยแพร่";
echo "<input class='form-control' type='radio' name ='publish' value='1'> เผยแพร่";
echo "</div>";
echo "</div>";
}
else
{
echo "<input class='form-control' type='radio' name ='publish' value='0'> ไม่เผยแพร่";
echo "<input class='form-control' type='radio' name ='publish' value='1' checked> เผยแพร่";
echo "</div>";
echo "</div>";
}        
echo "
	<div class='form-group'>

		<div class='col-md-2 text-right'>
			<label>ข้อมูลเพิ่มเติม</label>
		</div><!-- /.col-md-2 -->
		<div class='col-md-10'>
			<input type='text' class='form-control' name='ref_link' value='".$news_ref_link."'>
		</div><!-- /.col-md-10 -->

	</div>
";
echo "<div class='form-group'>";
echo "<label class='col-sm-2 control-label'>รายละเอียด</label>";
echo "<div class='col-sm-10'>";
echo "
	<script type='text/javascript' src='WYSIWYG/nicEdit.js'></script>
	<script type='text/javascript'>
		bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
	</script>
	<textarea name='detail' style='width: 100%; height: 250px;'>".$detail."</textarea>
";
echo "</div>";
echo "</div>";        
echo "</div>"; // End box-body

echo "<div class='box-footer'>"; // Start box-footer
echo "<input type='hidden' name='editnews' value='1'><input type='hidden' name='newsid' value='$newsid'><button type='submit' name='submit' class='btn btn-primary'>บันทึก</button>";
echo "</div>"; // End box-footer
echo "</form>";
echo "</div>"; // End box-primary
        
/////////////////////////////// PICTURE ---------------------------------------------
echo "
	<div class='box'>
		<div class='box-header with-border'>
			<h3 class='box-title'>ภาพประกอบ</h3>
		</div><!-- /.box-header with-border -->
		<div class='box-body'>
		";

		//$query = mysqli_num_rows"SELECT * FROM `news_pic` WHERE nw_id = '".$_GET['newsid']."'");
//        $query = mysqli_num_rows"SELECT * FROM `news_upload` WHERE `obj_id` = '".$objid."'");
         //$query = mysqli_num_rows ($link,"SELECT * FROM `news_upload` WHERE `obj_id` = '".$_GET['newsid']."'");
          // $query = mysqli_query ($link,"SELECT * FROM `news_upload` WHERE `obj_id` = '".$_GET['newsid']."'");
		$sql = "SELECT * FROM `news_upload` WHERE `obj_id` = '".$_GET['newsid']."' ";
        $query=mysqli_query($link,$sql) or die("Can't Query");
        if(mysqli_num_rows($query) != 0) {
			echo "
			<div class='row'>

					";

					while($row = mysqli_fetch_assoc($query)) {
						echo "
							<div class='col-md-2'>
                                <img src='../../pic/news_upload/".$row['obj_id']."/".$row['bpu_file']."' style='border: 1px solid #ccc;'>
								<br><br>";

								?>
<!--								<a href='model/funcNewsPic.php?method=cover&news=<?php //echo $_GET['newsid']; ?>&id=<?php //echo $row['bpu_id']; ?>'><?php //if($row['np_cover'] == 1) { //echo "<img src='images/icon_set2.png'>"; } else { //echo "<img src='images/icon_set3.png'>"; } ?></a>-->
								<a href='model/funcDeletePic.php?type=news&news=<?php echo $_GET['newsid']; ?>&id=<?php echo $row['bpu_id']; ?>'><img src='images/icon_del2.png'></a>

<!--					<a href='model/funcDeletePic.php?objectid=".$objectid."&type=news"."&refcode=".$refcode."&file=".$row['bpu_id']."'><img src='images/icon_del2.png'>".$row['bpu_id']."</a>-->

								<?php echo "
							</div>
						";
					}

					echo "

			</div><!-- /.row -->
			";
		} 
        
        
        else {
			echo "
			<div class='row'>
				<div class='col-md-12'>
					ไม่มีภาพประกอบ 
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
			";
		}

		echo "
		</div><!-- /.box-body -->
        
		<div class='box-footer'>
			<div class='row'>
        
				<div class='col-md-12'>
				 <form name ='formupload' method='post' action='model/funcMediaUpload.php' enctype='multipart/form-data'>
						<div class='form-inline'>


		                    <input type='file' name='uploadedfile' id='uploadedfile'>
							<input type='hidden' name='MAX_FILE_SIZE' value='1000000'/>
							<input type='hidden' name='id' value='".$_GET['newsid']."'/>
                            <input type='hidden' name='objectid' value='".$_GET['newsid']."'/>
                            <input type='hidden' name='type' value='news'>
							<br>
							<button class='btn btn-primary' type='submit'>อัพโหลด</button>
     

						</div><!-- /.form-inline -->
					</form>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		</div><!-- /.box-footer -->
	</div><!-- /.box -->
";
/////////////////////////////// PICTURE ---------------------------------------------        
        
 
/////////////////////////////// MEDIA FILE ---------------------------------------------       
echo "</div>";       
 
        
        
        
        
}
else {
    echo "<h1>Please, <a href='demo.php'>login</a> and come back later!</h1>";
	}
//}
                            

?>

<!--------   End Of Process------------>
						</div>
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <script src="js/jquery-2.0.2.min.js"></script>
		<!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
         <!-- AdminLTE for demo purposes -->
        <script src="js/AdminLTE/demo.js" type="text/javascript"></script>
		<!-- Page script -->
		<script type="text/javascript">
			$(function() {
				$("#alert-message").alert();
					window.setTimeout(function() { $("#alert-message").alert('close'); }, 3000);
			});
		</script>

    </body>
</html>
