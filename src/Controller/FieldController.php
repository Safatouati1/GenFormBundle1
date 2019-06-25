<?php

namespace Sofia\GenFormBundle\Controller;

use Sofia\GenFormBundle\Entity\Field;
use Sofia\GenFormBundle\Entity\Form;
use Sofia\GenFormBundle\Entity\Reponse;
use Sofia\GenFormBundle\Entity\Trace;
use App\User;
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

class FieldController extends AbstractController
{
    /**
     * @Route("/field", name="field")
     */
    public function index()
    {
        return $this->render('field/index.html.twig', [
            'controller_name' => 'FieldController',
        ]);
    }



    /**
     * @Route("api/Deletequestion/{id}")
     *
     */
    public function DeleteQuestionAction(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $field= $entityManager->getRepository(Field::class)->find($id);
        if (!$field) {
            return new JsonResponse('there\'s no such a question id in the database');
        }
        /* foreach ($form->getFields() as $field) {
             $entityManager->remove($field);
         }*/
        $entityManager->remove($field);
        $entityManager->flush();
        return new JsonResponse('question deleted');
    }

}
