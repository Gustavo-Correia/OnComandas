<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Lista pedidos - automaticamente filtrados por company_id
     */
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(15);

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Criar pedido - company_id adicionado automaticamente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'total' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        // company_id é adicionado automaticamente pelo BelongsToCompany trait
        $order = Order::create($validated);

        return redirect()->route('orders.index');
    }

    /**
     * Visualizar pedido - só permite se pertencer à mesma empresa
     */
    public function show(Order $order)
    {
        // Global scope garante que $order é da mesma empresa
        return Inertia::render('Orders/Show', [
            'order' => $order->load('items', 'user'),
        ]);
    }
}
