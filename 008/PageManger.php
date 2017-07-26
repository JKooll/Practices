<?php
/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/7/27
 * Time: 21:10
 */
include_once 'include.php';
$in = new MyInclude();
$in->includeAllFile();

if( isset( $_GET[ 'type' ] ) ){
    $classname = $_GET[ 'type' ].'Controller';
    if( !class_exists( $classname ) ){
        echo "type出错";
        exit();
    }
    $reflection = new ReflectionClass( $classname );
    if( $reflection->isInstantiable() ){
        $instance = $reflection->newInstance();
    }else{
        echo "等会，我再找找，怎么丢了呢... ";
    }
}else{
    echo "等会，我再找找，怎么丢了呢... ";
}
