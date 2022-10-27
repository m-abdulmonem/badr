<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Utils\MediaController;
use App\Http\Requests\Dashboard\Users\UsersRequest;
use App\Models\User;
use App\Traits\SendOtp;
use Illuminate\Support\Facades\Hash;

class ClientsController extends Controller
{
    use SendOtp;

    private string $folder = "dashboard.pages.users.";


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->canDisplay(), 403);


        $data = [
            'title' => 'Users Managment',
        ];

        return view($this->folder . "index", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(UsersRequest $request)
    {
        abort_if((!auth()->user()->canCreate() || !auth()->user()->canEdit()), 403);

        $request->merge([
            'full_name' => ($request->f_name . " " . $request->m_name . " " . $request->l_name),
            'password' => ($request->password ? Hash::make($request->password) : User::find($request->id)->password),
            'otp_code' => $this->send($request->email)
        ]);

        $data = User::updateOrCreate(['id' => $request->id], $request->except("_token", "id"));

        $data->license()->create($request->licenses);

        $this->upload($request, $data->id);

        return \response()->json(['data' => $data, 'status' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return
     */
    public function destroy(User $client)
    {
        abort_if(!auth()->user()->canDelete(), 403);

        if ($images = $client->images()) {
            $images->delete();
        }

        if ($licenses = $client->license()) {
            $licenses->delete();
        }

        $client->delete();

        return \response()->json(['status' => 1]);
    }



    private function upload($request, $userId)
    {
        if ($photos = $request->photos) {
            MediaController::upload($request,$photos, $userId);
        }
    }


}
