<?php
/**
 * Created by PhpStorm.
 * User: Bboto
 * Date: 28/02/2018
 * Time: 10:34
 */

namespace App\ViewModels;


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

}