<?php

namespace App\Http\Requests;


namespace App\Http\Requests;

use App\ApiHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseRequest extends FormRequest
{
    /**
     * Обработка ошибок валидации
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            ApiHelper::response(
                false,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                'Ошибка валидации данных',
                $validator->errors(),
            )
        );
    }

    /**
     * Обработка ошибок авторизации
     */
    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(
            ApiHelper::response(
                false,
                Response::HTTP_UNAUTHORIZED,
                $this->authorizationMessage(),
                'forbidden'
            )
        );
    }

    /**
     * Сообщение для ошибки авторизации (можно переопределить)
     */
    protected function authorizationMessage(): string
    {
        return 'У вас нет прав для выполнения этого действия';
    }

    /**
     * Обработка неаутентифицированных запросов
     */
    protected function unauthenticated(): void
    {
        throw new HttpResponseException(
            ApiHelper::response(
                false,
                Response::HTTP_UNAUTHORIZED,
                'Необходима аутентификация',
                'unauthenticated'
            )
        );
    }
}
