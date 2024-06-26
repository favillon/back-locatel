<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Events\BalanceAccountEvent;

class TransactionController extends Controller
{
    public function deposit(Request $request)
    {
        $response = $this->_transaction(TransactionTypeEnum::DEPOSIT, $request);
        return response()->json($response, $response['code']);
    }

    public function debit(Request $request)
    {
        $response = $this->_transaction(TransactionTypeEnum::DEBIT, $request); 
        return  response()->json($response, $response['code']);
    }

    private function _transaction($transactionType, $request)
    {
        $authUser = auth()->user();
        $account  = $authUser->account()->first();

        try {
            
            $validateRequest = Validator::make($request->all(), [
                'value'  => 'required'
            ]);

            $request->value =  ($transactionType == 1)  ? $request->value  :  ($request->value * -1) ;

            if ($validateRequest->fails()) {
                return [
                    'status'  => false,
                    'message' => 'Validation Error',
                    'errors'  => $validateRequest->errors(),
                    'code'    => Response::HTTP_UNAUTHORIZED
                ];
            }
            $transaction = Transaction::create([
                'transaction_type_id' => $transactionType,
                'account_id'          => $account->id,
                'value'               => $request->value,
            ]);

            if ($transaction) {
                BalanceAccountEvent::dispatch(['user' => $authUser, 'account' => $account]);
            }

            return [
                'status'  => true,
                'message' => 'Successful transaction',
                'code' =>  Response::HTTP_CREATED
            ]; //201

        } catch (\Throwable $th) {
            return [
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $th->getMessage(),
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
 }
