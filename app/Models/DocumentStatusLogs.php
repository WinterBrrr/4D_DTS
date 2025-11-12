<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentStatusLogs extends Model
{
    protected $fillable = ['document_id', 'changed_by', 'from_status', 'to_status', 'notes'];
}