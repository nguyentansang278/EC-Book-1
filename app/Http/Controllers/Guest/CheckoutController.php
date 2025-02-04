<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\Checkout\CheckoutRequest;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Address;
use App\Models\OrderItem;

use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Charge;
use Stripe\Stripe;
use App\Enums\PaymentMethod;


class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $address = Address::where('user_id', auth()->id())->first();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('info', 'Your cart is empty, please add items to your cart before proceeding to checkout.');
        }

        if (is_null($address)) {
            return redirect()->route('profile.edit')->with('info', 'Please add your address before proceeding to checkout.');
        }

        return view('guest.checkout.index', compact('cartItems', 'address'));
    }

    public function processCheckout(CheckoutRequest $request)
    {
        $paymentMethod = PaymentMethod::from($request->input('payment_method'));
        $address = Address::find($request->input('address_id'));
        $totalPrice = $request->input('total_price');

        if ($paymentMethod === PaymentMethod::CreditCard) {
            return $this->handleStripePayment($request, $totalPrice);
        } elseif ($paymentMethod === PaymentMethod::PayPal) {
            return $this->handlePayPalPayment($request, $totalPrice);
        } else {
            return $this->handleCashOnDelivery($request, $totalPrice);
        }
    }

    private function handleStripePayment(Request $request, $totalPrice)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $stripeToken = $request->input('stripeToken');
            if (!$stripeToken) {
                throw new \Exception('Stripe token is missing.');
            }

            $charge = Charge::create([
                'amount' => $totalPrice * 100, // Số tiền tính bằng cents
                'currency' => 'usd',
                'source' => $stripeToken,
                'description' => 'Payment for order',
            ]);

            // Lưu thông tin đơn hàng vào cơ sở dữ liệu
            $this->createOrder($request, 'card', $charge->id);

            return redirect()->route('order.success')->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function handlePayPalPayment(Request $request, $totalPrice)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $totalPrice
                    ]
                ]
            ]
        ]);

        if (isset($response['id'])) {
            $this->createOrder($request, 'paypal', $response['id']);

            return redirect($response['links'][1]['href']);
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    private function handleCashOnDelivery(Request $request, $totalPrice)
    {
        // Lưu thông tin đơn hàng vào cơ sở dữ liệu
        $this->createOrder($request, 'cod', null);

        return redirect()->route('order.success')->with('success', 'Order placed successfully!');
    }

    private function createOrder(Request $request, $paymentMethod, $transactionId)
    {
        $order = new Order();
        $order->user_id = auth()->id();
        $order->address_id = $request->input('address_id');
        $order->payment_method = $paymentMethod;
        $order->transaction_id = $transactionId;
        $order->total_price = $request->input('total_price');
        $order->order_status = 'pending';
        $order->save();

        $cartItems = Cart::where('user_id', auth()->id())->get();
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item->book_id,
                'quantity' => $item->quantity,
                'price' => $item->book->price,
            ]);
        }
        Cart::where('user_id', auth()->id())->delete();

        $this->sendOrderEmail($order);
    }

    private function sendOrderEmail(Order $order)
    {
        try {
            Mail::to($order->user->email)->send(new OrderPlacedMail($order));
        } catch (\Exception $e) {
            \Log::error('Failed to send order email: ' . $e->getMessage());
        }
    }
}
