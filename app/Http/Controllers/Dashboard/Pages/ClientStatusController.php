<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientStatusController extends Controller
{
    public function __invoke(Request $request, User $client)
    {
        abort_if(!$request->ajax(), 404);


        abort_if(!auth()->user()->canUserStatus(),403);


        $updated = $client->update([
            'status' => !$client->isActive()
        ]);

        return \response()->json(['msg' => "$client->full_name status was changed successfully", 'status' => 1,'data' =>  $updated]);


    }

}
