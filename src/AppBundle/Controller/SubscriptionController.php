<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Product;
use AppBundle\Entity\Subscription;
use AppBundle\Form\SubscriptionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;


/**
 * @Rest\Route(Path = "/subscription")
 * 
 */
class SubscriptionController extends FOSRestController
{

    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }


    /**
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "app_subscription_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
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
     * @Rest\Post("/")
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * 
     */
    public function postSubscription(Request $request)
    {

        $subscription = new Subscription();
        
        $form = $this->createForm(SubscriptionType::class, $subscription);
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
    * @Rest\Put("/{id}")
    * @Rest\View(statusCode=Response::HTTP_CREATED)
    * 
    */
    public function putSubscription(Subscription $subscription,Request $request)
    { 

        if (!$subscription) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        $form = $this->createForm(SubscriptionType::class, $subscription);
    
        $form->submit($request->request->all());

        if($form->isValid()){

            $this->em->persist($subscription);
            $this->em->flush();

            $view = $this->view($subscription, Response::HTTP_OK);
            return $this->handleView($view);

        }

        $view = $this->view($form, Response::HTTP_NOT_MODIFIED);
        return $this->handleView($view);
        
    }




    /**
     * @Rest\View(StatusCode = 204)
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "app_subscription_delete",
     *     requirements = {"id"="\d+"}
     * )
     */
    public function deleteSubscription(Request $request, Subscription $subscription)
    { 
        if (!$subscription) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        
        $this->em->remove($subscription);
        $this->em->flush();

        $view = $this->view(null, Response::HTTP_NO_CONTENT);
        return $this->handleView($view);

    }
}
