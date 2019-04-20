<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Swagger\Annotations as SWG;

class UserController extends Controller
{


    /**
     * @SWG\Post(
     *     path="/v1/user/info",
     *     tags={"user"},
     *     summary="用户信息",
     *     description="获取当前登录用户的信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(ref="#/parameters/Auth"),
     *     @SWG\Response(
     *          response="200",
     *          description="正确返回",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="user",
     *                  type="array",
     *                  @SWG\Items()
     *              )
     *          )
     *     ),
     *     @SWG\Response(
     *          response="400",
     *          description="错误返回",
     *          ref="#/definitions/Error"
     *     )
     * )
     *
     * 用户信息
     *
     * @return array
     */
    public function userInfo()
    {

        return response()->json([
            'code' => '0',
            'message' => '请求成功',
            'data' => [
                'user' => auth('api')->user()
            ],
        ]);

    }

}
