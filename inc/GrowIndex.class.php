<?php

class GrowIndex {
	
	public static $arr_uid, $arr_type, $arr_text, $arr_age_min, $arr_age_max;
	
	public $arr_learned_uid, $arr_learned_time, $arr_learned_early;
	
	function loadItems() {
		if(null === self::$arr_uid) {
//echo('!!!really loading!!!!');
			self::$arr_uid = array();
			self::$arr_type = array();
			self::$arr_text = array();
			self::$arr_age_min = array();
			self::$arr_age_max = array();
			$sql = "SELECT `uid` ,  `type` ,  `text` ,  `age_min` ,  `age_max` FROM grow_index ORDER BY age_min";
			$result = query($sql);
			
			$datas = array();
			
			while($row = mysqli_fetch_array($result)) {
				self::$arr_uid[] = $row['uid'];
				self::$arr_type[] = $row['type'];
				self::$arr_text[] = $row['text'];
				self::$arr_age_min[] = $row['age_min'];
				self::$arr_age_max[] = $row['age_max'];
				/*
				$ar = array(
				$row['uid'],
				$row['type'],
				$row['text'],
				$row['age_min'],
				$row['age_max']
				);
				
				$datas[] = $ar;
				*/
			}
			
			//echo(json_encode($datas));
		}
		return count(self::$arr_uid);
	}
	
	// TEST... no faster then SQL!
	function loadItemsFromFile() {
		$jsonstr = file_get_contents('../content/gi/prerendered.json');
		$json = json_decode($jsonstr);

		self::$arr_uid = array();
		self::$arr_type = array();
		self::$arr_text = array();
		self::$arr_age_min = array();
		self::$arr_age_max = array();

		foreach($json as $jo) {
		self::$arr_uid[] = $jo[0];
		self::$arr_type[] = $jo[1];
		self::$arr_text[] = $jo[2];
		self::$arr_age_min[] = $jo[3];
		self::$arr_age_max[] = $jo[4];
		}
		return count($json);
	}
	
	function loadLearnedItems($user_uid) {
		if(isset($this->arr_learned_uid)) unset($this->arr_learned_uid);
		if(isset($this->arr_learned_time)) unset($this->arr_learned_time);
		if(isset($this->arr_learned_early)) unset($this->arr_learned_early);

		$this->arr_learned_uid = array();
		$this->arr_learned_time = array();
		$this->arr_learned_early = array();
		
		$sql = "SELECT item_uid,log_time,early FROM grow_log WHERE user_uid='$user_uid' ORDER BY item_uid";
		$result = query($sql);
		while($row = mysqli_fetch_array($result)) {
			$this->arr_learned_uid[] = $row['item_uid'];
			$this->arr_learned_time[] = $row['log_time'];
			$this->arr_learned_early[] = $row['early'];
		}
		return count($this->arr_learned_uid);
	}
	
	function getAllItemsByAge($user_uid, $age_min, $age_max,$show_flag=0) { // show_flag: 0 all, 1 learned, 2 unlearned
		if(!isset($this->arr_learned_uid)) 
			$this->loadLearnedItems($user_uid);
		$ret = array();
		$count = count(self::$arr_uid);
		$idx = 0;//array_search($age_min,self::$arr_age_min);
		if($idx !== FALSE) {
			for($i = $idx; $i < $count; $i++) {
				if(self::$arr_age_min[$i] > $age_max)
					break;
				if(	(($age_min <= self::$arr_age_min[$i]) && ($age_max >= self::$arr_age_max[$i])) 
					||(($age_min >= self::$arr_age_min[$i]) && ($age_min <= self::$arr_age_max[$i]))
					||(($age_max <= self::$arr_age_max[$i]) && ($age_max >= self::$arr_age_min[$i]))
					) {
					$learned_idx = array_search(self::$arr_uid[$i],$this->arr_learned_uid);
					if($learned_idx!==FALSE) {
						$learned = TRUE;
						$learned_time = $this->arr_learned_time[$learned_idx];
						$learned_early = $this->arr_learned_early[$learned_idx];
					}
					else {
						$learned = FALSE;
						$learned_time = 0;
						$learned_early = FALSE;
					}
					if(($show_flag == 0) || ($show_flag==1 && $learned) || ($show_flag==2 && !$learned)) {
						$item = array(
							'uid' => self::$arr_uid[$i],
							'type' => self::$arr_type[$i],
							'text' => self::$arr_text[$i],
							'age_min' => self::$arr_age_min[$i],
							'age_max' => self::$arr_age_max[$i],
							'learned' => $learned,
							'time' => $learned_time,
							'early' => $learned_early
							);
						$ret[] = $item;
					}
				}
			}
		}
		return $ret;//json_encode($ret);
	}

