<?php

namespace YannLo\Agl\Modules\Examples\Apps;

/**
 * Article
 *
 * Basic article class Example Module
 */
class Article
{
    use \YannLo\Agl\Modules\Tools\App\Hydration;

    private int $id;
    private string $title;
    private string $slug;
    private string $content;


    public function __construct(array $data = [])
    {
        $this -> hydrate($data);
    }

    // GETTERS
    public function id(): int
    {
        return $this -> id;
    }

    public function title(): string
    {
        return $this -> title;
    }

    public function slug(): string
    {
        return $this -> slug;
    }

    public function content(): string
    {
        return $this -> content;
    }

    // SETTERS
    public function setid(int $id): void
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('id is not negative or null');
            return;
        }

        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        if (strlen($title) <= 3) {
            throw new \InvalidArgumentException('title is more short');
            return;
        }

        $this->title = $title;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
