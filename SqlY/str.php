<?php
function replace($str){
	/* 点的转义：. ==> u002E 美元符号的转义：$ ==> u0024 乘方符号的转义：^ ==> u005E 左大括号的转义：{ ==> u007B 左方括号的转义：[ ==> u005B 左圆括号的转义：( ==> u0028 竖线的转义：| ==> u007C 右圆括号的转义：) ==> u0029 星号的转义：* ==> u002A 加号的转义：+ ==> u002B 问号的转义：? ==> u003F 反斜杠的转义： ==> u005C \n 回车(\u000a) \t 水平制表符(\u0009) \b 空格(\u0008) \r 换行(\u000d) \f 换页(\u000c) \' 单引号(\u0027) \" 双引号(\u0022) \\ 反斜杠(\u005c) */
	$str = str_replace(array("\\"),"\\u005c",$str);
	$str = str_replace(array('"'),"\\u0022",$str);
	$str = str_replace(array("'"),"\\u0027",$str);
	$str = str_replace(array("\n"),"\\u000a",$str);
	$str = str_replace(array("\r"),"\\u000d",$str);
	return $str;
}
function addslash($str){
	$str = addslashes($str);
	return $str;
}

?>
