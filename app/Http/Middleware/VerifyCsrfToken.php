<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Route;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];


    protected function shouldPassThrough($request)
    {
        $myExcept = [
            'contents_uploadfile',
            'contents_uploadcoverimage',
            'crop_image_post',
            'contents_order',
            'banners_imageupload'
        ];

        /** @var \Illuminate\Http\Request $request */
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }
        if(in_array(Route::getCurrentRoute()->getName(), $myExcept)) {
            return true;
        }
        return false;
    }

}
