<?php
class Article {
    public int $id;
    public string $title;
    public string $content;
    public string $author;
    public string $image_url;
    public string $created_at;

    public function __construct(array $row) {
        $this->id = (int)$row['id'];
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->author = $row['author'] ?? 'Anonim';
        $this->image_url = $row['image_url'] ?? '';
        $this->created_at = $row['created_at'];
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "content" => $this->content,
            "author" => $this->author,
            "image_url" => $this->image_url,
            "created_at" => $this->created_at
        ];
    }
}