	//---- sql ----//
	function getLearnedItemsSQL($user_uid, $age_min, $age_max) {
		$sql = "SELECT * FROM grow_index WHERE (age_min >= '$age_min') AND (age_max <= '$age_max') AND uid in (SELECT item_uid FROM grow_log WHERE user_uid='$user_uid')";
		$result = query($sql);
		$ret = array();
		while($row = mysqli_fetch_array($result)) {
			$item = array(
			'uid' => $row['uid'],
			'type' => $row['type'],
			'text' => $row['text'],
			'age_min' => $row['age_min'],
			'age_max' => $row['age_max']
			);
			$ret[] = $item;
		}
		return json_encode($ret);
	}

	function getUnlearnedItemsSQL($user_uid, $age_min, $age_max) {
		$sql = "SELECT * FROM grow_index WHERE (age_min >= '$age_min') AND (age_max <= '$age_max') AND uid not in (SELECT item_uid FROM grow_log WHERE user_uid='$user_uid')";
		$result = query($sql);
		$ret = array();
		while($row = mysqli_fetch_array($result)) {
			$item = array(
			'uid' => $row['uid'],
			'type' => $row['type'],
			'text' => $row['text'],
			'age_min' => $row['age_min'],
			'age_max' => $row['age_max']
			);
			$ret[] = $item;
		}
		return json_encode($ret);
	}
	
	function setLearnedSQL($user_uid, $user_age, $item_uid, $is_learned) {
		if(!$is_learned) {
			$sql = "DELETE FROM grow_log WHERE user_uid='$user_uid' AND item_uid='$item_uid'";
			$result = query($sql);
			return mysqli_affected_rows();
		}
		else {
			$idx = array_search($item_uid, $arr_uid);
			if($idx !== FALSE) {
				$is_early = ($user_age < self::$arr_age_min[$idx]);
				$sql = "INSERT INTO grow_log (user_uid, item_uid, early) values ('$user_uid','$item_uid','$is_early') on duplicate key update item_uid=item_uid";
				$result = query($sql);	
				return mysqli_affected_rows();
			}
		}
		return 0;
	}
	
	static function getMore($uid) {
		$sql = "SELECT text,detail,advice,image_file FROM grow_index WHERE uid='$uid'";
        $row = M()->find($sql);
		if(!empty($row)) {
			$text = $row['text'];
			$detail = $row['detail'];
			$advice = $row['advice'];
			$image_file = $row['image_file'];
			if(!stripos($image_file,".png"))
				$image_file .= ".png";
			return array($text,$detail,$advice,$image_file);			
		}
	}


	
	//-- HTML formatting output --//
	static function output_more($uid,$type) {
		$data = self::getMore($uid);
		$title = ($type==0?'详细说明':'医生建议');
		$h3 = $data[0];
		$content = $data[1+$type];
		echo('<section class="fy-hd"><h2 class="title">'.$title.'</h2></section>');
		echo('<section class="fy-bd clearfix">');
		echo('<h3 class="title">'.$h3.'</h3>');
		echo('<section class="Txt clearfix"><p>'.$content.'</p><p  align="center"><img src="../content/gi/'.$data[3].'?a='.mt_rand().'" align="middle"></p></section>');
		echo('<section class="gotop divtop"><img src="../theme/cn/images/content/item_gotop02.png">回顶端</section>');
		echo('</section>');
	}
	
