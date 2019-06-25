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

class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification")
     */
    public function index()
    {
        return $this->render('notification/index.html.twig', [
            'controller_name' => 'NotificationController',
        ]);
    }


    /**
     * @Route("api/getnotif/{id}")
     *
     */
    public function getNotifcAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return new JsonResponse('there\'s no such a form id in the database');
        }


        $notifsArray = array();
        foreach ($user->getNotifs() as $notif) {
            $rep= $entityManager->getRepository(Reponse::class)->find($notif->getRep());
            if (!$rep) {
                return new JsonResponse('there\'s no such a form id in the database');
            }
            $form= $entityManager->getRepository(Form::class)->find($rep->getIdF());
            if (!$form) {
                return new JsonResponse('there\'s no such a form id in the database');
            }

            $data = array(
                'id' => $notif->getId(),
                'title' => $notif->getTitle(),
                'titleform' =>$form->getTitle(),
                'emailRep' =>$rep->getEmail(),
                'dateRep' =>$rep->getDateCreation(),

            );
            array_push($notifsArray, $data);
        }
        return new JsonResponse($notifsArray);

    }



    /**
     * @Route("api/DeleteNotif/{id}")
     *
     */
    public function DeleteAction(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $no= $entityManager->getRepository(Notification::class)->find($id);
        if (!$no) {
            return new JsonResponse('there\'s no such a question id in the database');
        }
        /* foreach ($form->getFields() as $field) {
             $entityManager->remove($field);
         }*/
        $entityManager->remove($no);
        $entityManager->flush();
        return new JsonResponse('no deleted');
    }

}
