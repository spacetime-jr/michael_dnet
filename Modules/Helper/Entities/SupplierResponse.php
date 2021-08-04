<?php

namespace Modules\Helper\Entities;

use Illuminate\Database\Eloquent\Model;

class SupplierResponse extends Model
{
    const PULSA = 'pulsa';
    const DATA = 'data';
    const PLNPRE = 'plnpre';
    const PLNPOST = 'plnpost';


    const SUCCESS = 'success';
    const PENDING = 'pending';
    const FAILED = 'failed';

    protected $fillable = ['transaction_id', 'type', 'payload', 'response', 'status', 'saldo'];

    public function transaction(){
        return $this->belongsTo('Modules\Ppob\Entities\Transaction', 'transaction_id');
    }
}
