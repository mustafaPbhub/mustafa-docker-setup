<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserDataImport implements ToCollection , WithHeadingRow,WithValidation
{
    /**
    * @param Collection $collection
    */


    public function collection(collection $row)
    {
        $deleteAllUser = User::latest()->forceDelete();
        foreach($row as $key => $value){

            $role = Role::where('name', $row[$key]['role'])->first();
           $saveUser = User::insertOrIgnore([
                'id' => $row[$key]['id'],
                'image' => $row[$key]['image'],
                'name' => $row[$key]['name'],
                'username' => $row[$key]['user_name'],
                'email' => $row[$key]['email'],
                'password' =>  $row[$key]['encrypted_password'],
                'password_txt' => $row[$key]['password'] ?? '',
                'role' => $role->id ?? '',
                'email_verified_at' => $row[$key]['email_verified_at'],
                'created_at' => $row[$key]['created_at'],
                'updated_at' => $row[$key]['updated_at'],
            ]);
        }
        return $saveUser;



    }
    public function rules() :array
    {
        return array(
            'id' => 'required',
            'name' => 'required',
            'user_name' => 'required',
            'email' => 'required|email',
            'encrypted_password' => 'required',
            'role' => 'required',
        );

    }
    public function customValidationMessages()
    {
    return [
        'id' => 'User id is required',
        'name' => 'User Full name is required',
        'user_name.required' => 'User name is required',
        'email.required' => 'User email is required',
        'encrypted_password.required' => 'User password in Encrypted form is required',
        'role.required' => 'User role is required',
    ];
    }
}
