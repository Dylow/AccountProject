<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/new", name="app_new_account")
     */
    public function new(Request $request): Response
    {
        $formAccount = $this->createForm(AccountType::class);

        $formAccount->handleRequest($request);

        if ($formAccount->isSubmitted() && $formAccount->isValid()) {
            $account = $formAccount->getData();
            
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($account);
            $em->flush();
            
        //   return $this->redirectToRoute('app_toto');
        }
    
        return $this->render('account/new.html.twig', [
            'formAccount' => $formAccount->createView()
        ]);
        
    }

    /**
    * @Route("/account/edit/{id<\d+>}", name="app_edit_account")
    */ 
    public function edit(Request $request , Account $account): Response
    {
        $formAccount = $this->createForm(AccountType::class, $account);

        $formAccount->handleRequest($request);

        if ($formAccount->isSubmitted() && $formAccount->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('account/edit.html.twig', [
            'formAccount' => $formAccount->createView(),
            'account' => $account
        ]);
        
    }
    /**
    * @Route("/account/delete/{id<\d+>}", name="app_delete_account")
    */ 
    public function delete(Request $request , Account $account)
    {
        $em = $this->getDoctrine()->getManager();
    
        $em->remove($account);
        $em->flush();
        return $this->redirectToRoute('app_new_account');
    }

    /**
     * @Route("account/home", name="app_home")
     */
    public function index() : Response
    {
    // get the repository
    $accountRepository = $this->getDoctrine()->getRepository(Account::class);

    // // get all accounts
    $accounts = $accountRepository->findAll();

    return $this->render('account/home.html.twig', [
        'accounts' => $accounts,
    ]);
    }
}
