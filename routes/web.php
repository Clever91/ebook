<?php

use App\Helpers\Common\ClickHelper;
use App\Helpers\Log\TelegramLog;
use App\Models\Bot\ChatOrder;
use App\Models\Helpers\ClickTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Lunaweb\Localization\Facades\Localization;
use Telegram\Bot\Laravel\Facades\Telegram;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);
Route::get('/', function() {
    return redirect('login');
});

Route::get('/denied', function() {
    return view('error._denied');
})->name('denied');


// ~~~~~~~~~~~~~~~~~~~ Payment Callback ~~~~~~~~~~~~~~~~~~~

Route::group(['prefix' => 'pay'], function () {

    // payme prepare
    Route::match(['get', 'post'], '/payme/prepare', function(Request $request) {
        if (request()->isMethod('post')) {
            $data = request()->all();
            TelegramLog::log($data);
    
            if (empty($data))
                return ClickTransaction::getResponse($data, -8);

            if ($data['error'] != 0) {
                return ClickTransaction::getResponse($data, -8);
            }
            
            if ($data['action'] == ClickTransaction::ACTION_PREPARE) {
                if (!ClickHelper::checkSign($data)) {
                    return ClickTransaction::getResponse($data, -1);
                }
    
                $order = ChatOrder::find($data['merchant_trans_id']);
                if (is_null($order)) {
                    return ClickTransaction::getResponse($data, -5);
                }

                $model = ClickTransaction::create($data);
                if (!is_null($model)) {
                    return ClickTransaction::getResponse($data, 0, $model->id);
                }

                return ClickTransaction::getResponse($data, -6);
            } else if ($data['action'] == ClickTransaction::ACTION_COMPLETE) {

                if (!ClickHelper::checkSign($data, $data['merchant_prepare_id'])) {
                    return ClickTransaction::getResponse($data, -1);
                }

                $model = ClickTransaction::find($data['merchant_prepare_id']);
                if (is_null($model)) {
                    return ClickTransaction::getResponse($data, -6);
                }

                $order = ChatOrder::find($data['merchant_trans_id']);
                if (is_null($order)) {
                    $model->error = -5;
                    $model->error_note = ClickTransaction::getErrorNote(-5);
                    $model->save();
                    return ClickTransaction::getResponse($data, -5);
                }

                $amount = $order->amountWithDelivery();
                if ($amount != $data['amount']) {
                    $model->error = -2;
                    $model->error_note = ClickTransaction::getErrorNote(-2);
                    $model->save();
                    return ClickTransaction::getResponse($data, -2);
                }

                // check ClickTransaction::ACTION_CANCEL

                if ($model->action == ClickTransaction::ACTION_COMPLETE) {
                    $model->error = -4;
                    $model->error_note = ClickTransaction::getErrorNote(-4);
                    $model->save();
                    return ClickTransaction::getResponse($data, -4);
                }

                $model->action = ClickTransaction::ACTION_COMPLETE;
                $model->error = 0;
                $model->error_note = ClickTransaction::getErrorNote(0);
                if ($model->save()) {
                    $order->paid = ChatOrder::PAID_SUCCESS;
                    $order->state = ChatOrder::STATE_NEW;
                    if ($order->save()) {

                        // try {
                        //     // edit message reply markup
                        //     Telegram::editMessageReplyMarkup([
                        //         'chat_id' => $order->chat_id,
                        //         'message_id' => $order->message_id,
                        //         'inline_message_id' => $order->message_id,
                        //         'reply_markup' => false
                        //     ]);
                        //     Telegram::sendMessage([
                        //         'chat_id' => $order->chat_id,
                        //         'text' => Lang::get('bot.thank_you_your_order_accepted') ."*". $order->id ."*",
                        //         'parse_mode' => "Markdown",
                        //         'reply_to_message_id' => $order->message_id
                        //     ]);
                        // } catch (Exception $e) {
                        //     TelegramLog::log($e->getMessage());
                        // }

                        // // ~~~~~~~~~~~~~~~~~ send group check

                        // $group_id = env("TELEGRAM_ORDER_GROUP");
                        // $text = $order->telegramOrderList();

                        // try {
                        //     $response = Telegram::sendMessage([
                        //         'chat_id' => $group_id,
                        //         'text' => $text,
                        //         'parse_mode' => "HTML"
                        //     ]);
                        //     if (!$order->isPickUp()) {
                        //         $response = Telegram::sendLocation([
                        //             'chat_id' => $group_id,
                        //             'latitude' => $order->lat,
                        //             'longitude' => $order->long,
                        //             'reply_to_message_id' => $response->getMessageId()
                        //         ]);
                        //     }
                        // } catch (Exception $e) {
                        //     TelegramLog::log($e->getMessage());
                        // }

                        return ClickTransaction::getResponse($data, 0, null, $order->id);
                    }
                    return ClickTransaction::getResponse($data, -7);
                }
            } else {
                return ClickTransaction::getResponse($data, -3);
            }
            
        }
        return $request->route('home');
    })->name('payme.prepare');

    // payme complete
    Route::match(['get', 'post'], '/payme/complete', function(Request $request) {
        TelegramLog::log(request()->all());
    })->name('payme.complete');

});

