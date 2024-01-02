<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExports implements FromCollection, WithHeadings
{
    protected $users;

    /**
     * Testing constructor.
     *
     * @param Collection $users
     */
    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->users;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Password',
            'Address 1',
            'Address 2',
            'City',
            'Country',
            'State',
            'Postcode',
            'Phone',
            'Fax',
            'Status',
            'Showroom',
            'Customer No.',
            'Joined Date'
        ];
    }
}
