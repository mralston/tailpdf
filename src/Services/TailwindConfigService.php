<?php

namespace Mralston\TailPdf\Services;

class TailwindConfigService
{
    public function parse(string $path): array
    {
        $content = file_get_contents($path);

        // Strip multi-line comments
        $content = preg_replace('!/\*.*?\*/!s', '', $content);

        // Strip single-line comments (but not inside strings)
        // A simple way is to match lines and remove everything after // if it's not in a string
        // But for simplicity, let's just use a better regex or do it line by line
        $lines = explode("\n", $content);
        foreach ($lines as &$line) {
            // Remove everything after // if it's not preceded by : (e.g. http://)
            // This is still naive but better than before.
            // Actually, tailwind config usually doesn't have URLs with // unless in content paths.
            // Let's try to only remove // if it has a space before it or is at the start of the line.
            $line = preg_replace('/^\s*\/\/.*$/', '', $line);
            $line = preg_replace('/\s+\/\/.*$/', '', $line);
        }
        $content = implode("\n", $lines);

        // Strip imports
        $content = preg_replace('/import\s+.*?\s+from\s+[\'"].*?[\'"];/', '', $content);

        // Extract the default export object
        if (preg_match('/export\s+default\s+({.*});/s', $content, $matches)) {
            $configStr = $matches[1];

            // Remove JS-specific parts that will break parsing
            // Spread operators
            $configStr = preg_replace('/,\s*\.\.\..*?(?=[,\]\}])/', '', $configStr);
            $configStr = preg_replace('/\.\.\..*?(?=[,\]\}])/', '', $configStr);

            // Variable references in arrays (like plugins: [forms, typography])
            $configStr = preg_replace('/plugins:\s*\[.*?\]/s', '"plugins": []', $configStr);

            // Convert JS object to JSON-ish

            // 1. Handle single quotes for strings first, but avoid double quoting
            // Change 'foo' to "foo"
            $configStr = preg_replace("/'([^']*)'/", '"$1"', $configStr);

            // 2. Quote unquoted keys (handle optional space before colon)
            // Match words that are not already quoted and are followed by a colon
            $configStr = preg_replace('/(?<=[{\s,])(\w+)\s*:/', '"$1":', $configStr);

            // 3. Remove trailing commas before closing braces/brackets
            $configStr = preg_replace('/,\s*([\]\}])/', '$1', $configStr);

            // 4. Clean up any double-double quotes that might have been created
            $configStr = str_replace('""', '"', $configStr);

            $decoded = json_decode($configStr, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }

            throw new \Exception('Failed to parse tailwind config: '.json_last_error_msg()."\n".$configStr);
        }
    }
}
