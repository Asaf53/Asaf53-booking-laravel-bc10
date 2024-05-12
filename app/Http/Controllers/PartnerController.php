<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    function partner()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user->hasRole('client')) return abort(404);
        $user->syncRoles('partner');
        return redirect()->back();
    }
}
