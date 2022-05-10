<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCountryController extends AbstractController
{
    public function __construct(private CountryRepository $countryRepository,private EntityManagerInterface $em, private PaginatorInterface $paginator)
    { }

    #[Route('/admin/country_all', name: 'app_admin_country_all')]
    public function list(Request $request): Response
    {
        $qb = $this->countryRepository->getQbAll();
        $pagination = $this->paginator->paginate(
            $qb,
            $request->query->getInt('page',1),
            5
        );

        return $this->render('admin_country/all.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/admin/country/{slug}', name: 'app_admin_country_details')]
    public function details($slug): Response
    {
        $country = $this->countryRepository->findOneBy(['slug' => $slug]) ;
        dump($country);
        
        return $this->render('admin_country/details.html.twig', [
            'country' => $country,
        ]);
    }

    #[Route('/admin/country_edit/{slug}', name: 'app_admin_country_edit')]
    public function edit($slug, Request $request): Response
    {
        $countryEntity = $this->countryRepository->findOneBy(['slug' => $slug]) ;

        $form = $this->createForm(CountryType::class, $countryEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('app_admin_country_all');
        }

        return $this->render('admin_country/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/country_delete/{slug}', name: 'app_admin_country_delete')]
    public function delete($slug): Response
    {
        $country = $this->countryRepository->findOneBy(['slug' => $slug]) ;
        $this->em->remove($country);
        $this->em->flush();

        return $this->redirectToRoute('app_admin_country_all');
    }

    #[Route('/admin/country_add', name: 'app_admin_country_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(CountryType::class, new Country());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $country = $form->getData();
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('app_admin_country_all');
        }

        return $this->render('admin_country/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
