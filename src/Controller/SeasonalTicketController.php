<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SeasonalTicket;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class SeasonalTicketController extends AbstractController
{
    /**
     * @Route("/kjop/sesongbillett/{id}", name="seasonal_ticket_purchase")
     */
    public function purchase(Request $request, $id)
    {
        $seasonalTicket = $this->getDoctrine()
            ->getRepository(SeasonalTicket::class)
            ->find($id);

        if (!$seasonalTicket) {
            throw $this->createNotFoundException(
                'Ingen sesongbillett funnet for id '.$id
            );
        }

        Stripe::setApiKey('your_stripe_secret_key');

        $paymentIntent = PaymentIntent::create([
            'amount' => $seasonalTicket->getPrice() * 100, // converting price to cents
            'currency' => 'nok',
            'description' => 'Kjøp av sesongbillett: ' . $seasonalTicket->getName(),
        ]);

        // Save the payment intent ID and other relevant details in your database

        return $this->render('seasonal_ticket/purchase.html.twig', [
            'seasonalTicket' => $seasonalTicket,
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
}