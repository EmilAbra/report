<?php

namespace App\Controller;

use
Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    /**
     * @Route("/profile/{userId}", name="app_user", methods={"GET"})
     */
    public function profile(UserRepository $userRepository, int $userId): Response
    {
        $user = $userRepository
        ->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $userId
            );
        }
        $roles = $user->getRoles();

        if (in_array("ROLE_ADMIN", $roles)) {
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('user/user_profile.html.twig');
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function admin(UserRepository $userRepository): Response
    {
        $users = $userRepository
            ->findAll();

        if (empty($users)) {
            throw $this->createNotFoundException(
                'No users found in database'
            );
        }

        return $this->render('user/admin.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/create", name="admin_create_user", methods={"GET"})
     */
    public function adminCreateUser(): Response
    {
        return $this->render('user/admin_create_user.html.twig');
    }

    /**
     * @Route("/admin/create", name="admin_create_user_process", methods={"POST"})
     */
    public function adminCreateUserProcess(
        ManagerRegistry $doctrine,
        Request $request,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $acronym = $request->request->get('acronym');
        $plaintextPassword = $request->request->get('password');
        $name = $request->request->get('name');
        $address  = $request->request->get('address');
        $email  = $request->request->get('email');
        $phone  = $request->request->get('phone');
        $work  = $request->request->get('work');
        $imgpath  = $request->request->get('imgpath');

        $entityManager = $doctrine->getManager();

        $user = new User();

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );

        $user->setAcronym($acronym);
        $user->setPassword($hashedPassword);
        $user->setName($name);
        $user->setAddress($address);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setWork($work);
        $user->setImgpath($imgpath);

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    /**
     * @Route("/admin/{userId}/edit", name="admin_edit_user", methods={"GET"})
     */
    public function editUser(UserRepository $userRepository, int $userId): Response
    {
        $user = $userRepository
        ->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $userId
            );
        }

        return $this->render('user/admin_edit_user.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/{userId}/edit", name="admin_edit_user_process", methods={"GET", "POST"})
     */
    public function editUserProcess(ManagerRegistry $doctrine, int $userId, Request $request): Response
    {
        $acronym = $request->request->get('acronym');
        $name = $request->request->get('name');
        $address  = $request->request->get('address');
        $email  = $request->request->get('email');
        $phone  = $request->request->get('phone');
        $work  = $request->request->get('work');
        $imgpath  = $request->request->get('imgpath');

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $userId
            );
        }

        $user->setAcronym($acronym);
        $user->setName($name);
        $user->setAddress($address);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setWork($work);
        $user->setImgpath($imgpath);

        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    /**
     * @Route("/admin/{userId}/delete", name="admin_delete_user", methods={"GET"})
     */
    public function deleteUser(UserRepository $userRepository, int $userId): Response
    {
        $user = $userRepository
        ->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $userId
            );
        }

        return $this->render('user/admin_delete_user.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/{userId}/delete", name="admin_delete_user_process", methods={"GET", "POST"})
     */
    public function deleteUserProcess(ManagerRegistry $doctrine, int $userId): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $userId
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    /**
     * @Route("/profile/{userId}/edit", name="app_user_edit", methods={"GET"})
     */
    public function profileEdit(): Response
    {
        return $this->render('user/user_profile_edit.html.twig');
    }

    /**
     * @Route("/profile/{userId}/edit", name="user_edit_process", methods={"GET","POST"})
     */
    public function updateUser(ManagerRegistry $doctrine, Request $request, int $userId): Response
    {
        $name = $request->request->get('name');
        $address  = $request->request->get('address');
        $email  = $request->request->get('email');
        $phone  = $request->request->get('phone');
        $work  = $request->request->get('work');
        $imgpath  = $request->request->get('imgpath');

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $userId
            );
        }

        $user->setName($name);
        $user->setAddress($address);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setWork($work);
        $user->setImgpath($imgpath);

        $entityManager->flush();

        return $this->redirectToRoute('app_user', ['userId' => $userId]);
    }

    // /**
    //  * @Route("/user/create", name="create_user")
    //  */
    // public function createUser(
    //     ManagerRegistry $doctrine
    // ): Response {
    //     $entityManager = $doctrine->getManager();

    //     $user = $entityManager->getRepository(User::class)->find(5);
    //     $user->setRoles(['ROLE_ADMIN']);
    //     // $user = new User();
    //     // $user->setAcronym('admin');
    //     // $user->setPassword('\$2y\$13\$.2aIpiHXl6sDgh8ujSefqepuCmautsUPv3Lce2RWutWtxkcAYFXMC');
    //     // $user->setRoles(['ROLE_ADMIN']);
    //     // tell Doctrine you want to (eventually) save the user
    //     // (no queries yet)
    //     $entityManager->persist($user);

    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();

    //     return new Response('Saved new user with id '.$user->getId());
    // }
}
