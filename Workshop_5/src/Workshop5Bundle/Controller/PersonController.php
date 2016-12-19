<?php

namespace Workshop5Bundle\Controller;

use Workshop5Bundle\Entity\Person;
use Workshop5Bundle\Form\PersonType;
use Workshop5Bundle\Form\AddressType;
use Workshop5Bundle\Form\TelephoneType;
use Workshop5Bundle\Form\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Person controller.
 *
 * @Route("person")
 */
class PersonController extends Controller {

    /**
     * @Route("/newPerson")
     * @Template("Workshop5Bundle:Person:newPerson.html.twig")
     */
    public function newPersonAcction(Request $request) {
        $newPerson = new Person;
        $form = $this->createFormBuilder($newPerson)
                ->add('name', 'text')
                ->add('surname', 'text')
                ->add('description', 'text')
                ->add('save', 'submit', array('label' => 'Dodaj osobę'))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            $url = $this->generateUrl('person_index');
            return $this->redirect($url);
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/modifyPerson/{id}")
     * @Template("Workshop5Bundle:Person:newPerson.html.twig")
     */
    public function modifyPersonAction(Request $request, $id) {
        $usersRepository = $this->getDoctrine()->getRepository('Workshop5Bundle:Person');
        $loadedPerson = $usersRepository->findOneById($id);

        $form = $this->createFormBuilder($loadedPerson)
                ->add('name', 'text')
                ->add('surname', 'text')
                ->add('description', 'text')
                ->add('groups')
                ->add('save', 'submit', array('label' => 'Dodaj osobę'))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $validator = $this->get('validator');
            $errors = $validator->validate($form->getData());
            if (count($errors) > 0) {
                var_dump($errors);
                exit;
            }
//            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            // persist nie jest potrzebny
            $em->flush();
            $url = $this->generateUrl('person_index');
            return $this->redirect($url);
        }
        return array('loadedPerson' => $loadedPerson, 'form' => $form->createView());
    }

    /**
     * @Route("/deletePerson/{id}")
     */
    public function deletePersonAction($id) {
        $repository = $this->getDoctrine()->getRepository('Workshop5Bundle:Person');
        $personToDelete = $repository->find($id);
        if (!$personToDelete) {
            return new Response('Brak takiej osoby!');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($personToDelete);
            $em->flush();
            return new Response('Użytkownik skasowany');
        }
    }

    /**
     * Lists all person entities.
     *
     * @Route("/", name="person_index")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $newPerson = new Person;
        $newPersonForm = $this->createForm(new PersonType(), $newPerson)
                ->add('save', 'submit', array('label' => 'Dodaj osobę'));

        $lookingForForm = $this->createFormBuilder()
                ->add('name', 'text')
                ->add('save', 'submit', array('label' => 'Kogo szukasz?'))
                ->getForm();

        $lookingForForm->handleRequest($request);
        if ($lookingForForm->isSubmitted()) {
            $nameToFind = $lookingForForm->getData();
            $repository = $this->getDoctrine()->getRepository('Workshop5Bundle:Person');
            $personYouAreLookingFor = $repository->findAPerson($nameToFind['name']);
            return $this->render('searchResult.html.twig', array('personYouAreLookingFor' =>
                $personYouAreLookingFor));
            
        }

        $newPersonForm->handleRequest($request);
        if ($newPersonForm->isSubmitted()) {
            $person = $newPersonForm->getData();
            $em->persist($person);
            $em->flush();
        }
        $people = $em->getRepository('Workshop5Bundle:Person')->findAll();
        usort($people, array("Workshop5Bundle\Entity\Person", "cmp_obj"));
        return $this->render('person/index.html.twig', array(
                    'people' => $people, 'newPersonForm' => $newPersonForm->createView(),
                    'lookingForForm' => $lookingForForm->createView(),
        ));
    }

    static function cmp_obj($a, $b) {
        $al = strtolower($a->name);
        $bl = strtolower($b->name);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    }

    /**
     * Finds and displays a person entity.
     *
     * @Route("/{id}", name="person_show")
     * @Method("GET")
     */
    public function showAction(Person $person) {

        return $this->render('person/show.html.twig', array(
                    'person' => $person
        ));
    }

    /**
     * @Route("/editPerson/{id}")
     * @Template("Workshop5Bundle:test:test.html.twig")
     */
    public function editPersonAction(Request $request, $id) {
        $usersRepository = $this->getDoctrine()->getRepository('Workshop5Bundle:Person');
        $i = 0;
        $loadedPerson = $usersRepository->findOneById($id);
        $editForm = $this->createForm(new PersonType(), $loadedPerson);
        $addressFrom = $this->createForm(new AddressType());
        $telephoneFrom = $this->createForm(new TelephoneType());
        $emailFrom = $this->createForm(new EmailType());

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $i++;
        }
        $addressFrom->handleRequest($request);
        if ($addressFrom->isSubmitted() && $addressFrom->isValid()) {
            $address = $addressFrom->getData();
            $address->setPerson($loadedPerson);
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
            $i++;
        }
        $telephoneFrom->handleRequest($request);
        if ($telephoneFrom->isSubmitted() && $telephoneFrom->isValid()) {
            $telephone = $telephoneFrom->getData();
            $telephone->setPerson($loadedPerson);
            $em = $this->getDoctrine()->getManager();
            $em->persist($telephone);
            $em->flush();
            $i++;
        }
        $emailFrom->handleRequest($request);
        if ($emailFrom->isSubmitted() && $emailFrom->isValid()) {
            $email = $emailFrom->getData();
            $email->setPerson($emailFrom);
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();
            $i++;
        }
        if ($i > 0) {
            return $this->redirectToRoute('person_show', array('id' => $id));
        }

        return array('editForm' => $editForm->createView(), 'addressForm' => $addressFrom->createView(),
            'telephoneForm' => $telephoneFrom->createView(), 'emailForm' => $emailFrom->createView());
    }

//    public function editPersonAction(Request $request, Person $person) {
//        $deleteForm = $this->createDeleteForm($person);
//        $editForm = $this->createForm('Workshop5Bundle\Entity\Person', $person);
//        $addressFrom = $this->createForm('Workshop5Bundle\Entity\Address');
//        $editForm->handleRequest($request);
//        
//       if($editForm->isSubmitted() && $editForm->isValid()){
//           $this->getDoctrine()->getManager()->flus();
//           return $this->redirectToRoute('person_edit', array('person' => $person));
//       } 
//       if($editForm->isSubmitted() && $editForm->isValid()){
//           $this->getDoctrine()->getManager()->flus();
//           return $this->redirectToRoute('person_edit', array('person' => $person));
//       } 
}
