<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(path="/users")
 */
class UserController extends AbstractController
{
    /**
     * @Route(path="/add")
     */
    public function add(Request $request): Response
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_user_add', [
                'id' => $user->getId(),
            ]);
        }
        return $this->render('User/add.html.twig', [
            'UserType' => $form->createView()
        ]);
    }
}