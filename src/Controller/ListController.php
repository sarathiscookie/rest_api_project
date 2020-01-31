<?php

namespace App\Controller;

use App\Entity\TreeList;
use App\Repository\TreeListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as Rest;

class ListController extends AbstractFOSRestController
{
    /**
     * @var TreeListRepository
     */

    private $treeListRepository;

    public function __construct(TreeListRepository $treeListRepository, EntityManagerInterface $entityManager)
    {
        $this->treeListRepository = $treeListRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return \FOS\RestBundle\View\View
     */
    public function getListsAction()
    {
        $data = $this->treeListRepository->findAll();

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @param integer $id
     * @return \FOS\RestBundle\View\View
     */
    public function getListAction(int $id)
    {
        $data = $this->treeListRepository->findOneBy(['id' => $id]);

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @Rest\RequestParam(name="title", description="Title of the list", nullable=true)
     * @param ParamFetcher $paramFetcher
     * @return \FOS\RestBundle\View\View
     */
    public function postListsAction(ParamFetcher $paramFetcher)
    {
        $title = $paramFetcher->get('title');

        if ($title) {
            $list = new TreeList();

            $list->setTitle($title);

            $this->entityManager->persist($list);
            $this->entityManager->flush();

            return $this->view($list, Response::HTTP_CREATED);
        }

        return $this->view(['title' => 'This cannot be null'], Response::HTTP_BAD_REQUEST);
    }

    public function deleteListsAction(int $id)
    {
        $data = $this->treeListRepository->findOneBy(['id' => $id]);
        
        $this->entityManager->remove($data);
        $this->entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT); 
    }

    public function putListsAction()
    {
        //
    }

    public function getListsTasksAction(int $id)
    {
        //
    }
}
