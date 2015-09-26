<?php

namespace Kenarkose\Sortable;


use Illuminate\Http\Request;

class Supporter {

    /**
     * Key and direction parameter names in the request
     *
     * @var string
     */
    const keyName = 's';
    const directionName = 'd';

    /**
     * Cache for current key and direction
     *
     * @var string
     */
    protected $currentDirection;
    protected $currentKey;

    /**
     * The current request
     *
     * @var Request
     */
    protected $request;

    /**
     * Constructor
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Link generator
     *
     * @param string $key
     * @param string $content
     * @param string|null $title
     * @return string
     */
    public function generateLinkFor($key, $content, $title = null)
    {
        $active = ($key === $this->getCurrentKey()) ? 'active' : '';

        $direction = $linkDirection = 'asc';

        if ($key === $this->getCurrentKey())
        {
            $direction = ($this->getCurrentDirection() === 'asc') ? 'desc' : 'asc';
            $linkDirection = ($this->getCurrentDirection() === 'desc') ? 'desc' : 'asc';
        }

        $params = array_merge(
            $this->getQueryParams(),
            [
                's' => $key,
                'd' => $direction
            ]
        );

        $url = qs_url(
            $this->getCurrentRequestPath(),
            $params
        );

        return sprintf(
            '<a title="%s" class="%s %s" href="%s">%s</a>',
            $title,
            $linkDirection,
            $active,
            $url,
            $content
        );
    }

    /**
     * Returns query string params for link generations
     *
     * @return string
     */
    protected function getQueryParams()
    {
        $queryParams = $this->request->query();

        unset(
            $queryParams['s'],
            $queryParams['d'],
            $queryParams['page']
        );

        return $queryParams;
    }

    /**
     * Sets the sortable params
     *
     * @param string $key
     * @param string $direction
     */
    public function setParams($key, $direction)
    {
        $this->currentKey = $key;
        $this->currentDirection = $direction;
    }

    /**
     * Gets the current direction
     *
     * @return string
     */
    public function getCurrentDirection()
    {
        return $this->currentDirection;
    }

    /**
     * Gets the current key
     *
     * @return string
     */
    public function getCurrentKey()
    {
        return $this->currentKey;
    }

    /**
     * Gets the current request
     *
     * @return string
     */
    public function getCurrentRequestPath()
    {
        return $this->request->path();
    }

}