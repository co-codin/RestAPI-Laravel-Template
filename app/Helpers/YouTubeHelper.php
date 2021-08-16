<?php


namespace App\Helpers;


class YouTubeHelper
{
    /**
     * @param string $text
     * @return string
     */
    public static function filter(string $text): string
    {
        if (str_contains($text, '[youtube')) {
            $text = preg_replace_callback("#\\[youtube(.+?)\\]#i", function ($matches = []) {
                if (!count($matches)) return "";

                $param_str = trim($matches[1]);
                if (!preg_match("#url=['\"](.+?)['\"]#i", $param_str, $_match)) {
                    return "";
                }

                $url = trim($_match[1]);
                $code = self::getYoutubeCode($url);

                if (!$code) {
                    return "";
                }

                $aspectRatio = '16by9';

                if (preg_match("#aspectRatio=['\"](.+?)['\"]#i", $param_str, $_match)) {
                    $aspectRatio = str_replace('/', 'by', $_match[1]);
                }

                return '<div class="embed-responsive embed-responsive-' . $aspectRatio . '"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $code . '"></iframe></div>';

            }, $text);
        }

        return $text;
    }

    /**
     * @param string $url
     * @return false|mixed
     */
    protected static function getYoutubeCode(string $url): mixed
    {
        if (preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches)) {
            return $matches[1];
        }

        return false;
    }
}
