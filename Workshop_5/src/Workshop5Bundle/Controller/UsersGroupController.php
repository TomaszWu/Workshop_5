<?php

namespace Workshop5Bundle\Controller;

use Workshop5Bundle\Entity\UsersGroup;
use Workshop5Bundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usersgroup controller.
 *
 * @Route("usersgroup")
 */
class UsersGroupController extends Controller
{
    
    /**
     * @Route("/addGroup")
     * @Template("Workshop5Bundle:Group:addGroup.html.twig")
     */
    public function addGroup(Request $request){
        $newGroup = new UsersGroup;
        $form = $this->createFormBuilder($newGroup)
                ->add('name', 'text')
                ->add('save', 'submit', array('label' => 'Dodaj grupę'))
                ->getForm();
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $group = $form->getData();
            
            $em->persist($group);
            $em->flush();
            $url = $this->generateUrl('usersgroup_index');
            return $this->redirect($url);
        }
        

        $usersGroups = $em->getRepository('Workshop5Bundle:UsersGroup')->findAll();

        return array('form' => $form->createView(), 'usersGroups' => $usersGroups);
    }
    
    /**
     * @Route("/addGroup/{id}")
     * @Template("Workshop5Bundle:Group:addGroup.html.twig")
     */
    public function addUserToGroup(Request $request, $id){
        $form = $this->createFormBuilder($newGroup)
                ->add('user', 'text')
                ->add('save', 'submit', array('label' => 'Dodaj grupę'))
                ->getForm();
        $form->handleRequest($request);
        
    }
    
    
    
    /**
     * Lists all usersGroup entities.
     *
     * @Route("/", name="usersgroup_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usersGroups = $em->getRepository('Workshop5Bundle:UsersGroup')->findAll();

        return $this->render('usersgroup/index.html.twig', array(
            'usersGroups' => $usersGroups,
        ));
    }

    /**
     * Finds and displays a usersGroup entity.
     *
     * @Route("/{id}", name="usersgroup_show")
     * @Method("GET")
     */
    public function showAction(UsersGroup $usersGroup)
    {
        
        return $this->render('usersgroup/show.html.twig', array(
            'usersGroup' => $usersGroup,
        ));
    }
    
    
    
    
}
