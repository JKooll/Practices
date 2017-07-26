<?php
/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/7/26
 * Time: 11:17
 */
class PagePath
{
    private $path = array(
        'exam' => 'main/view/page/exam.html',
        'test' => 'main/view/page/test.php'
    );

    function getPage( $page )
    {
        if( array_key_exists( $page , $this->path ) ){
            return file_get_contents( $this->path[ $page ] , 1);
        }
    }
}