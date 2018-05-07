<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Prestamo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Prestamo controller.
 *
 * @Route("prestamo")
 */
class PrestamoController extends Controller
{
    /**
     * Lists all prestamo entities.
     *
     * @Route("/", name="prestamo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prestamos = $em->getRepository('AppBundle:Prestamo')->findAll();

        return $this->render('prestamo/index.html.twig', array(
            'prestamos' => $prestamos,
        ));
    }

    /**
     * Creates a new prestamo entity.
     *
     * @Route("/new", name="prestamo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $prestamo = new Prestamo();
        $form = $this->createForm('AppBundle\Form\PrestamoType', $prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prestamo);
            $em->flush();

            return $this->redirectToRoute('prestamo_show', array('idprestamo' => $prestamo->getIdprestamo()));
        }

        return $this->render('prestamo/new.html.twig', array(
            'prestamo' => $prestamo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a prestamo entity.
     *
     * @Route("/{idprestamo}", name="prestamo_show")
     * @Method("GET")
     */
    public function showAction(Prestamo $prestamo)
    {
        $deleteForm = $this->createDeleteForm($prestamo);

        return $this->render('prestamo/show.html.twig', array(
            'prestamo' => $prestamo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing prestamo entity.
     *
     * @Route("/{idprestamo}/edit", name="prestamo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Prestamo $prestamo)
    {
        $deleteForm = $this->createDeleteForm($prestamo);
        $editForm = $this->createForm('AppBundle\Form\PrestamoType', $prestamo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prestamo_edit', array('idprestamo' => $prestamo->getIdprestamo()));
        }

        return $this->render('prestamo/edit.html.twig', array(
            'prestamo' => $prestamo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a prestamo entity.
     *
     * @Route("/{idprestamo}", name="prestamo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Prestamo $prestamo)
    {
        $form = $this->createDeleteForm($prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($prestamo);
            $em->flush();
        }

        return $this->redirectToRoute('prestamo_index');
    }

    /**
     * Creates a form to delete a prestamo entity.
     *
     * @param Prestamo $prestamo The prestamo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Prestamo $prestamo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prestamo_delete', array('idprestamo' => $prestamo->getIdprestamo())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
