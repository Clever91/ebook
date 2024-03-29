<?php

namespace App\Models\Bot;

use App\Models\Admin\Customer;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    protected $fillable = [
        'chat_id', 'customer_id', 'first_name', 'last_name',
        'language_code', 'locale', 'username', 'step'
    ];

    public function existCustomer()
    {
        if (empty($this->customer_id) || is_null($this->customer_id))
            return false;

        $customer = Customer::find($this->customer_id);
        if (is_null($customer))
            return false;

        return true;
    }

    public function customer()
    {
        return Customer::find($this->customer_id);
    }

    public function getFullName()
    {
        $full_name = $this->first_name;
        if (!empty($this->last_name))
            $full_name .= " " . $this->last_name;
        return $full_name;
    }
}
