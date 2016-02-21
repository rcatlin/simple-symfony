<?php

namespace RCatlin\Api\Controller\Api;

use Doctrine\ORM\EntityManager;
use RCatlin\Api\ReverseTransformer;
use RCatlin\Api\Serializer;
use RCatlin\Api\Validator;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Teapot\StatusCode;

class ArticleCreateController extends AbstractArticleController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ReverseTransformer\Entity\ArticleReverseTransformer
     */
    private $articleReverseTransformer;

    /**
     * @var Validator\Entity\ArticleValidator
     */
    private $articleValidator;

    /**
     * @param EntityManager                                       $entityManager
     * @param ReverseTransformer\Entity\ArticleReverseTransformer $articleReverseTransformer
     * @param Serializer\ScopeBuilder                             $scopeBuilder
     * @param Validator\Entity\ArticleValidator                   $articleValidator
     */
    public function __construct(
        EntityManager $entityManager,
        ReverseTransformer\Entity\ArticleReverseTransformer $articleReverseTransformer,
        Serializer\ScopeBuilder $scopeBuilder,
        Validator\Entity\ArticleValidator $articleValidator
    ) {
        parent::__construct($scopeBuilder);

        $this->entityManager = $entityManager;
        $this->articleReverseTransformer = $articleReverseTransformer;
        $this->articleValidator = $articleValidator;
    }

    /**
     * @param Request  $request
     * @param ApiResponse $response
     * @param array    $vars
     *
     * @return ApiResponse
     */
    public function create(Request $request, ApiResponse $response, array $vars = [])
    {
        $json = $this->readRequestJson($request);

        if ($json === null) {
            return $this->renderBadRequest($response, 'Bad Request JSON');
        }

        $validationResult = $this->articleValidator->validate($json, Validator\Context::CREATE);

        if ($validationResult->isNotValid()) {
            return $this->renderValidationErrors($response, $validationResult->getMessages());
        }

        $values = $json;

        try {
            $article = $this->articleReverseTransformer->reverseTransform($values);
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        try {
            $this->entityManager->persist($article);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        $scope = $this->getArticleScope($article);

        return $this->renderResult($response, $scope->toArray(), StatusCode::CREATED);
    }
}
