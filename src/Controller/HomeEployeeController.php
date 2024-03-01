<?php

namespace App\Controller;
use App\Entity\Overview;
use App\Form\OverviewType;
use App\Repository\OverviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeEployeeController extends AbstractController
{
    #[Route('/home/eployee', name: 'app_home_eployee')]
    public function index(OverviewRepository $overviewRepository): Response
    {
        $orderCount = $overviewRepository->count([]);

        // Fetch total amount
        $total = $overviewRepository->createQueryBuilder('o')
            ->select('SUM(o.total)')
            ->getQuery()
            ->getSingleScalarResult();

        // Fetch total paid
        $totalPaid = $overviewRepository->createQueryBuilder('o')
            ->select('SUM(o.grand)')
            ->getQuery()
            ->getSingleScalarResult();

        // Fetch total due
        $due = $overviewRepository->createQueryBuilder('o')
            ->select('SUM(o.due)')
            ->getQuery()
            ->getSingleScalarResult();
        return $this->render('employee/home_eployee/HomeEployee.html.twig', [
            'controller_name' => 'HomeEployeeController',
            'overviews' => $overviewRepository->findAll(),
            'orderCount' => $orderCount,
            'total' => $total,
            'totalPaid' => $totalPaid,
            'due' => $due,
        ]);
    }
}
