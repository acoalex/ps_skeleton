<?php
/**
 * NOTICE OF LICENSE
 *
 * @author    veiss, Alex www.veiss.eu <alex@veiss.com>
 * @copyright Copyright (c) permanent, veiss, UAB
 * @license   MIT
 * @see       /LICENSE
 *
 *  International Registered Trademark & Property of veiss, UAB
 */

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header("Location: ../");
exit;
