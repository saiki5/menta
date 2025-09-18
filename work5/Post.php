<?php
class Post {
    private $id;
    private $name;
    private $content;
    private $created_at;

    // コンストラクタ
    public function __construct($id, $name, $content, $created_at) {
        $this->id = $id;
        $this->name = $name;
        $this->content = $content;
        $this->created_at = $created_at;
    }

    // ゲッター
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
    }

    public function getContent() {
        return nl2br(htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8'));
    }

    public function getCreatedAt() {
        return $this->created_at;
    }
}
