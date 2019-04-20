<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 接口正确返回统一方法
     *
     * @param   $message    string      返回信息
     * @param   $data       array       返回的数据
     * @param   $code       int         返回的状态
     * @return  array
     */
    protected function successReturn($message='请求成功', $data=[], $code=200)
    {
        $response = [
            'status_code'   => $code,
            'message'       => $message,
            'data'          => $data
        ];

        return $response;
    }

    /**
     * 接口错误返回的统一方法
     *
     * @param   $message        string  返回的信息
     * @param   $data           array   返回的数据
     * @param   $code           int     返回的状态
     * @param   $sub_code       int     子码
     * @return array
     */
    protected function failReturn($message='请求失败', $data=[], $code=201, $sub_code=500000, $sub_data=[])
    {
        $response = [
            'status_code'   => $code,
            'message'       => $message,
            'data'          => NULL,
            'sub_code'      => $sub_code,
            'sub_message'   => $this->getSubMessage($sub_code),
            'sub_data'      => $sub_data
        ];

        return $response;
    }

    /**
     * 错误码换错误信息方法
     *
     * @brief   错误返回应该不仅仅返回status_code=201，这里我写了个错误返回的demo
     *           错误码定义应该有一定规律，如AABBCC
     * @param   $sub_code   string
     * @return  string
     */
    private function getSubMessage($sub_code)
    {
        $code = [
            //  10开头的都是成功
            '100000' => '请求成功',
            //  20开头的都是参数问题
            '200001' => '缺少必要参数',
            '200002' => '参数不合法',     //  建议也返回出错的参数
            //  2001是用户和验证相关的参数问题
            '200101' => '请求验证失败',
            '200102' => '验证参数已过期',
            '200103' => '短信发送失败',
            '200104' => '短信发送太频繁',
            '200105' => '短信验证码过期',
            //  2009是通用接口调用验证的问题
            '200900' => '通用接口调用失败',
            //  40开头都是数据库相关错误
            '400001' => '未查到必要的数据',   //  数据库里必查的数据没有查到
            '400002' => 'sql执行失败',
            //  50开头的都php内部错误
            '500000' => '服务器错误',
        ];

        return isset($code[$sub_code]) ? $code[$sub_code] : '未知错误';
    }

    /**
     * 参数校验
     *
     * @param   $data   array   数组，key为提示文字，value为值，
     *                           这个方法是用来判断必传参数是否传，0,'',null,false都会当做未传处理
     * @param   $flag   mixed   需要只检测null就传true
     * @return  array|string    返回错误信息或通过'pass'
     */
    protected function paramsCheckRequire(array $data, $flag=false)
    {
        if (!is_array($data)) {
            $type = gettype($data);
            throwException("You must put a array in [check_require] , you putted a ".$type." data");
        }

        if ($flag) {
            foreach ($data as $k => $v)
            {
                if ($v === null)
                    return $this->failReturn('',$this->getSubMessage(200001).'：'.$k,201,200001);
            }
        } else {
            foreach ($data as $k => $v)
            {
                if(!$v)
                    return $this->failReturn('',$this->getSubMessage(200001).'：'.$k,201,200001);
            }
        }

        return 'pass';
    }

    /**
     * 验证手机号
     *
     * @param   $phone      string
     * @return  array|string
     */
    protected function checkPhone($phone)
    {
        if (preg_match("/^1\d{10}$/",$phone)) {
            return 'pass';
        } else {
            return $this->failReturn('手机号格式不正确', ['phone' => $phone],201,200002,'手机号错误');
        }
    }

    /**
     * 获取异常信息
     *
     * @param \Exception $e
     * @return array
     */
    protected function getException(\Exception $e)
    {
        $data = [];
        $data['code']       = $e->getCode();
        $data['line']       = $e->getLine();
        $data['message']    = $e->getMessage();
        $data['file']       = $e->getFile();
        $data['file']       = basename($data['file']);

        return $data;
    }
}
