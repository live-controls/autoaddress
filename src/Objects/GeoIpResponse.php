<?php

namespace LiveControls\AutoAddress\Objects;

class GeoIpResponse
{
    public readonly ?string $ip;
    public readonly ?string $areacode;
    public readonly ?string $city;
    public readonly ?string $state;
    public readonly ?string $country;

    /**
     * @param array{
     *  ip?: string|null,
     *  areacode?: string|null,
     *  city?: string|null,
     *  state?: string|null,
     *  country?: string|null
     * } $data
     */
    public function __construct(array $data)
    {
        $this->ip = $data['ip'] ?? null;
        $this->areacode = $data['areacode'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->state = $data['state'] ?? null;
        $this->country = $data['country'] ?? null;
    }
}