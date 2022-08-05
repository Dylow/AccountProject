<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\TestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     */
    public function index(): Response
    {
        // $form = $this->createForm(TestType::class);

        // get the repository
        $accountRepository = $this->getDoctrine()->getRepository(Account::class);

        // // get all accounts
        $accounts = $accountRepository->findAll();

        // // get one account by id
        $account = $accountRepository->find(2);

        $account->setBalance(100);

        $accountRepository->update();

        // $newAccount = new Account();
        // $newAccount->setName('PEL');
        // $newAccount->setBalance(200);

        // $accountRepository->add($newAccount,true);

        return $this->render('test/test.html.twig', [
            'accounts' => $accounts,
        ]);
    }
}
