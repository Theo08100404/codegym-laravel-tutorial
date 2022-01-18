<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sortable;

    protected $fillable = [
        'comment',
        'project_id',
        'task_id',
        'user_id',
    ];

    //コメントをしたユーザーを取得
    public function commenter()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    //課題を取得
    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
