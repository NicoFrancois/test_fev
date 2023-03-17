<?php

namespace App\Controller;

use App\Command\Command\AddUserCommand;
use App\Command\CommandHandler\AddUserCommandHandler;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UserType;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home" )
     * @method ({"POST"})
     */
    public function home()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @param UserRepository $repository
     * @return Response
     *
     * @Route("/index-user", name="index_user")
     */
    public function index(UserRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $pagination = $paginator->paginate(
            $repository->getAllByName(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('indexUser.html.twig', [
            'users' => $pagination,
        ]);
    }

    /**
     * @param Request $request
     * @param AddUserCommandHandler $handler
     * @return RedirectResponse|Response
     * @Route("/add", name="add_user")
     * @method ({"GET", "POST"})
     */
    public function add(Request $request, AddUserCommandHandler $handler)
    {
        $command = new AddUserCommand();

        $form = $this->createForm(UserType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', sprintf('User added'));
                return $this->redirectToRoute('index_user');
            } catch ( \Exception $e ) {
                $this->addFlash('error', sprintf("Error : %s", $e->getMessage()));
            }
        }

        return $this->render('add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}