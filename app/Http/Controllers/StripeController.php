<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeController extends Controller
{
    public function createAccount(Request $request)
    {
        $stripe = new StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
        $account = $stripe->accounts->create([
            'country' => 'US',
            'type' => 'express',
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            'business_type' => 'individual',
            'business_profile' => ['url' => ''],
        ]);
        return response()->json(["data" => $account]);
    }

    public function createAccountLink($id)
    {
        $stripe = new StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
        $data = $stripe->accountLinks->create([
            'account' => $id,
            'refresh_url' => 'https://example.com/reauth',
            'return_url' => 'https://example.com/return',
            'type' => 'account_onboarding',
        ]);

        return response()->json(["data" => $data]);
    }

    public function retrieveAccount($id)
    {
        $stripe = new StripeClient('sk_test_51OwZmCRutpyIFE5KjOrHlss8Bwx6ukF0c53cVowOzNFp0hixgi7ZrtNRo6cjcfjPFMJuXnFviEq6Vtqhhw9aY4ov00apSzsfUi');
        $data = $stripe->accounts->retrieve($id, []);
        
        return response()->json(["data" => $data]);
    }
}
