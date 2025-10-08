<?php

/**
 * This file contains the DataDiffCategory enum.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

/**
 * Enum for data diff categories.
 */
enum DataDiffCategory: string
{

    /**
     * Items that are in the incoming data set without equivalent in the base data of the target.
     */
    case New = 'new';

    /**
     * Items that are in the base data of the target without equivalent in the incoming data set.
     */
    case Obsolete = 'obsolete';

    /**
     * Items that are identical in the incoming data set and the base data set.
     */
    case Same = 'same';

    /**
     * Items from the incoming data set with inconsequential differences compared to the base data set.
     * For example, if the base data is considered newer than the incoming data, or the only change
     * in the incoming data is the time key.
     */
    case Skipped = 'skipped';

    /**
     * All incoming items.
     */
    case Total = 'total';

    /**
     * Items from the incoming data set with differences compared to the base data set.
     */
    case Updated = 'updated';

}

?>
