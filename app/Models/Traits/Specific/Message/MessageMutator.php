<?php

namespace App\Models\Traits\Specific\Message;

trait MessageMutator
{
    /*------------------------------------------------------------------------
     * Mutator
     * -----------------------------------------------------------------------
     */

    /**
     * for upload file in message
     */
//    public function setUploadFileAttribute()
//    {
//        $url = request()->file('upload_file')->store('message', 'public');
//        $this->attributes['upload_file'] = $url;
//    }


    /*------------------------------------------------------------------------
    * Mutator
    * -----------------------------------------------------------------------
    */

    /**
     * get url file
     *
     * @param $value
     * @return string
     */
//    public function getUploadFileAttribute($value)
//    {
//        if (!empty($value))
//            return url('storage/app/public/' . $value);
//    }
}
