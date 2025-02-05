<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadImage')) {
    /**
     * Upload an image to a specific subfolder and return the stored location.
     *
     * @param \Illuminate\Http\UploadedFile $file The image file instance from the request.
     * @param string $imageName The desired name of the image (without extension).
     * @param string $imageSubfolder The subfolder inside the upload directory.
     * @return string|bool The path of the uploaded image, or false on failure.
     */
    function uploadImage($file, $imageName, $imageSubfolder , $full_path)
    {
        try {
            // Ensure the file is valid
            // if (!$file || !$file->isValid()) {
            //     return false;
            // }

            // Generate a full file name with the original extension
            $fileName = $imageName . '.' . $file->getClientOriginalExtension();

            // Define the upload path
            $path = $imageSubfolder ? $imageSubfolder . '/' . $fileName : $fileName;

            // Store the file in the 'uploads' disk
            Storage::disk('uploads')->put($path, file_get_contents($file));
            $newpath = 'uploads/' . ($imageSubfolder ? $imageSubfolder . '/' . $fileName : $fileName);

        if($full_path){
            return $newpath;
        }else{

            return $fileName;
        }


        } catch (\Exception $e) {
            // Log the error or handle it as necessary
            \Log::error('Image upload failed: ' . $e->getMessage());
            return false;
        }
    }
}
