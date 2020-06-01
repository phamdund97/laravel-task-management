<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'customers_id', 'status', 'begin_at', 'finish_at'
    ];

    public function members()
    {
        return $this->belongsToMany(Member::Class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::Class);
    }

    public function customers()
    {
        return $this->belongsTo(Customer::Class);
    }

    public function scopeTasksFinished()
    {
        return $this->tasks()->where('status', Member::STATUS_CLOSE)->count();
    }

    public function getProcessDataAttribute()
    {
        if ($this->tasksFinished() == null) {
            return number_format((0 / count($this->tasks)) * 100, 1, '.', ',');
        } else {
            return number_format($this->tasksFinished() / count($this->tasks) * 100, 1, '.', ',');
        }
    }
}
