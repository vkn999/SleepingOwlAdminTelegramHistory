<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Olimpiad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'subject_id',
        'grade_id',
        'sort',
        'grades_numbers',
        'subject_short_note',
        'subject_note',
        'cost_old',
        'cost',
        'teacher_fee',
        'students_count_default',
        'free_for_students_count_to',
        'tasks'
    ];

    protected $appends = [
        'name'
    ];

    // RELATIONSHIPS

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    // METHODS

    public function esablishParameters()
    {
        // from Event
        if (!$this->cost_old) {
            $this->cost_old = $this->event->cost_old;
        }
        if (!$this->cost) {
            $this->cost = $this->event->cost;
        }
        if (!$this->teacher_fee) {
            $this->teacher_fee = $this->event->teacher_fee;
        }
        if (!$this->students_count_default) {
            $this->students_count_default = $this->event->students_count_default;
        }
        // from Grade
        if (!$this->grades_numbers) {
            $this->grades_numbers = $this->grade->grades_numbers;
        }
        return $this->belongsTo(Grade::class);
    }
}
