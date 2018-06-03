<?php
if (!isset($_SESSION))
session_start();

include("../email.php");
$usr = $_SESSION['user'];
$empno = @$_SESSION['empno'];
$jf = @$_SESSION['jf'];	
$branch_code = @$_SESSION['branch_code'];	
include_once('../db.php');
ConnectToDb($server, $user, $pass, $database);


if (isset($_GET['lp'])) {
	switch ($_GET['lp']) {
		case "h":
			$landing_page = "dashboard.php";
			break;;
		default:
			$landing_page = "dashboard.php";
	}
} else {
	$landing_page = "dashboard.php";
}
	
function stringFormat($string) {
		$new_string = str_replace("'", "''", trim($string));
		return $new_string;
	}
	
function getAll($tab) {
	$result = mysql_query("SELECT * FROM $tab where deleted = '0'");
	return $result;
}

function getApplication($tab) {
	$result = mysql_query("SELECT * FROM $tab where deleted = '0' order by app_name");
	return $result;
}

function getStaff($tab) {
	$result = mysql_query("SELECT * FROM $tab where status = 1 order by staff_id");
	return $result;
}

function getSupervisorEmail($fv) {
	$result = mysql_fetch_array(mysql_query("SELECT * FROM employee_master where empname='$fv'"));
	return $result;
}

