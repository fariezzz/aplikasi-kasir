<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use Illuminate\Http\Request;
use App\Mail\RequestDenied;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class AccountRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (! Gate::allows('admin')) {
            return back();
        }

        Cache::forget('new_request');

        return view('pages.request.index', [
            'title' => 'Requests',
            'requests' => AccountRequest::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!auth()->guest()){
            return back();
        }

        return view('pages.request.create', [
            'title' => 'Make a Request',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!auth()->guest()){
            return back();
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|string|min:5|max:20|alpha_dash|unique:users,username|unique:account_requests,username',
            'email' => 'required|email:dns|unique:users,email|unique:account_requests,email',
            'role' => 'required',
            'reasons' => 'required'
        ]);

        $validatedData['status'] = 'Pending';

        AccountRequest::create($validatedData);

        Cache::put('new_request', true);

        return redirect('/login')->with('success', 'Request has been successfully sent.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountRequest $accountRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountRequest $accountRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountRequest $account_request)
    {
        if (! Gate::allows('admin')) {
            return back();
        }

        if ($request->status == 'Denied') {
            $account_request->delete();

            Mail::to($account_request->email)->send(new RequestDenied($account_request->name));
            return back()->with('success', 'Request has been successfully denied and the email has been sent to '. $account_request->email .'.');
        }

        if ($request->status === 'Accepted') {
            return redirect()->route('users.create', [
                'name' => $account_request->name,
                'email' => $account_request->email,
                'username' => $account_request->username,
                'role' => $account_request->role,
                'request_id' => encrypt($account_request->id)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountRequest $accountRequest)
    {
        //
    }
}
