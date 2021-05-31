<?php

namespace App\Http\Controllers\Clients\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;

class OrderController extends Controller
{
    use ResponseTrait;

    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['order_status_id'] = OrderStatus::isDefault()->first()->id;
        $data['payment_status_id'] = PaymentStatus::isDefault()->first()->id;
        $order = Order::create($data);
        $order->products()->attach($data['products']);

        return self::okResponse(['order' => new OrderResource($order)]);
    }

    public function payment($provider)
    {
        // todo send
    }

    /**
     * @param $provider
     * @param $status
     * @param $order
     */
    public function getStatusForPayment($provider, $status, $order)
    {
        // todo get response from payment system

        if($status == 'ok') {
            $order = Order::find($order);
            if($order) {
                $paymentStatus = PaymentStatus::where('alias', 'buy')->first();
                $order->update(['payment_status' => $paymentStatus->id]);
            }
        }
    }
}

