<?php
/**
 * Created by PhpStorm.
 * User: Bboto
 * Date: 28/02/2018
 * Time: 10:34
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\Request;

class SecretPostVM
{
    /**
     * @var string This text will be saved as a secret
     */
    public $secret;

    /**
     * @var int The secret won’t be available after the given number of views. It must be greater than 0.
     */
    public $expireAfterViews;

    /**
     * @var int The secret won’t be available after the given time. The value is provided in minutes. 0 means never expires
     */
    public $expireAfter;

    function __construct(Request $request)
    {
        $this->secret = $request->get('secret');
        $this->expireAfter = $request->get('expireAfter');
        $this->expireAfterViews = $request->get('expireAfterViews');
    }

    public function isValid()
    {
        //TODO: write unit tests for these
        $isExpiresAfterValid = is_numeric($this->expireAfter) && $this->expireAfter >= 0;
        $isExpiresAfterViewsValid = is_numeric($this->expireAfterViews) && $this->expireAfterViews > 0;

        if( !empty($this->secret) &&
            $isExpiresAfterValid &&
            $isExpiresAfterViewsValid
        )
        {
            return true;
        }
        else
        {
            return false;
        }
    }



}