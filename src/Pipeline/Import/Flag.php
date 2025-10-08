<?php

/**
 * This file contains the Import Flag enum.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

/**
 * Enum for import flags.
 */
enum Flag: string
{

    /**
     * Abort the import if the set of data to import is empty.
     * Default behavior in that case would instead be to delete all data
     * in the matching content range.
     */
    case AbortOnEmptyData = 'abort_on_empty_data';

    /**
     * Ignore a changed item where the only changed value is the time key.
     * Items where this is the case would be categorized as "skipped".
     * Default behavior here is to update also the time key in the target.
     */
    case IgnoreTimeKeyOnlyChange = 'ignore_time_key_only_change';

}

?>
