<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Validators\MainValidator;
use App\Models\User;
use App\Models\UserProfile;
use App\Providers\UserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Termwind\Components\Dd;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    use RegistersUsers;
    protected $redirectTo = '/users';

    protected function create(array $data)
    {
        $validator = $this->validator($data);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        $user = $this->userService->registerUser($data);

        return $user->first();
    }

    protected function validator(array $data)
    {
        $mainValidator = new MainValidator;
        return $mainValidator->registerValidator($data);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showUsers()
    {
        $users = User::with('person', 'profile')->get()->toArray();
        return view('auth.admin.users', ['users' => $users]);
    }
    public function showUser($id)
    {
        $user = User::with(['person', 'person.address', 'person.phone', 'person.identification', 'profile', 'approver'])->where('id', $id)->first()->toArray();
        return view('auth.admin.user', ['user' => $user]);
    }

    public function userUpdate(Request $request, $id, UserService $userService, MainValidator $mainValidator)
    {
        $data = $mainValidator->validateUpdateUserRequest($request);
        if (count($data) <= 0) {
            return redirect(route('users'));
        }

        DB::beginTransaction();

        try {
            $user = $userService->getUserById($id);

            $user->fill([
                'email' => isset($data['email']) ? $data['email'] : $user->email,
                'password' => isset($data['password']) ? Hash::make($data['password']) : $user->password,
                'profile_id' => isset($data['profile_type']) ? UserProfile::firstWhere('profile_name', $data['profile_type'])->id : $user->profile_id,
                'approver_user_id' => isset($data['approver_user_id']) ? User::where('id', $data['approver_user_id'])->value('id') : $user->approver_user_id,
                'approve_limit' => $data['approve_limit'] ?? $user->approve_limit,
            ]);

            $user->person->fill([
                'name' => $data['name'] ?? $user->person->name,
                'birthdate' => $data['birthdate'] ?? $user->person->birthdate,
            ]);

            $user->person->address->fill([
                'street' => $data['street'] ?? $user->person->address->street,
                'street_number' => $data['street_number'] ?? $user->person->address->street_number,
                'neighborhood' => $data['neighborhood'] ?? $user->person->address->neighborhood,
                'postal_code' => $data['postal_code'] ?? $user->person->address->postal_code,
                'city' => $data['city'] ?? $user->person->address->city,
                'state' => $data['state'] ?? $user->person->address->state,
                'country' => $data['country'] ?? $user->person->address->country,
                'complement' => $data['complement'] ?? $user->person->address->complement,
            ]);

            $user->person->phone->fill([
                'number' => $data['phone'] ?? $user->person->phone->number,
                'phone_type' => $data['phone_type'] ?? $user->person->phone->phone_type,
            ]);

            $user->person->identification->fill([
                'identification' => $data['document_number'] ?? $user->person->identification->identification,
            ]);

            $user->save();
            $user->person->save();
            $user->person->address->save();
            $user->person->phone->save();
            $user->person->identification->save();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollback();
            throw $error;
        }

        return redirect()->route('users', ['id' => $user->id]);
    }
}
