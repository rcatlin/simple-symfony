<?php

namespace RCatlin\Blog\Controller\Api;

use League\Fractal\Scope;
use RCatlin\Blog\Behavior;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Serializer;

abstract class AbstractArticleController
{
    use Behavior\ReadsRequestContent;
    use Behavior\RenderError;
    use Behavior\RenderResponse;

    /**
     * @var Serializer\ScopeBuilder
     */
    private $scopeBuilder;

    /**
     * @param Serializer\ScopeBuilder $scopeBuilder
     */
    public function __construct(Serializer\ScopeBuilder $scopeBuilder)
    {
        $this->scopeBuilder = $scopeBuilder;
    }

    /**
     * @param Entity\Article $article
     *
     * @return Scope
     */
    protected function getArticleScope(Entity\Article $article)
    {
        return $this->scopeBuilder->buildItem(Entity\Article::class, $article);
    }

    /**
     * @param Entity\Article[] $articles
     *
     * @return Scope
     */
    protected function getArticlesScope(array $articles)
    {
        return $this->scopeBuilder->buildCollection(Entity\Article::class, $articles);
    }
}