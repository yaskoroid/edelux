<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.19
 * Time: 16:28
 */

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Item;
use App\Form\ItemUpdate;
use App\Form\ItemCreate;

/**
 * Item controller.
 * @Route("/api",name="api_")
 */
class ItemController extends AbstractFOSRestController
{
    /**
     * Create item.
     * @Rest\Post("/item")
     *
     * @return Response
     */
    public function createItemAction(Request $request)
    {
        $item = new Item();
        $form = $this->createForm(ItemCreate::class, $item);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
            return $this->handleView(
                $this->view(['status' => 'ok', 'item' => ['id' => $item->getId()]], Response::HTTP_CREATED)
            );
        }

        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * Update item.
     * @Rest\Put("/item/{id}", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function putItemAction(Request $request, int $id)
    {
        $item = new Item();
        $form = $this->createForm(ItemUpdate::class, $item);
        $data = json_decode($request->getContent(), true);
        $data['id'] = $id;
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository(Item::class)->find($item->getId());
            $entity->fromArray($form->getData());
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_ACCEPTED));
        }

        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * Get item by id.
     * @Rest\View
     * @Rest\Get("/item/{id}", requirements={"id" = "\d+"})
     * @return Response
     */
    public function getItemAction(Request $request, int $id)
    {
        $repository = $this->getDoctrine()->getRepository(Item::class);
        $item = $repository->find($id);
        if (!$item) {
            return $this->handleView($this->view(
                ['error' => ['code' => '404', 'message' => 'Not found']],
                Response::HTTP_NOT_FOUND
            ));
        }
        return $this->handleView($this->view($item));
    }

    /**
     * Delete item
     * @Rest\Delete("/item/{id}", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function deleteItemAction(Request $request, int $id)
    {
        $doctrine = $this->getDoctrine();

        $em = $doctrine->getManager();
        $item = $doctrine->getRepository(Item::class)->find($id);
        if (!$item) {
            return $this->handleView($this->view(
                ['error' => ['code' => '404', 'message' => 'Not found']],
                Response::HTTP_NOT_FOUND
            ));
        }
        $em->remove($item);
        $em->flush();

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_NO_CONTENT));
    }
}