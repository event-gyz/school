<?php
/*
ql> describe score;
+-------------+---------------+------+-----+-------------------+----------------+
| Field       | Type          | Null | Key | Default           | Extra          |
+-------------+---------------+------+-----+-------------------+----------------+
| uid         | int(11)       | NO   | PRI | NULL              | auto_increment |
| user_uid    | int(11)       | NO   |     | NULL              |                |
| product_id  | int(11)       | NO   |     | NULL              |                |
| score       | decimal(10,0) | NO   |     | 0                 |                |
| seq_no      | int(11)       | YES  |     | NULL              |                |
| record_time | timestamp     | NO   |     | CURRENT_TIMESTAMP |                |
+-------------+---------------+------+-----+-------------------+----------------+
6 rows in set (0.00 sec)

    	$numargs = func_num_args();
	if($numargs > 0) $arg_list = func_get_args();
*/
function update_score()
{
	//user_uid
	//product_id
	//score
	//seq
	//record_time
    	$num = func_num_args();
	if($num > 0) $args = func_get_args();

	switch($num)
	{
		case "3":
				$user_uid = $args[0];
				$product_id = $args[1];
				$score	= $args[2];
		break;
		case "4":
                                $user_uid = $args[0];
                                $product_id = $args[1];
                                $score  = $args[2];
			if(is_int($arg[3]))
			{
				$seq_no = $args[3];
			}else
			{
				$record_time = "'".$args[3]."'";
			}
		break;
		case "5":
			$user_uid = $args[0];
                        $product_id = $args[1];
                        $score  = $args[2];
			if(is_int($args[3])) $seq_no = $args[3];
			$record_time = $args[4];
		break;
		default:
			return -1;
		break;
	}

	if(!isset($seq_no)) $seq_no = 1;
	$sql =	" insert into score (user_uid, product_id, score, seq_no";
        if(isset($record_time)) $sql = $sql . ", record_time ";
        $sql = $sql .")	".
		" values ".
		" ('".$user_uid."','".$product_id."','".$score."','".$seq_no."'";
        if(isset($record_time)) $sql = $sql .",'".$record_time."'";
        $sql = $sql .")";
	$result = query($sql);
	return $result; 
}

function check_is_test($product_id)
{
	$sql =  " select count(*) from product 
			where category_id = 'CAT005'
			and id = '".$product_id."'";
	$result = query($sql);
        $row = mysqli_fetch_array($result);
        return $row[0];

}

function check_score_exist($user_uid,$product_id,$seq_no)
{
	$sql = 	" select count(*) from score ".
		" where user_uid = '".$user_uid."'	".
		" and product_id = '".$product_id."'	".
		" and  seq_no	= '".$seq_no."'	";
	$result = query($sql);
	$row = mysqli_fetch_array($result);
	if($row[0]==1) debug(" TEST RECORD EXISTED> user_uid=".$user_uid.
		",product_id=".$product_id.",seq_no=".$seq_no);
	return $row[0];
}

function delete_score()
{
    	$num = func_num_args();
	if($num > 0) $args = func_get_args();

	switch($num)
	{
	// Patrick added 2014-02-07: delete scores of this user when birthday changes
		case "1":			
				$user_uid = $args[0];
				$sql = 	" delete from score where user_uid = '".$user_uid."'";
		break;
	// End Patrick
		case "3":
				$user_uid = $args[0];
				$product_id = $args[1];
			if(is_int($arg[2]))
                        {
				$seq_no	= $args[2];
                        }
                        else
                        {
                                $record_time = "'".$args[2]."'";
                        }

		break;
		case "4":
                                $user_uid = $args[0];
                                $product_id = $args[1];
			if(is_int($arg[2]))
			{
				$seq_no = $args[2];
			}
				$record_time = "'".$args[3]."'";
		break;
		default:
			return -1;
		break;
	}
	if(!isset($sql)) {
		if(!isset($seq_no)) $seq_no = 1;
		$sql = 	" delete from score ".
			" where user_uid = '".$user_uid."'	".
			" and product_id = '".$product_id."'	".
			" and ( seq	= '".$seq."'	".
			" or record_time = '".$record_time."'	) ";
	}
	$result = query($sql);
	$row = mysqli_fetch_object($result);
	return $row[0];
}

