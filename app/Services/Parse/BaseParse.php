<?php


namespace App\Services\Parse;


use DiDom\Document;
use DOMDocument;

class BaseParse
{
    /**
     * @param string $source html or url
     * @return Document
     */
    public function getDocument(string $source): Document
    {
        $html = $source;

        if (filter_var($source, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            $html = $this->getHtml($source);
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML("\xEF\xBB\xBF" . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        return new Document($dom);
    }

    public function getHtml(string $url): bool|string
    {
        return file_get_contents($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $res = curl_exec($ch);

        curl_close($ch);

        return $res;
    }

    public function removeWhiteSpace(string $text, bool $all = false): string
    {
        $whiteSpaces = [
            "  ", " \t", "\t", " \r", " \n", "\n",
            "\t\t", "\t ", "\t\r", "\t\n",
            "\r\r", "\r ", "\r\t", "\r\n",
            "\n\n", "\n ", "\n\t", "\n\r"
        ];

        if ($all) {
            $whiteSpaces = array_merge($whiteSpaces, [" "]);
        }

        return str_replace($whiteSpaces, '', $text);
    }

    public function formatMonth(string $date): string
    {
        $months = [
            'январь' => 'января',
            'февраль' => 'февраля',
            'март' => 'марта',
            'апрель' => 'апреля',
            'май' => 'мая',
            'июнь' => 'июня',
            'июль' => 'июля',
            'август' => 'августа',
            'сентябрь' => 'сентября',
            'октябрь' => 'октября',
            'ноябрь' => 'ноября',
            'декабрь' => 'декабря',
        ];

        foreach ($months as $correctMonth => $month) {
            $date = str_replace($month, $correctMonth, $date);
        }

        return $date;
    }
}
