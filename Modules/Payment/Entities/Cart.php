<?php

namespace Modules\Payment\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Course;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Modules\BundleSubscription\Entities\BundleCoursePlan;

class Cart extends Model
{
use Tenantable;

    protected $fillable = ['course_id','user_id','price','instructor_id','tracking'];
    protected $guarded  = ['id'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function bundle()
    {
        return $this->belongsTo(BundleCoursePlan::class, 'bundle_course_id', 'id');
    }

    public function schedule()
    {
        return $this->belongsTo('Modules\Appointment\Entities\Schedule', 'schedule_id', 'id')->withDefault();
    }
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id')->withDefault();
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }
}
