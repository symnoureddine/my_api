<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscription;
use AppBundle\Form\SubscriptionType;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Version;



/**
 * @Route(path = "/subscription")
 * @Version("v1")
 */
class SubscriptionController extends AbstractFOSRestController
{

    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }


    /**
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="get subscription",
     *  section="Subscription",
     *  requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The subscription unique identifier."
     *         }
     *  },
     *  input="AppBundle\Form\Type\SubscriptionType",
     *  output="AppBundle\Entity\Subscription"
     * )
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "app_subscription_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     *

     * 
     * 
     */
    public function getSubscription(Subscription $subscription)
    {
        if (!$subscription) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        return $subscription;
    }


    /**
     * 
     * @ApiDoc(
     * resource=true,
     * description="Create a new Subscription",
     * section="Subscription",
     * input="AppBundle\Form\Type\SubscriptionType",
     * output="AppBundle\Entity\Subscription"
     * )
     * @Rest\Post("/")
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * 
     */
    public function postSubscription(Request $request)
    {

        $subscription = new Subscription();

        $form = $this->createForm(SubscriptionType::class, $subscription);
        
        $form->handleRequest($request);

        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($subscription);
            $this->em->flush();

            $view = $this->view($subscription, Response::HTTP_CREATED);
            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }



    /**
     * @ApiDoc(
     * resource=true,
     * description="Update  Subscription",
     * section="Subscription",
     * requirements={
     *        {
     *            "name"="id",
     *            "dataType"="integer",
     *            "requirements"="\d+",
     *            "description"="The subscription unique identifier."
     *        }
     * },
     * input="AppBundle\Form\Type\SubscriptionType",
     * output="AppBundle\Entity\Subscription"
     * )
     * @Rest\Put(
     *       path = "/{id}",
     *       name = "app_subscription_put",
     *       requirements = {"id"= "\d+"}
     * )
     * @Rest\View(statusCode=Response::HTTP_OK)
     * 
     */
    public function putSubscription(Subscription $subscription, Request $request)
    {

        if (!$subscription) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        $form = $this->createForm(SubscriptionType::class, $subscription);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            $this->em->persist($subscription);
            $this->em->flush();

            $view = $this->view($subscription, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_NOT_MODIFIED);
        return $this->handleView($view);
    }




    /**
     * @ApiDoc(
     * resource=true,
     * description="Delete Subscription",
     * section="Subscription",
     * requirements={
     *        {
     *            "name"="id",
     *            "dataType"="integer",
     *            "requirements"="\d+",
     *            "description"="The subscription unique identifier."
     *        }
     * }
     * )
     * @Rest\View(StatusCode = 204)
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "app_subscription_delete",
     *     requirements = {"id"="\d+"}
     * )
     */
    public function deleteSubscription( Subscription $subscription)
    {
        if (!$subscription) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        $this->em->remove($subscription);
        $this->em->flush();

        $view = $this->view(null, Response::HTTP_OK);
        return $this->handleView($view);
    }
}