function get_score($product_id, $user_uid)
{
	$sql =	" select * from score ".
		" where user_uid = '".$user_uid."'	".
		" and product_id = '".$product_id."'	";
	$result = query($sql);
	$ar = array();
	if(mysqli_num_rows($result)>0)
	while($row=mysqli_fetch_object($result))
	{
		$obj = array(
			'uid' => $row->uid,
			'user_uid' => $row->user_uid,
			'product_id' => $row->product_id,
			'score' => $row->score,
			'record_time' => $row->record_time
				);	
		array_push($ar,$obj);

	}
	return $ar;

}


/*
describe score_stat;
+-------------+---------------+------+-----+-------------------+----------------+
| Field       | Type          | Null | Key | Default           | Extra          |
+-------------+---------------+------+-----+-------------------+----------------+
| uid         | int(11)       | NO   | PRI | NULL              | auto_increment |
| id          | varchar(32)   | NO   | UNI | NULL              |                |
| name        | varchar(32)   | YES  |     | NULL              |                |
| stat_type   | varchar(16)   | YES  |     | NULL              |                |
| stat_month  | varchar(12)   | NO   |     | 201301            |                |
| description | varchar(128)  | YES  |     | NULL              |                |
| create_time | timestamp     | YES  |     | NULL              |                |
| last_update | timestamp     | NO   |     | CURRENT_TIMESTAMP |                |
| score_sum   | decimal(10,0) | NO   |     | 0                 |                |
| score_count | int(11)       | NO   |     | 0                 |                |
+-------------+---------------+------+-----+-------------------+----------------+
10 rows in set (0.00 sec)
*/
function init_score_stat($product_id, $yyyymm)
{
	if($yyyymm == "") $yyyymm = date("Ym");

	$sql = 	" insert into score_stat	".
		" (id, name, stat_type, stat_month) ".
		" values ".
		" ('".$product_id."','".$product_id."_stat_".$yyyymm."','AVG','".$yyyymm."')";
	$result = query($sql);
	return mysqli_num_rows($result);
}

function update_score_stat($product_id ,$score , $record_time)
{
	$yyyymm = date("Ym",strtotime($record_time));
	//debug("record time = ".$record_time." > yyyymm = ".$yyyymm);
	$sql =  " select count(*) from score_stat where 
			product_id = '".$product_id."'
			and stat_month = '".$yyyymm."'";
	$result_cnt = query($sql);
	$row_cnt = mysqli_fetch_array($result_cnt);
	debug($sql);
	debug($row_cnt[0]);
	if($row_cnt[0]==0)
	{
	$sql =  " insert into score_stat 
			 (product_id, 
				name, 
			   stat_type, 
			  stat_month, 
                     	 create_time,
			   score_sum, score_count) 
		  values ('".$product_id."',
			 'average_name',
				'AVG',
   			'".$yyyymm."',
				now(),
 			  '".$score."',1)";
	}
	else
	{
	$sql =	" update score_stat set score_sum = score_sum + ".$score.", 
			score_count = score_count +1 
			where product_id = '".$product_id."'
			  and stat_month = '".$yyyymm."'";
	}

	debug(" sql = ".$sql);
	$result = query($sql);
	return $result;
}

function score_stat_exist($stat_id, $yyyymm)
{
	$sql =	" select count(*) from score_stat ".
		" where id = '".$stat_id."' and stat_month = '".$yyyymm."'";
	$result = query($sql);
	return mysqli_num_rows($result);
} 
/*
describe score_stat_accu;
+-------------+-------------+------+-----+---------+----------------+
| Field       | Type        | Null | Key | Default | Extra          |
+-------------+-------------+------+-----+---------+----------------+
| uid         | int(11)     | NO   | PRI | NULL    | auto_increment |

| count_label | varchar(32) | YES  |     | NULL    |                |
| count       | int(11)     | NO   |     | 0       |                |
| stat_id     | varchar(32) | NO   |     | NULL    |                |
+-------------+-------------+------+-----+---------+----------------+
6 rows in set (0.00 sec)$
*/
function init_stat_accu($product_id, $yyyymm)
{
	for($i=0;$i<=9;$i++)
	{
	$sql =	" insert into score_stat_accu ".
		" (count_name, count_level, count_label, count, product_id, stat_month ) ".
		" values ".
		" ('ACC".$product_id."_".$yyyymm."_".$i."',
			'".$i."',
			'".($i*10+1)."-".(($i+1)*10)."',
			0,
			'".$product_id."',
			'".$yyyymm."')";
	query($sql);
	}
}


