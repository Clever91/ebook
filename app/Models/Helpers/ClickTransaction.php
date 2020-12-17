<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Model;

class ClickTransaction extends Model
{
    const ACTION_PREPARE = 0;
    const ACTION_COMPLETE = 1;
    const ACTION_CANCEL = 2;

    protected $fillable = [ 
        'click_trans_id', 'service_id', 'click_paydoc_id', 'merchant_trans_id', 
        'amount', 'action', 'error', 'error_note', 'sign_time', 'sign_string',
    ];

    public static function getResponse($data, $error, $prepare_id = null, $confirm_id = null)
    {
        $error_note = self::getErrorNote($error);
        if ($error < 0) {
            return [
                'error' => $error,
                'error_note' => $error_note,
            ];    
        }

        if (!is_null($confirm_id)) {
            return [
                'click_trans_id' => $data['click_trans_id'],
                'merchant_trans_id' => $data['merchant_trans_id'],
                'error' => $error,
                'error_note' => $error_note,
                'merchant_confirm_id' => $confirm_id,
            ];
        }

        return [
            'click_trans_id' => $data['click_trans_id'],
            'merchant_trans_id' => $data['merchant_trans_id'],
            'error' => $error,
            'error_note' => $error_note,
            'merchant_prepare_id' => $prepare_id,
        ];
    }

    public static function getErrorNote($error)
    {
        // -1 	SIGN CHECK FAILED! 	Ошибка проверки подписи
        // -2 	Incorrect parameter amount 	Неверная сумма оплаты
        // -3 	Action not found 	Запрашиваемое действие не найдено
        // -4 	Already paid 	Транзакция ранее была подтверждена (при попытке подтвердить или отменить ранее подтвержденную транзакцию)
        // -5 	User does not exist 	Не найдет пользователь/заказ (проверка параметра merchant_trans_id)
        // -6 	Transaction does not exist 	Не найдена транзакция (проверка параметра merchant_prepare_id)
        // -7 	Failed to update user 	Ошибка при изменении данных пользователя (изменение баланса счета и т.п.)
        // -8 	Error in request from click 	Ошибка в запросе от CLICK (переданы не все параметры и т.п.)
        // -9 	Transaction cancelled
        $error_note = "None";
        switch ($error) {
            case 0:
                $error_note = 'Success';
                break;
            case -1:
                $error_note = 'SIGN CHECK FAILED!';
                break;
            case -2:
                $error_note = 'Incorrect parameter amount';
                break;
            case -3:
                $error_note = 'Action not found';
                break;
            case -4:
                $error_note = 'Already paid';
                break;
            case -5:
                $error_note = 'User does not exist';
                break;
            case -6:
                $error_note = 'Transaction does not exist';
                break;
            case -7:
                $error_note = 'Failed to update user';
                break;
            case -8:
                $error_note = 'Error in request from click';
                break;
            case -9:
                $error_note = 'Transaction cancelled';
                break;
        }
        return $error_note;
    }
}
