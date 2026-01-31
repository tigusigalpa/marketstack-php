<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\Endpoints;

use Tigusigalpa\Marketstack\DTO\CurrencyData;

/**
 * Currencies endpoint.
 *
 * Provides access to currency information.
 */
class Currencies extends BaseEndpoint
{
    /**
     * The endpoint path.
     */
    protected string $endpoint = 'currencies';

    /**
     * Get a specific currency by code.
     *
     * @param string $code
     * @return $this
     */
    public function code(string $code): static
    {
        $this->endpoint = "currencies/{$code}";
        return $this;
    }

    /**
     * Transform a data item to a DTO.
     *
     * @param array<string, mixed> $data
     * @return CurrencyData
     */
    protected function transformToDto(array $data): object
    {
        return new CurrencyData($data);
    }
}
