<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $users = User::where('roles','MB')->where('rb_id',Auth::user()->id)->with('status')->get();

            return Datatables::of($users)
              
                 ->addColumn('aksi',function($data){
                    $edit = '<a href="users/'.$data->id.'/edit" data-toggle="tooltip" data-placement="top"  onClick="Edit(this.id)"  id="' . $data->id . '" title="Edit Produk" class="btn btn-success btn-sm"> <i class="fa  fa-pencil-alt"></i> </a>';
                    return $edit;
                })
                 ->addColumn('status',function($data){
                    return $data->status_id != null ? $data->status->name :'-';
                })
                ->addIndexColumn()
                ->rawColumns(['aksi','status'])
                ->make(true);
        }
        return view('pages.mitra.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.mitra.u+sers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate(
                $request,
                [
                    'name'    => 'required|unique:users',
                    'phone'    => 'required|unique:users',
                    'email'    => 'required|unique:users',
                    'pemilik'    => 'required|unique:users',
                    'alamat'    => 'required',
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required',
                ]
            );

            User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'pemilik' => $request->pemilik,
                'alamat' => $request->alamat,
                'roles' => "MB",
                'rb_id' => Auth::user()->id,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('users.index')->with('success','data berhasil disimpan!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('pages.mitra.users.edit',compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'pemilik' => $request->pemilik,
                'alamat' => $request->alamat,
        ]);
        return redirect()->route('users.index')->with('success','data berhasil disimpan!!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
