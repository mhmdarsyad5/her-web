<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLocation extends Model
{
    protected $table = 'visitor_logs';

    protected $primaryKey = 'city';

    public $incrementing = false;

    protected $keyType = 'string';
}
