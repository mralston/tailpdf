<?php

namespace Mralston\TailPdf\Facades;

use Illuminate\Support\Facades\Facade;
use Mralston\TailPdf\Services\TailPdfService;

/**
 * @method static pdf(?string $html = null): static
 * @method static response(): \Illuminate\Http\Client\Response
 * @method static raw(): string
 * @method static stream(?string $filename = null): \Symfony\Component\HttpFoundation\StreamedResponse
 * @method static download(?string $filename = null): \Symfony\Component\HttpFoundation\StreamedResponse
 * @method static store(): static
 * @method static noStore(): static
 * @method static fonts(array $fonts = []): static
 * @method static tailwindConfig(array $config = []): static
 * @method static tailwindConfigFrom(string $path): static
 * @method static defaultTailwindConfigFile(): static
 * @method static format(\Mralston\Tailpdf\Enums\Format $format): static
 * @method static landscape(): static
 * @method static portrait(): static
 * @method static printBackground(): static
 * @method static hideBackground(): static
 * @method static scale(float $scale = 1): static
 * @method static width(?float $width = null): static
 * @method static height(?float $height = null): static
 * @method static dimensions(?float $width = null, ?float $height = null): static
 * @method static margin(?\Mralston\TailPdf\Dto\Margin $margin = null): static
 * @method static html(?string $html = null): static
 * @method static view(string $view, array $data = []): static
 * @method static timeout(int $seconds): static
 *
 * @see \Mralston\TailPdf\Services\TailPdfService
 */
class TailPdf extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TailPdfService::class;
    }
}
