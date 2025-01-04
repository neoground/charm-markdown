# A Galactic Markdown Module for Charm Framework 3.1+

Welcome to the charm-markdown module, a remarkable addition to the 
[Charm Framework](https://github.com/neoground/charm) galaxy,
designed to provide seamless integration of Markdown and YAML frontmatter functions. 
Whether you're a Markdown padawan or a seasoned YAML-Frontmatter Jedi, this module is the
perfect companion for your Charm framework journey.

Harness the power of Charm's built-in [Symfony/Yaml](https://symfony.com/doc/current/components/yaml.html)
package and [Parsedown](https://github.com/erusev/parsedown) + [Parsedown-Extra](https://github.com/erusev/parsedown-extra) 
for HTML creation, bringing balance to the Markdown Force in your application.

## Installation

Begin your quest by adding charm-markdown to your project via Composer:

```bash
composer require neoground/charm-markdown
```

Next, install charm-markdown in your application:

```bash
bob cm:i neoground/charm-markdown
```

## Usage

Awaken the charm-markdown Force by initializing it with a file or a string:

```php
$filepath = C::Storage()->getDataPath() . DS . 'demo.md';
$doc = C::Markdown()->fromFile($filepath);
```

or

```php
$doc = C::Markdown()->fromString('# Hello World');
```

Unlock the secrets of the Markdown galaxy by accessing:

- `$doc->getMarkdownContent();` to obtain the Markdown content part of the document
- `$doc->getYaml();` to retrieve the YAML frontmatter data as an array (or an empty array if not set)
- `$doc->getHtml();` to generate the HTML content, with Markdown Extra support and "id" tags added to each heading for
  easy anchoring
- `$doc->getContentsList()` to get an array of all headings as an easy table of contents

Experience the power of charm-markdown with direct access:

This returns an array with keys `yaml` (array) and `markdown` (string), containing each part of the document:

```php
$arr = C::Markdown()->separateMarkdownFromYaml($content);

```

Extract the YAML array directly from the content string as an array:

```php
C::Markdown()->getYaml($content);
```

Obtain the Markdown part directly from the content string as a string:

```php
C::Markdown()->getMarkdownContent($content);
```

Format the Markdown part of the content string as HTML:

```php
C::Markdown()->toHtml($content);
```

## Usage in Views

In Twig views you can output a markdown string directly as HTML with:

```twig
<div id="content">{{ markdownToHtml(markdownString)|raw }}</div>
```

---

Embrace the charm-markdown Force and embark on an epic adventure of Markdown and YAML mastery in your Charm Framework
application. May the Markdown be with you!
