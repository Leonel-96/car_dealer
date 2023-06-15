<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpClient\HttpClient;

class CarController extends AbstractController
{
    #[Route('/Car', name: 'app_car')]
    public function index(PersistenceManagerRegistry $doctrine, PaginatorInterface $paginator, CarRepository $carRepository, Request $request): Response
    {
        $car = $doctrine->getRepository(Car::class)->findAll();

        $pagination = $paginator->paginate(
            $carRepository->paginationQuery(),
            $request->query->get('page',1),
            12
        );

        $latitude = 52.52; // Latitude souhaitée
        $longitude = 13.41; // Longitude souhaitée

        $url = "https://api.open-meteo.com/v1/meteofrance?latitude=$latitude&longitude=$longitude&hourly=temperature_2m";

        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        $statusCode = $response->getStatusCode();
        if ($statusCode === 200) {
            $data = $response->toArray();

            if (isset($data['hourly']['temperature_2m'][0])) {
                $temperature = $data['hourly']['temperature_2m'][0];
            } else {
                // Gérer le cas où la valeur de température n'est pas disponible
                $temperature = 'N/A';
            }

            return $this->render('car/index.html.twig', [
                'cars' => $car,
                'pagination' => $pagination,
                'temperature' => $temperature
        ]); } 
        else {
                // Gérez ici les erreurs de la requête à l'API
                // Affichez un message d'erreur ou une page d'erreur appropriée
                // Retournez la réponse appropriée
            }
    }

    #[Route('/admin/index',name:'index')]
    public function admin(PersistenceManagerRegistry $doctrine, PaginatorInterface $paginator,CarRepository $carRepository,Request $request): Response
    {
        $data = $doctrine->getRepository(Car::class)->findAll();

        $pagination = $paginator->paginate(
            $carRepository->paginationQuery(),
            $request->query->get('page',1),
            20
        );

        return $this->render('car/admin/index.html.twig', [
            'datas' => $data,
            'pagination' => $pagination,
        ]);
    }
    #[Route('/admin/create',name:'create')]
    public function create(Request $request , PersistenceManagerRegistry $doctrine)
    {
        $car = new Car();
        $form = $this->createForm(CarType::class,$car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $carManager= $doctrine->getManager();
            $carManager->persist($car);
            $carManager->flush();

            $this->addFlash('notice','Submitted Successfully');
        }

        return $this->render('car/admin/create.html.twig',[
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/show/{$id}',name:'view')]
    public function view(PersistenceManagerRegistry $doctrine, $id): Response
    {
        $car = $doctrine->getRepository(Car::class)->find($id);
        $form = $this->createForm(CarType::class,$car);
        return $this->render('car/admin/show.html.twig', [
            'form' => $form->createView()
        ]);

    }
    #[Route('/admin/edit/{$id}',name:'update')]
    public function update(PersistenceManagerRegistry $doctrine,Request $request,$id )
    {
        $car = $doctrine->getRepository(Car::class)->find($id);
        $form = $this->createForm(CarType::class,$car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $carManager= $doctrine->getManager();
            $carManager->persist($car);
            $carManager->flush();

            $this->addFlash('notice','Updated Successfully');
        }

        return $this->render('car/admin/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{$id}',name:'delete')]

    public function delete($id, PersistenceManagerRegistry $doctrine){
        $car = $doctrine->getRepository(Car::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($car);
        $em->flush();

        $this->addFlash('notice','Successfully Deleted');
    }
}
