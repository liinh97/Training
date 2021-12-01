<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authenticate;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getLogin(){
        return view('login');
    }

    public function postLogin(Authenticate $request){
        $login = [
            'name' => $request['name'],
            'password' => $request['password'],
            'role' => User::ADMIN,
        ];
        if (Auth::attempt($login)) {
            return redirect()->route('users.index');
        } else {
            return redirect()->back()->withErrors(['err' => 'Check again your account']);
        }
    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('users.getLogin');
    }

    public function index(Request $request){
        $users = User::orderBy('id', 'desc')->select([
            'id',
            'name',
            'email',
            'phone',
            'post_code',
            'city',
            'ward',
            'address', 
            'note'
        ]);
        $cities = User::groupBy('city');
        $wards = User::groupBy('ward');
        $oldValue = (object)[];
        if(isset($request['Name']) && !empty($request['Name'])){
            $users = $users->where('name', 'like', '%' . $request['Name'] . '%');
            $cities = $cities->where('name', 'like', '%' . $request['Name'] . '%');
            $wards = $wards->where('name', 'like', '%' . $request['Name'] . '%');
            $oldValue->Name = $request['Name'];
        }
        if(isset($request['Phone']) && !empty($request['Phone'])){
            $users = $users->where('phone', 'like', '%' . $request['Phone'] . '%');
            $cities = $cities->where('phone', 'like', '%' . $request['Phone'] . '%');
            $wards = $wards->where('phone', 'like', '%' . $request['Phone'] . '%');
            $oldValue->Phone = $request['Phone'];
        }
        if(isset($request['City']) && !empty($request['City'])){
            $users = $users->where('city', 'like', '%' . $request['City'] . '%');
            $cities = $cities->where('city', 'like', '%' . $request['City'] . '%');
            $wards = $wards->where('city', 'like', '%' . $request['City'] . '%');
            $oldValue->City = $request['City'];
        }
        if(isset($request['Ward']) && !empty($request['Ward'])){
            $users = $users->where('ward', 'like', '%' . $request['Ward'] . '%');
            $cities = $cities->where('ward', 'like', '%' . $request['Ward'] . '%');
            $wards = $wards->where('ward', 'like', '%' . $request['Ward'] . '%');
            $oldValue->Ward = $request['Ward'];
        }
        $users = $users->paginate(User::PAGINATE);
        $cities = $cities->pluck('city');
        $wards = $wards->pluck('ward');
        return view('users.users', compact('users', 'oldValue', 'cities', 'wards'));
    }

    public function create(){
        return view('users.user-create')->with('title', 'User Create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'post_code' => 'required',
            'city' => 'required',
            'ward' => 'required',
            'address' => 'required',
            'note' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return view('users.user-create')->with('errs', $validator->errors());
        }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'post_code' => $request['post_code'],
            'city' => $request['city'],
            'ward' => $request['ward'],
            'address' => $request['address'],
            'role' => User::USER,
            'note' => $request['note'],
            'password' => bcrypt($request['password']),
        ]);
        if($user){
            return redirect()->route('users.index');
        }
        return view('users.users-create')->with('status', false);
    }

    public function edit($id){
        $user = User::find($id);
        return view('users.user-create', compact('user'));
    }

    public function update(Request $request, $id){
        $user = User::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user['id'],
            'phone' => 'required',
            'post_code' => 'required',
            'city' => 'required',
            'ward' => 'required',
            'address' => 'required',
            'note' => 'required',
        ]);
        if($validator->fails()){
            return view('users.user-create')->with('errs', $validator->errors());
        }
        if(!is_null($request['password'])){
            $password = bcrypt($request['password']);
        }else{
            $password = $user['password'];
        }
        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'post_code' => $request['post_code'],
            'city' => $request['city'],
            'ward' => $request['ward'],
            'address' => $request['address'],
            'note' => $request['note'],
            'password' =>  $password,
        ]);
        if($user){
            return redirect()->route('users.index');
        }
        return view('users.users-create')->with('status', false);
    }

    public function destroy($id){
        User::where('id', $id)->delete();
        return redirect()->route('users.index');
    }
}
