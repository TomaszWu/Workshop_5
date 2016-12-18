<?php
namespace Workshop5Bundle\Controller;

use Workshop5Bundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    public function modifyPersonAction(Request $request, $id){
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
                var_dump($errors);exit;
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
    public function deletePersonAction($id){
        $repository = $this->getDoctrine()->getRepository('Workshop5Bundle:Person');
        $personToDelete = $repository->find($id);
        if(!$personToDelete){
            return new Response ('Brak takiej osoby!');
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
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $people = $em->getRepository('Workshop5Bundle:Person')->findAll();

        return $this->render('person/index.html.twig', array(
                    'people' => $people,
        ));
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
    
    
    
//    public function test(Request $request, Person $person) {
//        $deleteForm = $this->createDeleteForm($person);
//        $editForm = $this->createForm('stworzony crudem formularz', $person);
//        $addressFrom = $this->createForm('stworzony crudem formularz');
//        $editForm->handleRequest($request);
//        
//       if($editForm->isSubmitted() && $editForm->isValid()){
//           $this->getDoctrine()->getManager()->flus();
//           return $this->redirectToRoute('person_edit', array('person' => $person));
//       } 
//       
//       
//       
//    }
    

}
