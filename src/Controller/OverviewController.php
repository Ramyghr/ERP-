<?php

namespace App\Controller;

use App\Entity\Overview;
use App\Form\OverviewType;
use App\Repository\OverviewRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/overview')]
class OverviewController extends AbstractController
{
    #[Route('/', name: 'app_overview_index', methods: ['GET'])]
    public function index(OverviewRepository $overviewRepository): Response
    {   
        
        $orderCount = $overviewRepository->count([]);

        $totala = $overviewRepository->createQueryBuilder('o')
            ->select('SUM(o.total)')
            ->getQuery()
            ->getSingleScalarResult();

        $totalPaid = $overviewRepository->createQueryBuilder('o')
            ->select('SUM(o.grand)')
            ->getQuery()
            ->getSingleScalarResult();

        $due = $overviewRepository->createQueryBuilder('o')
            ->select('SUM(o.due)')
            ->getQuery()
            ->getSingleScalarResult();
        return $this->render('overview/index.html.twig', [
            'overviews' => $overviewRepository->findAll(),
            'orderCount' => $orderCount,
            'totala' => $totala,
            'totalPaid' => $totalPaid,
            'due' => $due,
        ]);
    }

    #[Route('/new', name: 'app_overview_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, ProduitRepository $produitRepository, OverviewRepository $overviewRepository): Response
{
    $overview = new Overview();
    $form = $this->createForm(OverviewType::class, $overview);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $subAmount = 0;
        foreach ($overview->getProduct() as $product) {
            $subAmount += $product->getPrice() * $product->getQuantity();
        }

        $vat = $subAmount * 0.17;
        $totala  = $subAmount + $vat;
        $discount = $totala * ($overview->getDiscountPercentage() / 100);
        $granda = $totala - $discount;

        $overview->setVat($vat);
        $overview->setSubAmount($subAmount);
        $overview->setTotala($totala);
        $overview->setGranda($granda);
        $overview->setDiscountPercentage($discount);

        $entityManager->persist($overview);
        $entityManager->flush();

        return $this->redirectToRoute('app_home_eployee', [], Response::HTTP_SEE_OTHER);
    }

    // If form is not submitted or not valid, rendering the form
    return $this->render('overview/new.html.twig', [
        'overview' => $overview,
        'form' => $form->createView(),
        'overviews' => $overviewRepository->findAll(),
        'products' => $produitRepository->findAll(),
    ]);
}


    #[Route('/{id}', name: 'app_overview_show', methods: ['GET'])]
    public function show(Overview $overview): Response
    {
        return $this->render('overview/show.html.twig', [
            'overview' => $overview,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_overview_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Overview $overview, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OverviewType::class, $overview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_home_eployee', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('overview/edit.html.twig', [
            'overview' => $overview,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_overview_delete', methods: ['POST'])]
    public function delete(Request $request, Overview $overview, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$overview->getId(), $request->request->get('_token'))) {
            $entityManager->remove($overview);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home_eployee', [], Response::HTTP_SEE_OTHER);
    }
}
