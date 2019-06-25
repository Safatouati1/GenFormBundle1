<?php

namespace Sofia\GenFormBundle\Controller;

use Sofia\GenFormBundle\Entity\Field;
use Sofia\GenFormBundle\Entity\Form;
use Sofia\GenFormBundle\Entity\Reponse;
use Sofia\GenFormBundle\Entity\Trace;
use Sofia\GenFormBundle\Entity\User;
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

class ResponsesController extends AbstractController
{
    /**
     * @Route("/responses", name="responses")
     */
    public function index()
    {
        return $this->render('responses/index.html.twig', [
            'controller_name' => 'ResponsesController',
        ]);
    }



    /**
     * @Route("form/submit/")
     */
    public function ResponseForm(Request $request,\Swift_Mailer $mailer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reponse = new Reponse();
        $data = json_decode($request->getContent(false), true);
//var_dump(json_encode($data['content']));die();
        $form = $entityManager->find(Form::class, $data['idForm']);
        if (!$form) {
            return new JsonResponse('there\'s no such user in the database');
        }
        $user=$entityManager->find(User::class, $form->getUser());

        $creationDate = new \DateTime();
        // var_dump($user);die();

        $reponse->setIdF($form);
        $reponse->setDateCreation($creationDate->format('d/m/Y'));
        $reponse->setEmail($data['Email']);
        $reponse->setContent(json_encode($data['content']));
        $entityManager->persist($reponse);
        $entityManager->flush();
        $notification = new Notification();

        $em = $this->getDoctrine()->getManager();
        $notification->setUser($form->getUser());
        $resp = $entityManager->find(Reponse::class, $reponse->getId());
        if (!$resp) {
            return new JsonResponse('there\'s no such user in the database');
        }
        $message = (new \Swift_Message("new response"))
            ->setFrom($user->getEmail())
            ->setTo($user->getEmail())
            ->setBody("you have a new response from ".$resp->getEmail()."visit your account http://localhost:4200/login");

        $mailer->send($message);
        $notification->setRep($resp);
        $notification->setTitle('Saved new response with id '.$reponse->getId());
        $em->persist($notification);
        $em->flush();


        return new JsonResponse('Saved new response with id '.$reponse->getId());

    }



    /**
     * @Route("api/form/submit/responses/{id}")
     */
    public function getResponseForm(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();


        $form = $entityManager->find(Form::class, $id);
        if (!$form) {
            return new JsonResponse('there\'s no such form in the database');
        }
        $responsesArray = array();
        foreach ($form->getResponses() as $resp) {
            // var_dump($resp);die();
            $data = array(
                'id' => $resp->getId(),
                'DateCreation' => $resp->getDateCreation(),
                'Email' => $resp->getEmail(),
                'content' => $resp->getContent(),

            );
            array_push($responsesArray, $data);
        }
        return new JsonResponse($responsesArray);


    }

    /**
     * @Route("api/formresp/{id}")
     *
     */
    public function FormRespAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $rep = $entityManager->getRepository(Reponse::class)->find($id);
        $form = $entityManager->getRepository(Form::class)->find($rep->getIdF());
        // var_dump($form->getId());die();
        // var_dump($rep->getIdF());die();
        if (!$form) {
            return new JsonResponse('there\'s no such a form id in the database');
        }

        $data = array(

            'id' => $rep->getId(),
            'DateCreation' => $rep->getDateCreation(),
            'Email' => $rep->getEmail(),
            'idF' => $form->getId(),
            'content' => $rep->getContent(),



        );


        return new JsonResponse($data);

    }




    /**
     * @Route("api/formresp/{id}")
     *
     */
    public function NotifcAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $rep = $entityManager->getRepository(Reponse::class)->find($id);
        $form = $entityManager->getRepository(Form::class)->find($rep->getIdF());
        // var_dump($form->getId());die();
        // var_dump($rep->getIdF());die();
        if (!$form) {
            return new JsonResponse('there\'s no such a form id in the database');
        }

        $data = array(

            'id' => $rep->getId(),
            'DateCreation' => $rep->getDateCreation(),
            'Email' => $form->getEmail(),
            'idF' => $form->getId(),
            'content' => $rep->getContent(),



        );


        return new JsonResponse($data);

    }



    /**
     * @Route("api/getrep/{id}")
     */
    public function getResp(Request $resquest,$id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $form = $entityManager->getRepository(Form::class)->find($id);
        if (!$form) {
            return new JsonResponse('there\'s no such a form id in the database');
        }


        $dateRespArray = array();
        $dateRespOcKArray = array();
        $dateRespOcVArray = array();
        foreach ($form->getResponses() as $rep) {


            $data =

                $rep->getDateCreation();
            array_push($dateRespArray, $data);
        }

        $testdata=array_count_values($dateRespArray);
        $dateRespOcKArray=array_keys($testdata);
        $dateRespOcVArray =array_values($testdata);
        $dataArray=array('tabDate' =>$dateRespOcKArray,'tabocc' =>$dateRespOcVArray);
        return new JsonResponse($dataArray);



    }
    /**
     * @Route("api/getQuestRep/{id}")
     *
     */
    public function statAction(Request $request,$id)
    {    $entityManager = $this->getDoctrine()->getManager();
        $dateRespArray = array();

        $form = $entityManager->getRepository(Form::class)->find($id);
        if (!$form) {
            return new JsonResponse('there\'s no such id in the database');
        }
        $dateRes = array();
        foreach ($form->getResponses() as $f){
            $json=json_decode($f->getContent(),true);
            if(is_array($json)){
                foreach ($json as $j){
                    if(array_key_exists('rep',$j)){
                        $field = $entityManager->getRepository(Field::class)->find($j['id']);
                        if (!$field) {
                            return new JsonResponse('there\'s no such id in the database');
                        }
                        // var_dump($j['id']);die();
                        array_push($dateRespArray,$field->getLabel());
                    }
                }
            }

        }



        $testdata=array_count_values($dateRespArray);
        $dateRespOcKArray=array_keys($testdata);
        $dateRespOcVArray =array_values($testdata);
        $dataArray=array('tabDate' =>$dateRespOcKArray,'tabocc' =>$dateRespOcVArray);
        // var_dump($dateRespOcKArray);die();
        return new JsonResponse($dataArray);
    }




    /**
     * @Route("api/getcheckRep/{id}")
     *
     */
    public function statcheckAction(Request $request,$id)
    {    $entityManager = $this->getDoctrine()->getManager();
        $dateRespArray = array();

        $form = $entityManager->getRepository(Form::class)->find($id);
        if (!$form) {
            return new JsonResponse('there\'s no such id in the database');
        }
        $dateRes = array();
        foreach ($form->getResponses() as $f){
            $json=json_decode($f->getContent(),true);
            if(is_array($json)){
                foreach ($json as $j){
                    if(array_key_exists('rep',$j)){
                        $field = $entityManager->getRepository(Field::class)->find($j['id']);
                        if (!$field) {
                            return new JsonResponse('there\'s no such id in the database');
                        }
                        // var_dump($j['id']);die();
                        array_push($dateRespArray,$field->getLabel());
                    }else{
                        var_dump(false);
                    }
                }
            }

        }



        $testdata=array_count_values($dateRespArray);
        return new JsonResponse($testdata);
    }


}
