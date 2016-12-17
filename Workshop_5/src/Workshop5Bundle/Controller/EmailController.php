<?php

namespace Workshop5Bundle\Controller;

use Workshop5Bundle\Entity\Email;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Email controller.
 *
 * @Route("email")
 */
class EmailController extends Controller {

    /**
     * @Route("/addEmailNumber/{id}")
     * @Template("Workshop5Bundle:Address:newAddress.html.twig") 
     */
    public function addEmailAddressAction(Request $request, $id) {
        $newEmail = new Email;
        $form = $this->createFormBuilder($newEmail)
                ->add('email_address', 'text')
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        'Domowy' => 'domowy',
                        'Służbowy' => 'sluzbowy',
                        'Inny' => 'inny',
                    )
                ))
                ->add('save', 'submit', array('label' => 'Dodaj adres'))
                ->getForm();

        $repository = $this->getDoctrine()->getRepository('Workshop5Bundle:Person');
        $loadedPerson = $repository->findOneById($id);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $email = $form->getData();
            $newEmail->setEmailAddress($email->getEmailAddress());
            $newEmail->setType($email->getType());
            $newEmail->setPerson($loadedPerson);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newEmail);
            $em->flush();
            $url = $this->generateUrl('person_show', array('id' => $id));
            return $this->redirect($url);
        }
        return array('form' => $form->createView());
    }

    /**
     * Lists all email entities.
     *
     * @Route("/", name="email_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $emails = $em->getRepository('Workshop5Bundle:Email')->findAll();

        return $this->render('email/index.html.twig', array(
                    'emails' => $emails,
        ));
    }

    /**
     * Finds and displays a email entity.
     *
     * @Route("/{id}", name="email_show")
     * @Method("GET")
     */
    public function showAction(Email $email) {

        return $this->render('email/show.html.twig', array(
                    'email' => $email,
        ));
    }

}
