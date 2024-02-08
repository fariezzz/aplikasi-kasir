<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class ChangeStatusController extends Controller
{
    public function changeStatus(Request $request, $id) {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();
    
        return response()->json(['message' => 'Transaction status updated successfully']);
    }
}
