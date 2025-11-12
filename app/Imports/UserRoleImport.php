<?php

namespace App\Imports;

use App\Models\Role;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserRoleImport implements ToCollection , WithHeadingRow,WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $row)
    {
        $deleteAllUser = Role::latest()->forceDelete();
        foreach($row as $key => $value){
           $saveRole = Role::updateOrCreate(['id'=>$row[$key]['id']],[
                'id' => $row[$key]['id'],
                'name' => $row[$key]['name'],
                'created_at' => $row[$key]['created_at'],
                'updated_at' => $row[$key]['updated_at'],
            ]);
        }
        return $saveRole;
    }
    public function rules() :array
    {
        return array(
            'id' => 'required',
            'name' => 'required',
        );

    }
    public function customValidationMessages()
    {
        return [
            'id' => 'Role id is required',
            'name' => 'Role name is required',
        ];
    }
}
