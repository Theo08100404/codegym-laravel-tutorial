<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'image',
        'project_id',
        'task_id',
    ];


    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
