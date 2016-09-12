<?php
/**
 * Created by PhpStorm.
 * User: chamika
 * Date: 9/7/16
 * Time: 4:52 PM
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @Route("/home")
     */
    public function showHome(){
        return $this->render('conList/home.html');
    }

    /**
     * @Route("/")
     */
    public function showList(){
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('AppBundle:Contact')->findAll();
        return $this->render('conList/viewList.html.twig',['contacts'=>$contacts]);
    }

    /**
     * @Route("/showAddNew")
     */
    public function addCotact(){
        return $this->render('conList/addNew.html.twig');
    }

    /**
     * @Route("/addNewAction", name="addNewAction")
     */
    public function addNewAction(){
        $form = $this->createFormBuilder()
            ->add('name','text')
            ->add('address','text')
            ->add('email','text')
            ->add('contactno','text')
            ->getForm();
        return array('form'=>$form);
    }

    /**
     * @Route("/listdata")
     * @Method("GET")
     */
    public function conList(){
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('AppBundle:Contact')->findAll();

        $contacts = $this->get('serializer')->serialize($contacts,'json');
        $respose = new Response($contacts);
        $respose->headers->set('Content-Type','application/json');
        return $respose;
    }

    /**
     * @Route("/getlist")
     * @Method("GET")
     */
    public function getList(){
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('AppBundle:Contact')->findAll();

        $contacts = $this->get('serializer')->serialize($contacts,'json');
        $respose = new Response($contacts);
        $respose->headers->set('Content-Type','application/json');

        return $this->render('conList/getlist.html.twig',$respose);
    }



}