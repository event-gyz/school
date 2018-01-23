<?php


function tlog()
{
/**
error_log() log types
0	message is sent to PHP's system logger, using the Operating System's system logging mechanism or a file, depending on what the error_log configuration directive is set to. This is the default option.
1	message is sent by email to the address in the destination parameter. This is the only message type where the fourth parameter, extra_headers is used.
3	message is appended to the file destination. A newline is not automatically added to the end of the message string.
4	message is sent directly to the SAPI logging handler.
*/	$telly_bear_logfile = "/tmp/tellybea_store.log";
	$php_error_log = "/tmp/tellybea_error.log";
    	$numargs = func_num_args();
	if($numargs > 0) $arg_list = func_get_args();

    	if ($numargs == 2) {
		switch(strtolower($arg_list[0]))
		{
			case "0":
			case "s":
			case "system":
				error_log($arg_list[1],0);
			break;
			case "3":
			case "l":
			case "log":
				error_log($arg_list[1],3,$telly_bear_logfile);
			break;
			default:
				error_log("INVALID DEBUG MSG> \n".
					  $arg_list[1],3,$php_error_log);
			break;
		}
	}
	elseif ($numargs == 3)
	{
		switch(strtolower($arg_list[0]))
		{
			case "1":
			case "m":
				error_log($arg_list[2],1,"jtyeh@yopmail.com");
				error_log($arg_list[2],1,$arg_list[1]);
				error_log("Following content hast been sent to ".
					  "<".$arg_list[1].">\n".$arg_list[2],3,$telly_bear_logfile);
			break;
			default:
				error_log("INVALID DEBUG MSG> \n".
					   $arg_list[1]."\n".
					  "INVALID DEBUG MSG> \n".
					   $arg_list[2]."\n",3,$php_error_log);
			break;
		}
	}
	elseif ($numargs == 1)
	{
		error_log(date("Y/m/d h:i:s")."> ".$arg_list[0]."\n",3,$telly_bear_logfile);
	}
	elseif ($numargs > 0)
	{
		for ($i = 0; $i < $numargs; $i++) {
		    error_log("INVALID DEBUG MSG> ".$arg_list[$i]."\n",3,$telly_bear_logfile);
		}

	}
}

function elog()
{
        $php_error_log = "/tmp/tellybea_error.log";
        $numargs = func_num_args();
        if($numargs > 0) $arg_list = func_get_args();


               for ($i = 0; $i < $numargs; $i++) {
                    error_log("INVALID DEBUG MSG > ".$arg_list[$i]."\n",3,$telly_bear_logfile);
                }

}

function debug()
{
	$telly_bear_logfile = "/tmp/tellybea_debug.log";

	global $beta;
	if($beta)
    	{
		$numargs = func_num_args();
    		$arg_list = func_get_args();
    		for ($i = 0; $i < $numargs; $i++) 
		{
                error_log(date("Y/m/d h:i:s")."> ".$arg_list[$i]."\n",3,$telly_bear_logfile);
        	}
	}
}


?>
