<?php

if ( ! function_exists('sortable_link'))
{
    /**
     * Generates the sortable link
     *
     * @param string $key
     * @param string $content
     * @param string|null $title
     * @return string
     */
    function sortable_link($key, $content, $title = null)
    {
        return app('sortable.supporter')->generateLinkFor($key, $content, $title);
    }
}


if ( ! function_exists('qs_url'))
{
    /**
     * Generate a query string url for the application.
     *
     * Assumes that you want a URL with a query string rather than route params
     * (which is what the default url() helper does)
     * @link http://stackoverflow.com/questions/21632835/laravel-route-url-with-query-string
     *
     * @param  string $path
     * @param  mixed $qs
     * @param  bool $secure
     * @return string
     */
    function qs_url($path = null, $qs = [], $secure = null)
    {
        $url = app('url')->to($path, $secure);

        if (count($qs))
        {
            foreach ($qs as $key => $value)
            {
                $qs[$key] = sprintf('%s=%s', $key, urlencode($value));
            }

            $url = sprintf('%s?%s', $url, implode('&', $qs));
        }

        return $url;
    }

}