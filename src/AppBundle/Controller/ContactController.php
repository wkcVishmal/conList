<?php
namespace AppBundle\Controller;


use AppBundle\Entity\Contact;
//use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactController extends Controller
{
    /**
     * @Route("/")
     */
    public function showHome(){
        return $this->render('conList/home.html.twig');
    }

    /**
     * @Route("/addNew")
     */
    public function addCotact(){
        return $this->render('conList/addNew.html.twig');
    }

    /**
     * @Route("/saveContact")
     */
    public function saveContact(){

        //$name   = $request->request->get('name', null);
        //$address = $request->request->get('address', null);
        //$email   = $request->request->get('email', null);
        //$contactno     = $request->request->get('contactno', null);

        $name = "cccc";
        $address = "sfass";
        $email = "eeee";
        $contactno = "245235235";

        $contact = new Contact();
        $contact->setName($name);
        $contact->setAddress($address);
        $contact->setEmail($email);
        $contact->setContactno($contactno);

        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();

    }

    /**
     *@Route("add")
     */
    public function newAction(Request $request){
        $contact = new Contact();

        $form = $this->createFormBuilder($contact)
            ->add('name',TextType::class,array('attr' => array('class' => 'form-control','style'=>'margin-bottom:15px','ng-model' => 'name')))
            ->add('address',TextType::class,array('attr' => array('class' => 'form-control','style'=>'margin-bottom:15px','ng-model' => 'address')))
            ->add('email',TextType::class,array('attr' => array('class' => 'form-control','style'=>'margin-bottom:15px','ng-model' => 'email')))
            ->add('contactno',TextType::class,array('label'=>'Contact No:','attr' => array('class' => 'form-control','style'=>'margin-bottom:15px','ng-model' => 'contactno')))
            ->add('save',SubmitType::class,array('label'=>'Add Contact','attr' => array('class' => 'btn btn-primary','style'=>'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //die('SUBMITTED');
            $name=$form['name']->getData();
            $address=$form['address']->getData();
            $email=$form['email']->getData();
            $contactno=$form['contactno']->getData();

            $contact->setName($name);
            $contact->setAddress($address);
            $contact->setEmail($email);
            $contact->setContactno($contactno);

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash(
              'Notice',
                'Contact Added'
            );
        }
        return $this->render('conList/new.html.twig',array(
            'form'=> $form->createView()
        ));
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


}