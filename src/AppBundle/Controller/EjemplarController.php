<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ejemplar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ejemplar controller.
 *
 * @Route("ejemplar")
 */
class EjemplarController extends Controller
{
    /**
     * Lists all ejemplar entities.
     *
     * @Route("/", name="ejemplar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ejemplars = $em->getRepository('AppBundle:Ejemplar')->findAll();

        return $this->render('ejemplar/index.html.twig', array(
            'ejemplars' => $ejemplars,
        ));
    }

    /**
     * Creates a new ejemplar entity.
     *
     * @Route("/new", name="ejemplar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ejemplar = new Ejemplar();
        $form = $this->createForm('AppBundle\Form\EjemplarType', $ejemplar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ejemplar);
            $em->flush();

            return $this->redirectToRoute('ejemplar_show', array('idejemplar' => $ejemplar->getIdejemplar()));
        }

        return $this->render('ejemplar/new.html.twig', array(
            'ejemplar' => $ejemplar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ejemplar entity.
     *
     * @Route("/{idejemplar}", name="ejemplar_show")
     * @Method("GET")
     */
    public function showAction(Ejemplar $ejemplar)
    {
        $deleteForm = $this->createDeleteForm($ejemplar);

        return $this->render('ejemplar/show.html.twig', array(
            'ejemplar' => $ejemplar,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ejemplar entity.
     *
     * @Route("/{idejemplar}/edit", name="ejemplar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ejemplar $ejemplar)
    {
        $deleteForm = $this->createDeleteForm($ejemplar);
        $editForm = $this->createForm('AppBundle\Form\EjemplarType', $ejemplar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ejemplar_edit', array('idejemplar' => $ejemplar->getIdejemplar()));
        }

        return $this->render('ejemplar/edit.html.twig', array(
            'ejemplar' => $ejemplar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ejemplar entity.
     *
     * @Route("/{idejemplar}", name="ejemplar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ejemplar $ejemplar)
    {
        $form = $this->createDeleteForm($ejemplar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ejemplar);
            $em->flush();
        }

        return $this->redirectToRoute('ejemplar_index');
    }

    /**
     * Creates a form to delete a ejemplar entity.
     *
     * @param Ejemplar $ejemplar The ejemplar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ejemplar $ejemplar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ejemplar_delete', array('idejemplar' => $ejemplar->getIdejemplar())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
