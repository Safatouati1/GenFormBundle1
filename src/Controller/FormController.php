<?php
/**
 * Created by PhpStorm.
 * User: safa
 * Date: 12/04/2019
 * Time: 12:38 PM
 */

namespace Sofia\GenFormBundle\Controller;
use Sofia\GenFormBundle\Entity\Field;
use Sofia\GenFormBundle\Entity\Form;
use Sofia\GenFormBundle\Entity\Reponse;
use Sofia\GenFormBundle\Entity\Trace;
use App\Entity\User;
use Sofia\GenFormBundle\Entity\Notification;
use App\Entity\AccessToken;

use PhpParser\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SerializerBundle\JMSSerializerBundle;

class FormController extends AbstractController
{
    /**
     * @Route("/api/Formapi/{id}", name="form",methods={"POST"})
     */
    public function index(Request $request,$id)
    {
        /* return $this->json([
             'message' => 'Welcome to your new controller!',
             'path' => 'src/Controller/FormController.php',
         ]);*/





        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        /* $entityManager = $this->getDoctrine()->getManager();

         $form = new Form();
         $form->setTitle('Hello');


         // tell Doctrine you want to (eventually) save the Product (no queries yet)
         $entityManager->persist($form);

         // actually executes the queries (i.e. the INSERT query)
         $entityManager->flush();

         return new Response('Saved new product with id '.$form->getId());*/

        $entityManager = $this->getDoctrine()->getManager();

        $formulaire = new Form();
        $data = json_decode($request->getContent(false), true);
        $user = $entityManager->find(User::class, $id);
        if (!$user) {
            return new JsonResponse('there\'s no such user in the database');
        }
        $creationDate = new \DateTime();


        $formulaire->setUser($user);
        $formulaire->setDateCreation($creationDate->format('d/m/Y'));
        //var_dump(gettype((string)($creationDate->format('d/m/Y'))));die();
        $formulaire->setDateExpiration($data['DateExp']);

        $formulaire->setDescription($data['description']);
        $formulaire->setTitle($data['title']);
        $entityManager->persist($formulaire);
        $entityManager->flush();
        foreach($data['Fields'] as $question){
            $field = new Field();
            $field->setObligation($question['obligation']);
            $field->setTypee($question['typee']);
            $field->setSubtitle($question['subtitle']);
            $field->setLabel($question['Label']);
            $field->setItemArray(json_encode($question['itemArray']));
            $field->setIdForm($formulaire);
            $entityManager->persist($field);
            $entityManager->flush();
        }




        return new JsonResponse('Saved new product with id '.$formulaire->getId());
    }




