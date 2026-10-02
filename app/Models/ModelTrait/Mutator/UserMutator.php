<?php

namespace App\Models\ModelTrait\Mutator;


trait UserMutator
{
    /**
     * Concat name and family for user  (full name )
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['name'] . ' ' . $this->attributes['family'];
    }
}
