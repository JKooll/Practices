<?php
/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/7/24
 * Time: 9:33
 * 依赖DBConfig
 */
class DBController
{
    private $dbconfig = '';
    private $db_hostname = '';
    private $db_username = '';
    private $db_password = '';
    private $db_database = '';
    private $port = '';
    private $db_server = '';
    private $table = '';
    private $fetch_array_mode = MYSQLI_NUM;

    private $query = array(
        0 => array(
            'key' => 'select' ,
            'value' => ''
        ),
        1 => array(
            'key' => 'insert into',
            'value' => ''
        ),
        2 => array(
            'key' => 'update',
            'value' => ''
        ),
        3 => array(
            'key' => 'delete',
            'value' => ''
        ),
        4 => array(
            'key' => 'from',
            'value' => ''
        ),
        5 => array(
            'key' => 'where',
            'value' => ''
        ),
        6 => array(
            'key' => 'limit',
            'value' => ''
        )
    );

    function __construct()
    {
      $this->loginDB();
    }

    function getDBConfig()
    {
        $dbconfig = new DBConfig();
        $this->dbconfig = $dbconfig->getDBConfig();

        $this->db_hostname = $this->dbconfig[ ' db_hostname ' ];
        $this->db_username = $this->dbconfig[ ' db_username ' ];
        $this->db_password = $this->dbconfig[ ' db_password ' ];
        $this->db_database = $this->dbconfig[ ' db_database ' ];
        $this->port = $this->dbconfig[ 'port' ];
    }

    function loginDB()
    {
        if( empty( $this->dbconfig ) )
            $this->getDBConfig();

        $db_server = mysqli_connect( $this->db_hostname , $this->db_username ,
            $this->db_password , $this->db_database  );

        if( mysqli_connect_errno() ) {
            die("Unable to connect to MySQL:" . mysqli_connect_error() );
            exit();
        }

        $this->db_server = $db_server;
    }

    function getMaxID()
    {
        $result = $this->table( "title" )->select( "Max(id)" )->get();
        $max_id = $result->fetch_array( $this->fetch_array_mode )[0];
        return $max_id;
    }

    function getMinID()
    {
        $result = $this->table( "title" )->select( "Min(id)" )->get();
        $min_id = $result->fetch_array( $this->fetch_array_mode )[0];
        return $min_id;
    }

    function query( $statment )
    {
        if( $result = $this->db_server->query( $statment ) ){
            return $result;
        }else{
            return FALSE;
        }
    }

    function setQuery( $key , $value)
    {
        for( $i = 0 ; $i < count( $this->query ) ; $i++ ){
            if( $this->query[ $i ][ 'key' ] == $key){
                $this->query[ $i ][ 'value' ] = $value;
            }
        }
    }

    function table( $table = '' )
    {
        $this->table = $table;
        return $this;
    }

    function select( $select = '' )
    {
        $this->setQuery( 'select' , $select );
        $this->setQuery( 'from' , $this->table );
        return $this;
    }

    function insert( $insert = '' )
    {
        $this->setQuery( 'insert' , $this->table . ' ' . $insert );
        return $this;
    }

    function delete( $delete = ' ')
    {
        $this->setQuery( 'delete' , $delete );
        $this->setQuery( 'from' , $this->table );
        return $this;
    }

    function where( $where = '' )
    {
        $this->setQuery( 'where' , $where );
        return $this;
    }

    function limit( $limit = '' )
    {
        $this->setQuery( 'limit' , $limit );
        return $this;
    }

    function get()
    {
        $statment = $this->createStatment();
        return $this->query( $statment );
    }

    function createStatment()
    {
        $statment = '';
        for( $i = 0 ; $i < count( $this->query ) ; $i++ ){
            if( !empty( $this->query[ $i ][ 'value' ] ) ){
                $subarr = $this->query[ $i ];
                $statment .= $subarr[ 'key' ] . ' ' . $subarr[ 'value' ] . ' ';
            }
        }
        return $statment;
    }

    function sanitizeString( $str )
    {
        if( get_magic_quotes_gpc() ){
            $str  = stripcslashes( $str );
        }
        $str = htmlentities( $str );
        $str = strip_tags( $str );
        return $str;
    }

    function sanitizeMySQL( $query )
    {
        $query = $this->db_server->real_escape_string( $query );
        $query = $this->sanitizeString( $query );
        return $query;
    }

    function setFetchArrayMode( $mode = MYSQLI_NUM ){
        $this->fetch_array_mode = $mode;
    }
}
