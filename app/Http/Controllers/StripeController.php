<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Transfer;

class StripeController extends Controller
{
    public function createAccount(Request $request)
    {
        $stripe = new StripeClient('sk_test_51OwZmCRutpyIFE5KjOrHlss8Bwx6ukF0c53cVowOzNFp0hixgi7ZrtNRo6cjcfjPFMJuXnFviEq6Vtqhhw9aY4ov00apSzsfUi');
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
        try {
            $stripe = new StripeClient('sk_test_51OwZmCRutpyIFE5KjOrHlss8Bwx6ukF0c53cVowOzNFp0hixgi7ZrtNRo6cjcfjPFMJuXnFviEq6Vtqhhw9aY4ov00apSzsfUi');
            $data = $stripe->accountLinks->create([
                'account' => $id,
                'refresh_url' => 'https://example.com/reauth',
                'return_url' => 'https://example.com/return',
                'type' => 'account_onboarding',
            ]);
            //code...
            return response()->json(["data" => $data]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(["data" => $th->getMessage()]);
        }
    }

    public function retrieveAccount($id)
    {
        $stripe = new StripeClient('sk_test_51OwZmCRutpyIFE5KjOrHlss8Bwx6ukF0c53cVowOzNFp0hixgi7ZrtNRo6cjcfjPFMJuXnFviEq6Vtqhhw9aY4ov00apSzsfUi');
        $data = $stripe->accounts->retrieve($id, []);

        return response()->json(["data" => $data]);
    }

    public function loginAccountLink($id)
    {
        try {
            $stripe = new StripeClient('sk_test_51OwZmCRutpyIFE5KjOrHlss8Bwx6ukF0c53cVowOzNFp0hixgi7ZrtNRo6cjcfjPFMJuXnFviEq6Vtqhhw9aY4ov00apSzsfUi');
            $data = $stripe->accounts->createLoginLink($id, []);
            return response()->json(["data" => $data]);
            //code...
        } catch (\Throwable $th) {
            return response()->json(["data" => $th->getMessage()]);
            //throw $th;
        }
    }

    public function payoutAccount($id)
    {
        Stripe::setApiKey('sk_test_51OwZmCRutpyIFE5KjOrHlss8Bwx6ukF0c53cVowOzNFp0hixgi7ZrtNRo6cjcfjPFMJuXnFviEq6Vtqhhw9aY4ov00apSzsfUi');
        try {
            $data = Transfer::create([
                "amount" => 1000,
                "currency" => "usd",
                "destination" => $id,
              ]);
            return response()->json(["data" => $data]);
            //code...
        } catch (\Throwable $th) {
            return response()->json(["data" => $th->getMessage()]);
            //throw $th;
        }
    }
}
