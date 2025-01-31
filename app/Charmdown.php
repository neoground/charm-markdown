<?php
/**
 * This file contains the Charmdown class
 */

namespace Neoground\Charm\Markdown;

use Charm\Vivid\C;

/**
 * Class Charmdown
 *
 * A ParsedownExtra class with support for custom stuff, like toc
 *
 * @package Charm\Vivid\Helper
 */
class Charmdown extends \ParsedownExtra
{
    /** @var array storage of all headings */
    protected array $contentsListArray = [];

    /**
     * The constructor
     *
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Heading process
     *
     * Creates heading block element and stores to the ToC list. It overrides
     * the parent method: \Parsedown::blockHeader() and returns $Block array if
     * the $Line is a heading element.
     *
     * @param array $Line Array that Parsedown detected as a block type element.
     *
     * @return void|array   Array of Heading Block.
     */
    protected function blockHeader($Line)
    {
        // Use parent blockHeader method to process the $Line to $Block
        $Block = parent::blockHeader($Line);

        if (!empty($Block)) {
            // Get the text of the heading
            if (isset($Block['element']['handler']['argument'])) {
                // Compatibility with old Parsedown Version
                $text = $Block['element']['handler']['argument'];
            }
            if (isset($Block['element']['text'])) {
                // Current Parsedown
                $text = $Block['element']['text'];
            }

            // Get the heading level. Levels are h1, h2, ..., h6
            $level = $Block['element']['name'];

            // Get the anchor of the heading to link from the ToC list
            $id = $Block['element']['attributes']['id'] ?? $this->createAnchorID($text);

            // To prevent JS / CSS3 errors when an id starts numeric, we'll prepend "no" in those cases
            if(is_numeric($id[0])) {
                $id = "no" . $id;
            }

            // Set attributes to head tags
            $Block['element']['attributes'] = [
                'id' => $id,
                'name' => $id,
            ];

            // Add/stores the heading element info to the ToC list
            $this->setContentsList([
                'text' => $text,
                'id' => $id,
                'level' => $level,
            ]);

            return $Block;
        }
    }

    /**
     * Get the ToC
     *
     * @return array
     */
    public function getContentsList()
    {
        return $this->contentsListArray;
    }

    /**
     * Create unique anchor ID for element
     *
     * @param string $text
     *
     * @return string
     */
    protected function createAnchorID($text)
    {
        return C::Formatter()->slugify($text);
    }

    /**
     * Set/stores the heading block to ToC list in a string and array format.
     *
     * @param array $Content Heading info such as "level","id" and "text".
     *
     * @return void
     */
    protected function setContentsList(array $Content)
    {
        // Stores as an array
        $this->contentsListArray[] = $Content;
    }


}