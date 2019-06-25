<?php

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
class TraceController extends AbstractController
{
    /**
     * @Route("/trace", name="trace")
     */
    public function index()
    {
        return $this->render('trace/index.html.twig', [
            'controller_name' => 'TraceController',
        ]);
    }



    /**
     * @Route("api/historique/{id}")
     *
     */
    public function TracesAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return new JsonResponse('there\'s no such form id in the database');
        }

        $tracesArray = array();
        foreach ($user->getTraces() as $trace) {
            $form= $entityManager->getRepository(Form::class)->find($trace->getIdF());
            if (!$form) {
                return new JsonResponse('there\'s no such id in the database');
            }


            $data = array(
                'id' => $trace->getId(),
                'titleform' =>$form->getTitle(),
                'emaildest' =>$trace->getMailD(),
                'dateS' =>$trace->getDateS(),

            );
            array_push($tracesArray, $data);
        }

        return new JsonResponse($tracesArray);

    }
    /**
     * @Route("api/DeleteTraces/{id}")
     *
     */
    public function DeleteTracesAction(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $no= $entityManager->getRepository(Trace::class)->find($id);
        if (!$no) {
            return new JsonResponse('there\'s no such id in the database');
        }
        /* foreach ($form->getFields() as $field) {
             $entityManager->remove($field);
         }*/
        $entityManager->remove($no);
        $entityManager->flush();
        return new JsonResponse('no deleted');
    }

}
