<?php

/**
 * Useful functions.
 */

namespace Company\SmallProject;

function captureOutput($string)
{
    \ob_start();
    print $string;
    return \ob_get_clean();
}