// ~~~~~~~~~~~~~~~~~~~ Admin ~~~~~~~~~~~~~~~~~~~
Localization::localizedRoutesGroup(function() {

    // error route
    Route::get('/error/404', function() {
        if (Auth::check())
            return view('error._404');
        
        return view('auth._404');
    })->name('error404');

    Route::get('/error/500', function() {
        if (Auth::check())
            return view('error._500');
        
        return view('auth._500');
    })->name('error500');

    // admin route
    Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
        // globale route
        Route::get('/', 'Admin\DashboardController@index')->name('home');
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard')->middleware('auth');
        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

        // resource route
        // Route::group(['middleware' => ['sadmin', 'admin']], function() {
        // });
        Route::resource('user', 'Admin\UserController')->except('show');
        Route::resource('category', 'Admin\CategoryController')->except('show');
        Route::resource('group', 'Admin\GroupController')->except('show');
        Route::resource('author', 'Admin\AuthorController')->except('show');
        Route::resource('product', 'Admin\ProductController')->except('show');

        // custom image route
        Route::get('/product/{product}/eform', 'Admin\ProductController@eform')->name('product.eform');
        Route::patch('/product/{product}/eform', 'Admin\ProductController@eform')->name('product.eform.patch');
        Route::get('/product/{product}/image', 'Admin\ProductController@image')->name('product.image');
        Route::patch('/product/{product}/image', 'Admin\ProductController@image')->name('product.image.patch');

        // custom image route
        Route::get('/author/{author}/image', 'Admin\AuthorController@image')->name('author.image');
        Route::patch('/author/{author}/image', 'Admin\AuthorController@image')->name('author.image.patch');

        // custom image route
        Route::get('/group/{group}/image', 'Admin\GroupController@image')->name('group.image');
        Route::patch('/group/{group}/image', 'Admin\GroupController@image')->name('group.image.patch');

        // custom image route
        Route::get('/category/{category}/image', 'Admin\CategoryController@image')->name('category.image');
        Route::patch('/category/{category}/image', 'Admin\CategoryController@image')->name('category.image.patch');

        Route::get('/ebook/index', 'Admin\EbookController@index')->name('admin.ebook.index');
        Route::get('/order/index', 'Admin\OrderController@index')->name('admin.order.index');

        // group relation
        Route::get('/relation/{relation}/{type}/index', 'Admin\GroupRelationController@index')->name('admin.relation.index');
        Route::post('/relation/{relation}/{type}/store', 'Admin\GroupRelationController@store')->name('admin.relation.store');

        Route::get('/telegram/{product}/index', 'Admin\TelegramController@index')->name('admin.telegram.index');
        Route::post('/telegram/{product}/send', 'Admin\TelegramController@send')->name('admin.telegram.send');
    });
    
});


// ~~~~~~~~~~~~~~~~~~~ Firebase Auth ~~~~~~~~~~~~~~~~~~~


Route::group(['prefix' => "firebase"], function() {

    Route::get('/auth', function() {
        return view('auth.firebase');
    });

    Route::get('/', 'Auth\FirebaseController@index');
    Route::get('/check', 'Auth\FirebaseController@check');
    Route::get('/create', 'Auth\FirebaseController@create');  
    Route::get('/success', 'Auth\FirebaseController@success');  

});