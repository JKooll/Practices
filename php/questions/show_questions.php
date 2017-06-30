<?php
include_once "vendor/autoload.php";

class ShowQuestions extends Common
{
    private $questions_table = "questions";
    private $answers_table = "answers";
    private $page = "view/show_questions_page.php";

    public function __construct()
    {
        parent::__construct();
        CreateTable::create($this->db());
    }

    public function get($id = -1, $data = [])
    {
        if ($id == -1) {
            $id = isset($_GET['id']) ? $_GET['id'] : -1;
        }
        if ($id == -1) {
            return $this->error();
        }
        $db = $this->db();
        if (!$db->has($this->questions_table, ["id" => $id])) {
            return $this->error();
        }
        $question = $db->get($this->questions_table,"*", ["id" => $id]);
        $data['question'] = $question;
        $answers = $db->select($this->answers_table, "*", ["question_id" => $id]);
        $data['answers'] = $answers;
        return $this->view($this->page, $data);
    }

    public function post()
    {
        $id = isset($_POST['question_id']) ? $_POST['question_id'] : -1;
        $author = $_POST['author'];
        $email = $_POST['email'];
        $content = $_POST['content'];
        $date = date('Y-m-d H:i:s');
        $db = $this->db();
        $db->insert($this->answers_table, [
            'author' => $author,
            'email' => $email,
            'question_id' => $id,
            'content' => $content,
            'date' => $date
        ]);
        $data['status']['code'] = 'success';
        $data['status']['content'] = '回答添加成功';
        return $this->get($id, $data);
    }

    public function error()
    {
        return $this->view("view/404.html");
    }
}

$showquestions = new ShowQuestions();
$showquestions->process();
