<?php
/**
 * md5
 *
 * User: Ken.Zhang <kenphp@yeah.net>
 * Date: 2019/4/18
 * Time: 17:30
 */
namespace App\Helpers\Hasher;

use Illuminate\Contracts\Hashing\Hasher;

class MD5Hasher implements Hasher
{
    public function check($value, $hashedValue, array $options = [])
    {

        return $this->make($value) === $hashedValue;
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }

    public function make($value, array $options = [])
    {
//        $value = env('SALT', '').$value;

        return md5($value);
    }

}