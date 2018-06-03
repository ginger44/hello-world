<?php
if (! isset ( $_SESSION ))
	session_start ();
ob_start();
include ("includes.php");
include ("config.php"); 
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="js/jquery-ui-code/themes/base/jquery-ui.css">
<script src="js/jquery-ui-code/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-code/ui/jquery-ui.js"></script> 
<script src="js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="js/jquery-ui-code/resources/demos/style.css">
<script src="SpryAssets/SpryValidationTextField.js"	type="text/javascript"></script>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<style>
.ui-datepicker-title {
    background: #23C6E9 none; 
}

.ui-datepicker-header {
    background: #23C6E9 none;
}

.ui-datepicker-prev {
    background-image: url('images/prev.png') !important;
        background-position: 0px 0px !important;
}

.ui-datepicker-next {
    background-image: url('images/next.png') !important;
	background-position: 0px 0px !important;
}
#success {
	background-color: #55BEF2;
	font-size: 28px;
	text-align: center;
	margin-left: auto;
	margin-right: auto;
	color: white;
	height: 40px;
	width: 60%;
}

#failure {
	background-color: #F73416;
	font-size: 28px;
	text-align: center;
	margin-left: auto;
	margin-right: auto;
	color: white;
	height: 40px;
	width: 60%;
}

table {
    border: 1px solid black;
    border-collapse: collapse;
}
#the {
	border: 1px solid black;
    border-collapse: collapse;	
    padding: 5px;
    text-align: center;    
	background-color: #43F7F7	;
	font-size: 18px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<link rel="Stylesheet" href="skye.css" type="text/css" media ="screen">  
<link href="validate_form/validate.css" rel="stylesheet" type="text/css">
<link href="validate_form/main.css" type="text/css" media="all">
<link href="myaccount/nucss/css.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="scripts/mootools-core-1.4.5-full-compat.js"></script>
<script type="text/javascript" src="scripts/mootools-1.2.4.4-more.js"></script>
<script type="text/javascript" src="validate_form/date-en-GB.js"></script>
<script type="text/javascript" src="validate_form/validate.js"></script>
<script type="text/javascript" src="1-simple-calendar/tcal.js"></script>
<link rel="stylesheet" type="text/css" href="1-simple-calendar/tcal.css" />
</head>

<body>
<?php

