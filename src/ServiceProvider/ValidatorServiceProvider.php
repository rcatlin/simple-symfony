<?php

namespace RCatlin\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Validator;

class ValidatorServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Validator\Entity\ArticleValidator::class,
        Validator\Entity\TagValidator::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Validator\Entity\ArticleValidator::class)
            ->withArgument(Validator\Entity\TagValidator::class)
        ;

        $container->share(Validator\Entity\TagValidator::class);
    }
}