function update_stat_accu($product_id, $score, $record_time)
{
        $yyyymm = date("Ym",strtotime($record_time));
	$level = (int)($score/10);

	$sql =	" select count(*) from score_stat_accu
			where product_id = '".$product_id."'
			  and stat_month = '".$yyyymm."'";
	$result_cnt = query($sql);
	$row_cnt = mysqli_fetch_array($result_cnt);

	if($row_cnt[0] == 0)
	{
		init_stat_accu($product_id, $yyyymm);		
	}	
       /*$sql =  " insert into score_stat_accu 
                 (count_name, count_level, count_label, count, product_id )
                 values 
                 ('ACC_".$product_id."_".$level."','".$level."','".($level*10+1)."-".(($level+1)*10)."',1,'".$product_id."')
		 on duplicate key 
			update  count = count + 1 ";
	*/
	$sql =	" update score_stat_accu set  count = count + 1
			where product_id ='".$product_id."'
			  and count_level = '".$level."'
			  and stat_month = '".$yyyymm."'";
	$result = query($sql);
	return $result;     
}

function stat_accu_exist($stat_id)
{
	$sql = " select count(*) from score_stat_accu ".
		" where stat_id = '".$stat_id."'";
	$result = query($sql);
	$row = mysqli_fetch_array($result);
	return $row[0];
}


function get_category_accu_level($category_id, $stat_month)
{
//select sum(a.count), a.count_level  from score_stat_accu a,product b where a.product_id = b.id and b.category_id = 'CAT005' and a.stat_month='201301'  group by a.count_level;
	if($category_id == "" ) return null;
	$sql = " select sum(a.count) cnt, a.count_label  
		 from score_stat_accu a, product b 
                 where a.product_id = b.id and b.category_id = '".$category_id."' ";
	if($stat_month != "") $sql = $sql . " and a.stat_month='".$stat_month."' ";
	$sql = $sql . " group by a.count_label order by a.count_label";
	tlog($sql);
	$result = query($sql);

        $ar = array();
        if(mysqli_num_rows($result)>0)
        while($row=mysqli_fetch_object($result))
        {
                $obj = array(
                        'count' => $row->cnt,
                        'score_level' => $row->count_label,
                                );
                array_push($ar,$obj);

        }
        return $ar;




	
}

/*
+-------------+--------------+------+-----+---------+----------------+
| Field       | Type         | Null | Key | Default | Extra          |
+-------------+--------------+------+-----+---------+----------------+
| uid         | int(11)      | NO   | PRI | NULL    | auto_increment |
| category_id | varchar(10)  | NO   | MUL | NULL    |                |
| id          | varchar(20)  | NO   | UNI | NULL    |                |
| price       | varchar(10)  | NO   |     | 2.99    |                |
| credit      | int(11)      | NO   |     | 1       |                |
| discount    | float        | NO   |     | NULL    |                |
| type        | varchar(5)   | NO   | MUL | NULL    |                |
| name        | varchar(50)  | NO   |     | NULL    |                |
| description | varchar(50)  | NO   |     | NULL    |                |
| cover       | varchar(255) | NO   |     | NULL    |                |
| age_min     | int(11)      | NO   |     | 0       |                |
| age_max     | int(11)      | NO   |     | 200     |                |
| data        | varchar(100) | NO   |     |         |                |
| version     | int(11)      | NO   |     | 1       |                |
| preview_url | varchar(300) | NO   |     | NULL    |                |
+-------------+--------------+------+-----+---------+----------------+
15 rows in set (0.00 sec)

*/
/*
mysql> describe product_subscribe;
+--------------+-------------+------+-----+-------------------+----------------+
| Field        | Type        | Null | Key | Default           | Extra          |
+--------------+-------------+------+-----+-------------------+----------------+
| uid          | int(11)     | NO   | PRI | NULL              | auto_increment |
| user_uid     | int(11)     | NO   |     | NULL              |                |
| subscribe_id | varchar(32) | NO   |     | NULL              |                |
| start_month  | int(11)     | NO   |     | 201301            |                |
| end_month    | int(11)     | NO   |     | 201301            |                |
| create_date  | timestamp   | NO   |     | CURRENT_TIMESTAMP |                |
+--------------+-------------+------+-----+-------------------+----------------+
6 rows in set (0.00 sec)
*/

