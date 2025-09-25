<?php
// Post.php
use Carbon\Carbon;

class Post
{
    private $id;
    private $name;
    private $content;
    private $created_at; // Carbonオブジェクトとして保持

    public function __construct($id, $name, $content, $created_at)
    {
        $this->id      = (int)$id;
        $this->name    = $name;
        $this->content = $content;
        $this->created_at = Carbon::parse($created_at);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
    }

    public function getContent()
    {
        return nl2br(htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8'));
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getCreatedAtForHumans()
    {
        try {
            return $this->created_at->diffForHumans();
        } catch (Exception $e) {
            return $this->created_at->toDateTimeString();
        }
    }

    /**
     * 投稿日時を「YYYY年MM月DD日 HH:mm」形式で返すメソッドを追加
     * @return string
     */
    public function getCreatedAtFormatted()
    {
        return $this->created_at->format('Y年m月d日 H:i');
    }
}
