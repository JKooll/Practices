<?php
include_once "vendor/autoload.php";

class Questions extends Common
{
    private $page = "view/questions_page.php";
    private $questions_table = "questions";
    private $answers_table = "answers";

    public function __construct()
    {
        parent::__construct();
        CreateTable::create($this->db());
    }

    protected function get()
    {
        $db = $this->db();
        $questions_list = $db->select($this->questions_table, "*");
        for ($i = 0; $i < count($questions_list); $i++) {
            $questions_list[$i]['answers_count'] = $this->answers($questions_list[$i]['id']);
        }
        $data['questions_list'] = $questions_list;
        return $this->view($this->page, $data);
    }

    protected function post()
    {
        return $this->get();
    }

    protected function error()
    {
        return $this->view('view/404.html');
    }

    private function answers($id)
    {
        $db = $this->db();
        return $db->count($this->answers_table, [
            "question_id" => (int)$id
        ]);
    }

    public function test()
    {
        $db = $this->db();
        $questions_list = $db->select($this->questions_table, "*");
        dump($questions_list);
    }
}

$questions = new Questions();
$questions->process();
//$questions->test();
