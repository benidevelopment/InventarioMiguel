<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Articulo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\KnpSnappyBundle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



/**
 * Articulo controller.
 *
 * @Route("articulo")
 */
class ArticuloController extends Controller
{
    /**
     * Lists all articulo entities.
     *
     * @Route("/", name="articulo_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $articulos = $em->getRepository('AppBundle:Articulo')->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         * 
        */

        $paginator = $this->get('knp_paginator');
        
                    $result = $paginator->paginate(
                    $articulos, /* query NOT result */
                    $request->query->getInt('page', 1)/*page number*/,
                    $request->query->getInt('limit', 5)/*limit per page     */
        
                );
            
               
        return $this->render('articulo/index.html.twig', ["listaarticulos"=>$result]);
    
    }

    /**
     * Creates a new articulo entity.
     *
     * @Route("/new", name="articulo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $articulo = new Articulo();
        $form = $this->createForm('AppBundle\Form\ArticuloType', $articulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($articulo);
            $em->flush();

            return $this->redirectToRoute('articulo_show', array('idarticulo' => $articulo->getIdarticulo()));
        }

        return $this->render('articulo/new.html.twig', array(
            'articulo' => $articulo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a articulo entity.
     *
     * @Route("/{idarticulo}", name="articulo_show")
     * @Method("GET")
     */
    public function showAction(Articulo $articulo)
    {
        $deleteForm = $this->createDeleteForm($articulo);

        return $this->render('articulo/show.html.twig', array(
            'articulo' => $articulo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing articulo entity.
     *
     * @Route("/{idarticulo}/edit", name="articulo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Articulo $articulo)
    {
        $deleteForm = $this->createDeleteForm($articulo);
        $editForm = $this->createForm('AppBundle\Form\ArticuloType', $articulo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articulo_edit', array('idarticulo' => $articulo->getIdarticulo()));
        }

        return $this->render('articulo/edit.html.twig', array(
            'articulo' => $articulo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a articulo entity.
     *
     * @Route("/{idarticulo}", name="articulo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Articulo $articulo)
    {
        $form = $this->createDeleteForm($articulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($articulo);
            $em->flush();
        }

        return $this->redirectToRoute('articulo_index');
    }

    /**
     * Creates a form to delete a articulo entity.
     *
     * @param Articulo $articulo The articulo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Articulo $articulo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('articulo_delete', array('idarticulo' => $articulo->getIdarticulo())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * @route("/articulo",name="busca_articulo")
     * @return void
     */

    public function buscarArticulo(Request $request)
    {
        
        $busqueda= $request->request->get("consulta");
        $sesion=new Session();
        $sesion->set('articulos',$busqueda);

        $em=$this->get('doctrine.orm.entity_manager');
        if($busqueda=="")
        {
            $dql = "SELECT a FROM AppBundle:Articulo a";
        }
        else
        {
            $dql = "SELECT a FROM AppBundle:Articulo a  WHERE a. descripcion like '%$busqueda%'";
        }
        $query = $em->createQuery($dql);
        $paginator=$this->get('knp_paginator');
        $pagination = $paginator->paginate($query,$request->query->getInt('page',1),5);
        return $this->render('articulo/listadoArticulo.html.twig',array('listaarticulos'=>$pagination));
      
    }
    

 





     /**
     * @Route("/pdf", name="Imprimir_busqueda")
     */
    public function ImprimirBusqueda(Request $request)
    {
       $sesion=new Session();
       $busqueda=$sesion->get('articulos');
       
       $em=$this->get('doctrine.orm.entity_manager');
       if($busqueda=="")
       {
           $dql = "SELECT a FROM AppBundle:Articulo a";
       }
       else
       {
           $dql = "SELECT a FROM AppBundle:Articulo a  WHERE a. descripcion like '%$busqueda%'";
       }
       $query = $em->createQuery($dql);
       $paginator=$this->get('knp_paginator');
                   $result = $paginator->paginate(
                   $query, /* query NOT result */
                   $request->query->getInt('page', 1)/*page number*/,
                   $request->query->getInt('limit', 5)/*limit per page     */);

       $pagination = $paginator->paginate($query,$request->query->getInt('page',1),5);
       
       $fila="<tr style='height:44.45pt'>
        <td width=93 style='width:69.75pt;border:solid windowtext 1.0pt;border-top:
        none;padding:0cm 5.4pt 0cm 5.4pt;height:44.45pt'>
        <b><p class=MsoNormal align=center style='text-align:center'><span
        style='font-size:10.0pt;font-family:".+"Arial".",sans-serif'>{ID1</span></b></p>
        </td>
        <td width=483 style='width:362.25pt; border-top:none; border-left:none;
        border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
        padding:0cm 5.4pt 0cm 5.4pt;height:44.45pt'>
        <p class=MsoNormal align=center style='text-align:center'><b><span
        style='font-size:10.0pt;font-family:".+"Arial".",sans-serif'>{DESC1</span></b></p>
        </td>
        <td width=132 style='width:99.0pt;border-top:none;border-left:none;
        border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
        padding:0cm 5.4pt 0cm 5.4pt;height:44.45pt'>
        <p class=MsoNormal align=center style='text-align:center'><b><span
        style='font-size:10.0pt;font-family:".+"Arial".",sans-serif'>{NUMEJ1</span></b></p>
        </td>  
        
       </tr>    <!--fila*-->";

       $datos=$query->getResult();

       $fichero='..\web\Imprimir\ImpresionArticulos.htm';
       $texto = file($fichero);
       $ntexto = sizeof($texto);
       $contenidoDelArchivo ='';
       for($n=0;$n<$ntexto;$n++)//leer el fichero html (documento oficial)
       {
           $contenidoDelArchivo = $contenidoDelArchivo.$texto[$n];
       }
        
       for($i=0;$i<count($datos);$i++)
       {
          $contenidoDelArchivo=str_replace("<!--fila*-->",$fila,$contenidoDelArchivo);
          $idArticulo=$datos[$i]->getIdarticulo();
          $descripcionArticulo=$datos[$i]->getDescripcion();
          $numeroEjemplaresArticulo=$datos[$i]->getNumejemplar();
          $contenidoDelArchivo=str_replace("{DESC1",$descripcionArticulo,$contenidoDelArchivo);
          $contenidoDelArchivo=str_replace("{ID1",$idArticulo,$contenidoDelArchivo);
          $contenidoDelArchivo=str_replace("{NUMEJ",$numeroEjemplaresArticulo,$contenidoDelArchivo);
       }
       
      
       setlocale(LC_ALL,"esp");
       $fechaYhora=strftime("%A %d de %B del %Y ");
        $contenidoDelArchivo=str_replace("{PIE",$fechaYhora,$contenidoDelArchivo);



        $terminacion="Nuevo";strftime("%Y_%B_%d_%A_%X");
        $fichero='..\web\Imprimir\ImpresionArticulos'.$terminacion.'.htm';
        $archivo = fopen($fichero, 'w+');

        rewind($archivo);
        fwrite($archivo, $contenidoDelArchivo);
        fflush($archivo);
  
        // $snappy = $this->get('knp_snappy.pdf');

        // $html = $this->renderView('articulo/index.html.twig', ["listaarticulos"=>$result],array(
        //     "title" => "Articulos PDF"
        // ));
        fclose($archivo);
        $snappy = $this->get('knp_snappy.pdf');
        $filename = "custom_pdf_from_twig";
        
      
    
        return new Response(
            $snappy->getOutput($fichero), 
            //codigo de status correcto
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
         );
         return $this->redirectToRoute("articulo");
        }









}        