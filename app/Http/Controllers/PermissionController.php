<?php
/**
 * 权限管理
 *
 * See: https://learnku.com/articles/9842/user-role-permission-control-package-laravel-permission-usage-description
 * Author: Ken.Zhang
 * Date: 2019-04-17
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Swagger\Annotations as SWG;

class PermissionController extends Controller
{
    //
    
    /**
     * 
     */
    public function index()
    {
        Role::create(['guard_name' => 'api', 'name' => 'superadmin']);
//
        Permission::create(['guard_name' => 'api', 'name' => 'edit articles']);

        $user = auth('api')->user();
        $user->assignRole('superadmin');

        return response()->json(auth('api')->user());
        
    }

    /**
     * @SWG\Post(
     *     path="/v1/permission/my/roles",
     *     tags={"permission"},
     *     summary="当前用户角色",
     *     description="获取当前登录用户的角色",
     *     produces={"application/json"},
     *     @SWG\Parameter(ref="#/parameters/Auth"),
     *     @SWG\Response(
     *          response="200",
     *          description="正确返回",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="roles",
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
     * 获取当前用户权限
     */
    public function myRoles()
    {
        try{
            $user = auth('api')->user();
            $roles = [];

            if (!isset($user->roles))
                throw new \Exception('暂无权限');

            foreach ($user->roles as $role) {
                $roles[] = $role->name;
            }

            return response()->json([
                'code' => '0',
                'message' => '请求成功',
                'data' => [
                    'roles' => $roles
                ]
            ]);
        }catch (\Exception $e){
            return response()->json([
                'code' => '201000',
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
}
