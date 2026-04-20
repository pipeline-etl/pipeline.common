<?php

/**
 * This file contains a locator for pipeline elements.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

use Lunr\Ticks\Profiling\Profiler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Locator class.
 */
class Locator
{

    /**
     * Shared instance of the ServiceLocator class.
     * @var ContainerInterface
     */
    protected readonly ContainerInterface $locator;

    /**
     * Shared instance of the Logger class.
     * @var LoggerInterface
     */
    protected readonly LoggerInterface $logger;

    /**
     * Object keeping track of the pipeline run.
     * @var Profiler
     */
    protected readonly Profiler $profiler;

    /**
     * List of Namespaces that are searched for Sources/Flatteners/Preprocessors/Processors
     * @var string[]
     */
    protected array $namespaces;

    /**
     * Local cache of instantiated objects not coming from the Locator.
     * @var array<string, Node>
     */
    protected array $objectCache;

    /**
     * Constructor.
     *
     * @param ContainerInterface $locator Locator to load classes
     * @param LoggerInterface    $logger  Shared instance of a logger
     */
    public function __construct(ContainerInterface $locator, LoggerInterface $logger)
    {
        $this->locator = $locator;
        $this->logger  = $logger;

        $this->namespaces  = [];
        $this->objectCache = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->namespaces  = [];
        $this->objectCache = [];
    }

    /**
     * Set a profiler.
     *
     * @param Profiler $profiler Object keeping track of the pipeline run.
     *
     * @return void
     */
    public function setProfiler(Profiler $profiler): void
    {
        if (isset($this->profiler))
        {
            return;
        }

        $this->profiler = $profiler;
    }

    /**
     * Add an additional namespace to the component lookup path.
     *
     * Namespaces are walked in a LIFO fashion, so later registered
     * namespaces have priority over earlier registered ones. This
     * is to allow overriding components from the original namespace
     * within the application/library namespace.
     *
     * @param string $namespace Namespace name
     *
     * @return void
     */
    public function registerNamespace(string $namespace): void
    {
        array_unshift($this->namespaces, $namespace);
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
     *    $element is Element::Source ? (SourceInterface&Node)|null :
     *    Node|null
     * ) Instance of a class
     */
    protected function getInstance(string $name, Element $element): ?Node
    {
        $name       = $element->getClassName($name);
        $identifier = strtolower($name);

        if ($this->locator->has($identifier) === TRUE)
        {
            $object = $this->locator->get($identifier);

            return $object instanceof Node ? $object : NULL;
        }

        if (isset($this->objectCache[$identifier]))
        {
            return $this->objectCache[$identifier];
        }

        foreach ($this->namespaces as &$namespace)
        {
            $fqcn = "{$namespace}\\{$element->getNamespaceIdentifier()}\\{$name}";

            $exists = class_exists($fqcn, TRUE);

            if (!$exists)
            {
                continue;
            }

            if (is_subclass_of($fqcn, Parser::class))
            {
                $class = new $fqcn($this->logger, $this->profiler);
            }
            else
            {
                $class = new $fqcn($this->logger);
            }

            if (!($class instanceof Node))
            {
                return NULL;
            }

            $this->objectCache[$identifier] = $class;

            return $class;
        }

        unset($namespace);

        $this->logger->warning('Unable to find pipeline component: ({name})', [ 'name' => $name ]);
        return NULL;
    }

    /**
     * Get a shared instance of the logger.
     *
     * @return LoggerInterface Shared instance of a Logger
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Get an instance of a Source class.
     *
     * @param string $name Short identifier of the class
     *
     * @return (SourceInterface&Node)|null Instance of a Source class
     */
    public function getSource(string $name): (SourceInterface&Node)|null
    {
        return $this->getInstance($name, Element::Source);
    }

    /**
     * Get an instance of a Preprocessor class.
     *
     * @param string $name Short identifier of the class
     *
     * @return (PreprocessorInterface&Node)|null Instance of a Preprocessor class
     */
    public function getPreprocessor(string $name): (PreprocessorInterface&Node)|null
    {
        return $this->getInstance($name, Element::Preprocessor);
    }

    /**
     * Get an instance of a Processor class.
     *
     * @param string $name Short identifier of the class
     *
     * @return (ProcessorInterface&Node)|null Instance of a Processor class
     */
    public function getProcessor(string $name): (ProcessorInterface&Node)|null
    {
        return $this->getInstance($name, Element::Processor);
    }

    /**
     * Get an instance of a Flattener class.
     *
     * @param string $name Short identifier of the class
     *
     * @return (FlattenerInterface&Node)|null Instance of a Flattener class
     */
    public function getFlattener(string $name): (FlattenerInterface&Node)|null
    {
        return $this->getInstance($name, Element::Flattener);
    }

    /**
     * Get an instance of a Parser class.
     *
     * @param string $name Short identifier of the class
     *
     * @return Parser|null Instance of a Parser class
     */
    public function getParser(string $name): ?Parser
    {
        return $this->getInstance($name, Element::Parser);
    }

}

?>
