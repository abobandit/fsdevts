<?php

namespace App;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiHelper
{
    public static function response($success = true, $status = 200, $message = '', $data = []): JsonResponse
    {
        return response()->json([
            'status' => $success,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    /**
     * Проверяет, является ли запрос API запросом
     */
    public function isApiRequest(Request $request): bool
    {
        return $request->expectsJson() || $request->is('api/*');
    }

    /**
     * Обработка ошибки аутентификации (401)
     */
    public function handleAuthenticationException(): JsonResponse
    {
        return self::response(
            false,
            Response::HTTP_UNAUTHORIZED,
            'Необходима аутентификация',
            'unauthenticated');
    }

    /**
     * Обработка ошибки метод не разрешен (405)
     */
    public function handleMethodNotAllowedException(): JsonResponse
    {
        return self::response(false, 405, 'Method not allowed');
    }

    /**
     * Обработка ошибки не найдено (404)
     */
    public function handleNotFoundException(): JsonResponse
    {
        return self::response(false, 404, 'Route not found');
    }

    /**
     * Обработка ошибки не найдено (404)
     */
    public function handleModelNotFoundException($model): JsonResponse
    {
        $modelName = method_exists($model, 'label')
            ? $model::label()
            : 'Модель';
        return self::response(false, 404, 'Не удалось найти '.$modelName);
    }

    /**
     * Обработка ошибки валидации (400)
     */
    public function handleValidationException(ValidationException $e): JsonResponse
    {
        return self::response(
            false,
            400,
            'Ошибка валидации данных',
            $e->errors()
        );
    }

    /**
     * Обработка остальных HTTP исключений (4xx)
     */
    public function handleGenericException(Throwable $e): ?JsonResponse
    {
        if (method_exists($e, 'getStatusCode')) {
            $statusCode = $e->getStatusCode();

            if ($statusCode >= 400 && $statusCode < 500) {
                return self::response(
                    false,
                    $statusCode,
                    $e->getMessage() ?: 'Ошибка клиентского запроса'
                );
            }
        }

        return null;
    }
}
