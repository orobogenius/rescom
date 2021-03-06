<?php

//=========================================
// File name 	: adduser.php
// Description 	: Add User components for main app

// Author 		: Ozoka Lucky Orobo

// (c) Copyright:
//				GenTech

//=========================================

/**
* @file
* Add User components for main app
*
* @package com.gentech.rescom
* @brief ResCom
* @author Ozoka Lucky Orobo
*/

require_once('../helpers/form_helper.php');
require_once('../models/user.php');

$user = new User();

$level = $user->getAccessLevel($user->getID($_SESSION['username']));

if ($level < R_ADD_STUDENTS_LEVEL) {
	echo '<script>',
	'location.href = "http://localhost/rescom/app/main/views/index.php?action=dashboard";',
	'</script>';
}

echo '<div class="container content">' . R_NEWLINE;
if ($level == R_SUPER_ADMIN_LEVEL) {
	echo '<h3>Add User</h3>' . R_NEWLINE;	
} else {
	echo '<h3>'.$config['sidebar-texts'][1].'</h3>' . R_NEWLINE;
}
echo '<div class="panel panel-default section-panel">' . R_NEWLINE;
		echo '<div class="panel-heading">' . R_NEWLINE;
			echo '<h1 class="panel-title">Data Capture</h1>' . R_NEWLINE;
		echo '</div>' . R_NEWLINE;
		echo '<div class="panel-body">' . R_NEWLINE;

if ($level == R_SUPER_ADMIN_LEVEL) {
	$content = <<<END
	<p>
		This section provides functionalities to add <b>Staffs</b> and <b>Students</b> to the
		platform.
	</p>
	<p>
		To begin, select the type from the list in the form below and fill in the required field(s).<br /> <strong>NOTE:</strong> When adding staffs to the platform, you should specify their Access Level. This defines special priviledges for the staffs in the platform. There are 5 levels for staffs in the platform:
		<ul>
			<li>
				Level 1 - This is the basic level; it grants access to only <b>View</b> and <b>Print/Export</b> results and score sheets. Staffs with this access level cannot Add Students and Compile Results on the Platform
			</li>
			<li>
				Level 2 - This access level grants access to <b>View Results</b> and <b>Add Students</b> to the platform. Staffs with this access level cannot Compile Results on the platform.
			</li>
			<li>
				Level 3 - This access level grants access to <b>View Results</b>, <b>Add and Delete Students</b> to and from the platform. Staffs with this access level cannot Compile Results on the platform.
			</li>
			<li>
				Leve 4 - This access level grants access to <b>View Results</b>, <b>Add and Delete Students</b> to and from the platform, and <b>Compile Results</b> for students on the platform. Staffs with this access level cannot Add other Staffs to the platform.
			</li>
			<li>
				Level 5 - This is the super admin access level; it grants access to all <b>functionalities</b> and <b>sections</b> of the plaform. For security purposes, this access level should only be given to one or two Staffs. Only staffs with this access level can add other staffs to the platform. This is the level you are currently operating on.
			</li>
		</ul>
	</p>
END;
echo $content . R_NEWLINE;
getAddNewPanel("Add New");
$options = array(
	"Select Type" => 1,
	"Student" => 0,
	"Staff" => 0
	);
echo form_open();
echo form_group();
	echo form_label("Type: ", "usertype");
	echo form_col(9);
echo form_select("type", "usertype", $options);
echo '</div>' . R_NEWLINE;
echo '</div>' . R_NEWLINE;
echo '</form>' . R_NEWLINE;

echo form_open("post", "form-horizontal", "addstaff-admin");
	echo form_group();
	echo form_label("First Name: ", "firstname");
	echo form_col(9);
	echo form_input("firstname", "firstname", "", "First Name", "required", "Staff's First Name");
	echo '</div>' . R_NEWLINE;
	echo '</div>' . R_NEWLINE;
	echo form_group();
	echo form_label("Last Name: ", "lastname");
	echo form_col(9);
	echo form_input("lastname", "lastname", "", "Last Name", "required", "Staff's Surname");
	echo '</div>' . R_NEWLINE;
	echo '</div>' . R_NEWLINE;
	echo form_group();
	echo form_label("Position: ", "firstname");
	echo form_col(9);
	echo form_input("position", "position", "", "Position", "required", "Staff's Position in Organization");
	echo '</div>' . R_NEWLINE;
	echo '</div>' . R_NEWLINE;
	echo form_group();
	echo form_label("Username: ", "username");
	echo form_col(9);
	echo form_input("username", "username", "", "Choose a Username", "required", "Choose a user-friendly name");
	echo '<span style="float: left;">This will be their login name</span>' . R_NEWLINE;
	echo '</div>' . R_NEWLINE;
	echo '</div>' . R_NEWLINE;
	echo form_group();
	echo form_label("Password: ", "password");
	echo form_col(9);
	echo form_password("password", "password", "", "required");
	echo '</div>' . R_NEWLINE;
	echo '</div>' . R_NEWLINE;
	echo form_group();
	echo form_label("Access Level: ", "level");							
	echo form_col(9);
	$options = array(
		"1" => 1,
		"2" => 0,
		"3" => 0,
		"4" => 0,
		"5" => 0
	);
	echo form_select("level", "level", $options);
	echo '</div>' . R_NEWLINE;
	echo '</div>' . R_NEWLINE;
	echo '<div class="button-group">' . R_NEWLINE;
	echo form_button("submit", "primary", "Add Staff", "", "submit");
	echo form_button("clear", "secondary", "Clear Fields", "clear-fields");
	echo '</div>' . R_NEWLINE;
	echo form_hidden("add-staff", "add-staff", "add-staff");
echo form_close();
echo getStudentForm();
echo '</div>' . R_NEWLINE;
echo '</div>' . R_NEWLINE;
} else {
	$content = <<<END
	<p>
		This section provides functionalities to add <b>Students</b> to the
		platform. Students' data must be captured using this section before their results can be compiled.
	</p>
	<p>
		To begin, please fill in the field(s) in the form below
	</p>
END;
echo $content . R_NEWLINE;
getAddNewPanel("Add New");
echo getStudentForm("addstudent-base");
echo '</div>' . R_NEWLINE;
echo '</div>' . R_NEWLINE;
}
		echo '</div>' . R_NEWLINE;
	echo '</div>' . R_NEWLINE;
