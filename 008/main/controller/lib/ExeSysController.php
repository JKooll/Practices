<?php
/**
 * loginDB依赖于DBController,view/page/exam,
 * 数据库 ：wechat
 * 表 ： title，isdoing,user_title
 * 暂时不区分用户
 *
 */
class ExeSysController
{
    private $fetch_array_mode = MYSQLI_ASSOC;
    private $action = '';
    private $select = '';
    private $title_id = '';

    function __construct()
    {
       echo $this->run();
    }

    function run()
    {
        if( $action = $this->getParam( 'action' ) ){	
	    return $this->resolve( $action );
        }else{
            return '哈哈哈哈';
        }
    }

    function getParam( $param )
    {
        if( isset( $this->{ $param } ) ){
            if( !empty( $this->{ $param } ) ){
                return $this->{ $param };
            }else{
                if( isset( $_GET[ $param ] ) ){
                    $this->{ $param } = $_GET[ $param ];
                    return $this->{ $param };
                }else{
                    return '';
                }
            }
        }else{
            return FALSE;
        }
    }

    function resolve( $action = '' )
    {
        if( method_exists( 'ExeSysController' , $action ) ){
	    return $this->{$action}();
        }else{
            return"等会，我再找找，怎么丢了呢...";
        }
    }

    function next_title( $title_id = '' )
    {
        if( empty($title_id) ) {
            $title = $this->getRandomTitle();
        }else{
            $title = $this->getTitle( $title_id );
        }

       return  json_encode( $title );
    }

    function answer()
    {
        $select = $this->getParam( 'select' );
        $title_id = $this->getParam( 'title_id');

        $result = $this->checkAnswer( $select , $title_id);
        $content = $result;
        $result_code = 1;
        $detail = '';
        if( is_bool( $result ) ){
            if( !$result ){
                $content = "答案不正确，再试一下！！！<br />";
                $result_code = 0;
            }else{
                $content = "恭喜你答案正确，请进行下一题^-^<br />";
                $result_code = 1;
                $detail = $this->getTitle( $title_id , "detail" )["detail"];
            }
        }else{
            $content = "提交失败，请在试一下！";
        }

        $arr = array( "result_code" => $result_code ,"content" => $content ,"detail" => $detail );
        return json_encode( $arr );
    }

    function uploadTitle( $title , $answer , $detail )
    {
        $db = new DBController();
        $result = $db->insert( "title(title,answer,detail) values('$title','$answer','$detail')" )->get();
        if( !empty( $resutl ) ){
            return $result;
        }else{
            return "上传成功";
        }
    }

    function getTitle( $id , $field = '')
    {
        $select = '*';
        if( !empty( $field ) ){
            $select = $field;
        }
        $db = new DBController();
        $result = $db->table("title")->select($select)->where("id=$id")->get();
        if( !$result ){
            return "查询失败";
        }else{
            return $result->fetch_array( $this->fetch_array_mode );
        }

    }

    function getRandomTitle()
    {
        $db = new DBController();
        $max_id = $db->getMaxID();
        $min_id = $db->getMinID();
        $id = rand( $min_id , $max_id );
        return $this->getTitle( $id );
    }

    function checkAnswer( $select , $title_id )
    {
        $db = new DBController();
        $result = $db->table( 'title' )->select( 'answer' )->where( "id=$title_id" )->get();
        if( $result ){
            $answer = $result->fetch_array( $this->fetch_array_mode )['answer'];

            if( strtolower( $select ) == strtolower( $answer ) ){
                return true;
            }else{
                return false;
            }
        }else{
            return "查询失败,请重试...<br />";
        }
    }



    function show( $rootpage = '' , $title = array() , $examBody = '' )
    {
        echo $this->getPage( $rootpage , $title , $examBody );
    }

    function getPage( $rootpage , $title = array() , $examBody = '' )
    {
        if( !empty( $title ) ) {
            $examBody .= $title[ 'title' ].' <br />';
            $examBody .= '';
        }else{
            $examBody = "查询结果为空";
        }
        $p = new PagePath();
        return sprintf( $p->getPage( "exam" ) , $rootpage , $examBody);
    }


}
