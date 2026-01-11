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

// Render and return raw PDF content
$pdf = TailPdf::defaultTailwindConfigFile() // load tailwind.config.js
    ->html('<h1>Test</h1>') // supply HTML directly
    ->pdf() // render PDF
    ->raw(); // fetch raw PDF
    
// Return a streamed PDF response to the browser
return TailPdf::defaultTailwindConfigFile()
    ->html('<h1>Test</h1>')
    ->pdf()
    ->stream(); // stream can be returned from Laravel controller
    
// Return a streamed PDF download
return TailPdf::defaultTailwindConfigFile()
    ->html('<h1>Test</h1>')
    ->pdf()
    ->download('test.pdf');

// Save a PDF to disk
TailPdf::defaultTailwindConfigFile()
    ->html('<h1>Test</h1>')
    ->pdf()
    ->save('test.pdf');

// Render PDF from Laravel view
TailPdf::defaultTailwindConfigFile()
    ->view('my-view', [
        'var' => 'value',
    ])
    ->pdf()
    ->save('test.pdf');

// Render PDF asyncronously and upload to bucket (see https://tailpdf.com/docs/async-jobs/)
TailPdf::defaultTailwindConfigFile()
    ->html('<h1>Test</h1>')
    ->async(
        $bucketUrl, // Writeable bucket URL from AWS S3 / Cloudflare R2 / GCP Cloud Storage API
        $webhookUrl // URL where you receive status updates
    )
    ->pdf();

$status = TailPdf::pollStatus(); // Check status manually
```

## Security Vulnerabilities

Please [e-mail security vulnerabilities directly to me](mailto:matt@mralston.co.uk).

## TailPDF Service

This package requires a TailPDF account. Please visit https://tailpdf.com/

The TailPDF service is copyright to Warm Energy Labs Limited.
This package is not affiliated with Warm Energy Labs Limited.

## Licence

PDF is open-sourced software licenced under the [MIT license](LICENSE.md).
