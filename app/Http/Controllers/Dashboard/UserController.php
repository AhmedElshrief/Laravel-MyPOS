<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use function foo\func;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:create-users'])->only('create');
        $this->middleware(['permission:read-users'])->only('index');
        $this->middleware(['permission:update-users'])->only('edit');
        $this->middleware(['permission:delete-users'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        if($request->search){
//            $users = User::where('first_name', 'like', '%' . $request->search . '%')
//                ->orWhere('last_name', 'like', '%' . $request->search . '%')
//                ->get();
//        }else{
//            $users = User::whereRoleIs('admin')->get();
//        }

        $users = User::whereRoleIs('admin')->where(

            function ($q) use ($request)
            {
                return $q->when($request->search, function ($query) use ($request){

                    return $query->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                });

            })->latest()->paginate(2);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
         $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1',
        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image ']);
        $request_data['password'] = bcrypt($request->password);

        if ($request->image)
        {
            $request->image->store('users_images');
            $request_data['image'] = $request->image->hashName();
        }//end of if


        $user = User::create($request_data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    //
    // Update the specified resource in storage.
    //
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id) ],
            'image' => 'image',
//            'permission' => 'required',
        ]);

        $request_data = $request->except(['permissions', 'image']);

        if ($request->image)
        {
            if ($user->image != 'default.jpg')
            {
                Storage::disk('public_uploads')->delete('/users_images/'.$user->image);
            }

            $request->image->store('users_images');
            $request_data['image'] = $request->image->hashName();

        }//end of if

        $user->update($request_data);
        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.users.index');

    }//end of update method

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if($user->image != 'default.jpg'){
            Storage::disk('public_uploads')->delete('/users_images/'.$user->image);
        }

        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
