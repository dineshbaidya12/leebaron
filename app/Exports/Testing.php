<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class Testing implements FromCollection
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
}
