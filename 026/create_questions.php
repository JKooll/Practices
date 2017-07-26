<?php
include_once "vendor/autoload.php";

class CreateQuestions extends Common
{
    private $page = "view/create_questions_page.php";
    private $db_table = "questions";

    public function __construct()
    {
        parent::__construct();
        CreateTable::create($this->db());
    }

    protected function get()
    {
        return $this->view($this->page);
    }

    protected function post()
    {
        //验证用户提交
        if (!$this->validate()) {
            $data["status"]["code"] = "error";
            $data["status"]["content"] = "问题创建失败";
            return $this->view($this->page, $data);
        }

        //保存问题
        $author = $_POST['author'];
        $email = $_POST['email'];
        $question_content = $_POST['question_content'];
        $question_title = $_POST['question_title'];
        $date = date('Y-m-d H:i:s');
        $db = $this->db();
        $db->insert($this->db_table, [
            'author' => $author,
            'email' => $email,
            'title' => $question_title,
            'content' => $question_content,
            'date' => $date
        ]);
        $data["status"]["code"] = "success";
        $data["status"]["content"] = "问题\"{$question_title}\"创建成功,<a href='questions.php'>返回问题列表</a>";
        return $this->view($this->page, $data);
    }

    protected function error()
    {
        echo "<h1>error</h1>";
    }

    private function validate()
    {
        if (empty($_POST["question_title"]) ||
            empty($_POST["author"]) ||
            empty($_POST["email"]) ||
            empty($_POST["question_content"])
        ) {
            return false;
        }
        return true;
    }

    public function test()
    {
        $db = $this->db();
    }
}

$createquestions = new CreateQuestions();
$createquestions->process();
//$createquestions->test();
