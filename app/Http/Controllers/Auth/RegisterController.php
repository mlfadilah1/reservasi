<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => 'nullable|unique:users,id',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User();

        // Cek apakah ID manual disediakan
        if (!empty($data['id'])) {
            // Pastikan ID manual belum digunakan
            if (!User::find($data['id'])) {
                $user->id = $data['id'];  // Set ID manual jika belum digunakan
            } else {
                // Jika ID manual sudah digunakan, bisa return error atau lanjutkan dengan auto-increment
                return redirect()->back()->withErrors(['id' => 'ID sudah digunakan.']);
            }
        } else {
            // Jika ID manual tidak disediakan, cek apakah ada ID yang hilang (gap)
            $maxId = User::max('id');  // Dapatkan ID terbesar saat ini
            $missingId = $this->findMissingId($maxId);  // Cari ID yang hilang

            if ($missingId) {
                $user->id = $missingId;  // Set ID yang hilang (jika ada)
            }
        }

        // Set properti lainnya
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role = 'Customer';

        // Simpan user
        $user->save();

        return $user;
    }

    // Fungsi untuk mencari ID yang hilang
    protected function findMissingId($maxId)
    {
        // Loop dari 1 hingga maxId untuk mencari ID yang hilang
        for ($i = 1; $i <= $maxId; $i++) {
            if (!User::find($i)) {
                return $i;  // Kembalikan ID yang hilang
            }
        }
        return null;  // Jika tidak ada ID yang hilang
    }
}
