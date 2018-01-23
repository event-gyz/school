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
    $tblGrowIndex = new ajaxCRUD("分类", "grow_diary_category", "id", "../ajaxCRUD/");

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
    $tblGrowIndex->displayAs("id", "編號");
    $tblGrowIndex->displayAs("name", "名称");
    $tblGrowIndex->displayAs("sort", "排序");

	#set the textarea height of the longer field (for editing/adding)
    #http://ajaxcrud.com/api/index.php?id=setTextareaHeight
//    $tblGrowIndex->setTextareaHeight('type', 50);

    #i could omit a field if I wanted
    #http://ajaxcrud.com/api/index.php?id=omitField
    //$tblGrowIndex->omitField("fldField2");

    #i could omit a field from being on the add form if I wanted
    $tblGrowIndex->omitAddField("id");

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

//    $allowableValues = array(	array(0=>0,1=>"左侧牙齿"), array(0=>1,1=>"右侧牙齿") );
//    $tblGrowIndex->defineAllowableValues("type", $allowableValues);

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
//    $tblGrowIndex->addAjaxFilterBox('type');
    #i can set the size of the filter box
    //$tblGrowIndex->setAjaxFilterBoxSize('fldField1', 3);

    #i can format the data in cells however I want with formatFieldWithFunction
    #this is arguably one of the most important (visual) functions
//    $tblGrowIndex->formatFieldWithFunction('type', 'makeBlue');

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


?>