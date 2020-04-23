<?php
/**
 * @package Console
 * 
 * @author Sergey Iontsev
 * @version 1.0
 * @copyright © 2017 Sergey Iontsev. All rights reserved.
 * @license MIT License. See LICENSE file for details.
 */

namespace Console;

/**
 * Console class
 * 
 * @package Console
 */
class Console
{
    private $context = [];
    private $content = [];

    /**
     * Constructor
     * 
     * @param string $small optional
     * @param string $large optional
     * @param bool $value optional
     */
    public function __construct(string $small = null, string $large = null, bool $value = null)
    {
        if (empty($small) === false or empty($large) === false) {
            $this->create($small, $large, $value);
        }
    }

    /**
     * Create
     * 
     * Creating the option to observe for the command-line argument list.
     * @param string $small optional
     * @param string $large optional
     * @param bool $value optional
     * @return self
     */
    public function create(string $small = null, string $large = null, bool $value = null)
    {
        if (empty($small) === true and empty($large) === true) {
            throw new \Exception("Parameter value was not correct!");
        }

        if (strlen($small) > 1) {
            throw new \Exception("Parameter value was not correct!");
        }

        if (empty($small) === false and in_array($small, array_column($this->context, "small"), true) === true) {
            throw new \Exception("Parameter value was not correct!");
        }

        if (empty($large) === false and in_array($large, array_column($this->context, "large"), true) === true) {
            throw new \Exception("Parameter value was not correct!");
        }

        $value = ($value === false) ? "" : $value;
        $value = (is_null($value) == true) ? ":" : $value;
        $value = ($value === true) ? "::" : $value;

        $this->context[] = [
            "small" => $small,
            "large" => $large,
            "value" => $value
        ];

        return $this;
    }

    /**
     * Update
     * 
     * Updating the received value of the command-line option.
     * @param string $small optional
     * @param string $large optional
     * @param bool $value optional
     * @return self
     */
    public function update(string $small = null, string $large = null, bool $value = null)
    {
        if (strlen($small) > 1) {
            throw new \Exception("Parameter value was not correct!");
        }

        if (empty($small) === false and in_array($small, array_column($this->context, "small"), true) === false) {
            if (empty($large) === false and in_array($large, array_column($this->context, "large"), true) === false) {
                foreach ($this->context as $feature) {
                    if ($feature[$small] === $small and $feature[$large] !== $large) {
                        throw new \Exception("Parameter value was not correct!");
                    }

                    if ($feature[$large] === $large and $feature[$small] !== $small) {
                        throw new \Exception("Parameter value was not correct!");
                    }
                }
            }
        }

        $value = ($value === false) ? "" : $value;
        $value = (is_null($value) == true) ? ":" : $value;
        $value = ($value === true) ? ":" : $value;

        foreach ($this->context as $feature) {
            if ($feature["small"] === $small or $feature["large"] === $large)
            {
                $feature["small"] = (empty($small) === false) ? $small : $feature["small"];
                $feature["large"] = (empty($large) === false) ? $large : $feature["large"];
                $feature["value"] = $value;
            }
        }

        return $this;
    }

    /**
     * Delete
     * 
     * Deleting the command-line option.
     * @param string $element
     *  @return self
     */
    public function delete(string $element)
    {
        foreach ($this->context as $feature) {
            $feature["small"] = ($feature["small"] === $element) ? null : $feature["small"];
            $feature["large"] = ($feature["large"] === $element) ? null : $feature["large"];
        }

        return $this;
    }

    /**
     * Select
     * 
     * Selecting the command-line option values passed to the script.
     * @param string $element optional
     * @return array|string
     */
    public function select(string $element = null)
    {
        $this->content = getopt(
            array_reduce(
                $this->context,
                function ($data, $meta)
                {
                    $data = $data . $meta["small"] . $meta["value"];
                    return $data;
                },
                ""
            ),
            array_reduce(
                $this->context,
                function ($data, $meta)
                {
                    $data[] = $meta["large"] . $meta["value"];
                    return $data;
                },
                array()
            )
        );

        if ($this->content === false) {
            $this->content = [];
            throw new \Exception("Could not get command-line options!");
        }

        foreach ($this->context as $feature) {
            $small = $feature["small"];
            $large = $feature["large"];

            if (empty($small) === false and empty($large) === false) {
                if (array_key_exists($small, $this->content) === true and array_key_exists($large, $this->content) === true and $this->content[$small] !== $this->content[$large]) {
                    throw new \Exception("Cmmand-line options was not correct!");
                }

                if (array_key_exists($small, $this->content) === false and array_key_exists($large, $this->content) === true) {
                    $this->content[$small] = $this->content[$large];
                }

                if (array_key_exists($small, $this->content) === true and array_key_exists($large, $this->content) === false) {
                    $this->content[$large] = $this->content[$small];
                }
            }
        }

        if (empty($element) === false) {
            if (isset($this->content[$element]) === false) {
                throw new \Exception("Element \"{$element}\" not found!");
            } else {
                return $this->content[$element];
            }
        } else {
            return $this->content;
        }
    }

    /**
     * Set
     * 
     * Setting the command-line option value in the selected data.
     * @param string $element
     * @param string $content
     * @return self
     */
    public function set(string $element, string $content)
    {
        $this->content[$element] = $content;

        return $this;
    }

    /**
     * Has
     * 
     * Checking the command-line to enable the option with the given name.
     * @param string $element
     * @return bool
     */
    public function has(string $element)
    {
        return array_key_exists($element, $this->content);
    }

    /**
     * Get
     * 
     * Getting the command-line option value from the selected data.
     * @param string $element
     * @return string
     */
    public function get(string $element)
    {
        if (array_key_exists($element, $this->content) === false) {
            throw new \Exception("Element \"{$element}\" not found!");
        }
        else {
            return $this->content[$element];
        }
    }
}
