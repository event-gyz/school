<?php

/*
mysql> describe pattern;
+---------------+--------------+------+-----+---------+----------------+
| Field         | Type         | Null | Key | Default | Extra          |
+---------------+--------------+------+-----+---------+----------------+
| uid           | int(11)      | NO   | PRI | NULL    | auto_increment |
| name          | varchar(256) | YES  | UNI | NULL    |                |
| type          | varchar(16)  | NO   |     | NULL    |                |
| pattern_month | int(11)      | YES  |     | 201301  |                |
| category_id   | varchar(32)  | YES  |     | NULL    |                |
| score_min     | tinyint(4)   | NO   |     | 0       |                |
| score_max     | tinyint(4)   | NO   |     | 100     |                |
| content       | text         | YES  |     | NULL    |                |
| age_min       | float        | YES  |     | 0       |                |
| age_max       | float        | YES  |     | 7.5     |                |
+---------------+--------------+------+-----+---------+----------------+
10 rows in set (0.00 sec)

*/
function add_new_pattern($name, $type, $pattern_month, $category_id, $score_min, $score_max, $age_min, $age_max, $content , $lang)
{
       $sql = " select max(uid)+1 from pattern";
       $result = query($sql);
       $row = mysqli_fetch_array($result);
       $p_name= "pt_".$category_id."_".$row[0]."_name";
       $p_content= "pt_".$category_id."_".$row[0]."_content";

	if($row[0] > 0 )
	{
		$sql =	" insert into pattern 
			  	(name, type, pattern_month, category_id, score_min, score_max,
				 age_min, age_max, content )
			  values
				('".$p_name."','".$type."','".$pattern_month."','".$category_id."',
				 '".$score_min."','".$score_max."','".$age_min."','".$age_max."',
				 '".$p_content."')";
		$result = query($sql);
		$sql = " select uid from pattern where name = '".$p_name."'";
		$result = query($sql);
		$row = mysqli_fetch_object($result);
		return ($result && update_content($row->uid, $content, $lang) && update_name($row->uid, $name, $lang));
	}

}

function add_new_pattern_slim($type, $pattern_month, $category_id, $score_min, $score_max, $age_min, $age_max)
{
//       $sql = " select count(*)+1 from pattern where type = '".$type."' and category_id ='".$category_id."'";
	$sql = " select max(uid)+1 from pattern";

       $result = query($sql);
       $row = mysqli_fetch_array($result);
       $p_name= "pt_".$category_id."_".$row[0]."_name";
       $p_content= "pt_".$category_id."_".$row[0]."_content";

	if($row[0] > 0 )
	{
		$sql =	" insert into pattern 
			  	(name, type, pattern_month, category_id, score_min, score_max,
				 age_min, age_max, content )
			  values
				('".$p_name."','".$type."','".$pattern_month."','".$category_id."',
				 '".$score_min."','".$score_max."','".$age_min."','".$age_max."',
				 '".$p_content."')";
		$result = query($sql);
		$sql = " select uid from pattern where name = '".$p_name."'";
		$result = query($sql);
		$row = mysqli_fetch_object($result);
		return $row->uid;
	}

}


function update_pattern($uid, $name, $type, $pattern_month, $category_id, $score_min, $score_max, $age_min, $age_max, $content , $lang)
{
        $sql =  " select count(*) from pattern where uid = '".$uid."'";
        $result = query($sql);
        $row = mysqli_fetch_array($result);

        if($row[0] != 1 )
        {
                return false;
        }
        else
        {
                $sql =  " update pattern 
				set uid = '".$uid."' ";
		//if($name!="") $sql = $sql.", name='".$name."'"; 
		if($type!="") $sql = $sql.", type='".$type."'";
		if($pattern_month!="") $sql = $sql.", pattern_month='".$pattern_month."'";
		if($category_id!="") $sql = $sql.", category_id='".$category_id."'";   	
		if($score_min!="") $sql = $sql.", score_min='".$score_min."'"; 
		if($score_max!="") $sql = $sql.", score_max='".$score_max."'"; 
		if($age_min!="") $sql = $sql.", age_min='".$age_min."'"; 
		if($age_max!="") $sql = $sql.", age_max='".$age_max."'"; 
		//if($content!="") $sql = $sql.", content='".$content."'"; 
		$sql = $sql." where uid = '".$uid."' ";
                $result = query($sql); 
                return ($result && update_content($uid, $content, $lang) && update_name($uid, $name, $lang));
        }

}
            
function update_content($uid, $content, $lang)
{
         $sql = "INSERT INTO language (name,lang,value) VALUES (                
                                        (select content from pattern where uid = '".$uid."')  
                                         ,'".$lang."',
                                        '".$content."') 
                                        ON DUPLICATE KEY UPDATE value='".$content."'";
                                  return query($sql);

}

function update_name($uid, $name, $lang)
{
          $sql = "INSERT INTO language (name,lang,value) VALUES (
                                          (select name from pattern where uid = '".$uid."')  
                                         ,'".$lang."',                                        
                                          '".$name."') 
                                        ON DUPLICATE KEY UPDATE value='".$name."'";
                                  return query($sql);

}
/*
ql> select * from pattern where uid = 16\G
*************************** 1. row ***************************
          uid: 16
         name: PT_CAT005_01 <--- some title left for admin 
         type: SUGGESTION
pattern_month: 201307
  category_id: CAT005
    score_min: 0
    score_max: 100
      content: NULL		real content
      age_min: 0
      age_max: 7.5
1 row in set (0.00 sec)

*/

function get_pattern($type, $category_id, $score, $age, $lang)
{
	if($type == "SUGGESTION" || $type == "RECOMMEND" || $type == "KNOWLEDGE" )
	{
		$sql = 	" select * from pattern where type = '".$type."' ";
		if($score != "") $sql = $sql . " and ".$score." >= score_min ".
					       " and ".$score." <= score_max ";
		if($age != "")   $sql = $sql . " and ".$age." >= age_min ".
					       " and ".$age." <= age_max ";
		if($category_id != "") $sql = $sql . " and category_id = '".$category_id."'";
		$sql = $sql . " order by rand() limit 1 ";
		$result = query($sql);
		if(mysqli_num_rows($result)==1)
		{
			$row = mysqli_fetch_object($result);
			return array(	'category_id'=>$row->category_id, 
					'name'=>getStr($lang,$row->name),
					'content'=>getStr($lang,$row->content) );
		}
		else	
			return array( 'category_id'=>'','name'=>'','content'=>''); 
	}
	else
	{
		return null;
	}
}

/*
mysql> select * from pattern where uid = 17\G
*************************** 1. row ***************************
          uid: 17
         name: 專家建議01   article title
         type: RECOMMEND
pattern_month: 201307
  category_id: NULL
    score_min: 0
    score_max: 100
      content: NULL		article content
      age_min: 0
      age_max: 7.5
1 row in set (0.00 sec)

*/

?>
