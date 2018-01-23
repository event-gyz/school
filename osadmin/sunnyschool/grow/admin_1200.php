<?php
	require ('../../include/init.inc.php');
	$method = $user_id = $page_no = '';
	extract ( $_GET, EXTR_IF_EXISTS );

	require_once('../ajaxCRUD/preheader.php'); // <-- this include file MUST go first before any HTML/output

	#the code for the class
	include ('../ajaxCRUD/ajaxCRUD.class.php'); // <-- this include file MUST go first before any HTML/output

    #this one line of code is how you implement the class
    ########################################################
    ##
    $tblGrowIndex = new ajaxCRUD("指標", "grow_index", "uid", "../ajaxCRUD/");

    ##
    ########################################################
    $tblGrowIndex->setCSSFile("cuscosky.css");
    $tblGrowIndex->addText ="新增ㄧ項";
//    $tblGrowIndex->displayAddFormTop();
    ## all that follows is setup configuration for your fields....
    ## full API reference material for all functions can be found here - http://ajaxcrud.com/api/
    ## note: many functions below are commented out (with //). note which ones are and which are not

    #i can define a relationship to another table
    #the 1st field is the fk in the table, the 2nd is the second table, the 3rd is the pk in the second table, the 4th is field i want to retrieve as the dropdown value
    #http://ajaxcrud.com/api/index.php?id=defineRelationship
    //$tblGrowIndex->defineRelationship("fkID", "tblDemoRelationship", "pkID", "fldName", "fldSort DESC"); //use your own table - this table (tblDemoRelationship) not included in the installation script

    #i don't want to visually show the primary key in the table
    $tblGrowIndex->omitPrimaryKey();

    #the table fields have prefixes; i want to give the heading titles something more meaningful
    $tblGrowIndex->displayAs("stid", "編號");
    $tblGrowIndex->displayAs("type", "分類");
    $tblGrowIndex->displayAs("text", "文字");
    $tblGrowIndex->displayAs("detail", "詳細說明");
    $tblGrowIndex->displayAs("advice", "醫師建議");
    $tblGrowIndex->displayAs("image_file", "示意圖");
    $tblGrowIndex->displayAs("age_min", "年齡下限（月）");
    $tblGrowIndex->displayAs("age_max", "年齡上限（月）");

	#set the textarea height of the longer field (for editing/adding)
    #http://ajaxcrud.com/api/index.php?id=setTextareaHeight
    $tblGrowIndex->setTextareaHeight('text', 50);
    $tblGrowIndex->setTextareaHeight('detail', 50);
    $tblGrowIndex->setTextareaHeight('advice', 50);

    #i could omit a field if I wanted
    #http://ajaxcrud.com/api/index.php?id=omitField
    //$tblGrowIndex->omitField("fldField2");

    #i could omit a field from being on the add form if I wanted
    $tblGrowIndex->omitAddField("stid");

    #i could disallow editing for certain, individual fields
    //$tblGrowIndex->disallowEdit('fldField2');

    #i could set a field to accept file uploads (the filename is stored) if wanted
    $tblGrowIndex->setFileUpload("image_file", "../../../content/gi/","../../../content/gi/");

    #i can have a field automatically populate with a certain value (eg the current timestamp)
    //$tblGrowIndex->addValueOnInsert("fldField1", "NOW()");

    #i can use a where field to better-filter my table
    //$tblGrowIndex->addWhereClause("WHERE (fldField1 = 'test')");

    #i can order my table by whatever i want
    //$tblGrowIndex->addOrderBy("ORDER BY fldField1 ASC");

    #i can set certain fields to only allow certain values
    #http://ajaxcrud.com/api/index.php?id=defineAllowableValues
    
    $age_range = array();
    for($i = 0; $i <= 12*6; $i+=0.5)
		    $age_range[] = $i;
    /*
    for($i = 0; $i <= 6; $i++) {
	    for($j = 0; $j < 12; $j++) {
		    //$age = array(0=>($i.".".$j),1=>($i."歲".$j."個月"));
		    $age = $i.".".$j;
		    $age_range[] = $age;
	    }
    }
    */
    $tblGrowIndex->defineAllowableValues("age_min", $age_range);
    $tblGrowIndex->defineAllowableValues("age_max", $age_range);
    
    $allowableValues = array(	array(0=>0,1=>"0 语言与沟通发展"), 
    							array(0=>1,1=>"1 社会人格发展"), 
    							array(0=>2,1=>"2 动作技能（粗动作）"), 
    							array(0=>3,1=>"3 动作技能（精细动作）"), 
    							array(0=>4,1=>"4 知觉与认知发展"), 
    							array(0=>5,1=>"5 自主能力发展")
    						);
    $tblGrowIndex->defineAllowableValues("type", $allowableValues);

    //set field fldCheckbox to be a checkbox
    //$tblGrowIndex->defineCheckbox("fldCheckbox");

    #i can disallow deleting of rows from the table
    #http://ajaxcrud.com/api/index.php?id=disallowDelete
    //$tblGrowIndex->disallowDelete();

    #i can disallow adding rows to the table
    #http://ajaxcrud.com/api/index.php?id=disallowAdd
    //$tblGrowIndex->disallowAdd();

    #i can add a button that performs some action deleting of rows for the entire table
    #http://ajaxcrud.com/api/index.php?id=addButtonToRow
    //$tblGrowIndex->addButtonToRow("Add", "add_item.php", "all");

    #set the number of rows to display (per page)
    $tblGrowIndex->setLimit(20);

	#set a filter box at the top of the table
    //$tblGrowIndex->addAjaxFilterBox('fldField1');

    #if really desired, a filter box can be used for all fields
//    $tblGrowIndex->addAjaxFilterBoxAllFields();
    $tblGrowIndex->addAjaxFilterBox('type');
    #i can set the size of the filter box
    //$tblGrowIndex->setAjaxFilterBoxSize('fldField1', 3);

	#i can format the data in cells however I want with formatFieldWithFunction
	#this is arguably one of the most important (visual) functions
	$tblGrowIndex->formatFieldWithFunction('type', 'makeBlue');
	$tblGrowIndex->formatFieldWithFunction('text', 'makeBold');

	//$tblGrowIndex->modifyFieldWithClass("fldField1", "zip required"); 	//for testing masked input functionality
	//$tblGrowIndex->modifyFieldWithClass("fldField2", "phone");			//for testing masked input functionality

	//$tblGrowIndex->onAddExecuteCallBackFunction("mycallbackfunction"); //uncomment this to try out an ADD ROW callback function

	$tblGrowIndex->deleteText = "刪除";

	#actually show the table
//	$tblGrowIndex->insertRowsReturned();
	ob_start();
	$tblGrowIndex->showTable();
	$myStr = ob_get_contents();
	ob_end_clean();
	Template::assign ('gi_count',$tblGrowIndex->getNumRows());
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
	
?>