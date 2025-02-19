<?php

namespace Behandam\Response;

use Illuminate\Contracts\Support\Responsable;

class BehandamResponse implements Responsable
{
    private mixed $data = null;

    private mixed $links = null;

    private mixed $meta = null;

    private ?string $message = null;

    private ?string $errorMessage = null;

    private ?array $errors = null;

    private ?string $next = null;

    private int $httpCode = 200;

    public static function make(): static
    {
        return new static;
    }

    public static function from(array|object $data = []): BehandamResponse
    {
        $data = is_object($data) ? get_object_vars($data) : $data;

        return self::make()
            ->data($data['data'] ?? $data)
            ->links($data['links'] ?? null)
            ->meta($data['meta'] ?? null)
            ->message($data['message'] ?? null)
            ->status($data['status'] ?? 200)
            ->errorMessage($data['error_message'] ?? null)
            ->errors($data['errors'] ?? null)
            ->next($data['next'] ?? null);
    }

    public function message(?string $value): static
    {
        $this->message = $value;

        return $this;
    }

    public function data(mixed $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function links(mixed $data): static
    {
        $this->links = $data;

        return $this;
    }

    public function meta(mixed $data): static
    {
        $this->meta = $data;

        return $this;
    }

    public function errorMessage(?string $errorMessage): static
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function errors(?array $errors): static
    {
        $this->errors = $errors;

        return $this;
    }

    public function next(?string $next): static
    {
        $this->next = $next;

        return $this;
    }

    public function status(int $status): static
    {
        $this->httpCode = $status;

        return $this;
    }

    public function toResponse($request)
    {
        return response()->json(
            $this->responseData(),
            $this->httpCode,
        );
    }

    public function responseData(): array
    {
        $response = ['data' => $this->data];

        if ($this->links) {
            $response['links'] = $this->links;
        }

        if ($this->meta) {
            $response['meta'] = $this->meta;
        }

        if ($this->next) {
            $response['next'] = $this->next;
        }

        return array_merge($response, [
            'message' => $this->message,
            'error' => [
                'message' => $this->errorMessage,
                'errors' => $this->errors,
            ],
        ]);
    }
}
