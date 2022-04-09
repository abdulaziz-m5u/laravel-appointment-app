<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploading;
use App\Http\Requests\Admin\EmployeeRequest;

class EmployeeController extends Controller
{
    use MediaUploading;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all()->pluck('name', 'id');

        return view('admin.employees.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $employee = Employee::create($request->validated() + [
                'email' => $request->email,
                'phone' => $request->phone
            ]);
        $employee->services()->sync($request->input('services', []));
        
        if ($request->input('photo', false)) {
            $employee->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        return redirect()->route('admin.employees.index')->with([
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
    public function edit(Employee $employee)
    {
        $services = Service::all()->pluck('name', 'id');

        $employee->load('services');

        return view('admin.employees.edit', compact('services', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request,Employee $employee)
    {
        $employee->update($request->validated() + [
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        $employee->services()->sync($request->input('services', []));
    
        if ($request->input('photo', false)) {
            if (!$employee->photo || $request->input('photo') !== $employee->photo->file_name) {
                $employee->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
            }
        } elseif ($employee->photo) {
            $employee->photo->delete();
        }

        return redirect()->route('admin.employees.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    /**
     * Delete all selected Employee at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Employee::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }
}
