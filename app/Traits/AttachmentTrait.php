<?php

namespace App\Traits;

use FFMpeg\Format\FormatInterface;
use FFMpeg\Filters\Audio\AudioFilterInterface;
use FFMpeg\Filters\Audio\AudioFilters;
use FFMpeg\Format\AudioInterface;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use FFMpeg\FFMpeg;
use FFMpeg\Media\Audio;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\TimeCode;
use App\Models\Base\Attachment;
use Activity;

define('PATH_TO_UPLOAD', 'files/uploads/');
define('PATH_FOR_DEFAULT', 'assets/admin/_images/default/');
define('SITE_NAME', 'shanilo');

trait AttachmentTrait
{
    protected static function bootAttachmentTrait()
    {
        static::deleting(function ($object) {
            $object->attachments()->get()->each(function ($attachment) {
                $attachment->delete();
            });
        });
    }

    public function attachments($slug = null)
    {
        if ($slug) {
            return $this->morphMany(Attachment::class, 'attachmentable')->where('slug', $slug);
        } else {
            return $this->morphMany(Attachment::class, 'attachmentable');
        }
    }

    public function attachmentSlug($slug = "main")
    {
        return $this->attachments()->slug($slug);
    }

    public function attachmentLog($log)
    {
        Activity::create([
            'log_name' => 'default',
            'description' => 'updated',
            'subject_id' => $this->id,
            'subject_type' => get_class($this),
            'causer_id' => \Auth::guard('admins')->check()?\Auth::guard('admins')->user()->id:\Auth::user()->id,
            'causer_type' =>\Auth::guard('admins')->check()? get_class(\Auth::guard('admins')->user()):get_class(\Auth::user()),
            'properties' => ["attributes" => ["description" => $log]],
        ]);
    }

    public function createImage($file, $slug, $cropper = null, $thumbnails = null, $quality = 90, $watermark = false,$groupName='')
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $randText = str_random(4);

