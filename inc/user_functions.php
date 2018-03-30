<?php

//("inc_db.php");


class MyUser
{
	public $id;
	public $uid;
	public $first_name;
	public $last_name;
	public $email;
	public $credit;
	public $image_url;
	public $token;
	public $perm;
	public $admin = false;
	public $age;
	public $epaper;

	function login($_EMAIL,$_PASS)
	{
		$_EMAIL = strtolower($_EMAIL);
		$this->resetCuser();
		if(func_num_args()==2)
		{
			if($this->admin)
			{
				$sql = "select uid from admin where email ='".$_EMAIL."' and password= '".$_PASS."'";
			}
			else
			{
//				$sql = "SELECT uid from member where email ='".$_EMAIL."' and password= md5(lower('".$_PASS."'))";
				$sql = "SELECT uid from member where (email ='".$_EMAIL."' or cellphone ='".$_EMAIL."') and password= md5(lower('".$_PASS."'))";
			}
			$result = M()->find($sql);
			if($result==null) return -1;
			if(empty($result))
			{
				return -1;
			}
			else
			{
				$this->uid = $result['uid'];
				$this->getUserToken();
				return $this->uid;
			}

		}
		else
		{
			return -1;
		}

	}

	function login_phone($_PHONE)
	{
		$_PHONE = int($_PHONE);
		$this->resetCuser();
		if(func_num_args()==2)
		{
			if($this->admin)
			{
				$sql = "select uid from admin where cellphone ='".$_PHONE."'";
			}
			else
			{
				$sql = "SELECT uid from member where (cellphone ='".$_PHONE."')";
			}
			$result = M()->find($sql);
			if($result==null) return -1;
			if(empty($result))
			{
				return -1;
			}
			else
			{
				$this->uid = $result['uid'];
				$this->getUserToken();
				return $this->uid;
			}

		}
		else
		{
			return -1;
		}

	}

    function login_wx($_OPENID)
    {
        $this->resetCuser();
        if(func_num_args()==2)
        {
            if($this->admin)
            {
                $sql = "select uid from admin where wx_openid ='".$_OPENID."'";
            }
            else
            {
                $sql = "SELECT uid from member where wx_openid ='".$_OPENID."'";
            }
            $result = M()->find($sql);
            if($result==null) return -1;
            if(empty($result))
            {
                return -1;
            }
            else
            {
                $this->uid = $result['uid'];
                $this->getUserToken();
                return $this->uid;
            }

        }
        else
        {
            return -1;
        }

    }

	function exist($_EMAIL)
	{
		$_EMAIL = strtolower($_EMAIL);
		if(isset($_EMAIL))
		{
			$sql = "select count(*) from member where email ='".$_EMAIL."'";
			$result = query($sql);
			if($row=mysql_fetch_row($result))
			{
				if($row[0]==1) return true;
				else return false;
			}
		}
		else
		{
			return false;
		}
	}

	function register($_EMAIL, $_PASS, $_FNAME, $_LNAME, $_PHONE,$_CITY)
	{
		$_EMAIL = strtolower($_EMAIL);
		if(!$this->exist( $_EMAIL ))
		{

			$sql = "INSERT INTO member (`id`, password, first_name, last_name, cellphone, email,city) VALUES ('".$_EMAIL."',md5(lower('".$_PASS."')),'".$_FNAME."','".$_LNAME."','".$_PHONE."','".$_EMAIL."','".$_CITY."')";
			$result = query($sql);

			if($this->login($_EMAIL, $_PASS) == -1)
			{
				return false;
			}
			else
			{
				$this->getUserInfo();
				return true;
			}
		}
		else
		{
			return false;
		}

	}



	function getUserInfo()
	{
		if($this->admin)
			$sql = "select * from admin where uid = '".$this->uid."'";
		else
			$sql = "select * from member where uid = '".$this->uid."'";
		$result = M()->find($sql);
			if(!empty($result))
			{
				$this->id 		= $result['id'];
				$this->first_name	= $result['first_name'];
				$this->last_name	= $result['last_name'];
				$this->email		= $result['email'];
				$this->credit		= $result['credit'];
				$this->image_url	= $result['image_url'];
				$this->cellphone	= $result['cellphone'];
				$this->epaper		= $result['epaper'];
			}

	}

