<?php

namespace App\Models;

use App\Models\Disease;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Crop extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setAvatarAttribute($value)
    {
        if (isset($value))
        {
            // remove old avatar on update
            if ($this->avatar) Storage::disk('public')->delete($this->avatar);
            $path = $value->store('crop/'.date('FY'), ['disk' => 'public']);
            $this->attributes['avatar'] = $path;
        }
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($item) {
            if ($item->avatar) Storage::disk('public')->delete($item->avatar);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function condition()
    {
        return $this->belongsToMany(Condition::class)->withPivot(['min', 'max', 'regular'])->withTimestamps();
    }


    public function disease()
    {
        return $this->hasMany(Disease::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

}
