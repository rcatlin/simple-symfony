<?php

namespace RCatlin\Blog\Behavior;

use Assert\Assertion;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\Response;

trait RenderError
{
    public function renderNotFound(Response $response, $message)
    {
        Assertion::string($message);

        $response->setStatusCode(404);
        $response->setResult(ResourceFactory::result(['message' => $message]));

        return $response;
    }

    public function renderBadRequest(Response $response, $message)
    {
        Assertion::string($message);

        $response->setStatusCode(400);
        $response->setResult(ResourceFactory::result(['message' => $message]));

        return $response;
    }

    public function renderValidationError(Response $response, array $errors)
    {
        $response->setStatusCode(400);
        $response->setResult(ResourceFactory::result(['errors' => $errors]));

        return $response;
    }
}
