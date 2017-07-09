<?php
header("Content-Type:text/html;charset=utf-8");

if(isset($_REQUEST['authcode'])){
    session_start();
    if(strtolower($_REQUEST['authcode']) == $_SESSION['authcode']){
        echo "输入正确";
    }else{
        echo "输入错误";
    }
    exit();
}