        //Make Model Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/');
        }
        //Make Object Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/' . $id . '/');
        }


        //Remove Special Character
        $fileName = SITE_NAME . '-' . $randText . '-' . preg_replace("/[^a-zA-Z0-9.]/", '0', $file->getClientOriginalName());;

        if (File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $fileName)) {
            $fileName = rand(10000, 99999) . '-' . $fileName;
        }
        $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $fileName;

        $size = intval($file->getClientSize());
        $size = ($size / 1024) / 1024;
        $size_format = 'MB';
        if ($size < 1) {
            $size = $size * 1024;
            $size_format = 'KB';
        }

        $attachment=$this->attachments()->create([
            'title' => $slug,
            'slug' => $slug = (substr($slug, 0, 7) == "attach_") ? "attachment" : $slug,
            'mime' => $file->getMimeType(),
            'file_name' => $fileName,
            'size' => intval($size), // Kilobyte or Megabyte
            'size_format' => $size_format, // KB or MB
            'group_name'=>$groupName
        ]);

        $img = Image::make($file);

        if (!is_null($cropper)) {
            $width = intval($cropper['w']);
            $height = intval($cropper['h']);
            $x = intval($cropper['x']);
            $y = intval($cropper['y']);
            $img = $img->crop($width, $height, $x, $y);
        }

        if ($watermark) {
            $imageWidth = $img->width();
            $watermark = Image::make(asset('assets/front/_images/logo/watermark.png'));
            $watermark->resize(intval($imageWidth / 3), null, function ($constraint) {
                $constraint->aspectRatio();
                // $constraint->upsize();
            });
            $img->insert($watermark, 'center');
        }

        // if ($file->getClientOriginalExtension() == 'gif') {
        //     copy($file->getRealPath(), $filePath);
        // } else {
        $img->save($filePath, $quality);
        // }
        //

        if (exif_imagetype($filePath)) {
            if (isset($thumbnails)) {
                foreach ($thumbnails as $thumb_size) {
                    list($width, $height) = explode('/', $thumb_size);
                    $img_thumb = Image::make($filePath);
                    if ($width == 0) {
                        $img_thumb->resize(null, intval($height), function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } elseif ($height == 0) {
                        $img_thumb->resize(intval($width), null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } else {
                        $img_thumb->fit(intval($width), intval($height));
                    }
                    $img_thumb->save(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . 'th_' . $width . '-' . $height . '_' . $fileName);
                }
            }
        }
        return $attachment;
    }

    public function createImageResponseId($file, $slug, $cropper = null, $thumbnails = null, $quality = 90, $watermark = false)
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $randText = str_random(4);

        //Make Model Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/');
        }
        //Make Object Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/' . $id . '/');
        }


        //Remove Special Character
        $fileName = SITE_NAME . '-' . $randText . '-' . preg_replace("/[^a-zA-Z0-9.]/", '0', $file->getClientOriginalName());;

        if (File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $fileName)) {
            $fileName = rand(10000, 99999) . '-' . $fileName;
        }
        $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $fileName;

        $size = intval($file->getClientSize());
        $size = ($size / 1024) / 1024;
        $size_format = 'MB';
        if ($size < 1) {
            $size = $size * 1024;
            $size_format = 'KB';
        }

        $created_image = $this->attachments()->create([
            'title' => $slug,
            'slug' => $slug = (substr($slug, 0, 7) == "attach_") ? "attachment" : $slug,
            'mime' => $file->getMimeType(),
            'file_name' => $fileName,
            'size' => intval($size), // Kilobyte or Megabyte
            'size_format' => $size_format, // KB or MB
        ]);

        $img = Image::make($file);

        if (!is_null($cropper)) {
            $width = intval($cropper['w']);
            $height = intval($cropper['h']);
            $x = intval($cropper['x']);
            $y = intval($cropper['y']);
            $img = $img->crop($width, $height, $x, $y);
        }

        if ($watermark) {
            $imageWidth = $img->width();
            $watermark = Image::make(asset('assets/front/_images/logo/watermark.png'));
            $watermark->resize(intval($imageWidth / 3), null, function ($constraint) {
                $constraint->aspectRatio();
                // $constraint->upsize();
            });
            $img->insert($watermark, 'center');
        }

        // if ($file->getClientOriginalExtension() == 'gif') {
        //     copy($file->getRealPath(), $filePath);
        // } else {
        $img->save($filePath, $quality);
        // }

        if (exif_imagetype($filePath)) {
            if (isset($thumbnails)) {
                foreach ($thumbnails as $thumb_size) {
                    list($width, $height) = explode('/', $thumb_size);
                    $img_thumb = Image::make($filePath);
                    if ($width == 0) {
                        $img_thumb->resize(null, intval($height), function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } elseif ($height == 0) {
                        $img_thumb->resize(intval($width), null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } else {
                        $img_thumb->fit(intval($width), intval($height));
                    }
                    $img_thumb->save(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . 'th_' . $width . '-' . $height . '_' . $fileName);
                }
            }
        }

        return $created_image->id;
    }

    public function updateImage($file, $slug, $cropper = null, $thumbnails = null, $quality = 90, $watermark = false)
    {
        // Delete Old Images
        $this->attachmentSlug($slug)->get()->each(function ($attachment) {
            $attachment->delete();
        });

        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $randText = str_random(4);

        //Make Model Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/');
        }
        //Make Object Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/' . $id . '/');
        }


        //Remove Special Character
        $fileName = SITE_NAME . '-' . $randText . '-' . preg_replace("/[^a-zA-Z0-9.]/", '0', $file->getClientOriginalName());;

        if (File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $fileName)) {
            $fileName = rand(10000, 99999) . '-' . $fileName;
        }
        $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $fileName;

        $size = intval($file->getClientSize());
        $size = ($size / 1024) / 1024;
        $size_format = 'MB';
        if ($size < 1) {
            $size = $size * 1024;
            $size_format = 'KB';
        }

        $this->attachments()->create([
            'title' => $slug,
            'slug' => $slug = (substr($slug, 0, 7) == "attach_") ? "attachment" : $slug,
            'mime' => $file->getMimeType(),
            'file_name' => $fileName,
            'size' => intval($size), // Kilobyte or Megabyte
            'size_format' => $size_format, // KB or MB
        ]);

        $img = Image::make($file);


        if (!is_null($cropper)) {
            $width = intval($cropper['w']);
            $height = intval($cropper['h']);
            $x = intval($cropper['x']);
            $y = intval($cropper['y']);
            $img = $img->crop($width, $height, $x, $y);
        }
        if ($watermark) {
            $imageWidth = $img->width();
            $watermark = Image::make(asset('assets/front/_images/logo/watermark.png'));
            $watermark->resize(intval($imageWidth / 3), null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->insert($watermark, 'center');
        }

        if ($file->getClientOriginalExtension() == 'gif') {
            copy($file->getRealPath(), $filePath);
        } else {
            $img->save($filePath, $quality);
        }

        $this->attachmentLog('عکس ویرایش گردید.');

        if (exif_imagetype($filePath)) {
            if (isset($thumbnails)) {
                foreach ($thumbnails as $thumb_size) {
                    list($width, $height) = explode('/', $thumb_size);
                    $img_thumb = Image::make($filePath);
                    if ($width == 0) {
                        $img_thumb->resize(null, intval($height), function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } elseif ($height == 0) {
                        $img_thumb->resize(intval($width), null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } else {
                        $img_thumb->fit(intval($width), intval($height));
                    }
                    $img_thumb->save(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . 'th_' . $width . '-' . $height . '_' . $fileName);
                }
            }
        }
    }

    public function checkImage($slug = "main")
    {
        $image = $this->attachments->filter(function ($value) use ($slug) {
            return ($value['slug'] == $slug) ? true : false;
        })->first();

        if (empty($image)) {
            return false;
        } else {
            return true;
        }
    }

    public function takeImage($slug = "main", $thumbs = null, $default = 'default.png')
    {
        $image = $this->attachments->filter(function ($value) use ($slug) {
            return ($value['slug'] == $slug) ? true : false;
        })->first();

        if (!empty($image)) {
            $modelName = md5($this->getTable());
            $id = md5($this->id);

            if (isset($thumbs)) {
                list($width, $height) = explode('/', $thumbs);
                $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . 'th_' . $width . '-' . $height . '_' . $image->file_name;
            } else {
                $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $image->file_name;
            }

            if (File::exists($filePath)) {
                return url('/') . "/" . $filePath;
            } else {
                return url('/') . "/" . PATH_FOR_DEFAULT . $default;
            }

        } else {
            return url('/') . "/" . PATH_FOR_DEFAULT . $default;
        }
    }

    public function takeImageWithName($imageName, $thumbs = null, $default = 'default.png')
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);

        if (isset($thumbs)) {
            list($width, $height) = explode('/', $thumbs);
            $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . 'th_' . $width . '-' . $height . '_' . $imageName;
        } else {
            $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $imageName;
        }

        if (File::exists($filePath)) {
            return url('/') . "/" . $filePath;
        } else {
            return url('/') . "/" . PATH_FOR_DEFAULT . $default;
        }
    }

    public function deleteImage($slug)
    {
        $this->attachmentSlug($slug)->get()->each(function ($attachment) {
            $attachment->delete();
        });
    }

    /******************************/
    //Video
    /******************************/

    public function createVideo($file, $slug, $FineUploaderFile = "", $storage = false)
    {
        $ffmpeg = FFMpeg::create($this->getGetFFMpegFFProp()['ffmpeg']);
        $ffprop = FFProbe::create($this->getGetFFMpegFFProp()['ffprop']);

        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $randText = str_random(4);

        //Make Model Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/');
        }
        //Make Object Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/' . $id . '/');
        }

        if ($storage == true) {
            if (!File::exists(storage_path() . '/app/' . $modelName . '/')) {
                File::makeDirectory(storage_path() . '/app/' . $modelName . '/');
            }
            if (!File::exists(storage_path() . '/app/' . $modelName . '/' . $id . '/')) {
                File::makeDirectory(storage_path() . '/app/' . $modelName . '/' . $id . '/');
            }
        }
        if ($storage == true) {
            $filePath = storage_path() . '/app/' . $modelName . '/' . $id;
        } else {
            $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id;

        }

        if ($FineUploaderFile == "") {
            $fileName = SITE_NAME . '-' . $randText . '-' . preg_replace("/[^a-zA-Z0-9.]/", '0', $file->getClientOriginalName());
            if (File::exists($filePath . '/' . $fileName)) {
                $fileName = rand(10000, 99999) . '-' . $fileName;
            }
            $file->move($filePath, $fileName);
        } else {
            $fileName = $FineUploaderFile;
            rename(storage_path() . '/app/public/completed/' . $fileName, $filePath . '/' . $fileName);
        }

        $UploadedFile = $filePath . '/' . $fileName;

        $size = $ffprop->format($UploadedFile)->get('size');
        $size = ($size / 1024) / 1024;
        $size_format = 'MB';
        if ($size < 1) {
            $size = $size * 1024;
            $size_format = 'KB';
        }
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $duration = $ffprop->format($UploadedFile)->get('duration', 'sexagesimal');
        $ducation_for_pic = intval($duration) / 2;

        if (!$this->attachmentSlug('video_picture_preview')->count()) {
            $video = $ffmpeg->open($UploadedFile);
            $video->frame(TimeCode::fromSeconds($ducation_for_pic))->save(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $randText . '.jpg');
            $this->attachments()->create([
                'title' => "video_picture_preview",
                'slug' => "video_picture_preview",
                'mime' => "image/jpeg",
                'file_name' => $randText . '.jpg',
            ]);
        }

        $this->attachments()->create([
            'title' => $slug,
            'slug' => $slug = (substr($slug, 0, 7) == "attach_") ? "attachment" : $slug,
            'mime' => 'video/' . $ext,
            'file_name' => $fileName,
            'size' => intval($size), // Kilobyte or Megabyte
            'size_format' => $size_format, // KB or MB
            'duration' => gmdate("H:i:s", $duration),
        ]);
    }

    public function takeVideo($slug)
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);

        $video = $this->attachments->filter(function ($value) use ($slug) {
            return ($value['slug'] == $slug) ? true : false;
        })->first();

        if(!$video){
            return false;
        }

        $file_path = asset(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $video->file_name);
        return $file_path;
    }

    public function deleteVideo($slug, $storage = false, $previewImage = false, $previewImageSlug = 'video_picture_preview')
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);

        $video = $this->attachments->filter(function ($value) use ($slug) {
            return ($value['slug'] == $slug) ? true : false;
        })->first();

        if ($storage == true) {
            $file_path = storage_path() . '/app/' . $modelName . '/' . $id . '/' . $video->file_name;
        } else {
            $file_path = PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $video->file_name;
        }

        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $video->delete();
        if ($previewImage == true) {
            $this->attachmentSlug($previewImageSlug)->delete();
        }
    }

    /******************************/
    //Music
    /******************************/
    /**
     * @param $file
     * @param $slug
     * @param string $FineUploaderFile
     * @param bool $storage
     */
    public function createMusic($file, $slug, $FineUploaderFile = "", $storage = false)
    {

        $ffmpeg = FFMpeg::create($this->getGetFFMpegFFProp()['ffmpeg']);
        $ffprop = FFProbe::create($this->getGetFFMpegFFProp()['ffprop']);

        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $randText = str_random(4);
        $this->makeDirectories($id,$modelName,$storage);

        if ($storage == true) {
            $filePath = storage_path() . '/app/' . $modelName . '/' . $id;
        } else {
            $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id;
        }

        if ($FineUploaderFile == "") {
            $fileName = SITE_NAME . '-' . $randText . '-' . preg_replace("/[^a-zA-Z0-9.]/", '0', $file->getClientOriginalName());
            if (File::exists($filePath . '/' . $fileName)) {
                $fileName = rand(10000, 99999) . '-' . $fileName;
            }
            $file->move($filePath, $fileName);
        } else {
            $fileName = $FineUploaderFile;
            rename(storage_path() . '/app/public/completed/' . $fileName, $filePath . '/' . $fileName);
        }

        $UploadedFile = $filePath . '/' . $fileName;
        $uploadedCutFile=PATH_TO_UPLOAD . $modelName . '/' . $id . '/cut_' .$fileName;

        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if($slug!=='demo'){
            //clip music
            $cutAudio = $ffmpeg->open($UploadedFile);
            $filter = new AudioFilters($cutAudio);
            $filter->clip(TimeCode::fromSeconds(30),TimeCode::fromSeconds(15));
            $format = new Mp3();
            $format->setAudioChannels(2)->setAudioKiloBitrate(256);
            $cutAudio->save($format,$uploadedCutFile);



            //Save Attachment of cut file
            $size=$ffprop->format($uploadedCutFile)->get('size');
            $size = ($size / 1024) / 1024;
            $size_format = 'MB';
            if ($size < 1) {
                $size = $size * 1024;
                $size_format = 'KB';
            }
            $duration = $ffprop->format($uploadedCutFile)->get('duration', 'sexagesimal');
            $this->attachments()->create([
                'title'=>$slug,
                'slug'=>'cut',
                'mime'=>'music/'.$ext,
                'file_name' => 'cut_'.$fileName,
                'size' => intval($size), // Kilobyte or Megabyte
                'size_format' => $size_format, // KB or MB
                'duration' => gmdate("H:i:s", $duration),
            ]);
        }


        //Save Attachment of main file
        $size = $ffprop->format($UploadedFile)->get('size');
        $size = ($size / 1024) / 1024;
        $size_format = 'MB';
        if ($size < 1) {
            $size = $size * 1024;
            $size_format = 'KB';
        }

        $duration = $ffprop->format($UploadedFile)->get('duration', 'sexagesimal');

        $this->attachments()->create([
            'title' => $slug,
            'slug' => $slug = (substr($slug, 0, 7) == "attach_") ? "attachment" : $slug,
            'mime' => 'music/' . $ext,
            'file_name' => $fileName,
            'size' => intval($size), // Kilobyte or Megabyte
            'size_format' => $size_format, // KB or MB
            'duration' => gmdate("H:i:s", $duration),
        ]);
    }

    public function takeMusic($slug)
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);

        $music = $this->attachments->filter(function ($value) use ($slug) {
            return ($value['slug'] == $slug) ? true : false;
        })->first();
        if($music){
            $file_path = asset(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $music->file_name);
            return $file_path;
        }
        return false;
    }

    public function takeZip()
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $zip = $this->attachments->filter(function ($value)  {
            return ($value['slug'] == 'zip') ? true : false;
        })->first();
        $file_path = asset(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $zip->file_name);
        return $file_path;
    }

    public function deleteMusic($slug, $storage = false)
    {

        $modelName = md5($this->getTable());
        $id = md5($this->id);

        $music = $this->attachments->filter(function ($value) use ($slug) {
            return ($value['slug'] == $slug) ? true : false;
        })->first();
        $cut= $this->attachments->filter(function ($value){
            return ($value['slug'] == 'cut') ? true : false;
        })->first();

        if ($storage == true) {
            $storage_path = storage_path() . '/app/' . $modelName . '/' . $id . '/' . $music->file_name;
        }
        $file_path = public_path(PATH_TO_UPLOAD .'/'. $modelName . '/' . $id . '/' . $cut->file_name);


        if(isset($storage_path) && file_exists($storage_path)){
            @unlink($storage_path);
        }
        if (file_exists($file_path)) {
            @unlink($file_path);
        }
        $music->delete();
        $cut->delete();
    }

    public function moveMusic($slug,$to="storage")
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $music = $this->attachments->filter(function ($value) use ($slug) {
            return ($value['slug'] == $slug) ? true : false;
        })->first();
        $this->makeDirectories($id,$modelName,true);
        if($to=='public'){
            $oldPath=storage_path("app/$modelName/$id/".$music->file_name);
            $newPath=public_path(PATH_TO_UPLOAD."/$modelName/$id/".$music->file_name);
        }else{
            $newPath=storage_path("app/$modelName/$id/".$music->file_name);
            $oldPath=public_path(PATH_TO_UPLOAD."/$modelName/$id/".$music->file_name);
        }
        File::move($oldPath,$newPath);
    }

    public function moveFile($slug,$to="storage")
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $file = $this->attachments->filter(function ($value) use ($slug) {
            return ($value['slug'] == $slug) ? true : false;
        })->first();
        $this->makeDirectories($id,$modelName,true);
        if($to=='public'){
            $oldPath=storage_path("app/$modelName/$id/".$file->file_name);
            $newPath=public_path(PATH_TO_UPLOAD."/$modelName/$id/".$file->file_name);
        }else{
            $newPath=storage_path("app/$modelName/$id/".$file->file_name);
            $oldPath=public_path(PATH_TO_UPLOAD."/$modelName/$id/".$file->file_name);
        }
        File::move($oldPath,$newPath);
    }

    public function createFile($file, $slug, $storage = false)
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $randText = str_random(4);

        //Make Model Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/');
        }
        //Make Object Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/' . $id . '/');
        }

        if ($storage == true) {
            if (!File::exists(storage_path() . '/app/' . $modelName . '/')) {
                File::makeDirectory(storage_path() . '/app/' . $modelName . '/');
            }
            if (!File::exists(storage_path() . '/app/' . $modelName . '/' . $id . '/')) {
                File::makeDirectory(storage_path() . '/app/' . $modelName . '/' . $id . '/');
            }
        }

        //Remove Special Character
        $fileName = SITE_NAME . '-' . $randText . '-' . preg_replace("/[^a-zA-Z0-9.]/", '0', $file->getClientOriginalName());
        if (File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $fileName)) {
            $fileName = rand(10000, 99999) . '-' . $fileName;
        }
        if ($storage == true) {
            $filePath = storage_path() . '/app/' . $modelName . '/' . $id;
        } else {
            $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id;
        }
        $file->move($filePath, $fileName);

        $size = $file->getClientSize();
        $size = ($size / 1024) / 1024;
        $size_format = 'MB';
        if ($size < 1) {
            $size = $size * 1024;
            $size_format = 'KB';
        }

        $attachment=$this->attachments()->create([
            'title' => $slug,
            'slug' => $slug = (substr($slug, 0, 7) == "attach_") ? "attachment" : $slug,
            'mime' => File::mimeType($filePath . '/' . $fileName),
            'file_name' => $fileName,
            'size' => intval($size), // Kilobyte or Megabyte
            'size_format' => $size_format, // KB or MB
        ]);
        return $attachment;
    }

    public function updateFile($file, $slug, $storage = false)
    {
        // Delete Old Files
        $this->attachmentSlug($slug)->get()->each(function ($attachment) {
            $attachment->delete();
        });

        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $randText = str_random(4);

        //Make Model Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/');
        }
        //Make Object Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/' . $id . '/');
        }

        if ($storage == true) {
            if (!File::exists(storage_path() . '/app/' . $modelName . '/')) {
                File::makeDirectory(storage_path() . '/app/' . $modelName . '/');
            }
            if (!File::exists(storage_path() . '/app/' . $modelName . '/' . $id . '/')) {
                File::makeDirectory(storage_path() . '/app/' . $modelName . '/' . $id . '/');
            }
        }

        //Remove Special Character
        $fileName = SITE_NAME . '-' . $randText . '-' . preg_replace("/[^a-zA-Z0-9.]/", '0', $file->getClientOriginalName());
        if (File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $fileName)) {
            $fileName = rand(10000, 99999) . '-' . $fileName;
        }
        if ($storage == true) {
            $filePath = storage_path() . '/app/' . $modelName . '/' . $id;
        } else {
            $filePath = PATH_TO_UPLOAD . $modelName . '/' . $id;
        }
        $file->move($filePath, $fileName);

        $size = $file->getClientSize();
        $size = ($size / 1024) / 1024;
        $size_format = 'MB';
        if ($size < 1) {
            $size = $size * 1024;
            $size_format = 'KB';
        }

        $this->attachments()->create([
            'title' => $slug,
            'slug' => $slug = (substr($slug, 0, 7) == "attach_") ? "attachment" : $slug,
            'mime' => File::mimeType($filePath . '/' . $fileName),
            'file_name' => $fileName,
            'size' => intval($size), // Kilobyte or Megabyte
            'size_format' => $size_format, // KB or MB
        ]);
    }

    public function takeFile($slug)
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);

        $file = $this->attachments->filter(function ($value) use ($slug) {
            return ($value['slug'] == $slug) ? true : false;
        })->first();
        if(!$file){
            return false;
        }
        $file_path = asset(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $file->file_name);
        return $file_path;
        return false;
    }

    public function takeFileWithId($attachmentId)
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);
        $file = $this->attachments->where('id',$attachmentId)->first();
        if(!$file){
            return false;
        }
        $file_path = asset(PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $file->file_name);
        return $file_path;
    }

    public function deleteFile($slug, $storage = false)
    {
        $modelName = md5($this->getTable());
        $id = md5($this->id);

        if ($storage == true) {
            $file_path = storage_path() . '/app/' . $modelName . '/' . $id . '/' . $this->attachmentSlug($slug)->first()->file_name;
        } else {
            $file_path = PATH_TO_UPLOAD . $modelName . '/' . $id . '/' . $this->attachmentSlug($slug)->first()->file_name;
        }
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $this->attachmentSlug($slug)->get()->each(function ($attachment) {
            $attachment->delete();
        });
    }

    private function getGetFFMpegFFProp($os = 'linux')
    {
        $operatingSystems = [
            'windows' => [
                'ffmpeg' =>[
                    'ffmpeg.binaries' => 'assets/admin/_plugins/ffmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
                    'ffprobe.binaries' => 'assets/admin/_plugins/ffmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
                    'timeout' => 0, // the timeout for the underlying process
//                'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
                ],
                'ffprop' =>[
                    'ffmpeg.binaries' => 'assets/admin/_plugins/ffmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
                    'ffprobe.binaries' => 'assets/admin/_plugins/ffmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
                    'timeout' => 0, // the timeout for the underlying process
//                'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
                ]
            ],
            'linux' => [
                'ffmpeg' => [
                    'ffmpeg.binaries' => 'assets/admin/_plugins/ffmpeg/ffmpeg', // the path to the FFMpeg binary
                    'ffprobe.binaries' => 'assets/admin/_plugins/ffmpeg/ffprobe', // the path to the FFProbe binary
                    'timeout' => 3600, // the timeout for the underlying process
                    'ffmpeg.threads' => 12,   // the number of threads that FFMpeg should use
                ],
                'ffprop' => [
                    'ffmpeg.binaries' => 'assets/admin/_plugins/ffmpeg/ffmpeg', // the path to the FFMpeg binary
                    'ffprobe.binaries' => 'assets/admin/_plugins/ffmpeg/ffprobe', // the path to the FFProbe binary
                    'timeout' => 3600, // the timeout for the underlying process
                    'ffmpeg.threads' => 12,   // the number of threads that FFMpeg should use
                ]
            ]
        ];
        return $operatingSystems[$os];
    }

    private function makeDirectories($id,$modelName,$storage=false){
        //Make Model Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/');
        }
        //Make Object Folder
        if (!File::exists(PATH_TO_UPLOAD . $modelName . '/' . $id . '/')) {
            File::makeDirectory(PATH_TO_UPLOAD . $modelName . '/' . $id . '/');
        }

        if ($storage == true) {
            if (!File::exists(storage_path() . '/app/' . $modelName . '/')) {
                File::makeDirectory(storage_path() . '/app/' . $modelName . '/');
            }
            if (!File::exists(storage_path() . '/app/' . $modelName . '/' . $id . '/')) {
                File::makeDirectory(storage_path() . '/app/' . $modelName . '/' . $id . '/');
            }
        }
    }
}
