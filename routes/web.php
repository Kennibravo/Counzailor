<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*** General Routes for both Counsellors and Counsellee */
$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
});

/*** Counsellor Routes */
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['name' => 'counsellor.', 'middleware' => 'assign.guard:counsellor', 'prefix' => 'counsellor', 'namespace' => 'Counsellor'], function () use ($router) {
        $router->group(['namespace' => 'Auth'], function () use ($router) {
            $router->post('register', ['as' => 'register', 'uses' => 'RegisterController@register']);
            $router->put('register_step_two/{counsellorId}', ['as' => 'register.step_two', 'uses' => 'RegisterController@registerStepTwo']);
            $router->post('login', ['as' => 'login', 'uses' => 'LoginController@login']);
        });

        $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
            $router->group(['namespace' => 'Profile', 'name' => 'profile.', 'prefix' => 'profile'], function () use ($router) {
                $router->put('update', ['as' => 'update.info', 'uses' => 'ProfileController@update']);
                $router->get('/', ['as' => 'get', 'uses' => 'ProfileController@getProfile']);
                $router->delete('{userId}', ['as' => 'deactivate', 'uses' => 'ProfileController@deactivateAccount']);
                $router->post('/register-counsellee/{userId}', ['as' => 'register.counsellee', 'uses' => 'ProfileController@registerAsCounsellee']);
                $router->put('update_password', ['as' => 'password.update', 'uses' => 'ProfileController@updatePassword']);
            });

            $router->group(['namespace' => 'Follower', 'name' => 'follow.', 'prefix' => 'follow'], function () use ($router) {
                $router->get('followers', ['as' => 'followers', 'uses' => 'FollowerController@getAllCounsellorFollowers']);
                $router->get('{followerId}', ['as' => 'follow', 'uses' => 'FollowerController@followCounsellee']);
                $router->get('unfollow/{followerId}', ['as' => 'unfollow', 'uses' => 'FollowerController@unfollowCounsellee']);
                $router->get('check-follow/{counselleeId}', ['as' => 'check.follow', 'uses' => 'FollowerController@checkIfCounsellorFollowCounsellee']);
                $router->get('search/{search}', ['as' => 'check.follow', 'uses' => 'FollowerController@searchThroughCounsellorFollowers']);
                /*$router->get('test', function () {
                   $u = \App\Models\CounsellorFollower::searchFollowers('kennysd');
                });*/
            });

            $router->group(['name' => 'category.', 'prefix' => 'categories'], function () use ($router) {
                $router->get('', ['as' => 'index', 'uses' => 'CategoryController@index']);
                $router->post('', ['as' => 'store', 'uses' => 'CategoryController@store']);
                $router->put('update/{categoryId}', ['as' => 'update', 'uses' => 'CategoryController@update']);
                $router->get('/{id}', ['as' => 'show', 'uses' => 'CategoryController@show']);
            });
        });
    });


    /*** Counsellee Routes */
    $router->group(['name' => 'counsellee.', 'middleware' => 'assign.guard:counsellee', 'prefix' => 'counsellee', 'namespace' => 'Counsellee'], function () use ($router) {
        $router->group(['namespace' => 'Auth'], function () use ($router) {
            $router->post('register', ['as' => 'register', 'uses' => 'RegisterController@register']);
            $router->put('register_step_two/{counselleeId}', ['as' => 'register.step_two', 'uses' => 'RegisterController@registerStepTwo']);
            $router->post('login', ['as' => 'login', 'uses' => 'LoginController@login']);
        });

        $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
            $router->group(['prefix' => 'chat', 'name' => 'chat.', 'namespace' => 'Chat'], function () use ($router) {
                $router->post('create', ['as' => 'create', 'uses' => 'ChatController@createChat']);
                $router->post('send-message', ['as' => 'send.msg', 'uses' => 'ChatController@sendMessageToCounsellor']);
                $router->get('messages/{chatId}', ['as' => 'messages', 'uses' => 'ChatController@getCounselleeMessagesInAChat']);
                $router->get('', ['as' => 'current.user', 'uses' => 'ChatController@getCurrentCounselleeChats']);
            });

            $router->group(['prefix' => 'counsel_requests', 'name' => 'counsel.'], function () use ($router) {
                $router->get('', ['as' => 'index', 'uses' => 'CounselRequestController@index']);
                $router->post('', ['as' => 'store', 'uses' => 'CounselRequestController@store']);
                $router->put('update/{id}', ['as' => 'update', 'uses' => 'CounselRequestController@update']);
                $router->delete('delete/{id}', ['as' => 'update', 'uses' => 'CounselRequestController@delete']);
            });
        });
    });
});