    /**
     * @Route("api/userform/{id}")
     *
     */
    public function listUserForms(Request $resquest,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse('there\'s no such an id in the database');
        }
        $formsArray = array();
        foreach ($user->getForms() as $form) {
            $data = array(
                'id' => $form->getId(),
                'DateCreation'=>$form->getDateCreation(),
                'DateExp'=>$form->getDateExpiration(),
                'title' => $form->getTitle(),
                'description' => $form->getDescription(),

            );
            array_push($formsArray, $data);
        }
        return new JsonResponse($formsArray);


    }

    /**
     * @Route("api/formofuser/{id}")
     *
     */
    public function showFormAction(Request $request, $id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $form = $entityManager->getRepository(Form::class)->find($id);
        if (!$form) {
            return new JsonResponse('there\'s no such a form id in the database');
        }
        $formArray = array();
        $fieldsArray = array();
        foreach ($form->getFields() as $field) {
            $data = array(

                'id' => $field->getId(),
                'typee' => $field->getTypee(),
                'obligation' => $field->getObligation(),
                'subtitle' => $field->getSubtitle(),
                'Label' => $field->getLabel(),
                'itemArray' => $field->getItemArray(),

            );
            array_push($fieldsArray, $data);
        }
        $data2 = array(
            'id' =>$form->getId(),
            'DateCreation'=>$form->getDateCreation(),
            'DateExp'=>$form->getDateExpiration(),
            'title' =>$form->getTitle(),
            'view' =>$form->getView(),
            'description' => $form->getDescription(),
            'Fields' => $fieldsArray,

        );
        array_push($formArray, $data2);

        return new JsonResponse($formArray);

    }

    /**
     * @Route("api/deleteForm/{id}")
     *
     */
    public function deleteFormAction(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $entityManager->getRepository(Form::class)->find($id);
        if (!$form) {
            return new JsonResponse('there\'s no such a form id in the database');
        }
        /* foreach ($form->getFields() as $field) {
             $entityManager->remove($field);
         }*/
        $entityManager->remove($form);
        $entityManager->flush();
        return new JsonResponse('form deleted');
    }

    /**
     * @Route("formofuser/{id}")
     *
     */
    public function submitFormAction(Request $request, $id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $form = $entityManager->getRepository(Form::class)->find($id);
        if (!$form) {
            return new JsonResponse('there\'s no such a form id in the database');
        }
        $formArray = array();
        $fieldsArray = array();
        foreach ($form->getFields() as $field) {
            $data = array(

                'id' => $field->getId(),
                'typee' => $field->getTypee(),
                'obligation' => $field->getObligation(),
                'subtitle' => $field->getSubtitle(),
                'Label' => $field->getLabel(),
                'itemArray' => $field->getItemArray(),

            );
            array_push($fieldsArray, $data);
        }
        $data2 = array(
            'id' => $form->getId(),
            'title' => $form->getTitle(),
            'DateCreation'=>$form->getDateCreation(),
            'DateExp'=>$form->getDateExpiration(),
            'description' => $form->getDescription(),
            'view' =>$form->getView(),

            'Fields' => $fieldsArray,

        );
        array_push($formArray, $data2);

        return new JsonResponse($formArray);

    }











    /**
     * @Route(path="api/getForm/")
     *
     */
    public function listForms()
    {

        $em = $this->getDoctrine()->getManager();
        $forms = $em->getRepository(Form::class)->findAll();

        $stack = array();
        foreach ($forms as $form) {
            $data = array(

                'id' => $form->getId(),
                'DateCreation'=>getDateCreation(),
                'DateExp'=>getDateExpiration(),
                'title' => $form->getTitle(),
                'userId' => $form->getUser(),


            );


            array_push($stack, $data);
        }

        return new JsonResponse($stack);
    }




    /**
     * @Route("api/UpdateForm/{id}")
     *
     */
    public function UpdateFormAction(Request $request,$id)
    {
        $data = json_decode($request->getContent(false), true);
        //var_dump($request->getContent());die();
        $entityManager = $this->getDoctrine()->getManager();
        $form= $entityManager->getRepository(Form::class)->find($id);
        if (!$form) {
            return new JsonResponse('there\'s no such a question id in the database');
        }
       /* $user = $entityManager->find(User::class, $data['userId']);
        if (!$user) {
            return new JsonResponse('there\'s no such user in the database');
        }
        $form->setUser($user);*/

        $form->setTitle($data['title']);
       // $form->setDateCreation();
        $form->setDateExpiration($data['DateExp']);
        $form->setDescription($data['description']);
        $entityManager->persist($form);
        $entityManager->flush();
        foreach($data['Fields'] as $question){
            $q=array($question);
            if (array_key_exists('id',$q[0])) {
                $Editablefield= $entityManager->getRepository(Field::class)->find($question['id']);
                $Editablefield->setTypee($question['typee']);
                $Editablefield->setObligation($question['obligation']);
                $Editablefield->setSubtitle($question['subtitle']);
                $Editablefield->setLabel($question['Label']);
                $Editablefield->setItemArray(json_encode($question['itemArray']));
                $entityManager->persist($Editablefield);
                $entityManager->flush();

            }else{
                $field = new Field();
                $field->setTypee($question['typee']);
                $field->setObligation($question['obligation']);
                $field->setSubtitle($question['subtitle']);
                $field->setLabel($question['Label']);
                $field->setItemArray(json_encode($question['itemArray']));
                $field->setIdForm($form);
                $em = $this->getDoctrine()->getManager();
                $em->persist($field);
                $em->flush();

            }
        }


        return new JsonResponse('Form Updated');
    }


    /**
     * @Route("api/sendMail/{idf}")
     *
     */
    public function sendMail(Request $request,\Swift_Mailer $mailer,$idf)
    {
        $data = json_decode($request->getContent(false), true);
        $subject =$data['subject'];
        $from =$data['email'];
        $to =$data['Tomail'];
        $body =$data['lien'];

        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body );

     $mailer->send($message);

        $trace = new Trace();
        $creationDate = new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $form= $em->getRepository(Form::class)->find($idf);
        $user= $em->getRepository(User::class)->find($form->getUser());
        if (!$form) {
            return new JsonResponse('there\'s no such a question id in the database');
        }
        if (!$user) {
            return new JsonResponse('there\'s no such a question id in the database');
        }
        $trace->setDateS($creationDate->format('d/m/Y'));
        $trace->setIdF($form);
        $trace->setMailD($to);
        $trace->setUser($user);
        $em->persist($trace);
        $em->flush();
        return new JsonResponse('done');
    }


    /**
     * @Route("api/form/submit/{id}")
     */
    public function SubmitForm(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reponse = new Responses();
        $data = json_decode($request->getContent(false), true);
        $form = $entityManager->find(User::class, $id);
        if (!$form) {
            return new JsonResponse('there\'s no such user in the database');
        }

        // var_dump($user);die();
        $reponse->setUser($form);

        $reponse->setContent(json_encode($data['Content']));
        $entityManager->persist($reponse);
        $entityManager->flush();




        return new JsonResponse('Saved new product with id '.$reponse->getId());
}









    /**
     * @Route("Updateview/{id}")
     *
     */
    public function UpdateView(Request $request,$id)
    {
        $data = json_decode($request->getContent(false), true);
        //var_dump($request->getContent());die();
        $entityManager = $this->getDoctrine()->getManager();
        $form= $entityManager->getRepository(Form::class)->find($id);
        if (!$form) {
            return new JsonResponse('there\'s no such a question id in the database');
        }
        $form->setView($data['view']);
        $entityManager->persist($form);
        $entityManager->flush();



        return new JsonResponse('View Updated');
    }



}