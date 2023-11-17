<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SeasonalTicket;
use Symfony\Component\HttpFoundation\Response;

class SesongbillettController extends AbstractController
{
    /**
     * @Route("/kjop/sesongbillett/{id}", name="sesongbillett_kjop")
     */
    public function kjop($id)
    {
        $sesongbillett = $this->getDoctrine()
            ->getRepository(SeasonalTicket::class)
            ->find($id);

        if (!$sesongbillett) {
            throw $this->createNotFoundException(
                'Ingen sesongbillett funnet med id '.$id
            );
        }

        // Implementer kjøpslogikken her
        // ...

        return new Response('Sesongbillett kjøpt: ' . $sesongbillett->getNavn());
    }
}