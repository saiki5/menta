<?php
// Post.php
// 1つの投稿を表すクラス（箱）の定義

use Carbon\Carbon; // Carbonを使うため（autoload を index.php で読み込みます）

class Post
{
    // プロパティ（外から直接いじれないように private にする）
    private $id;
    private $name;
    private $content;
    private $created_at;

    // コンストラクタ：新しい Post を作るときに初期値を入れるよ
    public function __construct($id, $name, $content, $created_at)
    {
        $this->id         = (int)$id;
        $this->name       = $name;
        $this->content    = $content;
        $this->created_at = $created_at; // 文字列形式の日時（例: "2025-09-19 12:34:56"）
    }

    // ゲッターメソッド（外から見るための窓）
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        // XSS対策：そのまま出すと危ないのでエスケープする
        return htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
    }

    public function getContent()
    {
        // 改行を <br> にして、HTML特殊文字を安全に出す
        return nl2br(htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8'));
    }

    public function getCreatedAt()
    {
        // 生の日時文字列がほしいとき用
        return $this->created_at;
    }

    public function getCreatedAtForHumans()
    {
        // Carbon を使って「5分前」「2日前」など人間にわかりやすい形式で返す
        try {
            return Carbon::parse($this->created_at)->diffForHumans();
        } catch (Exception $e) {
            // 何か問題があったら生の文字列を返す
            return $this->created_at;
        }
    }
}
