<?php

namespace App\Models;

use App\Models\Crop;
use App\Models\Guide;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setAvatarAttribute($value)
    {
        if (isset($value))
        {
            // remove old avatar on update
            if ($this->avatar) Storage::disk('public')->delete($this->avatar);
            $path = $value->store('activity/'.date('FY'), ['disk' => 'public']);
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

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function getStageTextAttribute()
    {

        return $this->stage == 1 ? 'Nursery':'Planting';

    }
}

