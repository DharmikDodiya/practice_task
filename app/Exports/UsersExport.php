<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return User::select('id','name','email','role')->get();
        return User::all();
    }

    // public function headings(): array
    // {
    //     return ["Id","Name","Email","Role"];
    // }
}
