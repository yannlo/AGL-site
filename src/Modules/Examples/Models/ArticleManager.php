<?php

namespace YannLo\Agl\Modules\Examples\Models;

use YannLo\Agl\Modules\Examples\Apps\Article;

class ArticleManager
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function getAll(): array
    {
        $articles = [];

        $query = $this -> pdo ->query("SELECT * FROM articles");
        $result = $query->fetchAll();

        foreach ($result as $article) {
            $articles[] = new Article($article);
        }

        return $articles;
    }

    public function getOnce(int $id): ?Article
    {
        $query = $this -> pdo ->prepare("SELECT * FROM articles WHERE id = :id");

        $query->execute([
            "id" => $id
        ]);

        $result = $query->fetch();

        if (is_null($result)) {
            throw new \InvalidArgumentException("Not found article with this id:" . $id);
            return null;
        }

        $article = new Article($result);
        return $article;
    }
}
