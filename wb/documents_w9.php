<?php

use Dompdf\Dompdf;

require_once '../vendor/autoload.php';
require_once 'includes/session.php';

if (!isGranted('page_documents_page_w9', 'page_w9')) :
	$_SESSION['error'] = 'Not Exist!';
	header('location: index.php');
	exit();
else :
	ob_start();

	global $conn;
	global $admin;

	if (isset($_GET["id"])) {
		$user_id = $_GET["id"];
	} else {
		$user_id = $admin["userId"];
	}

	$stmt = $conn->prepare("SELECT * FROM users  WHERE userId = :x");
	$stmt->execute(['x' => $user_id]);
	$admin = $stmt->fetch();

	$stmt = $conn->prepare("SELECT * FROM admin_addresses  WHERE user_id = :x");
	$stmt->execute(['x' => $user_id]);
	$address_info = $stmt->fetch();

	$stmt = $conn->prepare("SELECT * FROM document_w9  WHERE user_id = :x");
	$stmt->execute(['x' => $user_id]);
	$wData = $stmt->fetch();


	if (isset($wData['emp_id_num'])) {
		$eployee_id = json_decode($wData['emp_id_num']);
	}

	$stmt = $conn->prepare("SELECT * FROM user_documents  WHERE user_id = :x AND file_types = :file_types");
	$stmt->execute(['x' => $user_id, 'file_types' => 'ss_card']);
	$userDoc = $stmt->fetch();

	if (isset($userDoc["ss_number"])) {
		$ss_number = str_split($userDoc["ss_number"]);
	}

	$html = null;

	$html .= '<style>
        input{
			border:0
        }
        input[type="radio"] {
			cursor: pointer;
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			outline: 0;
			background: #fff;
			height: 9px;
			width: 9px;
			border: 1px solid #000;
        }

        input[type="radio"]:checked {
			background: #000;
        }

        input[type=radio]:focus {
			outline: 0;
			outline-offset: 0;
        }

        input[type="radio"]:after {
			content: "";
			position: relative;
			left: 40%;
			top: 20%;
			width: 15%;
			height: 40%;
			border-width: 0 2px 2px 0;
			transform: rotate(45deg);
			display: none;
        }

        input[type="radio"]:checked:after {
			display: block;
        }

        input[type="radio"]:disabled:after {
			border-color: #7b7b7b;
        }

        #sig-canvas {
			border: 2px dotted #CCCCCC;
			border-radius: 15px;
			cursor: crosshair;
			width: 100%;
        }

        input {
			height: 12px;

        }

        span.cls_005 {
			font-family: Arial, serif;
			font-size: 14.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_005 {
			font-family: Arial, serif;
			font-size: 14.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_006 {
			font-family: Arial, serif;
			font-size: 9.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_006 {
			font-family: Arial, serif;
			font-size: 9.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_002 {
			font-family: Arial, serif;
			font-size: 7.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_002 {
			font-family: Arial, serif;
			font-size: 7.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_003 {
			font-family: Arial, serif;
			font-size: 24.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_003 {
			font-family: Arial, serif;
			font-size: 24.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_004 {
			font-family: Arial, serif;
			font-size: 6.8px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_004 {
			font-family: Arial, serif;
			font-size: 6.8px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_007 {
			font-family: Arial, serif;
			font-size: 6.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_007 {
			font-family: Arial, serif;
			font-size: 6.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_008 {
			font-family: Arial, serif;
			font-size: 8.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_008 {
			font-family: Arial, serif;
			font-size: 8.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_009 {
			font-family: Arial, serif;
			font-size: 8.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: italic;
			text-decoration: none
        }

        div.cls_009 {
			font-family: Arial, serif;
			font-size: 8.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: italic;
			text-decoration: none
        }

        span.cls_011 {
			font-family: Arial, serif;
			font-size: 6.9px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_011 {
			font-family: Arial, serif;
			font-size: 6.9px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_010 {
			font-family: Arial, serif;
			font-size: 7.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_010 {
			font-family: Arial, serif;
			font-size: 5.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_012 {
			font-family: Arial, serif;
			font-size: 5.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: italic;
			text-decoration: none
        }

        div.cls_012 {
			font-family: Arial, serif;
			font-size: 5.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: italic;
			text-decoration: none
        }

        span.cls_013 {
			font-family: Arial, serif;
			font-size: 10.1px;
			color: rgb(255, 255, 255);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_013 {
			font-family: Arial, serif;
			font-size: 10.1px;
			color: rgb(255, 255, 255);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_014 {
			font-family: Arial, serif;
			font-size: 10.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_014 {
			font-family: Arial, serif;
			font-size: 10.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_016 {
			font-family: Arial, serif;
			font-size: 7.8px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_016 {
			font-family: Arial, serif;
			font-size: 7.8px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_017 {
			font-family: Arial, serif;
			font-size: 12.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_017 {
			font-family: Arial, serif;
			font-size: 12.1px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_018 {
			font-family: Arial, serif;
			font-size: 8.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_018 {
			font-family: Arial, serif;
			font-size: 8.0px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_019 {
			font-family: Arial, serif;
			font-size: 7.7px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: italic;
			text-decoration: none
        }

        div.cls_019 {
			font-family: Arial, serif;
			font-size: 7.7px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: italic;
			text-decoration: none
        }

        span.cls_020 {
			font-family: Arial, serif;
			font-size: 7.7px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_020 {
			font-family: Arial, serif;
			font-size: 7.7px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_022 {
			font-family: Arial, serif;
			font-size: 6.9px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_022 {
			font-family: Arial, serif;
			font-size: 6.9px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_021 {
			font-family: Arial, serif;
			font-size: 11.7px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_021 {
			font-family: Arial, serif;
			font-size: 11.7px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        span.cls_023 {
			font-family: Arial, serif;
			font-size: 11.9px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }

        div.cls_023 {
			font-family: Arial, serif;
			font-size: 11.9px;
			color: rgb(0, 0, 0);
			font-weight: normal;
			font-style: normal;
			text-decoration: none
        }
    </style>';

	$name =  $admin["userFirstName"] . ' ' . $admin["userLastName"];
	$business_name =  isset($wData["business_name"]) ? $wData["business_name"] : '';
	$tax_type = isset($wData["tax_type"]) ?? $wData["tax_type"];
	$payee_code =  (isset($wData["payee_code"])) ? $wData["payee_code"] : '';
	$tax_lmd = (isset($wData["tax_lmd"])) ? $wData["tax_lmd"] : "";
	$report_code = (isset($wData["report_code"])) ? $wData["report_code"] : '';
	$addr = ($address_info["address_line_1"] . ', ' . $address_info["address_line_2"]);
	$option_name = (isset($wData["option_name"])) ? $wData["option_name"] : '';
	$_all_addr = ($address_info["city"] . ', ' . $address_info["state"] . ', ' . $address_info["zip_code"]);
	$account_number = (isset($wData["account_number"])) ? $wData["account_number"] : '';
	$tax_others = (isset($wData["tax_others"])) ? $wData["tax_others"] : '';
	($tax_type == 1) ? 'checked' : '';
	$tax_type1 = ($tax_type == 1) ? 'checked' : '';
	$tax_type2 = ($tax_type == 2) ? 'checked' : '';
	$tax_type3 = ($tax_type == 3) ? 'checked' : '';
	$tax_type4 = ($tax_type == 4) ? 'checked' : '';
	$tax_type5 = ($tax_type == 5) ? 'checked' : '';
	$tax_type6 = ($tax_type == 6) ? 'checked' : '';
	$tax_type7 = ($tax_type == 7) ? 'checked' : '';

	$html .= '
<div style="position:relative;left:50%;margin-left:-305px;top:0px;width: 100%;height:791px;/* border-style:outset; *//* overflow:hidden; */">

<div style="position:absolute;left:0px;top:0px"><img src="dist/assets/background1.jpg" width="611" height="791"></div>
<div style="position:absolute;left:239.22px;top:32.64px" class="cls_005"><span class="cls_005"><strong>Request for Taxpayer </strong></span></div>
<div style="position:absolute;left:495.60px;top:41.23px" class="cls_006"><span class="cls_006"><strong>Give Form to the</strong></span></div>
<div style="position:absolute;left:36.00px;top:29.17px" class="cls_002"><span class="cls_002">Form </span><span class="cls_003"><strong>W-9</strong></span></div>
<div style="position:absolute;left:36.00px;top:56.53px" class="cls_002"><span class="cls_002">(Rev. October 2018)</span></div>
<div style="position:absolute;left:184.06px;top:47.63px" class="cls_005"><span class="cls_005"><strong>Identification Number and Certification</strong></span></div>
<div style="position:absolute;left:495.60px;top:52.03px" class="cls_006"><span class="cls_006"><strong>requester. Do not</strong></span></div>
<div style="position:absolute;left:36.00px;top:65.31px" class="cls_004"><span class="cls_004">Department of the Treasury</span></div>
<div style="position:absolute;left:495.60px;top:62.83px" class="cls_006"><span class="cls_006"><strong>send to the IRS.</strong></span></div>
<div style="position:absolute;left:36.00px;top:72.31px" class="cls_004"><span class="cls_004">Internal Revenue Service</span></div>
<div style="position:absolute;left:167.89px;top:70.91px" class="cls_007"><span class="cls_007"><strong>▶</strong></span><span class="cls_008"><strong> Go to </strong></span><a href="http://www.irs.gov/formw9/"><strong>www.irs.gov/FormW9</strong></a> <span class="cls_008"><strong>for instructions and the latest information.</strong></span></div>
<div style="position:absolute;left:61.60px;top:83.03px" class="cls_002"><span class="cls_002"><strong>1</strong> Name (as shown on your income tax return). Name is required on this line; do not leave this line blank. <br><input style="width:510px" type="text" disabled value="' . $name . '"></span></div>
<div style="position:absolute;left:61.60px;top:107.03px" class="cls_002"><span class="cls_002"><strong>2</strong> Business name/disregarded entity name, if different from above<br><input type="text" value="' . $business_name . '" style="width:510px" name="business_name"></span></div>
<div style="position:absolute;left:61.60px;top:133.03px" class="cls_002"><span class="cls_002"><strong>3</strong> Check appropriate box for federal tax classification of the person whose name is entered on line 1. Check only <strong>one</strong> of the</span></div>
<div style="position:absolute;left:458.30px;top:132.75px" class="cls_002"><span class="cls_002"><strong>4</strong> Exemptions (codes apply only to</span></div>
<div style="position:absolute;left:69.60px;top:141.03px" class="cls_002"><span class="cls_002">following seven boxes.</span></div>
<div style="position:absolute;left:458.30px;top:140.75px" class="cls_002"><span class="cls_002">certain entities, not individuals; see</span></div>
<div style="position:absolute;left:458.30px;top:148.75px" class="cls_002"><span class="cls_002">instructions on page 3):</span></div>
<div style="position:absolute;left:79.20px;top:159.03px" class="cls_002"><span class="cls_002"><input style="position: absolute; left:-14px; top:-5px" type="radio" name="tax_type" ' .  $tax_type1 . ' value="1">Individual/sole proprietor or</span></div>
<div style="position:absolute;left:193.29px;top:158.03px" class="cls_002"><span class="cls_002"><input style="position: absolute; left:-14px; top:-5px" type="radio" name="tax_type" ' .  $tax_type2 . ' value="2">C Corporation</span></div>
<div style="position:absolute;left:264.00px;top:158.03px" class="cls_002"><span class="cls_002"><input style="position: absolute; left:-13px; top:-5px" type="radio" name="tax_type" ' .  $tax_type3 . ' value="3">S Corporation</span></div>
<div style="position:absolute;left:337.20px;top:158.03px" class="cls_002"><span class="cls_002"><input style="position: absolute; left:-14px; top:-5px" type="radio" name="tax_type" ' .  $tax_type4 . ' value="4">Partnership</span></div>
<div style="position:absolute;left:408.00px;top:158.03px" class="cls_002"><span class="cls_002"><input style="position: absolute; left:-14px; top:-5px" type="radio" name="tax_type" ' .  $tax_type5 . ' value="5">Trust/estate</span></div>
<div style="position:absolute;left:79.20px;top:167.03px" class="cls_002"><span class="cls_002">single-member LLC</span></div>
<div style="position:absolute;left:457.89px;top:169.13px" class="cls_011"><span class="cls_011">Exempt payee code (if any)<input name="payee_code" value="' . ltrim($payee_code) . '" style="border: none;border-bottom:1px solid;width:33px;outline:none" type="text"></span></div>
<div style="position:absolute;left:79.20px;top:182.32px" class="cls_002"><span class="cls_002"><input style="position: absolute; left:-14px; top:-4px" type="radio" name="tax_type" ' .  $tax_type6 . ' value="6">Limited liability company. Enter the tax classification (C=C corporation, S=S corporation, P=Partnership) </span>
        <span class="cls_010">▶<input value="' . ltrim($tax_lmd) . '" name="tax_lmd" style="border: none;border-bottom:1px solid;width:40px;outline:none" type="text"></span>
</div>
<div style="position:absolute;left:79.20px;top:193.03px" class="cls_002"><span class="cls_002"><strong>Note:</strong> Check the appropriate box in the line above for the tax classification of the single-member owner. Do not check</span></div>
<div style="position:absolute;left:457.89px;top:194.03px" class="cls_002"><span class="cls_002">Exemption from FATCA reporting</span></div>
<div style="position:absolute;left:79.20px;top:201.03px" class="cls_002"><span class="cls_002">LLC if the LLC is classified as a single-member LLC that is disregarded from the owner unless the owner of the LLC is</span></div>
<div style="position:absolute;left:458.83px;top:205.03px" class="cls_002"><span class="cls_002">code (if any)<input name="report_code" value=" ' . ltrim($report_code) . '" style="border: none;border-bottom:1px solid;width:78px;outline:none" type="text"></span></div>
<div style="position:absolute;left:79.20px;top:209.03px" class="cls_002"><span class="cls_002">another LLC that is <strong>not</strong> disregarded from the owner for U.S. federal tax purposes. Otherwise, a single-member LLC that</span></div>
<div style="position:absolute;left:79.20px;top:217.03px" class="cls_002"><span class="cls_002">is disregarded from the owner should check the appropriate box for the tax classification of its owner.</span></div>
<div style="position:absolute;left:79.20px;top:229.03px" class="cls_002"><span class="cls_002"><input style="position: absolute; left:-14px; top:-4px" type="radio" name="tax_type" ' .  $tax_type7 . ' value="7">Other (see instructions) </span>
<span class="cls_010">▶
<input value=" ' . ltrim($tax_others) . '" name="tax_others"
 style="border: none;border-bottom:1px solid;width:291px;outline:none;position:absolute;top:-2px" type="text">
 </span></div>
<div style="position:absolute;left:457.89px;top:229.14px" class="cls_012"><span class="cls_012">(Applies to accounts maintained outside the U.S.)</span></div>
<div style="position:absolute;left:61.60px;top:239.03px" class="cls_002"><span class="cls_002"><strong>5</strong> Address (number, street, and apt. or suite no.) See instructions. <br>
                <input type="text" style="width:315px;" disabled value="' . $addr . '"></span></div>
<div style="position:absolute;left:392.80px;top:239.03px" class="cls_002"><span class="cls_002">Requester’s name and address (optional) <br>

                <textarea maxlength="135" rows="3" style="width:183px;resize:none" name="option_name"  type="text">' . $option_name . '</textarea>
        </span>
</div>
<div style="position:absolute;left:61.60px;top:263.03px" class="cls_002"><span class="cls_002"><strong>6</strong> City, state, and ZIP code <br>
                <input type="text" style="width:315px;" disabled value="' . $_all_addr . '"></span></div>
<div style="position:absolute;left:60.60px;top:287.03px" class="cls_002">
<span class="cls_002"><strong>7</strong> List account number(s) here (optional) <br>
<input value="' . ltrim($account_number) . '" name="account_number" type="text" style="width:515px;"/>
</span>
</div>
<div style="position:absolute;left:41.22px;top:310.17px" class="cls_013"><span class="cls_013"><strong>Part I</strong></span></div>
<div style="position:absolute;left:91.00px;top:310.17px" class="cls_014"><span class="cls_014"><strong>Taxpayer Identification Number (TIN)</strong></span></div>
<div style="position:absolute;left:36.00px;top:323.75px" class="cls_008"><span class="cls_008">Enter your TIN in the appropriate box. The TIN provided must match the name given on line 1 to avoid </span></div>
<div style="position:absolute;left:421.60px;top:323.03px" class="cls_002"><span class="cls_002"><strong>Social security number</strong></span></div>
<div style="position:absolute;left:36.00px;top:332.75px" class="cls_008"><span class="cls_008">backup withholding. For individuals, this is generally your social security number (SSN). However, for a</span></div>
<div style="position:absolute;left:36.00px;top:341.75px" class="cls_008"><span class="cls_008">resident alien, sole proprietor, or disregarded entity, see the instructions for Part I, later. For other</span></div>
<div style="position:absolute;left:468.37px;top:341.75px" class="cls_008"><span class="cls_008"><strong>-</strong></span></div>
<div style="position:absolute;left:511.57px;top:341.75px" class="cls_008"><span class="cls_008"><strong>-</strong></span></div>
<div style="position:absolute;left:36.00px;top:350.75px" class="cls_008"><span class="cls_008">entities, it is your employer identification number (EIN). If you do not have a number, see </span><span class="cls_009">How to get a</span></div>
<div style="position:absolute;left:36.00px;top:359.75px" class="cls_009"><span class="cls_009">TIN, </span><span class="cls_008">later.</span></div>
<div style="position:absolute;left:416.00px;top:334px" class="float-right">
        <input style="width: 16px;height:26px" type="text" value="' . (isset($ss_number[0]) ? $ss_number[0] : '') . '" disabled>
</div>
<div style="position:absolute;left:431.00px;top:334px" class="float-right">
        <input style="width: 16px;height:26px" type="text" value="' . (isset($ss_number[1]) ? $ss_number[1] : '') . '" disabled>
</div>
<div style="position:absolute;left:445.00px;top:334px" class="float-right">
        <input style="width: 16px;height:26px" type="text" value="' . (isset($ss_number[2]) ? $ss_number[2] : '') . '" disabled>
</div>
<div style="position:absolute;left:474.00px;top:334px" class="float-right">
        <input style="width: 16px;height:26px" type="text" value="' . (isset($ss_number[3]) ? $ss_number[3] : '') . '" disabled>
</div>
<div style="position:absolute;left:488.00px;top:334px" class="float-right">
        <input style="width: 17px;height:26px" type="text" value="' . (isset($ss_number[4]) ? $ss_number[4] : '') . '" disabled>
</div>
<div style="position:absolute;left:516.00px;top:334px" class="float-right">
        <input style="width: 16px;height:26px" type="text" value="' . (isset($ss_number[5]) ? $ss_number[5] : '') . '" disabled>
</div>
<div style="position:absolute;left:531.00px;top:334px" class="float-right">
        <input style="width: 16px;height:26px" type="text" value="' . (isset($ss_number[6]) ? $ss_number[6] : '') . '" disabled>
</div>
<div style="position:absolute;left:546.00px;top:334px" class="float-right">
        <input style="width: 16px;height:26px" type="text" value="' . (isset($ss_number[7]) ? $ss_number[7] : '') . '" disabled>
</div>
<div style="position:absolute;left:561.00px;top:334px" class="float-right">
        <input style="width: 16px;height:26px" type="text" value="' . (isset($ss_number[8]) ? $ss_number[8] : '') . '" disabled>
</div>
<div style="position:absolute;left:417.60px;top:359.46px" class="cls_006"><span class="cls_006"><strong>or</strong></span></div>
<div style="position:absolute;left:36.00px;top:371.75px" class="cls_008"><span class="cls_008"><strong>Note:</strong> If the account is in more than one name, see the instructions for line 1. Also see </span><span class="cls_009">What Name and</span></div>
<div style="position:absolute;left:421.60px;top:371.03px" class="cls_002"><span class="cls_002"><strong>Employer identification number</strong></span></div>
<div style="position:absolute;left:416.00px;top:381px" class="float-right">
        <input name="emp_id_num[]" value="' . (isset($eployee_id[8]) ? $eployee_id[0] : '') . '" style="width: 16px;height:26px" type="text">
</div>
<div style="position:absolute;left:431.00px;top:381px" class="float-right">
        <input name="emp_id_num[]" value="' . (isset($eployee_id[8]) ? $eployee_id[1] : '') . '" style="width: 17px;height:26px" type="text">
</div>
<div style="position:absolute;left:459.00px;top:381px" class="float-right">
        <input name="emp_id_num[]" value="' . (isset($eployee_id[8]) ? $eployee_id[2] : '') . '" style="width: 16px;height:26px" type="text">
</div>

<div style="position:absolute;left:472.00px;top:381px" class="float-right">
        <input name="emp_id_num[]" value="' . (isset($eployee_id[8]) ? $eployee_id[3] : '') . '" style="width: 16px;height:26px" type="text">
</div>
<div style="position:absolute;left:487.00px;top:381px" class="float-right">
        <input name="emp_id_num[]" value="' . (isset($eployee_id[8]) ? $eployee_id[4] : '') . '" style="width: 17px;height:26px" type="text">
</div>
<div style="position:absolute;left:503.00px;top:381px" class="float-right">
        <input name="emp_id_num[]" value="' . (isset($eployee_id[8]) ? $eployee_id[5] : '') . '" style="width: 16px;height:26px" type="text">
</div>
<div style="position:absolute;left:518.00px;top:381px" class="float-right">
        <input name="emp_id_num[]" value="' . (isset($eployee_id[8]) ? $eployee_id[6] : '') . '" style="width: 16px;height:26px" type="text">
</div>
<div style="position:absolute;left:533.00px;top:381px" class="float-right">
        <input name="emp_id_num[]" value="' . (isset($eployee_id[8]) ? $eployee_id[7] : '') . '" style="width: 16px;height:26px" type="text">
</div>
<div style="position:absolute;left:548.00px;top:381px" class="float-right">
        <input name="emp_id_num[]" value="' . (isset($eployee_id[8]) ? $eployee_id[8] : '') . '" style="width: 16px;height:26px" type="text">
</div>
<div style="position:absolute;left:36.00px;top:380.75px" class="cls_009"><span class="cls_009">Number To Give the Requester </span><span class="cls_008">for guidelines on whose number to enter.</span></div>
<div style="position:absolute;left:453.97px;top:389.75px" class="cls_008"><span class="cls_008"><strong>-</strong></span></div>
<div style="position:absolute;left:39.75px;top:406.17px" class="cls_013"><span class="cls_013"><strong>Part II</strong></span></div>
<div style="position:absolute;left:91.00px;top:406.17px" class="cls_014"><span class="cls_014"><strong>Certification</strong></span></div>
<div style="position:absolute;left:36.00px;top:419.74px" class="cls_008"><span class="cls_008">Under penalties of perjury, I certify that:</span></div>
<div style="position:absolute;left:36.00px;top:431.74px" class="cls_008"><span class="cls_008">1. The number shown on this form is my correct taxpayer identification number (or I am waiting for a number to be issued to me); and</span></div>
<div style="position:absolute;left:36.00px;top:441.50px" class="cls_008"><span class="cls_008">2. I am not subject to backup withholding because: (a) I am exempt from backup withholding, or (b) I have not been notified by the Internal Revenue</span></div>
<div style="position:absolute;left:45.00px;top:450.50px" class="cls_008"><span class="cls_008">Service (IRS) that I am subject to backup withholding as a result of a failure to report all interest or dividends, or (c) the IRS has notified me that I am</span></div>
<div style="position:absolute;left:45.00px;top:459.50px" class="cls_008"><span class="cls_008">no longer subject to backup withholding; and</span></div>
<div style="position:absolute;left:36.00px;top:472.38px" class="cls_008"><span class="cls_008">3. I am a U.S. citizen or other U.S. person (defined below); and</span></div>
<div style="position:absolute;left:36.00px;top:484.38px" class="cls_008"><span class="cls_008">4. The FATCA code(s) entered on this form (if any) indicating that I am exempt from FATCA reporting is correct.</span></div>
<div style="position:absolute;left:36.00px;top:496.83px" class="cls_016"><span class="cls_016"><strong>Certification instructions.</strong> You must cross out item 2 above if you have been notified by the IRS that you are currently subject to backup withholding because</span></div>
<div style="position:absolute;left:36.00px;top:505.83px" class="cls_016"><span class="cls_016">you have failed to report all interest and dividends on your tax return. For real estate transactions, item 2 does not apply. For mortgage interest paid,</span></div>
<div style="position:absolute;left:36.00px;top:514.83px" class="cls_016"><span class="cls_016">acquisition or abandonment of secured property, cancellation of debt, contributions to an individual retirement arrangement (IRA), and generally, payments</span></div>
<div style="position:absolute;left:36.00px;top:523.83px" class="cls_016"><span class="cls_016">other than interest and dividends, you are not required to sign the certification, but you must provide your correct TIN. See the instructions for Part II, later.</span></div>
<div style="position:absolute;left:36.00px;top:538.17px" class="cls_014"><span class="cls_014"><strong>Sign</strong></span></div>
<div style="position:absolute;left:78.00px;top:543.35px" class="cls_002"><span class="cls_002"><strong>Signature of</strong></span></div>
<div style="position:absolute;left:36.00px;top:548.17px" class="cls_014"><span class="cls_014"><strong>Here</strong></span></div>
<div style="position:absolute;left:78.00px;top:552.03px" class="cls_002"><span class="cls_002">
                <strong>U.S. person ▶</strong>
        </span><span style="position: absolute;top: -12px;left: 61px;" class="cls_010">

                <a style="width:214px;padding:1.5px 5px">

                </a>
        </span>
</div>
<div style="position:absolute;left:387.60px;top:552.03px" class="cls_002"><span class="cls_002"><strong>Date </strong></span><span class="cls_010"><strong>▶</strong>' . date("jS \d\a\y\ \of F, Y") . ' </span></div>
<div style="position:absolute;left:316.80px;top:568.74px" class="cls_008"><span class="cls_008"><strong>•</strong> Form 1099-DIV (dividends, including those from stocks or mutual</span></div>
<div style="position:absolute;left:36.00px;top:567.03px" class="cls_005"><span class="cls_005"><strong>General Instructions</strong></span></div>
<div style="position:absolute;left:316.80px;top:577.74px" class="cls_008"><span class="cls_008">funds)</span></div>
<div style="position:absolute;left:36.00px;top:586.74px" class="cls_008"><span class="cls_008">Section references are to the Internal Revenue Code unless otherwise</span></div>
<div style="position:absolute;left:316.80px;top:589.74px" class="cls_008"><span class="cls_008"><strong>•</strong> Form 1099-MISC (various types of income, prizes, awards, or gross</span></div>
<div style="position:absolute;left:36.00px;top:595.74px" class="cls_008"><span class="cls_008">noted.</span></div>
<div style="position:absolute;left:316.80px;top:598.74px" class="cls_008"><span class="cls_008">proceeds)</span></div>
<div style="position:absolute;left:36.00px;top:607.74px" class="cls_008"><span class="cls_008"><strong>Future developments.</strong> For the latest information about developments</span></div>
<div style="position:absolute;left:316.80px;top:610.74px" class="cls_008"><span class="cls_008"><strong>•</strong> Form 1099-B (stock or mutual fund sales and certain other</span></div>
<div style="position:absolute;left:36.00px;top:616.74px" class="cls_008"><span class="cls_008">related to Form W-9 and its instructions, such as legislation enacted</span></div>
<div style="position:absolute;left:316.80px;top:619.74px" class="cls_008"><span class="cls_008">transactions by brokers)</span></div>
<div style="position:absolute;left:36.00px;top:625.74px" class="cls_008"><span class="cls_008">after they were published, go to </span><a href="http://www.irs.gov/formw9./">www.irs.gov/FormW9.</a> </div>
<div style="position:absolute;left:316.80px;top:631.74px" class="cls_008"><span class="cls_008"><strong>•</strong> Form 1099-S (proceeds from real estate transactions)</span></div>
<div style="position:absolute;left:36.00px;top:639.60px" class="cls_017"><span class="cls_017"><strong>Purpose of Form</strong></span></div>
<div style="position:absolute;left:316.80px;top:643.74px" class="cls_008"><span class="cls_008"><strong>•</strong> Form 1099-K (merchant card and third party network transactions)</span></div>
<div style="position:absolute;left:36.00px;top:656.74px" class="cls_008"><span class="cls_008">An individual or entity (Form W-9 requester) who is required to file an</span></div>
<div style="position:absolute;left:316.80px;top:655.74px" class="cls_008"><span class="cls_008"><strong>•</strong> Form 1098 (home mortgage interest), 1098-E (student loan interest),</span></div>
<div style="position:absolute;left:36.00px;top:665.74px" class="cls_008"><span class="cls_008">information return with the IRS must obtain your correct taxpayer</span></div>
<div style="position:absolute;left:316.80px;top:664.74px" class="cls_008"><span class="cls_008">1098-T (tuition)</span></div>
<div style="position:absolute;left:36.00px;top:674.74px" class="cls_008"><span class="cls_008">identification number (TIN) which may be your social security number</span></div>
<div style="position:absolute;left:316.80px;top:676.74px" class="cls_008"><span class="cls_008"><strong>•</strong> Form 1099-C (canceled debt)</span></div>
<div style="position:absolute;left:36.00px;top:683.74px" class="cls_008"><span class="cls_008">(SSN), individual taxpayer identification number (ITIN), adoption</span></div>
<div style="position:absolute;left:316.80px;top:688.83px" class="cls_018"><span class="cls_018"><strong>•</strong> Form 1099-A (acquisition or abandonment of secured property)</span></div>
<div style="position:absolute;left:36.00px;top:692.74px" class="cls_008"><span class="cls_008">taxpayer identification number (ATIN), or employer identification number</span></div>
<div style="position:absolute;left:36.00px;top:701.74px" class="cls_008"><span class="cls_008">(EIN), to report on an information return the amount paid to you, or other</span></div>
<div style="position:absolute;left:324.80px;top:700.74px" class="cls_008"><span class="cls_008">Use Form W-9 only if you are a U.S. person (including a resident</span></div>
<div style="position:absolute;left:36.00px;top:710.74px" class="cls_008"><span class="cls_008">amount reportable on an information return. Examples of information</span></div>
<div style="position:absolute;left:316.80px;top:709.74px" class="cls_008"><span class="cls_008">alien), to provide your correct TIN.</span></div>
<div style="position:absolute;left:36.00px;top:719.74px" class="cls_008"><span class="cls_008">returns include, but are not limited to, the following.</span></div>
<div style="position:absolute;left:324.80px;top:721.74px" class="cls_009"><span class="cls_009">If you do not return Form W-9 to the requester with a TIN, you might</span></div>
<div style="position:absolute;left:36.00px;top:731.74px" class="cls_008"><span class="cls_008"><strong>•</strong> Form 1099-INT (interest earned or paid)</span></div>
<div style="position:absolute;left:316.80px;top:730.74px" class="cls_009"><span class="cls_009">be subject to backup withholding. See </span><span class="cls_008">What is backup</span><span class="cls_009"> </span><span class="cls_008">withholding,</span></div>
<div style="position:absolute;left:316.80px;top:739.74px" class="cls_009"><span class="cls_009">later.</span></div>
<div style="position:absolute;left:233.40px;top:758.03px" class="cls_002"><span class="cls_002">Cat. No. 10231X</span></div>
<div style="position:absolute;left:491.06px;top:754.17px" class="cls_002"><span class="cls_002">Form </span><span class="cls_014"><strong>W-9</strong></span><span class="cls_002"> (Rev. 10-2018)</span></div>

</div>';

	$html = ob_get_clean();
	$dompdf = new Dompdf();

	$dompdf->load_html($html);
	$dompdf->setPaper('A4', 'portrait');

	$dompdf->render();
	$dompdf->stream("sample.pdf", ["Attachment" => 0]);
?>

<?php endif; ?>