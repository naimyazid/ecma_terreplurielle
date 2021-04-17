<?php

namespace App\Controller\Admin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminListUsersController extends AbstractController
{
    /**
     * @Route("/admin/list/user", name="admin_list_users")
     */
    public function index(PaginatorInterface $paginator, UserRepository $userRepository, Request $request)
    {
        $users = $paginator->paginate(
            $userRepository->findAllQuery(),
            $request->query->getInt('page',1),
            8
        );
        return $this->render('admin/audio/list_users.html.twig',[
            "users"=>$users
        ]);
    }

}