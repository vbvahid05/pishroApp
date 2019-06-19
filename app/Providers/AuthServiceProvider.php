<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


use App\User;
use App\stockroom_order;
use App\Http\Controllers\PublicController;
use App\acl_userRoleAction;
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
//        \App\acl_userRoleAction::class => \App\Policies\CustomerPolicy::class,
    ];
//GateContract $gate
    public function boot(GateContract $gate )
    {
        $this->registerPolicies($gate);
        //--------------------
        $gate->define('customer_create',function($user,$action )
        {
            return PublicController::checkUserACL('customer_create');
        });
        //--------------------
        $gate->define('customer_read',function($user,$action )
        {
            return  PublicController::checkUserACL('customer_read');
        });
        //--------------------
        $gate->define('customer_update',function($user,$action )
        {
            return  PublicController::checkUserACL('customer_update');
        });
        //--------------------
        $gate->define('customer_delete',function($user,$action )
        {
            return  PublicController::checkUserACL('customer_delete');
        });
        //--------------------

        //@@@@@@@@@@@@@@@@@
        $gate->define('product_create',function($user,$action )
        {
            return PublicController::checkUserACL('product_create');
        });
        //--------------------
        $gate->define('product_read',function($user,$action )
        {
            return  PublicController::checkUserACL('product_read');
        });
        //--------------------
        $gate->define('product_update',function($user,$action )
        {
            return  PublicController::checkUserACL('product_update');
        });
        //--------------------
        $gate->define('product_delete',function($user,$action )
        {
            return  PublicController::checkUserACL('product_delete');
        });
        //--------------------

        //@@@@@@@@@@@@@@@@@
        $gate->define('order_create',function($user,$action )
        {
            return PublicController::checkUserACL('order_create');
        });
        //--------------------
        $gate->define('order_read',function($user,$action )
        {
            return  PublicController::checkUserACL('order_read');
        });
        //--------------------
        $gate->define('order_update',function($user,$action )
        {
            return  PublicController::checkUserACL('order_update');
        });
        //--------------------
        $gate->define('order_delete',function($user,$action )
        {
            return  PublicController::checkUserACL('order_delete');
        });
        //--------------------

        //@@@@@@@@@@@@@@@@@
        $gate->define('PuttingProduct_create',function($user,$action )
        {
            return PublicController::checkUserACL('PuttingProduct_create');
        });
        //--------------------
        $gate->define('PuttingProduct_read',function($user,$action )
        {
            return  PublicController::checkUserACL('PuttingProduct_read');
        });
        //--------------------
        $gate->define('PuttingProduct_update',function($user,$action )
        {
            return  PublicController::checkUserACL('PuttingProduct_update');
        });
        //--------------------
        $gate->define('PuttingProduct_delete',function($user,$action )
        {
            return  PublicController::checkUserACL('PuttingProduct_delete');
        });
        //--------------------

        //@@@@@@@@@@@@@@@@@
        $gate->define('TakeOutProducts_create',function($user,$action )
        {
            return PublicController::checkUserACL('TakeOutProducts_create');
        });
        //--------------------
        $gate->define('TakeOutProducts_read',function($user,$action )
        {
            return  PublicController::checkUserACL('TakeOutProducts_read');
        });
        //--------------------
        $gate->define('TakeOutProducts_update',function($user,$action )
        {
            return  PublicController::checkUserACL('TakeOutProducts_update');
        });
        //--------------------
        $gate->define('TakeOutProducts_Delete',function($user,$action )
        {
            return  PublicController::checkUserACL('TakeOutProducts_Delete');
        });
        //--------------------

        //@@@@@@@@@@@@@@@@@
        $gate->define('stockRequest_create',function($user,$action )
        {
            return PublicController::checkUserACL('stockRequest_create');
        });
        //--------------------
        $gate->define('stockRequest_read',function($user,$action )
        {
            return  PublicController::checkUserACL('stockRequest_read');
        });
        //--------------------
        $gate->define('stockRequest_update',function($user,$action )
        {
            return  PublicController::checkUserACL('stockRequest_update');
        });
        //--------------------
        $gate->define('stockRequest_delete',function($user,$action )
        {
            return  PublicController::checkUserACL('stockRequest_delete');
        });
        //--------------------


        //@@@@@@@@@@@@@@@@@
        $gate->define('invoice_create',function($user,$action )
        {
            return PublicController::checkUserACL('invoice_create');
        });
        //--------------------
        $gate->define('invoice_read',function($user,$action )
        {
            return  PublicController::checkUserACL('invoice_read');
        });
        //--------------------
        $gate->define('invoice_update',function($user,$action )
        {
            return  PublicController::checkUserACL('invoice_update');
        });
        //--------------------
        $gate->define('invoice_delete',function($user,$action )
        {
            return  PublicController::checkUserACL('invoice_delete');
        });


        //@@@@@@@@@@@@@@@@@
        $gate->define('warranty_create',function($user,$action )
        {
            return PublicController::checkUserACL('warranty_create');
        });
        //--------------------
        $gate->define('warranty_read',function($user,$action )
        {
            return  PublicController::checkUserACL('warranty_read');
        });
        //--------------------
        $gate->define('warranty_update',function($user,$action )
        {
            return  PublicController::checkUserACL('warranty_update');
        });
        //--------------------
        $gate->define('warranty_delete',function($user,$action )
        {
            return  PublicController::checkUserACL('warranty_delete');
        });


        //--------------------
        $gate->define('adminCheck',function($user,$action )
        {
           // $currentuser =  acl_userRoleAction::find($user->id);
            $currentuser = acl_userRoleAction::where('ura_user_id', '=', $user->id)->firstOrFail();

            if ($currentuser['ura_details'] == 'administrator')
            return true ;
            else return false;

            //return  PublicController::checkUserACL('invoice_delete');
        });

    }
}
