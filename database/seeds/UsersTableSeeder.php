<?php
use App\Models\Company;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email'  => 'user@example.com',
            'password' => Hash::make("password"),
        ]);

        $company = Company::create([
            'name' => 'My Awesome Company',
            'owner_id' => $user->id,
        ]);

        // Assign Role
        $user->assignRole("super_admin");

        // Attach User to Company
        $user->attachCompany($company);
    }
}
