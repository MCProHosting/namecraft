<?php


namespace Mcprohosting\Namecraft;


class Namecraft
{
    public $lists = array();

    protected $modes = array('CamelCase', 'Dash', 'Underscore');

    /**
     * Adds the given array of names to the lists to choose from.
     *
     * @param array $list
     * @return self
     */
    public function addList($list)
    {
        $this->lists[] = $list;

        return $this;
    }

    /**
     * Returns all name lists, loading the defaults if none have yet been added.
     *
     * @return array
     */
    public function getLists()
    {
        if (count($this->lists)) {
            return $this->lists;
        }

        $this->loadDefaultLists();

        return $this->lists;
    }

    /**
     * Loads all default lists.
     */
    protected function loadDefaultLists()
    {
        $dir = dirname(__FILE__) . '/../../../lists';
        $files = scandir($dir);

        foreach ($files as $file) {
            if (!is_file($dir . '/' . $file)) {
                continue;
            }

            $this->addList(file($dir . '/' . $file));
        }
    }

    /**
     * Generates a name using the given format, or a random format.
     *
     * @param string $format
     * @return mixed
     */
    public function generate($format = null)
    {
        $words = array();

        foreach ($this->getLists() as $list) {
            $words[] = strtolower($list[array_rand($list)]);
        }

        $process = 'process' . ($format ?: $this->modes[array_rand($this->modes)]);

        return $this->$process($words);
    }

    /**
     * Process a list of words into camelCase.
     *
     * @param array $words
     * @return string
     */
    protected function processCamelCase($words)
    {
        $out = '';

        foreach ($words as $word) {
            $out .= ucfirst($word);
        }

        return $out;
    }

    /**
     * Process a list of words to be separated by dashes.
     *
     * @param array $words
     * @return string
     */
    protected function processDash($words)
    {
        return implode('-', $words);
    }

    /**
     * Process a list of words to be separated by undescores.
     *
     * @param array $words
     * @return string
     */
    protected function processUnderscore($words)
    {
        return implode('_', $words);
    }
} 
