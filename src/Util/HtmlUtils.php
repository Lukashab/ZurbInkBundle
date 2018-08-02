<?php

/*
 * This file is part of the zurb-ink-bundle package.
 *
 * (c) Marco Polichetti <gremo1982@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gremo\ZurbInkBundle\Util;

use Pinky;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class HtmlUtils
{
    private $cssToInlineStyles;

    public function __construct(CssToInlineStyles $cssToInlineStyles)
    {
        $this->cssToInlineStyles = $cssToInlineStyles;
    }

    /**
     * @param string $html
     * @param string|array $css
     * @return string
     */
    public function inlineCss($html, $css)
    {
        if (is_array($css)) {
            $css = implode(PHP_EOL, $css);
        }

        if (method_exists($this->cssToInlineStyles, 'setHTML')) {
            $this->cssToInlineStyles->setHTML($html);
            $this->cssToInlineStyles->setCSS($css);

            $contents = $this->cssToInlineStyles->convert();

            // Reset CSS (in order to clean the parsed CSS rules)
            $this->cssToInlineStyles->setCSS(null);
        } else {
            $contents = $this->cssToInlineStyles->convert($html, $css);
        }

        return $contents;
    }

    /**
     * @param string $content
     * @return string
     */
    public function parseInky($content)
    {
        return Pinky\transformString($content)->saveHTML();
    }
}
