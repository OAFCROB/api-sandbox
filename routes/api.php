<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'namespace' => 'Api',
        'as' => 'api.',
    ],
    function() {
        Route::group(
            [
                'prefix' => 'users',
                'namespace' => 'Users',
                'as' => 'users.'
            ],
            function () {
                Route::get(
                    '/',
                    [
                        'as' => 'index',
                        'uses' => 'ListUsersAction@__invoke'
                    ]
                );

                Route::get(
                    '/{user_id}',
                    [
                        'as' => 'show',
                        'uses' => 'GetUserAction@__invoke'
                    ]
                );
            }
        );
    }
);

// @todo - Replace the auth with jwt.
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
