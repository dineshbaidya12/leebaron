<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AppointmentExports implements FromCollection,  WithHeadings
{
    protected $appointment;

    /**
     * Testing constructor.
     *
     * @param Collection $users
     */
    public function __construct(Collection $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->appointment;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Address',
            'City',
            'Country',
            'State',
            'Phone',
            'Email',
            'Postcode',
            'Appointment Date',
            'Request Date',
        ];
    }
}
