<?php

namespace RCatlin\Blog\Test\Unit\Controller\Api;

use Doctrine\ORM\EntityManager;
use RCatlin\Blog\Controller;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class ArticleDeleteControllerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;

    public function testDelete()
    {
        $id = $this->getFaker()->randomNumber();

        $article = $this->getMockArticle();

        $entityManager = $this->getMockEntityManager();
        $entityManager->expects($this->once())
            ->method('remove')
            ->with($article)
        ;
        $entityManager->expects($this->once())
            ->method('flush')
        ;

        $articleRepository = $this->getMockArticleRepository();
        $articleRepository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($article)
        ;

        $controller = new Controller\Api\ArticleDeleteController($entityManager, $articleRepository);

        $response = $controller->delete(new Request(), new Response(), ['id' => $id]);

        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testDeleteWithBadId()
    {
        $id = $this->getFaker()->randomNumber();

        $articleRepository = $this->getMockArticleRepository();
        $articleRepository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(null)
        ;

        $controller = new Controller\Api\ArticleDeleteController($this->getMockEntityManager(), $articleRepository);

        $response = $controller->delete(new Request(), new Response(), ['id' => $id]);

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EntityManager
     */
    private function getMockEntityManager()
    {
        return $this->buildMock(EntityManager::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Repository\ArticleRepository
     */
    private function getMockArticleRepository()
    {
        return $this->buildMock(Repository\ArticleRepository::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Article
     */
    private function getMockArticle()
    {
        return $this->buildMock(Entity\Article::class);
    }
}
