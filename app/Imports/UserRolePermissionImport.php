<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\UserAccess;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserRolePermissionImport implements ToCollection ,  WithHeadingRow,WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $row)
    {
        $deleteOldData = UserAccess::orderBy('id' , 'asc')->forceDelete();
        foreach($row as $key => $value){
           $roleData = Role::where('name', $row[$key]['role_name'])->first();
           $saveRole = UserAccess::create([
                'id' => $row[$key]['id'],
                'role_id' => $roleData->id ?? 1,
                'sub_menu_id' => $row[$key]['sub_menu_id'],
                'view_status' => $row[$key]['view_status'] ?? 0,
                'create_status' => $row[$key]['create_status'] ?? 0,
                'update_status' => $row[$key]['update_status'] ?? 0,
                'delete_status' => $row[$key]['delete_status'] ?? 0,
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
            'sub_menu_id' => 'required',
        );
    }
    public function customValidationMessages()
    {
        return [
            'id' => 'Access id is required',
            'Sub Menu Id' => 'Sub Menu is required',
        ];
    }
}
