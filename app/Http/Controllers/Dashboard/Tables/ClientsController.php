<?php

namespace App\Http\Controllers\Dashboard\Tables;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        abort_if(!$request->ajax(), 404);

        return datatables()->of(User::with(['images','license'])->orderByDesc("id")->get())
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return $data->full_name;
            })
            ->addColumn('email', function ($data) {
                return $data->email;
            })
            ->addColumn('type', function ($data) {
                $color = $data->isAdmin() ? "success" : "dark";

                return "<a class='text-$color text-dark'>" . ($data->isAdmin() ? "Admin" : "client") . "</a>";
            })
            ->addColumn('status', function ($data) {
                $color = $data->isActive()?  "success" : "danger" ;

                $status = $data->isActive() ? "active" : "blocked";

                return "<span class='badge badge-$color'>$status</span>";
            })
            ->addColumn('action', function ($data) {
                $btn = " ";


                $btn .= $this->editBtn($data);
                $btn .= $this->activeBlockBtn($data);
                $btn .= $this->deleteBtn($data);

                return $btn;
            })
            ->rawColumns(['action', 'type', 'status'])
            ->make(true);

    }



    private function editBtn($data)
    {
        if (auth()->user()->canEdit()) {


            return "<div class='btn btn-primary mr-1 btn-edit-user' title='Edit $data->name' data-data='$data'><i class='fa fa-edit'></i> Edit</div>";
        }
    }

    private function activeBlockBtn($data)
    {
        if (auth()->user()->canUserStatus()) {

            $blockClass = $data->isActive() ?  "btn-warning" : "btn-info";

            $blockTitle = $data->isActive() ? "Block" : "Active";

            return "<div class='btn mr-1 btn-block-user $blockClass' data-widget='" . $data->isActive() . "' data-route='" . route("dashboard.client.change.status", $data->id) . "' title='$blockTitle $data->name' data-name='$data->name' data-id='$data->id'><i class='fa-solid fa-ban'></i> $blockTitle</div>";

        }
    }


    private function deleteBtn($data)
    {
        if (auth()->user()->canDelete()) {
            return '<button class="btn btn-danger btn-delete " type="button"
        data-url="' . route("dashboard.clients.destroy", $data->id) . '"
        data-name="' . ($data->name) . '"
        data-token="' . csrf_token() . '"
        data-title="Are you Sure"
        data-text="Delete ' . ($data->name) . '"
        data-back="' . route("dashboard.clients.index") . '">
        <i class="fa fa-trash"></i> Delete</a>';
        }
    }

}