echo '</div>' . R_NEWLINE;
echo '</div>' . R_NEWLINE;


function getStudentForm($id = "") {
	if (!empty($id)) {
		$content = form_open_upload("post", "form-horizontal", $id);
	} else {
		$content = form_open_upload("post", "form-horizontal", "addstudent-admin");
	}
	$content .= form_group();
	$content .= form_label("Admission Number: ", "admin-no");
	$content .= form_col(9);
	$content .= form_input("admissionno", "admin-no", "", "Enter Admission Number", "required", "Enter Student's Admission Number");
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_group();
	$content .= form_label("First Name: ", "firstname");
	$content .= form_col(9);
	$content .= form_input("firstname", "firstname", "", "First Name", "required", "Enter Student's First Name");
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_group();
	$content .= form_label("Last Name: ", "lastname");
	$content .= form_col(9);
	$content .= form_input("lastname", "lastname", "", "Last Name", "required", "Enter Student's Surname");
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_group();
	$content .= form_label("Middle Name: ", "middlename");
	$content .= form_col(9);
	$content .= form_input("middlename", "middlename", "", "Middle Name", "", "Enter Student's Middle Name (if any)");
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_group();
	$content .= form_label("Sex: ", "sex");
	$content .= form_col(9);
	$options = array(
		"Male" => 1,
		"Female" => 0
	);
	$content .= form_select("sex", "sex", $options);
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_date();
	$content .= form_group();
	$content .= form_label("No. In Class: ", "numinclass");
	$content .= form_col(9);
	$content .= form_number("numinclass", "numinclass", "required");
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_group();
	$content .= form_label("Address: ", "address");
	$content .= form_col(9);
	$content .= form_textarea("address", "address", "10", "5", "", "required");
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_group();
	$content .= form_label("Parent Number: ", "Parent Number");
	$content .= form_col(9);
	$content .= form_number("parentnumber", "parentnumber", "required");
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_group();
	$content .= form_label("Class: ", "class");
	$content .= form_col(9);
	$user = new User();
	$content .= form_select("class", "class", $user->getClasses());
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_group();
	$content .= form_label("Class on Admission: ", "classonad");
	$content .= form_col(9);
	$user = new User();
	$content .= form_select("classonad", "classonad", $user->getClasses());
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= '<div class="passport-preview">' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= form_group();
	$content .= form_label("Passport: ", "passport");
	$content .= form_col(9);
	$content .= form_file("passport", "passport", "");
	$content .= '</div>' . R_NEWLINE;
	$content .= '</div>' . R_NEWLINE;
	$content .= '<div class="button-group">' . R_NEWLINE;
	$content .= form_button("submit", "primary", "Add Student", "", "submit");
	$content .= form_button("clear", "secondary", "Clear Fields", "clear-fields");
	$content .= '</div>' . R_NEWLINE;
	$content .= form_hidden("add-student", "add-student", "add-student");
	$content .= form_close();
	return $content;
}
