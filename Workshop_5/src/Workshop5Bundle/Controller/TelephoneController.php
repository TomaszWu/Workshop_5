<?php
namespace Workshop5Bundle\Controller;

use Workshop5Bundle\Entity\Telephone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Telephone controller.
 *
 * @Route("telephone")
 */
class TelephoneController extends Controller
{
    
    
    
    /**
     * @Route("/addTelephoneNumber/{id}")
     * @Template("Workshop5Bundle:Address:newAddress.html.twig") 
     */
    public function addTelephoneNumberAction(Request $request, $id) {
        $newTelephoneNumber = new Telephone;
        $form = $this->createFormBuilder($newTelephoneNumber)
                ->add('telephone_number', 'number')
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        'Domowy' => 'domowy',
                        'Służbowy' => 'sluzbowy',
                        'Inny' => 'inny',
                    )
                ))
                ->add('save', 'submit', array('label' => 'Dodaj numer telefonu'))
                ->getForm();

        $repository = $this->getDoctrine()->getRepository('Workshop5Bundle:Person');
        $loadedPerson = $repository->findOneById($id);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $telephoneNumber = $form->getData();
            $newTelephoneNumber->setTelephoneNumber($telephoneNumber->getTelephoneNumber());
            $newTelephoneNumber->setType($telephoneNumber->getType());
            $newTelephoneNumber->setPerson($loadedPerson);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newTelephoneNumber);
            $em->flush();
            $url = $this->generateUrl('person_show', array('id' => $id));
            return $this->redirect($url);
        }
        return array('form' => $form->createView());
    }
    
    
    
    /**
     * Lists all telephone entities.
     *
     * @Route("/", name="telephone_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $telephones = $em->getRepository('Workshop5Bundle:Telephone')->findAll();

        return $this->render('telephone/index.html.twig', array(
            'telephones' => $telephones,
        ));
    }

    /**
     * Finds and displays a telephone entity.
     *
     * @Route("/{id}", name="telephone_show")
     * @Method("GET")
     */
    public function showAction(Telephone $telephone)
    {

        return $this->render('telephone/show.html.twig', array(
            'telephone' => $telephone,
        ));
    }
}
