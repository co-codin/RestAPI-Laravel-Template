<?php


namespace App\Helpers;


use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

class ExceptionHelper
{
    #[ArrayShape(['css' => "string", 'content' => "string"])]
    public static function toHtml(\Throwable $exception): array
    {
        $e = FlattenException::createFromThrowable($exception);
        $handler = new HtmlErrorRenderer(true); // boolean, true raises debug flag...
        $css = $handler->getStylesheet();
        $content = $handler->getBody($e);

        return [
            'css' => $css,
            'content' => $content,
        ];
    }
}
