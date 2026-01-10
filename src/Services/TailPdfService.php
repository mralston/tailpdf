<?php

namespace Mralston\TailPdf\Services;

use Illuminate\Support\Facades\Http;
use Mralston\TailPdf\Dto\Margin;
use Mralston\TailPdf\Enums\Format;

use function Laravel\Prompts\error;

class TailPdfService
{
    private bool $store = true;
    private array $fonts = [];
    private array $tailwindConfig = [];
    private Format $format = Format::A4;
    private bool $landscape = false;
    private bool $printBackground = true;
    private float $scale = 1;
    private ?float $width = null;
    private ?float $height = null;
    private ?Margin $margin = null;
    private ?string $html = null;
    private int $timeout = 30;

    public function pdf(?string $html = null): string
    {
        if (empty($html) && empty($this->html)) {
            throw new \Exception('No HTML provided');
        }

        $response = Http::withHeaders([
            'X-API-Key' => config('tailpdf.api_key'),
            'X-No-Store' => $this->store ? 'false' : 'true',
        ])
            ->withUserAgent('TailPdf Laravel Package (https://packagist.org/packages/mralston/tailpdf)')
            ->timeout($this->timeout)
            ->post('https://api.tailpdf.com/pdf', [
                'content' => $html ?? $this->html,
                'fonts' => $this->fonts,
                'config' => $this->tailwindConfig,
                'pdfOptions' => [
                    'format' => $this->format->value,
                    'landscape' => $this->landscape,
                    'printBackground' => $this->printBackground,
                    'scale' => $this->scale,
                    'margin' => $this->margin?->toArray() ?? [],
                    ...$this->width ? ['width' => $this->width] : [],
                    ...$this->height ? ['height' => $this->height] : [],
                ],
            ])
            ->throw();

        return $response->body();
    }

    public function store(): static
    {
        $this->store = true;

        return $this;
    }

    public function noStore(): static
    {
        $this->store = false;

        return $this;
    }

    public function fonts(array $fonts = []): static
    {
        $this->fonts = $fonts;

        return $this;
    }

    public function tailwindConfig(array $config = []): static
    {
        $this->tailwindConfig = $config;

        return $this;
    }

    public function tailwindConfigFrom(string $path): static
    {
        $this->tailwindConfig = app(TailwindConfigService::class)
            ->parse($path);

        return $this;
    }

    public function defaultTailwindConfigFile(): static
    {
        return $this->tailwindConfigFrom(base_path('tailwind.config.js'));
    }

    public function format(Format $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function landscape(): static
    {
        $this->landscape = true;

        return $this;
    }

    public function portrait(): static
    {
        $this->landscape = false;

        return $this;
    }

    public function printBackground(): static
    {
        $this->printBackground = true;

        return $this;
    }

    public function hideBackground(): static
    {
        $this->printBackground = false;

        return $this;
    }

    public function scale(float $scale = 1): static
    {
        $this->scale = $scale;

        return $this;
    }

    public function width(?float $width = null): static
    {
        $this->width = $width;

        return $this;
    }

    public function height(?float $height = null): static
    {
        $this->height = $height;

        return $this;
    }

    public function dimensions(?float $width = null, ?float $height = null): static
    {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    public function margin(?Margin $margin = null): static
    {
        $this->margin = $margin;

        return $this;
    }

    public function html(?string $html = null): static
    {
        $this->html = $html;

        return $this;
    }

    public function view(string $view, array $data = []): static
    {
        $this->html = view($view, $data)->render();

        return $this;
    }

    public function timeout(int $seconds): static
    {
        $this->timeout = $seconds;

        return $this;
    }
}
