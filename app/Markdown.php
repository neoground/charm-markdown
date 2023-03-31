<?php
/**
 * This file contains the Charm kernel binding.
 */

namespace Neoground\Charm\Markdown;

use Charm\Vivid\Kernel\EngineManager;
use Charm\Vivid\Kernel\Interfaces\ModuleInterface;

/**
 * Class Markdown
 *
 * Charm kernel binding
 */
class Markdown extends EngineManager implements ModuleInterface
{
    /**
     * Load the module
     */
    public function loadModule()
    {
        // Nothing to do yet.
    }

    public function fromFile(string $path)
    {
        return new MarkdownDocument(file_get_contents($path));
    }

    public function fromString(string $str)
    {
        return new MarkdownDocument($str);
    }

    public function separateMarkdownFromYaml(string $content)
    {
        $md = $this->fromString($content);

        return [
            'yaml' => $md->getYaml(),
            'markdown' => $md->getMarkdownContent()
        ];
    }

    public function getYaml(string $content)
    {
        return $this->separateMarkdownFromYaml($content)['yaml'];
    }

    public function getMarkdownContent(string $content)
    {
        return $this->separateMarkdownFromYaml($content)['markdown'];
    }

    public function toHtml(string $content)
    {
        return $this->fromString($content)->getHtml();
    }

}