function getSupervisor($fv) { 
	//use branchcode to get bsm
	$result = mysql_query("SELECT empname from employee_master where empno IN
							(
							(SELECT depthead FROM employee_master where uname = '$fv'),
							(SELECT divhead FROM employee_master where uname = '$fv')
							) 
						");
	return $result; 
}

function getICO($usr) {
	//return all ICOs
	//$result = mysql_query("select empno as ico_empno, concat(fname, ' ',sname) as ico_empname, email as ico_email from employee_master where jf = 5 OR jf= 11 order by ico_empname"); //MODIFIED 11-OCT-2017

	$result = mysql_query("select empno as ico_empno, empname as ico_empname, email as ico_email from employee_master where jf = 5 OR jf= 11 order by ico_empname");

	return $result; 
}

function supervisorSurname($fv, $fs) {
	//return all ICOs
	$result = mysql_query("SELECT * from employee_master WHERE sname like '%$fv%' and empno !=  '$fs' order by empname");

	return $result; 
}

function getInsuranceCoy($tab) {
	$result = mysql_query("SELECT * FROM $tab where deleted = '0' order by name");
	return $result;
}

function getMine($tab, $fn) {
	$result = mysql_query("SELECT * FROM $tab where logged_by = '$fn' and deleted = '0'");
	return $result;
}

function getRepName($tab, $fn, $fv) {
	$result = mysql_query("SELECT * FROM $tab where $fn='$fv' and deleted = '0'");
	return $result;
}

function getRequests($tab, $a, $b) {
	$result = mysql_query("SELECT * FROM $tab where deleted = '0' and date_submitted between '$a' and '$b' and pending_with != '' ORDER BY id  DESC");
	return $result;
}

function getMyJobs($tab, $fn, $fv, $empno) {
	$result = mysql_query("SELECT * FROM $tab where $fn='$fv' and deleted = '0' and authby='$empno'");
	return $result;
}
  

function getPendReq2($tab, $fn) {
	$result = mysql_query("SELECT * FROM $tab where pending_with = 'ico/rbc' and rco_emailid = '$fn' and deleted = '0'");
	return $result;
}  

function getRepName2($tab, $fn, $fv) {
	$result = mysql_query("SELECT * FROM $tab where $fn like '%$fv%' and app_or_rej = 'Completed' and deleted = '0'");
	return $result;
}

function getRepName4($tab, $fn, $fv) {
	$result = mysql_query("SELECT * FROM $tab where $fn = '%$fv%' and app_or_rej = 'Completed' and deleted = '0'");
	return $result;
}

function getRepName3($tab, $a, $b, $c) {
	$result = mysql_query("SELECT * FROM $tab where $a between '$b' and '$c' and app_or_rej = 'Completed' and deleted = '0'");
	return $result;
}

function getRequest($tab, $fn, $fv) {
	$result = mysql_query("SELECT * FROM $tab where $fn != '$fv' and deleted = '0'");
	return $result;
}

function getDocument($tab, $fn, $fv) {
	$result = mysql_query("SELECT filename, doctype, document FROM $tab where $fn = '$fv' and deleted = '0'");
	return $result;
}

function getField($tab, $rf, $rv, $fn) {
	$result = mysql_query("SELECT * FROM $tab WHERE $rf='$rv'");
	$row = mysql_fetch_array($result);
	$val = $row[$fn];
	return $val;
}

function getBranchName($tab, $rf, $rv, $fn) {
	$result = mysql_query("SELECT * FROM $tab WHERE $rf='$rv'");
	$row = mysql_fetch_array($result);
	$val = $row[$fn];
	return $val;
}

function getSumAssured($tab, $fn, $fv) {
	$result = mysql_query("SELECT sum(ins_amt) as sum_assured FROM $tab where $fn = '$fv' and deleted = '0'");
	return $result;
}

function getCurrentJobFunction($tab, $fn, $fv){
	//return all JobFunctions
	$result = mysql_fetch_assoc(mysql_query("Select jdesc from $tab where $fn = $fv"));
	return $result;
}

function getAllJobFunctions($usr){
	$result = mysql_query("Select * from jobFunctions where jf != 'NULL' order by jdesc");
	return $result;
}

function deactivateUser($tab, $fv, $id) { 
	if (mysql_query("UPDATE $tab ".
				"SET status = $fv ".
				"WHERE staff_id = $id")
				)
				
		return true;
	else
		return false;
}

function activateUser($tab, $fv, $fr, $id) { 
	if (mysql_query("UPDATE $tab ".
				"SET status = $fv, ".
				"tickets = $fr ".
				"WHERE staff_id = $id")
				)
				
		return true;
	else
		return false;
}

function getPendReq($tab, $fn, $fv) {
	$result = mysql_query("SELECT * FROM $tab where $fn = '$fv' and deleted = '0'");
	return $result;
} 

function insertRecord($qry, $a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p) {
	$sql = "$qry
	VALUES ('$a', '$b', '$c', '$d', '$e', '$f', '$g', '$h', '$i', '$j', '$k', '$l', '$m', '$n', '$o', 
	'$p')";
	
	if (mysql_query($sql)) {
		return true;
	} else {
		echo "Error: " . $sql . "<br>" . mysql_error();
		return false;
	}
}

if (!isset($_SESSION['user'])) {
	header("Location:../dashboard");
} else {
	$username = $_SESSION['user'];
}

//mysql_fetch_array($result, MYSQL_ASSOC)) 
$arr = ""; 
$arr2 = "";
$res = getRepName("inci_dashboard_users", "role", "user_profile");
while ( $row = mysql_fetch_assoc($res)) {
	$arr = $row['empno'];
	$arr2 = $row['jf'];
	$arr = explode(';',$arr);
	$arr2 = explode(';',$arr2);
}
$res2 = getRepName("inci_dashboard_users", "role", "admin");
while ( $row = mysql_fetch_assoc($res2)) {
	$arr3 = $row['empno'];
	$arr4 = $row['jf'];
	$arr3 = explode(';',$arr3);
	$arr4 = explode(';',$arr4);
}

$rr = false; 
$off = false; 
$admin = false;

if (!isset($_SESSION['user'])) {
	header("Location:../dashboard");
} else {
	$username = $_SESSION['user'];

	if (in_array($empno, $arr) || in_array($jf, $arr2)) {
		$off = true;	
	}
	if (in_array($empno, $arr3) || in_array($jf, $arr4) || $empno == "13315" || $empno == "11162") {
		$admin = true;
	}
}
?>
