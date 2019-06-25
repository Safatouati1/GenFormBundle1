<?php

namespace Sofia\GenFormBundle\Controller;

use Sofia\GenFormBundle\Entity\Categorie;
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

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index()
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }



    /**
     * @Route("api/categorieform/{id}")
     *
     */
    public function categorieFormAction(Request $request, $id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $form = $entityManager->getRepository(Categorie::class)->find($id);
        if (!$form) {
            return new JsonResponse('there\'s no such a form id in the database');
        }
        $formArray = array();
        $fieldsArray = array();
        foreach ($form->getFields() as $field) {
            $data = array(

                'id' => $field->getId(),
                'typee' => $field->getType(),
                'obligation' => $field->getObligation(),
                'subtitle' => $field->getSubtitle(),
                'Label' => $field->getLabel(),
                'itemArray' => $field->getItemArray(),

            );
            array_push($fieldsArray, $data);
        }
        $data2 = array(
            'id' =>$form->getId(),
            'title' =>$form->getTitle(),
            'description' => $form->getDescription(),
            'Fields' => $fieldsArray,

        );
        array_push($formArray, $data2);

        return new JsonResponse($formArray);

    }


}
