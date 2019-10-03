<?php
namespace App\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

use App\Entity\Hotel;

class ApiController extends FOSRestController
{
    /**
     * Obtiene el listado completo de hoteles
     * @Rest\Get("/hotels")
     */
    public function getHotels()
    {

      $hotels = $this->getDoctrine()
        ->getRepository(Hotel::class)
        ->findAll();

      $data = array();
      foreach($hotels as $hotel){
        $data[]=array(
          'id' => $hotel->getId(),
          'data' => $hotel->getName(),
          'address' => $hotel->getAddress(),
          'phone' => $hotel->getPhone(),
          'stars' => $hotel->getStars(),
          'price' => number_format($hotel->getPrice(),0,",","."),
          'country' => $hotel->getCountry(),
          'city' => $hotel->getCity(),

        );
      }

      return View::create($data, Response::HTTP_OK);

    }

    /**
     * Obtiene el listado de hoteles con base a los filtros dados
     * @Rest\Get("/hotels/{filters}")
     */
    public function getHotelsByFilter($filters)
    {
      $filters = json_decode(urldecode(base64_decode($filters)),true);

      $repository = $this->getDoctrine()
        ->getRepository(Hotel::class);

      $query = $repository->createQueryBuilder('h')
        ->where('h.id != 0');


      if($filters['country']!=''){
        $query->andWhere('h.country = :country')->setParameter('country', $filters['country']);
      }
      if($filters['city']!=''){
        $query->andWhere('h.city = :city')->setParameter('city', $filters['city']);
      }
      if($filters['stars']!=''){
        $query->andWhere('h.stars = :stars')->setParameter('stars', $filters['stars']);
      }

      switch($filters['price']){
        case '1':{
          $query->andWhere('h.price < 50000');
        }break;
        case '2':{
          $query->andWhere('h.price >= 50000');
          $query->andWhere('h.price <= 100000');
        }break;
        case '3':{
          $query->andWhere('h.price > 100000');
        }break;
      }

      $hotels = $query->getQuery()->getResult();

      $data = array();
      foreach($hotels as $hotel){
        $data[]=array(
          'id' => $hotel->getId(),
          'data' => $hotel->getName(),
          'address' => $hotel->getAddress(),
          'phone' => $hotel->getPhone(),
          'stars' => $hotel->getStars(),
          'price' => number_format($hotel->getPrice(),0,",","."),
          'country' => $hotel->getCountry(),
          'city' => $hotel->getCity(),

        );
      }

      return View::create($data, Response::HTTP_OK);
    }

    /**
     * Crea un hotel nuevo
     * @Rest\Post("/hotels")
     */
    public function createHotel(Request $request)
    {

      //...

      return View::create($article, Response::HTTP_CREATED);

    }

    /**
     * Actualiza un hotel
     * @Rest\Put("/hotels/{idHotel}")
     */
    public function updateHotel(Request $request)
    {

      //...

      return View::create($article, Response::HTTP_CREATED);

    }

    /**
     * Elimina un hotel
     * @Rest\Delete("/hotels/{idHotel}")
     */
    public function deleteHotel(Request $request)
    {

      //...

      return View::create($article, Response::HTTP_CREATED);

    }




}
