<?php
	require ('../include/init.inc.php');
	$method = $user_id = $page_no = '';
	extract ( $_GET, EXTR_IF_EXISTS );

	require_once('ajaxCRUD/preheader.php'); // <-- this include file MUST go first before any HTML/output

	#the code for the class
	include ('ajaxCRUD/ajaxCRUD.class.php'); // <-- this include file MUST go first before any HTML/output

	// reset UID
	include_once("../../inc/inc_db.php");
	query("SET @num=0");
	query("UPDATE admin SET uid=(@num:=@num+1)");

    #this one line of code is how you implement the class
    ########################################################
    ##
    $tblTvqa = new ajaxCRUD("教師專區登入帳號", "admin", "uid", "ajaxCRUD/");
?>
<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="includes/jquery.ui.all.css">
		<script src="includes/jquery.ui.core.js"></script>
		<!--script src="includes/jquery.ui.widget.js"></script-->
		<script src="includes/jquery.ui.datepicker.js"></script>
	</head>

<?php

    ##
    ########################################################
    $tblTvqa->setCSSFile("cuscosky.css");
    $tblTvqa->addText ="新增ㄧ項";
//    $tblTvqa->displayAddFormTop();
    ## all that follows is setup configuration for your fields....
    ## full API reference material for all functions can be found here - http://ajaxcrud.com/api/
    ## note: many functions below are commented out (with //). note which ones are and which are not

    #i can define a relationship to another table
    #the 1st field is the fk in the table, the 2nd is the second table, the 3rd is the pk in the second table, the 4th is field i want to retrieve as the dropdown value
    #http://ajaxcrud.com/api/index.php?id=defineRelationship
    //$tblTvqa->defineRelationship("fkID", "tblDemoRelationship", "pkID", "fldName", "fldSort DESC"); //use your own table - this table (tblDemoRelationship) not included in the installation script

    #i don't want to visually show the primary key in the table
    //$tblTvqa->omitPrimaryKey();

    #the table fields have prefixes; i want to give the heading titles something more meaningful
    $tblTvqa->displayAs("id", "email");
//    $tblTvqa->displayAs("email", "email(必須與id相同)");
    $tblTvqa->setAddPlaceholderText("password","6至20位，可含字母、数字、下划线");
    /*
    $tblTvqa->displayAs("answer1", "答案1");
    $tblTvqa->displayAs("answer2", "答案2");
    $tblTvqa->displayAs("answer3", "答案3");
    $tblTvqa->displayAs("answer_id", "正確答案");
    $tblTvqa->displayAs("pub_date", "出現日期");
    */
	#set the textarea height of the longer field (for editing/adding)
    #http://ajaxcrud.com/api/index.php?id=setTextareaHeight
    /*
    $tblTvqa->setTextareaHeight('link', 100);
    $tblTvqa->setTextareaHeight('answer1', 50);
    $tblTvqa->setTextareaHeight('answer2', 50);
    $tblTvqa->setTextareaHeight('answer3', 50);
    */
    #i could omit a field if I wanted
    #http://ajaxcrud.com/api/index.php?id=omitField
    $tblTvqa->omitField("org");
    $tblTvqa->omitField("email");
    $tblTvqa->omitField("perm");

    #i could omit a field from being on the add form if I wanted
    $tblTvqa->omitAddField("org");
    $tblTvqa->omitAddField("email");
    $tblTvqa->omitAddField("perm");

    #i could disallow editing for certain, individual fields
    //$tblTvqa->disallowEdit('fldField2');

    #i could set a field to accept file uploads (the filename is stored) if wanted
    //$tblTvqa->setFileUpload("image", "../theme/cn/images/content/img/","../theme/cn/images/content/img/");

    #i can have a field automatically populate with a certain value (eg the current timestamp)
    //$tblTvqa->addValueOnInsert("fldField1", "NOW()");

    #i can use a where field to better-filter my table
    //$tblTvqa->addWhereClause("WHERE (fldField1 = 'test')");

    #i can order my table by whatever i want
    //$tblTvqa->addOrderBy("ORDER BY fldField1 ASC");

    #i can set certain fields to only allow certain values
    #http://ajaxcrud.com/api/index.php?id=defineAllowableValues
    
    /*
    $range = array();
    for($i = 1; $i <= 3; $i++)
		    $range[] = $i;
*/
    /*
    for($i = 0; $i <= 6; $i++) {
	    for($j = 0; $j < 12; $j++) {
		    //$age = array(0=>($i.".".$j),1=>($i."歲".$j."個月"));
		    $age = $i.".".$j;
		    $age_range[] = $age;
	    }
    }
    */
//    $range = array('0'=>'0 - 品德','1'=>'1 - 教案');
//    $tblTvqa->defineAllowableValues("type", $range);

    //set field fldCheckbox to be a checkbox
    //$tblTvqa->defineCheckbox("fldCheckbox");

    #i can disallow deleting of rows from the table
    #http://ajaxcrud.com/api/index.php?id=disallowDelete
    //$tblTvqa->disallowDelete();

    #i can disallow adding rows to the table
    #http://ajaxcrud.com/api/index.php?id=disallowAdd
    //$tblTvqa->disallowAdd();

    #i can add a button that performs some action deleting of rows for the entire table
    #http://ajaxcrud.com/api/index.php?id=addButtonToRow
    //$tblTvqa->addButtonToRow("Add", "add_item.php", "all");

    #set the number of rows to display (per page)
    $tblTvqa->setLimit(30);

	#set a filter box at the top of the table
    //$tblTvqa->addAjaxFilterBox('fldField1');

    #if really desired, a filter box can be used for all fields
//    $tblTvqa->addAjaxFilterBoxAllFields();
//    $tblTvqa->addAjaxFilterBox('org');
    //$tblTvqa->addAjaxFilterBox('pub_date');
    #i can set the size of the filter box
    //$tblTvqa->setAjaxFilterBoxSize('fldField1', 3);

	#i can format the data in cells however I want with formatFieldWithFunction
	#this is arguably one of the most important (visual) functions
	//$tblTvqa->formatFieldWithFunction('answer_id', 'makeBlue');
	//$tblTvqa->formatFieldWithFunction('question', 'makeBold');
	//$tblTvqa->modifyFieldWithClass("pub_date", "datepicker");
	//$tblTvqa->modifyFieldWithClass("fldField1", "zip required"); 	//for testing masked input functionality
	//$tblTvqa->modifyFieldWithClass("fldField2", "phone");			//for testing masked input functionality

	$tblTvqa->onAddExecuteCallBackFunction("onAddCallback"); //uncomment this to try out an ADD ROW callback function

	$tblTvqa->deleteText = "刪除";

	#actually show the table
//	$tblTvqa->showTable();
	ob_start();
	$tblTvqa->showTable();
	$myStr = ob_get_contents();
	ob_end_clean();
	Template::assign ('gi_count',$tblTvqa->getNumRows());
	Template::assign ('content',$myStr);
	Template::display ( 'sunnyschool/ajaxcrud.tpl' );

	#my self-defined functions used for formatFieldWithFunction
	function makeBold($val){
		if ($val == "") return "no value";
		return "<b>$val</b>";
	}

	function makeBlue($val){
		return "<span style='color: blue;'>$val</span>";
	}

	function myCallBackFunction($array){
		echo "THE ADD ROW CALLBACK FUNCTION WAS implemented";
		print_r($array);
	}
	
	function onAddCallback($array) {
		$id = $array['id'];
		$success = qr("update admin set email=id where uid=$id");
	}
	
?>

	</body>
</html>
