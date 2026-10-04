<?php

namespace App;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class FaqFullAnswerSanitizer
{
    private HtmlSanitizer $sanitizer;

    public function __construct()
    {
        $config = (new HtmlSanitizerConfig)
            ->allowElement('p')
            ->allowElement('strong')
            ->allowElement('b')
            ->allowElement('em')
            ->allowElement('i')
            ->allowElement('ul')
            ->allowElement('ol')
            ->allowElement('li')
            ->allowElement('br')
            ->allowElement('a', ['href'])
            ->blockElement('div')
            ->blockElement('span')
            ->allowLinkSchemes(['http', 'https', 'tel'])
            ->withMaxInputLength(200_000);

        $this->sanitizer = new HtmlSanitizer($config);
    }

    public function sanitize(?string $html): ?string
    {
        if ($html === null || trim($html) === '') {
            return null;
        }

        $sanitized = trim($this->sanitizer->sanitize(mb_substr($html, 0, 50_000)));

        $plainText = html_entity_decode(strip_tags($sanitized), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (preg_replace('/[\s\x{00A0}\x{200B}\x{FEFF}]+/u', '', $plainText) === '') {
            return null;
        }

        return $sanitized;
    }
}