$Mess = "";
$sa = "";
$sb = ""; 
$usr = @$_SESSION['user'];
$staff_no = $empno;
extract(mysql_fetch_array(mysql_query("select a.empname as staff_name, a.jf as job_func, a.branch_code as branch_code, b.dept_name as branch_dept, c.designation as grade
from employee_master a, department b, grades c
where a.dept_code = b.dept_code and a.grade_code = c.grade_code
and a.uname ='$usr'")));

if (isset($_POST['submit'])) {  	
	$reg_MTCN = mysql_real_escape_string($_POST['refno']);
	$trans_type = mysql_real_escape_string($_POST ['transType']);
	$amount = mysql_real_escape_string($_POST ['amount']);
	$branch_code = $branch_code;
	$trans_date = date('Y-m-d',strtotime(mysql_real_escape_string($_POST ['trans_date'])));
	$receiver_name = mysql_real_escape_string($_POST ['receiver_name']);
	$receiver_address = mysql_real_escape_string($_POST ['receiver_address']);
	$sender_name = mysql_real_escape_string($_POST ['sender_name']); 	
	$dob = date('Y-m-d',strtotime(mysql_real_escape_string($_POST ['dob'])));
	$idcard_type = mysql_real_escape_string($_POST ['idType']);
	$idcard_no = mysql_real_escape_string($_POST ['idtypeinput']);
	$country = mysql_real_escape_string($_POST ['country']);
	$reason = mysql_real_escape_string($_POST ['reason']);
	$indicator = mysql_real_escape_string($_POST ['indicator']);
	$submitted_by = $staff_no;  
	$submitted_date = date("Y-m-d H:i:s"); 		
				
	$new_ticket = "INSERT INTO moneytransfer_str_form (reg_MTCN, trans_type, amount, branch_code, trans_date, receiver_name, receiver_address, sender_name, dob, idcard_type, idcard_no, country, reason, indicator, submitted_by, submitted_date)";
	$myresult = insertRecord ( $new_ticket, "$reg_MTCN", "$trans_type", "$amount", "$branch_code", "$trans_date", "$receiver_name", "$receiver_address","$sender_name", "$dob", "$idcard_type", "$idcard_no", "$country", "$reason", "$indicator", "$submitted_by", "$submitted_date");
	
	if($myresult == true){
		//$form_id = mysql_insert_id();	
		header("Location:ini_req.php?resp=succ");		
	}else {
		header("Location:ini_req.php?resp=fai");
	}  
}
?>

<div style="margin-left: auto; margin-right: auto; width: 90%;">
	<form id="signinForm" name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
		<?php 
			echo $Mess; 
			
			if (isset ( $_GET ['resp'] )) {
				if ($_GET ['resp'] == 'fai') {
					echo "<div id='failure'>Failure: Required fields must be populated!</div><br>";
				}
				if ($_GET ['resp'] == 'fai2') {
					echo "<div id='failure'>Not saved!</div><br>";
				}
				if ($_GET ['resp'] == 'succ') {
					echo "<div id='success'>Saved successfully!</div><br>";
				}
			}		
			
		?>
		<h3>Fill Money Transfer STR Form</h3><hr/>
		<h6>-->All fields with asterisk(*) are compulsory.</h6>
		<table width="80%" border="0">
			<tr>
				<td width="20%">Branch Name:</td>
				<td width="80%">	
						<label><?php echo getBranchName("branch_codes", "branch_code", $branch_code, "branch_name"); ?></label>
				</td>
			</tr>
			<tr>
				<td width="20%">Transaction Date: *</td>
				<td width="80%">
				  <span id="sprytextfield1">
					<input type="text" name="trans_date" class="tcal" title="Select Date"/>
					<span class="textfieldRequiredMsg">A value is required.</span>
				  </span>
				</td>
			</tr>
			<tr>
				<td width="20%">Transaction Type:</td>
				<td width="80%">
					<span id="spryselect1">
						<select name="transType" id="transType"> 
							<option value="">SELECT TRANSACTION TYPE*****</option>
							<option value="MONEYGRAM">MONEYGRAM</option>
							<option value="WESTERNUNION">WESTERNUNION</option>
							<option value="RIA">RIA</option>
							<option value="SMALLWORLD">SMALL WORLD</option>
							<option value="TRANSFAST">TRANSFAST</option> 
						</select> 
						<span class="selectRequiredMsg">Please select the branch.</span>
					</span>
				</td>
			</tr>
			<tr>
				<td width="20%">Reference No/MTCN: *</td>
				<td width="80%">
					<span id="sprytextfield2">
						<input type="text" name="refno" id="refno" maxlength="25"/>
						<span class="textfieldRequiredMsg">A value is required.</span>
				   </span> 
				</td>
			</tr> 
			<tr>
				<td width="20%">Amount: *</td>
				<td width="80%">
					<span id='sprytextfield4'>
						<input type='text' name="amount" id="amount" maxlength="13" onkeypress="return isNumberKeyNoDecimal(event)"/>
						<span class="textfieldRequiredMsg">A value is required.</span>
					</span> 
				</td>
			</tr>  
			<tr>
				<td width="20%">Receiver's Name: *</td>
				<td width="80%">
					<span id='sprytextarea1'>
						<textarea id="receiver_name" name="receiver_name" rows="1" cols="60"></textarea>
						<span class="textareaRequiredMsg">A value is required.</span>
					</span>  
				</td> 
			</tr> 
			<tr>
				<td width="20%">Address: *</td>
				<td width="80%">
					<span id='sprytextarea2'>
						<textarea id="receiver_address" name="receiver_address" rows="5" cols="60"></textarea>
					<span class="textareaRequiredMsg">A value is required.</span>
					</span> 
				</td> 
			</tr>
			<tr>
				<td width="20%">Sender's Name: *</td>
				<td width="80%">
					<span id='sprytextarea3'>
						<textarea id="sender_name" name="sender_name" rows="1" cols="60"></textarea> 
						<span class="textareaRequiredMsg">A value is required.</span>
					</span> 
				</td> 
			</tr>	
			<tr>
				<td width="20%">Date Of Birth: *</td>
				<td width="80%">
					<span id="sprytextfield5">
						<input type="text" name="dob" class="tcal" title="Select Date"/>
						<span class="textfieldRequiredMsg">A value is required.</span>
					</span>
				</td> 
			</tr>
			<tr>
				<td width="20%">ID Number: *</td>
				<td width="80%">
					<span id="spryselect2">
						<select name="idType" id="idType">
							<option value="">---Select ID Card type</option>
							<option value="national">National ID Card</option>
							<option value="driver">Driver's License</option>
							<option value="international">International Passport</option>
							<option value="voters">Voter's Card</option>
							<option value="bvn">BVN</option>
					</select><span class="selectRequiredMsg">Please select the ID Card type.</span></span> &nbsp;&nbsp;&nbsp;<span id="sprytextfield6"><input type="text" name="idtypeinput" id="idtypeinput" maxlength="15"/><span class="textfieldRequiredMsg">A value is required.</span></span>
				</td> 
			</tr>	
			<tr>
				<td width="20%">Country: *</td>
				<td width="80%">
					<span id="spryselect3">
						<select name="country">
							<option value="-1" selected>---Please Select Country</option>
							<option value="United States"> United States </option>
							<option value="Abkhazia"> Abkhazia </option>
							<option value="Afghanistan"> Afghanistan </option>
							<option value="Albania"> Albania </option>
							<option value="Algeria"> Algeria </option>
							<option value="American Samoa"> American Samoa </option>
							<option value="Andorra"> Andorra </option>
							<option value="Angola"> Angola </option>
							<option value="Anguilla"> Anguilla </option>
							<option value="Antigua and Barbuda"> Antigua and Barbuda </option>
							<option value="Argentina"> Argentina </option>
							<option value="Armenia"> Armenia </option>
							<option value="Aruba"> Aruba </option>
							<option value="Australia"> Australia </option>
							<option value="Austria"> Austria </option>
							<option value="Azerbaijan"> Azerbaijan </option>
							<option value="The Bahamas"> The Bahamas </option>
							<option value="Bahrain"> Bahrain </option>
							<option value="Bangladesh"> Bangladesh </option>
							<option value="Barbados"> Barbados </option>
							<option value="Belarus"> Belarus </option>
							<option value="Belgium"> Belgium </option>
							<option value="Belize"> Belize </option>
							<option value="Benin"> Benin </option>
							<option value="Bermuda"> Bermuda </option>
							<option value="Bhutan"> Bhutan </option>
							<option value="Bolivia"> Bolivia </option>
							<option value="Bosnia and Herzegovina"> Bosnia and Herzegovina </option>
							<option value="Botswana"> Botswana </option>
							<option value="Brazil"> Brazil </option>
							<option value="Brunei"> Brunei </option>
							<option value="Bulgaria"> Bulgaria </option>
							<option value="Burkina Faso"> Burkina Faso </option>
							<option value="Burundi"> Burundi </option>
							<option value="Cambodia"> Cambodia </option>
							<option value="Cameroon"> Cameroon </option>
							<option value="Canada"> Canada </option>
							<option value="Cape Verde"> Cape Verde </option>
							<option value="Cayman Islands"> Cayman Islands </option>
							<option value="Central African Republic"> Central African Republic </option>
							<option value="Chad"> Chad </option>
							<option value="Chile"> Chile </option>
							<option value="People's Republic of China"> People's Republic of China </option>
							<option value="Republic of China"> Republic of China </option>
							<option value="Christmas Island"> Christmas Island </option>
							<option value="Cocos (Keeling) Islands"> Cocos (Keeling) Islands </option>
							<option value="Colombia"> Colombia </option>
							<option value="Comoros"> Comoros </option>
							<option value="Congo"> Congo </option>
							<option value="Cook Islands"> Cook Islands </option>
							<option value="Costa Rica"> Costa Rica </option>
							<option value="Cote d'Ivoire"> Cote d'Ivoire </option>
							<option value="Croatia"> Croatia </option>
							<option value="Cuba"> Cuba </option>
							<option value="Cyprus"> Cyprus </option>
							<option value="Czech Republic"> Czech Republic </option>
							<option value="Denmark"> Denmark </option>
							<option value="Djibouti"> Djibouti </option>
							<option value="Dominica"> Dominica </option>
							<option value="Dominican Republic"> Dominican Republic </option>
							<option value="Ecuador"> Ecuador </option>
							<option value="Egypt"> Egypt </option>
							<option value="El Salvador"> El Salvador </option>
							<option value="Equatorial Guinea"> Equatorial Guinea </option>
							<option value="Eritrea"> Eritrea </option>
							<option value="Estonia"> Estonia </option>
							<option value="Ethiopia"> Ethiopia </option>
							<option value="Falkland Islands"> Falkland Islands </option>
							<option value="Faroe Islands"> Faroe Islands </option>
							<option value="Fiji"> Fiji </option>
							<option value="Finland"> Finland </option>
							<option value="France"> France </option>
							<option value="French Polynesia"> French Polynesia </option>
							<option value="Gabon"> Gabon </option>
							<option value="The Gambia"> The Gambia </option>
							<option value="Georgia"> Georgia </option>
							<option value="Germany"> Germany </option>
							<option value="Ghana"> Ghana </option>
							<option value="Gibraltar"> Gibraltar </option>
							<option value="Greece"> Greece </option>
							<option value="Greenland"> Greenland </option>
							<option value="Grenada"> Grenada </option>
							<option value="Guam"> Guam </option>
							<option value="Guatemala"> Guatemala </option>
							<option value="Guernsey"> Guernsey </option>
							<option value="Guinea"> Guinea </option>
							<option value="Guinea-Bissau"> Guinea-Bissau </option>
							<option value="Guyana Guyana"> Guyana Guyana </option>
							<option value="Haiti Haiti"> Haiti Haiti </option>
							<option value="Honduras"> Honduras </option>
							<option value="Hong Kong"> Hong Kong </option>
							<option value="Hungary"> Hungary </option>
							<option value="Iceland"> Iceland </option>
							<option value="India"> India </option>
							<option value="Indonesia"> Indonesia </option>
							<option value="Iran"> Iran </option>
							<option value="Iraq"> Iraq </option>
							<option value="Ireland"> Ireland </option>
							<option value="Israel"> Israel </option>
							<option value="Italy"> Italy </option>
							<option value="Jamaica"> Jamaica </option>
							<option value="Japan"> Japan </option>
							<option value="Jersey"> Jersey </option>
							<option value="Jordan"> Jordan </option>
							<option value="Kazakhstan"> Kazakhstan </option>
							<option value="Kenya"> Kenya </option>
							<option value="Kiribati"> Kiribati </option>
							<option value="North Korea"> North Korea </option>
							<option value="South Korea"> South Korea </option>
							<option value="Kosovo"> Kosovo </option>
							<option value="Kuwait"> Kuwait </option>
							<option value="Kyrgyzstan"> Kyrgyzstan </option>
							<option value="Laos"> Laos </option>
							<option value="Latvia"> Latvia </option>
							<option value="Lebanon"> Lebanon </option>
							<option value="Lesotho"> Lesotho </option>
							<option value="Liberia"> Liberia </option>
							<option value="Libya"> Libya </option>
							<option value="Liechtenstein"> Liechtenstein </option>
							<option value="Lithuania"> Lithuania </option>
							<option value="Luxembourg"> Luxembourg </option>
							<option value="Macau"> Macau </option>
							<option value="Macedonia"> Macedonia </option>
							<option value="Madagascar"> Madagascar </option>
							<option value="Malawi"> Malawi </option>
							<option value="Malaysia"> Malaysia </option>
							<option value="Maldives"> Maldives </option>
							<option value="Mali"> Mali </option>
							<option value="Malta"> Malta </option>
							<option value="Marshall Islands"> Marshall Islands </option>
							<option value="Mauritania"> Mauritania </option>
							<option value="Mauritius"> Mauritius </option>
							<option value="Mayotte"> Mayotte </option>
							<option value="Mexico"> Mexico </option>
							<option value="Micronesia"> Micronesia </option>
							<option value="Moldova"> Moldova </option>
							<option value="Monaco"> Monaco </option>
							<option value="Mongolia"> Mongolia </option>
							<option value="Montenegro"> Montenegro </option>
							<option value="Montserrat"> Montserrat </option>
							<option value="Morocco"> Morocco </option>
							<option value="Mozambique"> Mozambique </option>
							<option value="Myanmar"> Myanmar </option>
							<option value="Nagorno-Karabakh"> Nagorno-Karabakh </option>
							<option value="Namibia"> Namibia </option>
							<option value="Nauru"> Nauru </option>
							<option value="Nepal"> Nepal </option>
							<option value="Netherlands"> Netherlands </option>
							<option value="Netherlands Antilles"> Netherlands Antilles </option>
							<option value="New Caledonia"> New Caledonia </option>
							<option value="New Zealand"> New Zealand </option>
							<option value="Nicaragua"> Nicaragua </option>
							<option value="Niger"> Niger </option>
							<option value="Nigeria"> Nigeria </option>
							<option value="Niue"> Niue </option>
							<option value="Norfolk Island"> Norfolk Island </option>
							<!--<option value="Turkish Republic of Northern Cyprus"> Turkish Republic of Northern Cyprus </option>-->
							<option value="Northern Mariana"> Northern Mariana </option>
							<option value="Norway"> Norway </option>
							<option value="Oman"> Oman </option>
							<option value="Pakistan"> Pakistan </option>
							<option value="Palau"> Palau </option>
							<option value="Palestine"> Palestine </option>
							<option value="Panama"> Panama </option>
							<option value="Papua New Guinea"> Papua New Guinea </option>
							<option value="Paraguay"> Paraguay </option>
							<option value="Peru"> Peru </option>
							<option value="Philippines"> Philippines </option>
							<option value="Pitcairn Islands"> Pitcairn Islands </option>
							<option value="Poland"> Poland </option>
							<option value="Portugal"> Portugal </option>
							<option value="Transnistria Pridnestrovie"> Transnistria Pridnestrovie </option>
							<option value="Puerto Rico"> Puerto Rico </option>
							<option value="Qatar"> Qatar </option>
							<option value="Romania"> Romania </option>
							<option value="Russia"> Russia </option>
							<option value="Rwanda"> Rwanda </option>
							<option value="Saint Barthelemy"> Saint Barthelemy </option>
							<option value="Saint Helena"> Saint Helena </option>
							<option value="Saint Kitts and Nevis"> Saint Kitts and Nevis </option>
							<option value="Saint Lucia"> Saint Lucia </option>
							<option value="Saint Martin"> Saint Martin </option>
							<!-- <option value="Saint Pierre and Miquelon"> Saint Pierre and Miquelon </option>-->
							<!-- <option value="Saint Vincent and the Grenadines"> Saint Vincent and the Grenadines </option>-->
							<option value="Samoa"> Samoa </option>
							<option value="San Marino"> San Marino </option>
							<option value="Sao Tome and Principe"> Sao Tome and Principe </option>
							<option value="Saudi Arabia"> Saudi Arabia </option>
							<option value="Senegal"> Senegal </option>
							<option value="Serbia"> Serbia </option>
							<option value="Seychelles"> Seychelles </option>
							<option value="Sierra Leone"> Sierra Leone </option>
							<option value="Singapore"> Singapore </option>
							<option value="Slovakia"> Slovakia </option>
							<option value="Slovenia"> Slovenia </option>
							<option value="Solomon Islands"> Solomon Islands </option>
							<option value="Somalia"> Somalia </option>
							<option value="Somaliland"> Somaliland </option>
							<option value="South Africa"> South Africa </option>
							<option value="South Ossetia"> South Ossetia </option>
							<option value="Spain"> Spain </option>
							<option value="Sri Lanka"> Sri Lanka </option>
							<option value="Sudan"> Sudan </option>
							<option value="Suriname"> Suriname </option>
							<option value="Svalbard"> Svalbard </option>
							<option value="Swaziland"> Swaziland </option>
							<option value="Sweden"> Sweden </option>
							<option value="Switzerland"> Switzerland </option>
							<option value="Syria"> Syria </option>
							<option value="Taiwan"> Taiwan </option>
							<option value="Tajikistan"> Tajikistan </option>
							<option value="Tanzania"> Tanzania </option>
							<option value="Thailand"> Thailand </option>
							<option value="Timor-Leste"> Timor-Leste </option>
							<option value="Togo"> Togo </option>
							<option value="Tokelau"> Tokelau </option>
							<option value="Tonga"> Tonga </option>
							<option value="Trinidad and Tobago"> Trinidad and Tobago </option>
							<option value="Tristan da Cunha"> Tristan da Cunha </option>
							<option value="Tunisia"> Tunisia </option>
							<option value="Turkey"> Turkey </option>
							<option value="Turkmenistan"> Turkmenistan </option>
							<option value="Turks and Caicos Islands"> Turks and Caicos Islands </option>
							<option value="Tuvalu"> Tuvalu </option>
							<option value="Uganda"> Uganda </option>
							<option value="Ukraine"> Ukraine </option>
							<option value="United Arab Emirates"> United Arab Emirates </option>
							<option value="United Kingdom"> United Kingdom </option>
							<option value="Uruguay"> Uruguay </option>
							<option value="Uzbekistan"> Uzbekistan </option>
							<option value="Vanuatu"> Vanuatu </option>
							<option value="Vatican City"> Vatican City </option>
							<option value="Venezuela"> Venezuela </option>
							<option value="Vietnam"> Vietnam </option>
							<option value="British Virgin Islands"> British Virgin Islands </option>
							<option value="US Virgin Islands"> US Virgin Islands </option>
							<option value="Wallis and Futuna"> Wallis and Futuna </option>
							<option value="Western Sahara"> Western Sahara </option>
							<option value="Yemen"> Yemen </option>
							<option value="Zambia"> Zambia </option>
							<option value="Zimbabwe"> Zimbabwe </option>
							<option value="other"> Other </option>
						</select>
						<span class="selectRequiredMsg">Please select the country.</span>
					</span>
				</td>
			</tr>	
			<tr>
				<td width="20%">Reason: *</td>
				<td width="80%">
					<span id='sprytextarea4'>
						<textarea rows="5" name="reason" id="reason" cols="60"></textarea>
						<span class="textareaRequiredMsg">A value is required.</span>
					</span> 
				</td> 
			</tr >
			<tr>
				<td width="20%">Indicator: *</td>
				<td width="80%">
					<span id='sprytextarea5'>
						<textarea rows="1" name="indicator" id="indicator" cols="60"></textarea>
						<span class="textareaRequiredMsg">A value is required.</span>
					</span> 
				</td> 
			</tr >
			<tr>
				<td colspan="2">
					<input type="submit" name="submit" id="submit" value="Submit" class="b" />
				</td>
			</tr>			
		</table>		
	</form>
</div>
<br/>


<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1"); 
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2"); 
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3"); 
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1"); 
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");  
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4"); 
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5"); 
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6"); 
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2");
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3");
var sprytextarea4 = new Spry.Widget.ValidationTextarea("sprytextarea4");
var sprytextarea5 = new Spry.Widget.ValidationTextarea("sprytextarea5");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1");

var table = $('#example').DataTable( {} ); 

	//Does not allow input of decimal
	function isNumberKeyNoDecimal(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	} 
	
	/*
	$('#transType').change(function() { 
		$('#moneyGramInput').css('display', ($('#transType').val() == 'moneygram') ? 'block' : 'none'); 
		$('#westernUnionInput').css('display', ($('#transType').val() == 'westernunion') ? 'block' : 'none');  
		$('#nothing').css('display', ($('#transType').val() == '') ? 'block' : 'none');  
	}); */
	
	$('#submit').on('click', function () {
       return confirm('Go ahead to submit this form?');
	});
</script> 
</body>
</html>
