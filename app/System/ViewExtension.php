<?php
/**
 * This file contains the Charm kernel binding.
 */

namespace Neoground\Charm\Markdown\System;

use Charm\Vivid\C;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class ViewExtension
 *
 * Adding view functions to twig views and much more!
 *
 * @package App\System
 */
class ViewExtension extends AbstractExtension
{
    /**
     * Set array of all functions to add to twig
     *
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        // Get all functions in this class
        $methods = get_class_methods($this);

        // Methods to ignore (from parent)
        $ignore = [
            'getTokenParsers',
            'getNodeVisitors',
            'getFilters',
            'getTests',
            'getFunctions',
            'getOperators'
        ];

        $arr = [];

        // Build array, ignore twig methods
        foreach($methods as $method) {
            if(!in_array($method, $ignore)) {
                $arr[$method] = new TwigFunction($method, [$this, $method]);
            }
        }

        return $arr;
    }

    /**
     * Format a markdown string (or content including YAML frontmatter) to HTML
     *
     * Use it in a view as {{ markdownToHtml(markdownString) }}
     *
     * @param string $markdown the content
     *
     * @return string the HTML
     */
    public function markdownToHtml($markdown)
    {
        return C::Markdown()->toHtml($markdown);
    }

}