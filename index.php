<?php
include("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="myaccount/nucss/css.css" type="text/css" rel="stylesheet">
<style>
	a {
		text-decoration:none;
		color:#144C81;
	}
	a:hover {
		color:#B4DD4F;
	}
	#submenu {
		width:250px;
	}
	#mylist li ul li a {
		text-decoration:none;
	}
	.glossymenu {
		margin: 5px 0;
		padding: 0;
		width: 190px; /*width of menu*/
		border: 1px solid #9A9A9A;
		border-bottom-width: 0;
	}
</style>
<script LANGUAGE="JavaScript">
if(document.referrer.indexOf("://") == -1) {
	//location = "index.php"
}
</script>
<script src="myaccount/js/core.js" type="text/javascript"></script>
<script src="myaccount/js/more.js" type="text/javascript"></script>
<script>
window.addEvent('domready',function (){
	
	$('mylist').addEvent('click:relay(li)',function () {
		if (this.getChildren()[0]){
			if (this.getChildren()[0].getStyle('display') =='block') {
				if (this.getProperty('title')) {
					this.getChildren()[0].setStyle('display','none');
				}
			}else {
				this.getChildren()[0].setStyle('display','block');
			}
		}
	});
	
	$('embedItems').setProperty('height',(window.getHeight()-75) + 'px');

});
</script>
<title>Money Transfer STR Portal</title>
</head>

<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0">
<style>
#logo {
	padding:3px;
	/*border-bottom:1px dashed #33C0C9;*/	background-image:url(../images/borderbg.gif); background-position:bottom; background-repeat:repeat-x;
}
</style>
<div id="logo" align="left"><img src="../new_template/images/skyeplus.gif"></div>
<div align="right" style="background-color:#fff"><img src="../new_template/images/images/spacer.gif" height="1px"/></div>
<?php
if (count($_GET) == 0) {
	$get_variables = "";
} else {
	$get_variables = "?";
	$count = 0;
	foreach ($_GET as $key => $value) {
		$get_variables .= $key."=".$value;
		$count ++;
		if ($count < count($_GET)) {
			$get_variables .= "&";
		}
	}
}
?>
<div style="width: 100%; height: auto; overflow: hidden; border-bottom:1px dashed #33C0C9;">
<div style="font-size:11px;color:#144C81;padding:5px; float: left; width: calc(100% - 300px);"><strong>SkyePlus &rarr; Money Transfer STR Portal</strong></div>
<div style="font-size:11px;color:#144C81;padding:5px; float: right; width: 250px; text-align: right;"><strong>Logged in as <?php echo $username;?></strong></div>
</div>
  <table border="1" cellpadding="2" cellspacing="1" width="100%">
    <tr>
      <td valign="top" width="100">
        <div id="submenu">
          <ul id="mylist">
            <li title="Money Transfer STR Portal">Money Transfer STR Portal					
				<ul class="products"> 
				<?php 
				if($jf ='2' OR $jf='6' OR $jf='$7' OR $usr='eosafile'){
				?>
					<li><a class="report" href="ini_req.php" target="embedItems" title="Branch Visitation">Fill a Form</a></li>
					<li><a class="report" href="pending_req.php" target="embedItems" title="My Access Forms">My Requests</a></li> 	
					<li><a class="report" href="branch_report.php" target="embedItems" title="Manage Requests">Branch Report</a></li>
				<?php
				}
				?>
            <?php 
				if($usr == 'eosafile' OR $usr == "oadeoye" OR $usr == "toyenuga"){
			?>
					<li><a class="report" href="report.php" target="embedItems" title="Manage Requests">Generate Report</a></li> 
			<?php
				}
			?>
				</ul>
            </li>
          </ul>
        </div>
      </td>
      <td style="border-left:1px dashed #ccc;padding-left:2px" valign="top">
        <iframe width="100%" name="embedItems" frameborder="0" marginheight="0" marginwidth="0" id="embedItems" height="100%" src="<?php echo $landing_page.$get_variables; ?>"></iframe>
      </td>
    </tr>
  </table>
</body>
</html>
