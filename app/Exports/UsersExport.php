<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection , WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  User::with('role')->whereHas("role",function($query){
            $query->Where("id","!=",1);
        })->orderBy('id' , 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Nom & Prénom',
            'username',
            'Email',
            "Role",
            "Créé à",
        ];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->username,
            $user->email,
            $user->role()->get()->first()->description,
            $user->created_at,
        ];
    }
}
