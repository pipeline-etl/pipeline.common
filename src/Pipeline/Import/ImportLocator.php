<?php

/**
 * This file contains a locator for pipeline elements.
 *
 * SPDX-FileCopyrightText: Copyright 2026 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

use Pipeline\Common\Element;
use Pipeline\Common\FlattenerInterface;
use Pipeline\Common\Locator;
use Pipeline\Common\Node;
use Pipeline\Common\Parser;
use Pipeline\Common\PreprocessorInterface;
use Pipeline\Common\ProcessorInterface;
use Pipeline\Common\SourceInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Locator class.
 */
class ImportLocator extends Locator
{

    /**
     * Constructor.
     *
     * @param ContainerInterface $locator Locator to load classes
     * @param LoggerInterface    $logger  Shared instance of a logger
     */
    public function __construct(ContainerInterface $locator, LoggerInterface $logger)
    {
        parent::__construct($locator, $logger);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Get an instance of a pipeline node.
     *
     * @param string  $name    Identifier for the node
     * @param Element $element Element of the node
     *
     * @return (
     *    $element is Element::Flattener ? (FlattenerInterface&Node)|null :
     *    $element is Element::Parser ? Parser|null :
     *    $element is Element::Preprocessor ? (PreprocessorInterface&Node)|null :
     *    $element is Element::Processor ? (ProcessorInterface&Node)|null :
     *    $element is Element::Range ? (ContentRangeInterface&Node)|null :
     *    $element is Element::Source ? (SourceInterface&Node)|null :
     *    Node|null
     * ) Instance of a class
     */
    protected function getInstance(string $name, Element $element): ?Node
    {
        return parent::getInstance($name, $element);
    }

    /**
     * Get an instance of a ContentRange class.
     *
     * @param string $name Short identifier of the class
     *
     * @return (ContentRangeInterface&Node)|null Instance of a ContentRange class
     */
    public function getContentRange(string $name): (ContentRangeInterface&Node)|null
    {
        return $this->getInstance($name, Element::Range);
    }

}

?>
