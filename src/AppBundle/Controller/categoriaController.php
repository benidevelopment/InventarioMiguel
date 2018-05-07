<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Categoria;
use Symfony\Component\HttpFoundation\Request;

class categoriaController extends Controller
{
 

     /**
     * @route("/categoria/listado",name="categoria_listado")
     * @return void
     */
    public function DatosCategorias(Request $request)
    {


        $cat = $this->getDoctrine()->getRepository('AppBundle\Entity\Categoria')->findall();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         * 
        */

        $paginator = $this->get('knp_paginator');

            $result = $paginator->paginate(
            $cat, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)/*limit per page     */

        );


        return $this->render('categoria/listadoCategoria.html.twig',["categorias"=>$result]);

    }

     /**
     * @route("/categoria/busqueda",name="busca_action")
     * @return void
     */

    public function buscarAction(Request $request)
    {
     
        $busqueda= $request->request->get("consulta");
        $em=$this->get('doctrine.orm.entity_manager');
        if($busqueda=="")
        {
            $dql = "SELECT a FROM AppBundle:Categoria a";
        }
        else
        {
            $dql = "SELECT a FROM AppBundle:Categoria a  WHERE a. descripcion like '%$busqueda%'";
        }
        $query = $em->createQuery($dql);
        $paginator=$this->get('knp_paginator');
        $pagination = $paginator->paginate($query,$request->query->getInt('page',1),5);
        return $this->render('categoria/listadoCategoria.html.twig',array('categorias'=>$pagination));
      
    }




   

     /**
     * @route("/categoria/nueva",name="categoria_nueva")
     * @return void
     */
    public function NuevaCategorias(Request $peticion)
    {
       // se crea un formulario
       $categoria=new categoria();
       $formulario=$this->createFormBuilder($categoria)
       ->add("Descripcion",TextType::class)
       ->add("Grabar",SubmitType::class)
       ->getform();
       $formulario->handleRequest($peticion);

        if($formulario->isSubmitted())
        {

        $em=$this->getDoctrine()->getManager();
        $em->persist($categoria);
        $em->flush();

        $cat = $this->getDoctrine()->getRepository('AppBundle\Entity\Categoria')->findall();

        return $this->render('categoria/listadoCategoria.html.twig',["categorias"=>$cat]);
        }
        else
        {
        return $this->render('categoria/nueva.html.twig',["formulario"=>$formulario->createView()]);
        }

    }


    //hacer la cosulta de un Alumno metiendo el dni a mano

     /**
     * @route("/categoria/borrar/{id}",name="categoria_borrar")
     * @return void
     */
    public function BorrarCategoria($id)
    {
       // se crea un formulario
      

       $em = $this->getDoctrine()->getEntityManager();
       $categorias = $em->getRepository('AppBundle\Entity\Categoria');

       $categoria = $categorias->find($id);
       $em->remove($categoria);
       $flush=$em->flush();
     
       $cat = $this->getDoctrine()->getRepository('AppBundle\Entity\Categoria')->findall();
       
        return $this->render('categoria/listadoCategoria.html.twig',["categorias"=>$cat]);
      





    }

    //hacer la cosulta de un Alumno metiendo el dni a mano

     /**
     * @route("/categoria/editar/{id}",name="categoria_editar")
     * @return void
     */
    public function EditarCategoria(Request $peticion, $id)
    {
       
      // se crea un formulario
      $em = $this->getDoctrine()->getEntityManager();
      $categorias = $em->getRepository('AppBundle\Entity\Categoria');
      $categoria = $categorias->find($id);
      
      $formulario=$this->createFormBuilder($categoria)
      ->add("Descripcion",TextType::class)
      ->add("Grabar",SubmitType::class)
      ->getform();
      $formulario->handleRequest($peticion);

       if($formulario->isSubmitted())
       {

       $em=$this->getDoctrine()->getManager();
       $em->persist($categoria);
       $em->flush();

       $cat = $this->getDoctrine()->getRepository('AppBundle\Entity\Categoria')->findall();

       return $this->render('categoria/listadoCategoria.html.twig',["categorias"=>$cat]);
       }
       else
       {
       return $this->render('categoria/nueva.html.twig',["formulario"=>$formulario->createView()]);
       }





    }





}
