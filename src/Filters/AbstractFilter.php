<?php

namespace MusicBrainz\Filters;

/**
 * This is the abstract filter which
 * contains the constructor which all
 * filters share because the only
 * difference between each filter class
 * is the valid argument types.
 *
 */
abstract class AbstractFilter
{
    /**
     * @var array
     */
    protected $validArgTypes;
    /**
     * @var array
     */
    protected $validArgs = array();
    /**
     * @var array
     */
    protected $protectedArgs = array(
        'arid'
    );

    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        foreach ($args as $key => $value) {
            if (in_array($key, $this->validArgTypes)) {
                $this->validArgs[$key] = $value;
            }
        }
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function createParameters(array $params = array())
    {
        $params = $params + array('query' => '');

        if (empty($this->validArgs) || $params['query'] != '') {
            return $params;
        }

        foreach ($this->validArgs as $key => $val) {
            if ($params['query'] != '') {
                $params['query'] .= '+AND+';
            }

            if (!in_array($key, $this->protectedArgs)) {
                // Lucene escape characters
                $val = urlencode(
                    preg_replace('/([\+\-\!\(\)\{\}\[\]\^\~\*\?\:\\\\])/', '\\\\$1', $val)
                );
            }
            // If the search string contains a space, wrap it in brackets/quotes
            // This isn't always wanted, but for the searches required in this
            // library, I'm going to do it.
            if (preg_match('/[\+]/', $val)) {
                $val = '(' . $val . ')';
            }

            $params['query'] .= $key . ':' . $val;
        }

        return $params;
    }
}
