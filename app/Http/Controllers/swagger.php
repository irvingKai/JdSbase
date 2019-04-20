<?php
/**
 * Swagger
 *
 * User: Ken.Zhang <kenphp@yeah.net>
 * Date: 2019/4/16
 * Time: 16:20
 */

use Swagger\Annotations as SWG;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *     basePath="",
 *     host="usermanager.tkjidi.com",
 *     schemes={"http","https"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="用户管理后台Api",
 *         @SWG\Contact(name="淘客基地技术部", url="https://www.tkjidi.com"),
 *     )
 * )
 */

/**
 * @SWG\Parameter(
 *      parameter="Auth",
 *      name="Authorization",
 *      type="string",
 *      in="header",
 *      required=true,
 *      description="Access Token"
 *  )
 */

/**
 * 正常响应
 *
 * @SWG\Definition(
 *     definition="Success",
 *     type="object",
 *     required={"code","message"},
 *     @SWG\Property(
 *          property="code",
 *          type="string",
 *          description="响应码",
 *          default="0"
 *     ),
 *     @SWG\Property(
 *          property="message",
 *          type="string",
 *          description="响应消息",
 *          default="请求成功"
 *     ),
 *     @SWG\Property(
 *          property="data",
 *          type="array",
 *          description="响应数据",
 *          @SWG\Items()
 *     )
 * )
 */

/**
 * 错误响应
 *
 * @SWG\Definition(
 *     definition="Error",
 *     type="object",
 *     required={"code","message"},
 *     @SWG\Property(
 *          property="code",
 *          type="string",
 *          description="响应码",
 *          default="01"
 *     ),
 *     @SWG\Property(
 *          property="message",
 *          type="string",
 *          description="响应消息",
 *          default="请求失败"
 *     ),
 *     @SWG\Property(
 *          property="errors",
 *          type="array",
 *          description="详情错误信息",
 *          @SWG\Items()
 *     )
 * )
 */