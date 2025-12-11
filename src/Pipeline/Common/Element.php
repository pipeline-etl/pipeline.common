<?php

/**
 * This file contains the Element enum.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

/**
 * Enum for pipeline elements.
 */
enum Element: string
{

    /**
     * Flatteners take the raw source data as input and flatten it into a list of items.
     */
    case Flattener = 'flattener';

    /**
     * Parsers take the flattened data as input and perform larger-scale processing on
     * that set of items. Parsers aren't required to use processors or preprocessors
     * and can use any kind of logic to process the flattened data.
     */
    case Parser = 'parser';

    /**
     * Preprocessors take the flattened data as input and perform larger-scale processing
     * on that set of items. Preprocessors, contrary to processors, have a view of the
     * entire data set and as such can perform operations that work with multiple items
     * at a time.
     */
    case Preprocessor = 'preprocessor';

    /**
     * Processors take the preprocessed data as input and perform scope-limited processing on items.
     * Contrary to preprocessors they only process one item at a time.
     */
    case Processor = 'processor';

    /**
     * Ranges specify the (sub)set of data to use for comparing new with existing data in an import.
     */
    case Range = 'range';

    /**
     * Sources specify where a pipeline retrieves data from.
     */
    case Source = 'source';

    /**
     * Get the expected class string for an element.
     *
     * @param string $name Node name
     *
     * @return class-string Class string for an element
     */
    public function getClassName(string $name): string
    {
        $name = str_replace('_', ' ', $name . '_' . $this->value);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        /**
         * Help phpstan detect that $name should in fact be a valid class name.
         * @var class-string $name
         */
        return $name;
    }

    /**
     * Get the namespace identifier for an element.
     *
     * @return string Namespace identifier for an element
     */
    public function getNamespaceIdentifier(): string
    {
        return ucfirst($this->value) . 's';
    }

}

?>
