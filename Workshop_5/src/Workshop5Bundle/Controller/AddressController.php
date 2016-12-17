<?php

namespace Workshop5Bundle\Controller;

use Workshop5Bundle\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Address controller.
 *
 * @Route("address")
 */
class AddressController extends Controller {

    /**
     * @Route("/addAddress/{id}")
     * @Template("Workshop5Bundle:Address:newAddress.html.twig") 
     */
    public function addAddressAction(Request $request, $id) {
        $newAddress = new Address;
        $form = $this->createFormBuilder($newAddress)
                ->add('city', 'text')
                ->add('street', 'text')
                ->add('flat_number', 'number')
                ->add('house_number', 'number')
                ->add('save', 'submit', array('label' => 'Dodaj adres'))
                ->getForm();

        $repository = $this->getDoctrine()->getRepository('Workshop5Bundle:Person');
        $loadedPerson = $repository->findOneById($id);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $address = $form->getData();
            $newAddress->setCity($address->getCity());
            $newAddress->setStreet($address->getStreet());
            $newAddress->setFlatNumber($address->getFlatNumber());
            $newAddress->setHouseNumber($address->getHouseNumber());
            $newAddress->setPerson($loadedPerson);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newAddress);
            $em->flush();
            $url = $this->generateUrl('person_show', array('id' => $id));
            return $this->redirect($url);
        }
        return array('form' => $form->createView());
    }

    /**
     * Lists all address entities.
     *
     * @Route("/", name="address_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $addresses = $em->getRepository('Workshop5Bundle:Address')->findAll();

        return $this->render('address/index.html.twig', array(
                    'addresses' => $addresses,
        ));
    }

    /**
     * Finds and displays a address entity.
     *
     * @Route("/{id}", name="address_show")
     * @Method("GET")
     */
    public function showAction(Address $address) {

        return $this->render('address/show.html.twig', array(
                    'address' => $address,
        ));
    }

}
