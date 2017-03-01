<?php
require ("DAL/Helper.php");

$Username = Helper::GetManager()->GetParameterValue('EmailAddress');
$Password = Helper::GetManager()->GetParameterValue('Password');

if ($Username == "mqureshi@ae.ibm.com" && $Password== "namnam") 
{
    setcookie (COOKIENAME, "User",time()+30);
	echo 1;
}
elseif($Username == "pnash@us.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
	echo 1;
}
elseif($Username == "dpcoakle@us.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
	echo 1;
}
elseif($Username == "grazia.ruggiero@it.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
	echo 1;
}
elseif($Username == "jannie.nicolaisen@se.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
	echo 1;
}
elseif($Username == "jsadikovic@us.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
 echo 1;
}
elseif($Username == "jraftery@us.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
 echo 1;
}
elseif($Username == "jafrances@es.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
 echo 1;
}
elseif($Username == "osabitsa@us.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
 echo 1;
}
elseif($Username == "patricia.linss@ch.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
 echo 1;
}
elseif($Username == "moyr@us.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
	echo 1;
}
elseif($Username == "rogerioa@ca.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
	echo 1;
}
elseif($Username == "tmuhanna@us.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
 echo 1;
}
elseif($Username == "surenegi@in.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
 echo 1;
}
elseif($Username == "tahir.virk@uk.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
	echo 1;
}
elseif($Username == "yuew@cn.ibm.com" && $Password== "emptoris") 
{
    setcookie (COOKIENAME, "User",time()+30);
	echo 1;
}
elseif($Username == "cdewitt@us.ibm.com" && $Password== "emptoris")
{
    setcookie (COOKIENAME, "User",time()+30);
        echo 1;
}
elseif($Username == "dkroeber@us.ibm.com" && $Password== "emptoris")
{
    setcookie (COOKIENAME, "User",time()+30);
        echo 1;
}
elseif($Username == "gdaustin@us.ibm.com" && $Password== "emptoris")
{
    setcookie (COOKIENAME, "User",time()+30);
        echo 1;
}
else
{
	echo 0;
}
?>
