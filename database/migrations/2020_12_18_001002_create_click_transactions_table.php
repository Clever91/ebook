<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClickTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('click_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('click_trans_id')->comment('ID платежа в системе CLICK');
            $table->bigInteger('service_id')->comment('ID сервиса');
            $table->bigInteger('click_paydoc_id')->comment('Номер платежа в системе CLICK. Отображается в СМС у клиента при оплате.');
            $table->string('merchant_trans_id')->comment('ID заказа(для Интернет магазинов)/лицевого счета/логина в биллинге поставщика');
            $table->float('amount', 8, 2)->comment('Сумма оплаты (в сумах)');
            $table->tinyInteger('action')->comment('Выполняемое действие. Для Prepare — 0');
            $table->integer('error')->comment('Код статуса завершения платежа. 0 – успешно. В случае ошибки возвращается код ошибки.');
            $table->string('error_note')->comment('Описание кода завершения платежа.');
            $table->string('sign_time')->comment('Дата платежа. Формат «YYYY-MM-DD HH:mm:ss»');
            $table->string('sign_string')->comment('Проверочная строка');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('click_transactions');
    }
}
