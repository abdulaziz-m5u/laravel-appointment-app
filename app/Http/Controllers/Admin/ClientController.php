<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploading;
use App\Http\Requests\Admin\ClientRequest;

class ClientController extends Controller
{
    use MediaUploading;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $client = Client::create($request->validated() + [
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        if ($request->input('photo', false)) {
            $client->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        return redirect()->route('admin.clients.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request,Client $client)
    {
        $client->update($request->validated() + [
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        if ($request->input('photo', false)) {
            if (!$client->photo || $request->input('photo') !== $client->photo->file_name) {
                $client->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
            }
        } elseif ($client->photo) {
            $client->photo->delete();
        }

        return redirect()->route('admin.clients.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    /**
     * Delete all selected Client at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Client::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }
}
