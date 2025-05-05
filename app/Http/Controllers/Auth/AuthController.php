<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\Rule;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['login','register','index']]);
    }

    //login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('api')->user();
       
        $user->with(['role','branch'])->get();


        return response()->json([
                'status' => 'success',
                'user' =>   new UserResource($user),
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    //register
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone'=> 'required|string',
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=> $request->phone,
            'role_id' => $request->role_id,
            'branch_id' => $request->branch_id,
        ]);

        $token = Auth::guard('api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' =>   new UserResource($user),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    //logout
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }


    //refresh token
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    //get all users 
    public function index(Request $request)
{
        // عدد العناصر في الصفحة (القيمة الافتراضية: 10)
        $perPage = $request->input('per_page', 10);

        // الاستعلام الأساسي مع العلاقات (إذا لزم الأمر)
        $users = User::with(['role', 'branch'])
            ->paginate($perPage);

        // إذا لم يتم العثور على مستخدمين
        if ($users->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No users found',
                'data' => []
            ], 200);
        }

        // إرجاع البيانات باستخدام الـ Resource
        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved successfully',
            'data' => UserResource::collection($users),
            'pagination' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
            ]
        ]);
}

//show one user 

   public function show($id)
        {
            // البحث عن المستخدم مع العلاقات
            $user = User::with(['role', 'branch'])->find($id);

            // إذا لم يتم العثور على المستخدم
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
            }

            // إرجاع البيانات باستخدام الـ Resource
            return response()->json([
                'status' => 'success',
                'message' => 'User retrieved successfully',
                'data' => new UserResource($user)
            ]);
     }

  //store
  public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone'=> 'required|string',
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=> $request->phone,
            'role_id' => $request->role_id,
            'branch_id' => $request->branch_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' =>   new UserResource($user),
        ]);
    }


    //update
    public function update(Request $request, $id)
{
    // التحقق من وجود المستخدم
    $user = User::find($id);
    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'User not found',
        ], 404);
    }

    // التحقق من صحة البيانات
    $validatedData = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => [
            'sometimes',
            'email',
            'max:255',
            Rule::unique('users')->ignore($user->id),
        ],
        'password' => 'sometimes|string|min:6',
        'phone' => 'sometimes|string',
        'role_id' => 'sometimes|exists:roles,id',
        'branch_id' => 'sometimes|exists:branches,id',
    ]);

    // تحديث كلمة المرور إذا تم تقديمها
    if ($request->has('password')) {
        $validatedData['password'] = Hash::make($request->password);
    }

    // تحديث البيانات
    $user->update($validatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'User updated successfully',
        'user' => new UserResource($user),
    ]);
}


//delete
public function destroy(string $id)
{
    $user = User::findOrFail($id);

    $user->delete();

    return response()->json([
        'message' => 'deleted successfuly',
        'deleted_item' => $user
    ], 200);
}

}
