<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';

    public static function getPhoneNumbers()
    {
        return Customer::select('phone')->get();
    }
    
    public static function getPhoneNumbersPaginated($rowsPerPage)
    {
        return Customer::select('phone')->paginate($rowsPerPage);
    }

}
