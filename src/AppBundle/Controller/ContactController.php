<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Version;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



/**
 * @Route(path = "/contact")
 * @Version("v1")
 */
class ContactController extends AbstractFOSRestController
{

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }


    /**
     * 
     * @Rest\Get(
     *       path="/{id}",
     *       name="app_contact_get",
     *       requirements={"id"="\d+"}
     * )
     * @Rest\View()
     * 
     */
    public function  getContact(Contact $contact)
    {
        if (!$contact) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        return $contact;
    }

   /**
    * @Rest\Post("/")
    * @Rest\View(statusCode=Response::HTTP_CREATED)
    * @ParamConverter("contact",class="AppBundle\Entity\Contact" , converter="fos_rest.request_body")
    */
    public function postContact(Contact $contact,Request $request)
    {
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($contact);
            $this->em->flush();

            $view = $this->view($contact, Response::HTTP_CREATED);
            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * @Rest\View(StatusCode = 200)
     * @Rest\Put(
     *      path  = "/{id}",
     *      name = "app_contact_put",
     *      requirements = {"id"="\d+"}  
     *  )
     *
     * @ParamConverter("newContact",class="AppBundle\Entity\Contact" , converter="fos_rest.request_body")
     * 
     */
    public function putContact(Contact $contact,Contact $newContact,Request $request)
    { 

        $form = $this->createForm(ContactType::class, $newContact);

       // $form->handleRequest($request);

        $form->submit($request->request->all());

        $contact->setName($newContact->getName());
        $contact->setFirstName($newContact->getFirstName());
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->merge($contact,$newContact);
            $this->em->persist($contact);
            $this->em->flush();

            $view = $this->view($contact, Response::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }


    /**
     * @Rest\View(StatusCode = 204)
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "app_contact_delete",
     *     requirements = {"id"="\d+"}
     * )
     */
    public function deleteContact(Contact $contact)
    { 
        if (!$contact) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        $this->em->remove($contact);
        $this->em->flush();

        $view = $this->view(null, Response::HTTP_OK);
        return $this->handleView($view);
    }
}
