<?php

if (!function_exists('terraWaLink')) {
    /**
     * Build a WhatsApp click-to-chat link with a prefilled inquiry message.
     */
    function terraWaLink(string $number, string $title, string $url): string
    {
        $message = "Hi, I'm interested in \"{$title}\" ({$url}). Could you share more details?";
        return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
    }
}

if (!function_exists('terraWaNumber')) {
    function terraWaNumber(): string
    {
        return '250796511725';
    }
}