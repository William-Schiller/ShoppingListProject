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
    public function update(Request $request, EntityManagerInterface $entityManager //, SluggerInterface $slugger
    ): Response
    {
        $user = $this->getUser();//on recupere celui qui se log

        $form= $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $image= $form->get('picture')->getData();

            //debut test
            if($image){
                $originalFileName= pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
//                $safeFileName=$slugger->slugify($originalFileName, '.');
//                $newFileName = $safeFileName.'-'.uniqid().'.'.$image->guessExtension();
                $newFileName = $originalFileName;
                try {
                    $image->move(
                        $this->getParameter('picture_profile_directory'),
                        $newFileName . '.jpg' //Je triche sur .jpg
                    );
                }catch (FileException $e){
                    //TODO traiter l exception
                }
                $user->setPictureFileName($newFileName . '.jpg'); // Je triche car fonction guessExtension pose probleme
            }
            //fin test , ensuite configu services yaml parameters

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('main_home');
        }

        return $this->render('user/update.html.twig',[
            'userForm' => $form->createView(),
        ]);
    }
}
