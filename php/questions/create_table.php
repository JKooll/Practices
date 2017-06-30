<?php
include "vendor/autoload.php";

class CreateTable
{
    private static $create_questions_table = "
        CREATE TABLE IF NOT EXISTS questions (
            id int primary key auto_increment,
            title varchar(125),
            content varchar(500),
            author varchar(125),
            email varchar(125),
            date DATETIME
        )";
    private static $create_answers_table = "
        CREATE TABLE IF NOT EXISTS answers (
            id int primary key auto_increment,
            question_id int,
            content varchar(500),
            author varchar(125),
            email varchar(125),
            date DATETIME
        )";

    public static function create($db, $table = '')
    {
        if (empty($table)) {
            $db->query(self::$create_answers_table);
            $db->query(self::$create_answers_table);
            return;
        }
        if (isset(self::$table)) {
            $db->query(self::$table);
        }
    }
}
