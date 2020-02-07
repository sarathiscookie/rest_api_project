<?php

namespace App\Controller;

use App\Entity\TreeList;
use App\Repository\TreeListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postListsAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data) {
            $list = new TreeList();

            $list->setTitle($data['title']);

            $this->entityManager->persist($list);
            $this->entityManager->flush();

            return $this->view(['message' => 'Well done! Title created successfully.'], Response::HTTP_CREATED);
        }

        return $this->view(['message' => 'Something went wrong'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param integer $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteListsAction(int $id)
    {
        $data = $this->treeListRepository->findOneBy(['id' => $id]);
        
        $this->entityManager->remove($data);
        $this->entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT); 
    }

    /**
     * @Rest\RequestParam(name="title", description="Title of the list", nullable=true)
     * @param ParamFetcher $paramFetcher
     * @param integer $id
     * @return \FOS\RestBundle\View\View
     */
    public function putListsAction(ParamFetcher $paramFetcher, int $id)
    {
        $errors = [];

        $data = $this->treeListRepository->findOneBy(['id' => $id]);

        $title = $paramFetcher->get('title');

        if($data) {
            if ( !empty($title) ) {

                $data->setTitle($title);
    
                $this->entityManager->persist($data);
                $this->entityManager->flush();
    
                return $this->view(null, Response::HTTP_NO_CONTENT);
    
            }
            else {
                $errors[] = [
                    'title' => 'This title value cannot be empty'
                ];
            }
        }
        else {
            $errors[] = [
                'title' => 'Whoops! Data not found.'
            ];
        }

        return $this->view($errors, Response::HTTP_NO_CONTENT);
    }

    public function getListsTasksAction(int $id)
    {
        //
    }
}
