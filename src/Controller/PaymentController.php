<?php

namespace App\Controller;

use App\Entity\FeeTier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;

class PaymentController extends AbstractController
{
    /**
     * @Route("/process-payment", name="process_payment")
     */
    public function processPayment(): Response
    {
        $ticketPrice = $this->getTicketPrice(); // Implement this method
        $feePercentage = $this->getFeePercentage($ticketPrice);
        $feeAmount = $ticketPrice * ($feePercentage / 100);

        Stripe::setApiKey('your_stripe_secret_key');

        $charge = \Stripe\Charge::create([
            'amount' => $ticketPrice + $feeAmount,
            'currency' => 'usd',
            // Add other Stripe charge parameters here
        ]);

        // Handle charge response

        return new Response('Payment processed');
    }

    private function getFeePercentage($ticketPrice): float
    {
        $feeTiers = $this->getDoctrine()
            ->getRepository(FeeTier::class)
            ->findAll();

        foreach ($feeTiers as $tier) {
            if ($ticketPrice >= $tier->getThreshold()) {
                return $tier->getPercentage();
            }
        }

        return 0; // Default fee percentage if no tier matches
    }
}