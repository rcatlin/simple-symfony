<?php

namespace RCatlin\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Transformer;

class TransformerContainerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Transformer\TransformerContainer::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $this->getContainer()->share(Transformer\TransformerContainer::class);
    }
}