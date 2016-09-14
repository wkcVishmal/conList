<?php
namespace AppBundle\Controller;


use AppBundle\Entity\Contact;
//use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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

    //show the Add new contact form
    /**
     * @Route("/addNew")
     */
    public function addCotact(){
        return $this->render('conList/addNew.html.twig');
    }

    //Backend API for save contact Json Object
    /**
     * @Route("/saveContact")
     */
    public function saveContact(Request $request){
        try{
            $data = json_decode($request->getContent(), true);

            $contact = new Contact();

            $name = $data['name'];
            $address = $data['address'];
            $email = $data['email'];
            $contactno = $data['contactno'];

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
            return new JsonResponse(array('data' => $name));
        }catch (Exception $e){

        }
    }

    /**
     * @Route("/deleteContact")
     */
    public function deleteContact(Request $request){
        try{
            $data = json_decode($request->getContent(), true);

            $id = $data['id'];
            //$id = 11;

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Contact')->findOneBy(array('id' => $id));

            if ($entity != null){
                $em->remove($entity);
                $em->flush();
            }

            return new JsonResponse(array('data' => "deleted"));
        }catch (Exception $e){

        }

    }

    //Another method:- for Create form to add new contact and save contact details
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




}