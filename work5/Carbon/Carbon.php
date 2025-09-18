use Carbon\Carbon;

class Post {
    // ... 既存コード ...

    public function getCreatedAtDiff() {
        Carbon::setLocale('ja'); // 日本語化
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