	function getUserId(){
		return $this->accessFromToken($_SESSION['user_token']);
	}
	function getUserToken()
	{
		if($this->token == null)
		{
			$this->token = generateFullTokenNew($this->uid);
		}
		elseif($this->verifyToken()==-1)
		{
			$this->token = generateFullTokenNew($this->uid);
		}
		return $this->token;
	}

	function verifyToken()
	{
		return verifyTokenNew($this->token);
	}

	function accessFromToken($token)
	{
		$this->resetCuser();
		if(verifyTokenNew($token)==1)
		{
			$this->token = $token;
			$this->uid = calUidFromToken($this->token);
			return $this->uid;
		}
		else
			return -1;
	}

	function resetCuser()
	{
		$this->id 		= null;
		$this->uid 		= null;
		$this->first_name 	= null;
		$this->last_name 	= null;
		$this->email 		= null;
		$this->credit 		= null;
		$this->image_url 	= null;
		$this->token 		= null;
	}

	function getCredit()
	{
		$sql = "select credit from member where uid = '".$this->uid."'";
		$result = query($sql);
		if($result!=null)
		{
			if(mysql_num_rows($result)==1)
			{
				$obj = mysql_fetch_object($result);
				$this->credit           = $obj->credit;
				return $this->credit;
			}
			else return -1;
		}
		else return -1;
	}

	function addCredit($points)
	{
		$this->getCredit();
		if( ( $points > 0 ) || ($this->credit + $points >0))
		{
			$sql = " update member set credit = credit + (".$points.") where uid = '".$this->uid."'";
			query($sql);
			return $this->getCredit();
		}
		else return -1;
	}

	function getUserAge()
	{
		if(isset($this->uid))
		{
			$sql = " select birth_day from user where uid = '".$this->uid."'";
			$result = query($sql);
			if($row = mysql_fetch_object($result))
			{
				$sec = abs(strtotime(date("Ym")) - strtotime($row->birth_day));
				$year = (int)($sec/(365.5*60*60*24));
				$month = (int)(($sec%(365.5*60*60*24))/(30*60*60*24));
				$this->age = $year.".".$month;
				return $this->age;
			}
			else
				return -1;

		}
		else
			return -1;
	}

	function getPerm()
	{
		if($this->admin)
		{
			$sql = " select perm from admin where uid = '".$this->uid."'";
			$result=query($sql);
			if($result)
			{
				$row=mysql_fetch_object($result);
				$this->perm=$row->perm;
			}
			else
				$this->perm=0;
			return $this->perm;
		}
		else
			return -1;
	}

	function getUserAgeByMemberUid()
	{
		if(isset($this->uid))
		{
			$sql = " select birth_day from user where uid = ( select max(uid) as uid from member where uid ='".$this->uid."') ";
			$result = query($sql);
			if($row = mysql_fetch_object($result))
			{
				$sec = abs(strtotime(date("Ym")) - strtotime($row->birth_day));
				$year = (int)($sec/(365.5*60*60*24));
				$month = (int)(($sec%(365.5*60*60*24))/(30*60*60*24));
				$this->age = $year.".".$month;
				return $this->age;
			}
		}
		return -1;

	}

	function getUserAgeByMemberUidInMonths() {
		if(isset($this->uid))
		{
			$sql = " select birth_day from user where uid = ( select max(uid) as uid from member where uid ='".$this->uid."') ";
			$result = query($sql);
			if($row = mysql_fetch_object($result))
			{
				$birthday = new DateTime($row->birth_day);
				$diff = $birthday->diff(new DateTime());
				$months = $diff->format('%m') + 12 * $diff->format('%y');
				$days = $diff->format('%d');
				if($days >= 15)
					$months += 0.5;
				return $months;
			}
		}
		return -1;
	}

	function getKidsUidArray() {
		$arr = array();
		if(isset($this->uid))
		{
			$sql = "select uid from user where supervisor_uid='".$this->uid."'";
			$result = query($sql);
			while($row=mysql_fetch_array($result)) {
				$arr[] = $row['uid'];
			}
		}
		return $arr;
	}

	function cleanUserScoreByMemberUid()
	{
		if(isset($this->uid))
		{
			$sql = " delete from score where uid = ( select max(uid) as uid from member where uid ='".$this->uid."') ";
			query($sql);
		}
	}

	function cleanUserScore()
	{
		if(isset($this->uid))
		{
			$sql = " delete from score where uid = '".$this->uid."' ";
			query($sql);
		}
	}
}

$CMEMBER = new MyUser();
$CUSER = new MyUser();
$CADMIN = new MyUser();
?>
