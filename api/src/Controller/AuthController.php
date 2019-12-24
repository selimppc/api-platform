<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @var UsersRepository $usersRepository
     */
    private $usersRepository;


    /**
     * AuthController constructor.
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @Route("/auth", name="auth")
     */
    public function index()
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function register(Request $request){

        //decode json data
        $requestData = json_decode($request->getContent(), true);

        //set data to be inserted
        $newUserData['email']    = $requestData['email'];
        $newUserData['password'] = $requestData['password'];

        //store data into Database -> users table
        $user = $this->usersRepository->createNewUser($newUserData);

        //return your desired message
        return new JsonResponse([
            'status' => 'success',
            'message' => sprintf('User %s successfully created', $user->getUsername())
        ], JsonResponse::HTTP_OK);

    }



    /**
     * api route redirects
     * @return Response
     */
    public function api()
    {
        return new Response(sprintf("Logged in as %s", $this->getUser()->getUsername()));
    }





}
