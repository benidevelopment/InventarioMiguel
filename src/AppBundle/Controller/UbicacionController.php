<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ubicacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ubicacion controller.
 *
 * @Route("ubicacion")
 */
class UbicacionController extends Controller
{
    /**
     * Lists all ubicacion entities.
     *
     * @Route("/", name="ubicacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ubicacions = $em->getRepository('AppBundle:Ubicacion')->findAll();

        return $this->render('ubicacion/index.html.twig', array(
            'ubicacions' => $ubicacions,
        ));
    }

    /**
     * Creates a new ubicacion entity.
     *
     * @Route("/new", name="ubicacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ubicacion = new Ubicacion();
        $form = $this->createForm('AppBundle\Form\UbicacionType', $ubicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ubicacion);
            $em->flush();

            return $this->redirectToRoute('ubicacion_show', array('idubicacion' => $ubicacion->getIdubicacion()));
        }

        return $this->render('ubicacion/new.html.twig', array(
            'ubicacion' => $ubicacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ubicacion entity.
     *
     * @Route("/{idubicacion}", name="ubicacion_show")
     * @Method("GET")
     */
    public function showAction(Ubicacion $ubicacion)
    {
        $deleteForm = $this->createDeleteForm($ubicacion);

        return $this->render('ubicacion/show.html.twig', array(
            'ubicacion' => $ubicacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ubicacion entity.
     *
     * @Route("/{idubicacion}/edit", name="ubicacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ubicacion $ubicacion)
    {
        $deleteForm = $this->createDeleteForm($ubicacion);
        $editForm = $this->createForm('AppBundle\Form\UbicacionType', $ubicacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ubicacion_edit', array('idubicacion' => $ubicacion->getIdubicacion()));
        }

        return $this->render('ubicacion/edit.html.twig', array(
            'ubicacion' => $ubicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ubicacion entity.
     *
     * @Route("/{idubicacion}", name="ubicacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ubicacion $ubicacion)
    {
        $form = $this->createDeleteForm($ubicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ubicacion);
            $em->flush();
        }

        return $this->redirectToRoute('ubicacion_index');
    }

    /**
     * Creates a form to delete a ubicacion entity.
     *
     * @param Ubicacion $ubicacion The ubicacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ubicacion $ubicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ubicacion_delete', array('idubicacion' => $ubicacion->getIdubicacion())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