function init_subscribe($user_uid, $subscribe_id, $start_month, $end_month)
{
	$sql =	" insert into product_subscribe ".
		" (user_uid, subscribe_id, start_month, end_month, active ) ".
		" values ".
		" ('".$user_uid."','".$subscribe_id."','".$start_month."','".$end_month."','1') ";
	$result = query($sql);
	return mysqli_num_rows($result);
}

function un_subscribe($user_uid, $subscribe_id)
{
	$sql = " update product_subscribe ".
		" set active = '0' where subscribe_id = '".$subscribe_id."' ".
		" and user_uid = '".$user_uid."'";
	$result = query($sql);
        return mysqli_num_rows($result);
}

function update_subscribe($user_uid, $subscribe_id, $start_month, $end_month)
{
        $sql = " update product_subscribe ".
                " set start_month = '".$start_month."', ".
		" end_month = '".$end_month."' ". 
		" where subscribe_id = '".$subscribe_id."'  ".
                " and user_uid = '".$user_uid."'";
        $result = query($sql);
        return mysqli_num_rows($result);
}





function get_alluser_product_stat($product_id, $yyyymm)
{

	$sql =	" select * from score_stat 
		  where a.product_id = '".$a.product_id."'
		  and stat_month = '".$yyyymm."'";
       $result = query($sql);
        $ar = array();
        if(mysqli_num_rows($result)>0)
        {
                $row = mysqli_fetch_object($result);
                $ar = array( 
                        'product_id' => $row->product_id,
                        'score_sum' => $row->score_sum,
                        'score_count' => $row->score_count,
                        'stat_month' => $row->stat_month
                        );
        }
        return $ar;

}

function get_alluser_category_stat($category_id, $yyyymm)
{
	$sql =	" select a.*,b.category_id from score_stat a, product b 
		  where a.product_id = b.id 
		  and b.category_id = '".$category_id."'
		  and a.stat_month = '".$yyyymm."'";
	$result = query($sql);
	$ar = array();
	if(mysqli_num_rows($result)>0)
	{
		$row = mysqli_fetch_object($result);
		$ar = array( 
			'category_id' => $row->category_id,
			'score_sum' => $row->score_sum,
			'score_count' =>$row->score_count,
		        'stat_month' => (string)$row->stat_month
			);
	}
	else
	{
		$ar = array(
                        'category_id' => $category_id,
                        'score_sum' => '0',
                        'score_count' => '1',
                        'stat_month' => (string)$yyyymm
                        );
	}
	return $ar;
}	

function get_user_product_stat($user_uid, $product_id, $yyyymm)
{

        $yyyy = substr($yyyymm,0,4);
        $mm = substr($yyyymm,4,2);
        if(substr($mm,0,1)=="0") $mm=substr($mm,1,1);
        $sql = " select avg(score) 
                 from score
                 where user_uid = '".$user_uid."'  
                 and year(record_time)= ".$yyyy." 
                 and month(record_time)= ".$mm."
                 and product_id = '".$product_id."'";
	$result = query($sql);
        $ar = array();   
        if(mysqli_num_rows($result)>0)
        {
                $row = mysqli_fetch_array($result);
                $ar = array(
                        'product_id' => $product_id,
                        'average' => $row[0],
                        'stat_month' => (string)$yyyymm
                        );
        }
	else
	{
		$ar = array(
                        'product_id' => $product_id,
                        'average' => 	'0',
                        'stat_month' => (string)$yyyymm
                        );
	}
        return $ar;

}


function get_user_category_stat($user_uid, $category_id, $yyyymm)
{
	$yyyy = substr($yyyymm,0,4);
	$mm = substr($yyyymm,4,2);
	if(substr($mm,0,1)=="0") $mm=substr($mm,1,1);
	$sql = " select avg(a.score) 
		 from score a, product b
		 where user_uid = '".$user_uid."'  
		 and year(a.record_time)= ".$yyyy." 
		 and month(a.record_time)= ".$mm."
		 and a.product_id = b.id
		 and b.category_id = '".$category_id."'"; 
        $result = query($sql);
        $ar = array();
        if(mysqli_num_rows($result)>0)
        {
                $row = mysqli_fetch_array($result);
                $ar = array(
                        'category_id' => $category_id,
                        'average' => (($row[0]==null)?'0':(string)$row[0]),
                        'stat_month' => (string)$yyyymm
                        );
        }
        return $ar;
}
?>
