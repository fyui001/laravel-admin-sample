<?php

namespace App\Http\Requests;

use App\Http\AuthTrait\AdminUserAuthenticationTrait;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    use AdminUserAuthenticationTrait;
}
