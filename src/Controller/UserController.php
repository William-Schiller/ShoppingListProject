<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route(path="/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/update", name="update")
     */
    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();//on recupere celui qui se log

        $form= $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('main_home');
        }

        return $this->render('user/update.html.twig',[
            'userForm' => $form->createView(),
        ]);
    }
}
