<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Swagger\Annotations as SWG;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * @SWG\Definition(
     *      definition="Token",
     *      type="object",
     *      required={},
     *      @SWG\Property(
     *          property="access_token",
     *          type="string",
     *          description="授权Token"
     *      ),
     *      @SWG\Property(
     *          property="token_type",
     *          type="string",
     *          description="Token类型"
     *      ),
     *      @SWG\Property(
     *          property="expires_in",
     *          type="integer",
     *          default=3600,
     *          description="有效期 (s)"
     *      )
     * )
     */

    /**
     * @SWG\Post(
     *     path="/v1/auth/login",
     *     tags={"auth"},
     *     summary="管理员登录",
     *     description="管理员登录接口",
     *     produces={"application/json"},
     *     @SWG\Parameter(ref="#/parameters/Auth"),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="account",
     *          description="账号",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="password",
     *          description="密码",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *          response="200",
     *          description="正确返回",
     *          ref="#/definitions/Token"
     *     ),
     *     @SWG\Response(
     *          response="400",
     *          description="错误返回",
     *          ref="#/definitions/Error"
     *     )
     * )
     *
     *
     * 用户登录接口
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 验证规则，由于业务需求，这里我更改了一下登录的用户名，使用手机号码登录
        $rules = [
            'account'   => 'required',
            'password' => 'required|string|min:6|max:20',
        ];

        // 验证参数，如果验证失败，则会抛出 ValidationException 的异常
        $params = $this->validate($request, $rules);

        // 使用 Auth 登录用户，如果登录成功，则返回 201 的 code 和 token，如果登录失败则返回
        $token = Auth::guard('api')->attempt([
            'phone'=>$request->input('account'),
            'password'=>$request->input('password')
        ]);
        if (!$token) {
            return response()->json([
                'code' => '201000',
                'message' => '账号或密码错误'
            ], 400);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @SWG\Post(
     *     path="/v1/auth/logout",
     *     tags={"auth"},
     *     summary="管理员退出",
     *     description="管理员退出接口",
     *     produces={"application/json"},
     *     @SWG\Parameter(ref="#/parameters/Auth"),
     *     @SWG\Response(
     *          response="200",
     *          description="正确返回",
     *          ref="#/definitions/Success"
     *     ),
     *     @SWG\Response(
     *          response="400",
     *          description="错误返回",
     *          ref="#/definitions/Error"
     *     )
     * )
     *
     * 处理用户登出逻辑
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'code' => 0,
            'message' => '退出成功'
        ]);
    }

    /**
     * @SWG\Post(
     *     path="/v1/auth/refresh/token",
     *     tags={"auth"},
     *     summary="刷新Access Token",
     *     description="刷新Access Token接口",
     *     produces={"application/json"},
     *     @SWG\Parameter(ref="#/parameters/Auth"),
     *     @SWG\Response(
     *          response="200",
     *          description="正确返回",
     *          ref="#/definitions/Token"
     *     ),
     *     @SWG\Response(
     *          response="400",
     *          description="错误返回",
     *          ref="#/definitions/Error"
     *     )
     * )
     *
     * 刷新Token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try{
            return $this->respondWithToken(auth('api')->refresh());
        }catch (JWTException $e) {
            return response()->json([
                'code' => '201000',
                'message' => '登录失效'
            ], 400);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'code' => '0',
            'message' => '请求成功',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ],
        ]);
    }

}
