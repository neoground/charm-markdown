<?php
/**
 * This file contains the MarkdownDocument class.
 */

namespace Neoground\Charm\Markdown;

use Charm\Vivid\C;
use Symfony\Component\Yaml\Yaml;

/**
 * Class MarkdownDocument
 *
 * Features for a single Markdown document,
 * which can also contain YAML frontmatter.
 */
class MarkdownDocument
{
    protected array $frontmatter;
    protected string $content;
    protected array $toc;

    public function __construct(string $content)
    {
        $arr = $this->separateMarkdownFromYaml($content);
        $this->content = $arr['markdown'];

        if($arr['yaml'] != '') {
            $this->frontmatter = Yaml::parse($arr['yaml']);
        }
    }

    public function getMarkdownContent() : string
    {
        return $this->content;
    }

    public function getYaml() : array
    {
        return $this->frontmatter;
    }

    /**
     * Split markdown content with optional frontmatter into each part
     *
     * @param string $markdown
     *
     * @return array with keys: yaml, markdown
     */
    private function separateMarkdownFromYaml(string $markdown): array {
        $yaml = '';
        $markdownContent = $markdown;
        if (str_starts_with($markdown, '---')) {
            // YAML section is surrounded by "---" and present
            $delimiterPos = strpos($markdown, '---', 3);
            if ($delimiterPos !== false) {
                $yaml = substr($markdown, 0, $delimiterPos + 3);
                $markdownContent = trim(substr($markdown, $delimiterPos + 3));
            }
        }

        return [
            'yaml' => str_replace("---", "", $yaml),
            'markdown' => $markdownContent,
        ];
    }

    public function getHtml() : string
    {
        $pd = new Charmdown();
        $pd->setUrlsLinked(false);

        $html = $this->formatHtml($pd->text($this->content));
        $this->toc = $pd->getContentsList();
        return $html;
    }

    public function getContentsList() : array
    {
        if(empty($this->toc)) {
            $pd = new Charmdown();
            $pd->text($this->content);
            $this->toc = $pd->getContentsList();
        }

        return $this->toc;
    }

    private function formatHtml(string $html): string {
        // Replace encoded entities inside code blocks with real characters
        return preg_replace_callback(
            '/<code[^>]*>.*?<\/code>(*SKIP)(*FAIL)|&(?:[a-zA-Z0-9]+|#\d+|#x[a-fA-F0-9]+);/',
            fn($match) => html_entity_decode($match[0], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            str_replace("&amp;", "&", $html)
        );
    }

}