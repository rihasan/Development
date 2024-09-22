<?php

namespace App\Helpers\Routes;


/**
 * Directory Iterator helper class
 */
class RouteHelper
{
    
    public static function includeRoutesFiles(string $folder)
    {
        // Iterate through api folder recursively

        /*
        * @var \RecursiveDirectoryIterator | \RecursiveIteratorIterator $it
        */ 

        $dirIterator = new \RecursiveDirectoryIterator($folder);
        $it = new \RecursiveIteratorIterator($dirIterator);

        // Require the file in each iterator

        while ($it->valid()) {
            if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                require $it->key();
                require $it->current()->getPathname();
            }
            $it->next();
        }

    }
}
