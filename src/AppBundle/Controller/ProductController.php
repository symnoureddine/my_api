<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Version;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Route(path = "/product")
 * @Version("v1")
 */
class ProductController extends AbstractFOSRestController
{
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="get product",
     *  section="Product",
     *  requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The product unique identifier."
     *         }
     *  },
     *  input="AppBundle\Form\Type\ProductType",
     *  output="AppBundle\Entity\Product"
     * )
     * @Rest\Get(
     *       path="/{id}",
     *       name="app_product_get",
     *       requirements={"id"="\d+"}
     * )
     * @Rest\View()
     * @ParamConverter("product", class="AppBundle:Product")
     * 
     */
    public function  getProduct(Product $product)
    { 
        if ($product === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $product;
        
    }


   /**
    * @ApiDoc(
    * resource=true,
    * description="Create a new product",
    * section="Product",
    * input="AppBundle\Form\Type\ProductType",
    * output="AppBundle\Entity\Product"
    * )
    * @Rest\Post("/")
    * @Rest\View(statusCode=Response::HTTP_CREATED)
    * @ParamConverter("product",class="AppBundle\Entity\Product" , converter="fos_rest.request_body")
    */
    public function postProduct(Product $product,Request $request)
    { 
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($product);
            $this->em->flush();

            $view = $this->view($product, Response::HTTP_CREATED);
            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_BAD_REQUEST);
        return $this->handleView($view);

    }


    /**
     * @ApiDoc(
     * resource=true,
     * description="Update product",
     * section="Product",
     * requirements={
     *        {
     *            "name"="id",
     *            "dataType"="integer",
     *            "requirements"="\d+",
     *            "description"="The product unique identifier."
     *        }
     * },
     * input="AppBundle\Form\Type\ContactType",
     * output="AppBundle\Entity\Contact"
     * )
     * @Rest\View(StatusCode = 200)
     * @Rest\Put(
     *      path  = "/{id}",
     *      name = "app_product_put",
     *      requirements = {"id"="\d+"}  
     *  )
     *
     * @ParamConverter("newProduct",class="AppBundle\Entity\Product" , converter="fos_rest.request_body")
     * 
     */
    public function putProduct(Product $product,Product $newProduct,Request $request)
    {
        $form = $this->createForm(ProductType::class, $newProduct);
 
         $form->submit($request->request->all());
         
         $product->setLabel($newProduct->getLabel());
         
         if ($form->isSubmitted() && $form->isValid()) {
             $this->em->merge($product,$newProduct);
             $this->em->persist($product);
             $this->em->flush();
 
             $view = $this->view($product, Response::HTTP_OK);
             return $this->handleView($view);
         }
 
         $view = $this->view($form, Response::HTTP_BAD_REQUEST);
         return $this->handleView($view);
    }


    /**
     * @ApiDoc(
     * resource=true,
     * description="Delete product",
     * section="Product",
     * requirements={
     *        {
     *            "name"="id",
     *            "dataType"="integer",
     *            "requirements"="\d+",
     *            "description"="The product unique identifier."
     *        }
     * }
     * )
     * @Rest\View(StatusCode = 200)
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "app_product_delete",
     *     requirements = {"id"="\d+"}
     * )
     */
    public function deleteProduct(Product $product)
    { 
        if (!$product) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        $this->em->remove($product);
        $this->em->flush();

        $view = $this->view(null, Response::HTTP_OK);
        return $this->handleView($view);
    }
}
