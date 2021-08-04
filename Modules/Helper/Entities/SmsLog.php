<?php

namespace Modules\Helper\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    const OTP = 'otp';
    const PROMOTION = 'promotion';
    const ALERT = 'alert';
    const OTHER = 'other';

    const SUCCESS = 'success';
    const PENDING = 'pending';
    const FAILED = 'failed';

    protected $fillable = ['phone', 'type', 'payload', 'response', 'status', 'msg_id'];
}
