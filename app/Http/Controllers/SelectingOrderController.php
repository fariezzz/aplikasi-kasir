<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class SelectingOrderController extends Controller
{
    /**
     * Add an order to the selected order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function addToSelectedOrder(Request $request, Order $order)
    {
        // Lakukan pengecekan apakah order sudah ada di dalam selected order
        // Jika belum, tambahkan order ke dalam selected order
        // Anda juga dapat menambahkan logika validasi lain sesuai kebutuhan aplikasi Anda
        // Misalnya, memeriksa apakah order sudah memiliki transaksi atau belum

        // Contoh sederhana: Tambahkan order ke dalam session atau menyimpannya ke dalam database
        // Anda perlu menyesuaikan dengan struktur data dan logika aplikasi Anda
        // Di sini, kami hanya akan menambahkan order ke dalam session

        // Memastikan bahwa selected_orders session telah dibuat sebelumnya
        if (!$request->session()->has('selected_orders')) {
            $request->session()->put('selected_orders', collect());
        }

        // Tambahkan order ke dalam selected_orders session
        $selectedOrders = $request->session()->get('selected_orders');
        $selectedOrders->push($order);
        $request->session()->put('selected_orders', $selectedOrders);

        // Redirect kembali ke halaman sebelumnya atau ke halaman tertentu
        return back();
    }

    /**
     * Remove an order from the selected order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function removeFromSelectedOrder(Request $request, Order $order)
    {
        // Lakukan pengecekan apakah order ada di dalam selected order
        // Jika ada, hapus order dari selected order
        // Anda perlu menyesuaikan logika penghapusan sesuai dengan struktur data dan kebutuhan aplikasi Anda

        // Contoh sederhana: Hapus order dari session selected_orders
        // Di sini, kami hanya akan menggunakan session

        if ($request->session()->has('selected_orders')) {
            $selectedOrders = $request->session()->get('selected_orders');
            $selectedOrders = $selectedOrders->reject(function ($item) use ($order) {
                return $item->id === $order->id;
            });
            $request->session()->put('selected_orders', $selectedOrders);
        }

        // Redirect kembali ke halaman sebelumnya atau ke halaman tertentu
        return back();
    }
}
