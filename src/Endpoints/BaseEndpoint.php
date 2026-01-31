<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\Endpoints;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Tigusigalpa\Marketstack\Exceptions\MarketstackException;
use Tigusigalpa\Marketstack\MarketstackClient;

/**
 * Base class for all API endpoints.
 *
 * Provides common functionality for building requests, executing them,
 * and transforming responses into various formats.
 */
abstract class BaseEndpoint
{
    /**
     * The Marketstack client instance.
     */
    protected MarketstackClient $client;

    /**
     * Query parameters for the request.
     *
     * @var array<string, mixed>
     */
    protected array $params = [];

    /**
     * The endpoint path (e.g., 'eod', 'intraday').
     */
    protected string $endpoint;

    /**
     * Create a new endpoint instance.
     *
     * @param MarketstackClient $client
     */
    public function __construct(MarketstackClient $client)
    {
        $this->client = $client;
    }

    /**
     * Set a query parameter.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    protected function setParam(string $key, mixed $value): static
    {
        if ($value !== null) {
            $this->params[$key] = $value;
        }

        return $this;
    }

    /**
     * Set multiple symbols.
     *
     * @param string ...$symbols
     * @return $this
     */
    public function symbols(string ...$symbols): static
    {
        return $this->setParam('symbols', implode(',', $symbols));
    }

    /**
     * Set the sort order.
     *
     * @param string $order 'ASC' or 'DESC'
     * @return $this
     */
    public function sort(string $order): static
    {
        return $this->setParam('sort', strtoupper($order));
    }

    /**
     * Set the limit for results.
     *
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): static
    {
        return $this->setParam('limit', $limit);
    }

    /**
     * Set the offset for pagination.
     *
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset): static
    {
        return $this->setParam('offset', $offset);
    }

    /**
     * Execute the request and return the raw response.
     *
     * @return Response
     * @throws MarketstackException
     */
    public function get(): Response
    {
        $response = $this->client->getHttpClient()
            ->get($this->endpoint, $this->params);

        if ($response->failed()) {
            throw new MarketstackException(
                $response->json('error.message') ?? 'API request failed',
                $response->status()
            );
        }

        return $response;
    }

    /**
     * Execute the request and return the JSON response as an array.
     *
     * @return array<string, mixed>
     * @throws MarketstackException
     */
    public function json(): array
    {
        return $this->get()->json();
    }

    /**
     * Execute the request and return the data as a Collection.
     *
     * @return Collection
     * @throws MarketstackException
     */
    public function collect(): Collection
    {
        $response = $this->json();
        $data = $response['data'] ?? [];

        return collect($data)->map(fn($item) => $this->transformToDto($item));
    }

    /**
     * Execute the request and return a single DTO or null.
     *
     * @return object|null
     * @throws MarketstackException
     */
    public function dto(): ?object
    {
        $response = $this->json();
        $data = $response['data'] ?? [];

        if (empty($data)) {
            return null;
        }

        $item = is_array($data) ? ($data[0] ?? null) : $data;

        return $item ? $this->transformToDto($item) : null;
    }

    /**
     * Transform a data item to a DTO.
     *
     * @param array<string, mixed> $data
     * @return object
     */
    abstract protected function transformToDto(array $data): object;

    /**
     * Build the full URL for debugging purposes.
     *
     * @return string
     */
    public function buildUrl(): string
    {
        $query = http_build_query(array_merge(
            ['access_key' => $this->client->getApiKey()],
            $this->params
        ));

        return $this->client->getBaseUrl() . '/' . $this->endpoint . '?' . $query;
    }
}
