# TailPdf

## Introduction

Laravel friendly wrapper for TailPDF. This package renders PDF files from HTML or Blade views and Tailwind CSS using the tailpdf.com service. 

## Installation

```bash
composer require mralston/tailpdf
```

## Configuration

Register an account at https://tailpdf.com/ and generate an API key. Past this into your .env file.

```dotenv
TAILPDF_API_KEY=YOUR KEY HERE
```

## Usage

Use the TailPdf facade to render your PDF.

```php
<?php

$pdf = TailPdf::defaultTailwindConfigFile()
    ->html('<h1>Test</h1>')
    ->pdf();

file_put_contents('test.pdf', $pdf);
```

## Security Vulnerabilities

Please [e-mail security vulnerabilities directly to me](mailto:matt@mralston.co.uk).

## Licence

PDF is open-sourced software licenced under the [MIT license](LICENSE.md).