	function output_li($uid, $text, $is_learned, $is_early, $is_late) {
		echo('<li'); 
		if($is_early)
			echo(' class="pass" ');
		elseif($is_late) {
			echo(' class="late" ');
		}
		echo('>');
		echo('<i><img src="../theme/cn/images/content/item_rep01.jpg"></i>');
		echo('<label>');
		echo('<input type="checkbox" class="ck" ');
		if($is_learned) {
			echo('checked');
		}
		echo('>');
		echo("<span>$text</span>");
		echo("</label>");
		echo('<div class="tablinks">');
		echo("<a name='$uid' value='0' href='javascript:void(0)'><img src='../theme/cn/images/content/item_rep02.jpg'></a>");
		echo("<a name='$uid' value='1' href='javascript:void(0)'><img src='../theme/cn/images/content/item_rep03.jpg'></a>");
		echo('</div>');
		echo('</li>');
	}
/*	
	function output_by_age($age) {
		$year = $age / 12;
		$month = $age % 12;
		echo("<tr><th width='18%' rowspan='6'><div><b>".$year."歲</b>".$month."個月</div></th>");
		echo('<td width="17%" class="title"><div>认知</div></td>');
		                                	
                                    	
                                        
                                        <td width="65%">
                                        	<ul class="clearfix">
                                            	<li class="pass">
                                                    <i><img src="../theme/cn/images/content/item_rep01.jpg"></i>
                                                    <label>
                                                        <input type="checkbox" class="ck" value="1">
                                                        <span>題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字</span>
                                                    </label>
                                                    <div class="tablinks">
                                                    	<a href="javascript:loadGIDetail(1,0)" class="fancybox"><img src="../theme/cn/images/content/item_rep02.jpg"></a>
                                                        <a href="javascript:loadGIDetail(1,1)" class="fancybox"><img src="../theme/cn/images/content/item_rep03.jpg"></a>
                                                	</div>
                                                </li>
                                                <li class="out">
                                                    <i><img src="../theme/cn/images/content/item_rep01.jpg"></i>
                                                    <label>
                                                        <input type="checkbox" class="ck" value="2">
                                                        <span>題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字</span>
                                                    </label>
                                                    <div class="tablinks">
                                                    	<a href="#reportbox01" class="fancybox"><img src="../theme/cn/images/content/item_rep02.jpg"></a>
                                                        <a href="#reportbox02" class="fancybox"><img src="../theme/cn/images/content/item_rep03.jpg"></a>
                                                	</div>
                                                </li>
                                                <li>
                                                    <i><img src="../theme/cn/images/content/item_rep01.jpg"></i>
                                                    <label>
                                                        <input type="checkbox" class="ck">
                                                        <span>題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字</span>
                                                    </label>
                                                    <div class="tablinks">
                                                    	<a href="#reportbox01" class="fancybox"><img src="../theme/cn/images/content/item_rep02.jpg"></a>
                                                        <a href="#reportbox02" class="fancybox"><img src="../theme/cn/images/content/item_rep03.jpg"></a>
                                                	</div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title"><div>语言</div></td>
                                        <td>
                                        	<ul class="clearfix">
                                            	<li>
                                                    <i><img src="../theme/cn/images/content/item_rep01.jpg"></i>
                                                    <label>
                                                        <input type="checkbox" class="ck">
                                                        <span>題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字</span>
                                                    </label>
                                                    <div class="tablinks">
                                                    	<a href="#reportbox01" class="fancybox"><img src="../theme/cn/images/content/item_rep02.jpg"></a>
                                                        <a href="#reportbox02" class="fancybox"><img src="../theme/cn/images/content/item_rep03.jpg"></a>
                                                	</div>
                                                </li>
                                                <li class="pass">
                                                    <i><img src="../theme/cn/images/content/item_rep01.jpg"></i>
                                                    <label>
                                                        <input type="checkbox" class="ck">
                                                        <span>題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字題目假字題目題目假字題目假字</span>
                                                    </label>
                                                    <div class="tablinks">
                                                    	<a href="#reportbox01" class="fancybox"><img src="../theme/cn/images/content/item_rep02.jpg"></a>
                                                        <a href="#reportbox02" class="fancybox"><img src="../theme/cn/images/content/item_rep03.jpg"></a>
                                                	</div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
	}
	*/
}

?>