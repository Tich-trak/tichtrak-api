<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploadTraits {
    /**
     * Upload Multiple File to AWS S3
     */
    protected function uploadMultipleFile($request, $directory, $fileKeys) {
        $imagesUrl = [];
        $images = $request->hasFile($fileKeys);

        if ($images && $images !== null) {
            $images = $request->file($fileKeys);

            foreach ($images as $key => $image) {
                $fileName  =  $directory . $this->generateCode() . '.' . $image->getClientOriginalExtension();

                $path = Storage::disk('s3')->putFileAs('uploads/' . $directory, $image, $fileName);
                $url = Storage::disk('s3')->url($path);

                $imagesUrl[] = $url;
            }
        }

        return $imagesUrl;
    }

    /**
     * Upload Single File to AWS S3
     */
    protected function uploadSingleFile($request, $directory, $fileKey) {
        $image = $request->hasFile($fileKey);

        if ($image && $image !== null) {
            $image = $request->file($fileKey);
            $fileName  =  $directory . $this->generateCode() . '.' . $image->getClientOriginalExtension();

            $path = Storage::disk('s3')->putFileAs('uploads/' . $directory, $image, $fileName);
            $url = Storage::disk('s3')->url($path);

            return $url;
        } else  return null;
    }
}
