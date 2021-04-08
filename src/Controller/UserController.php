<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
            $image= $form->get('picture')->getData(); // Recuperer le fichier

            if($image){
                //Recuperer le nom du fichier
                $originalFileName= pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
                //generer un nouveau nom unique pour l'image
                $newFileName = uniqid().'.'.$image->guessExtension();
                try { //Upload l'image dans un dossier du projet
                    $image->move(
                        $this->getParameter('picture_profile_directory'), //parametre de direction de l'upload
                        $newFileName //Donner un nom au fichier
                    );
                }catch (FileException $e){
                    //TODO traiter l exception
                }
                $user->setPictureFileName($newFileName); //Upload le User avec le nom du fichier
            }
            //ensuite configu services yaml parameters

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('main_home');
        }

        return $this->render('user/update.html.twig',[
            'userForm' => $form->createView(),
        ]);
    }
}
