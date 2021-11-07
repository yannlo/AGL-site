<?php

namespace YannLo\Agl\Modules\Tools\Action;

/**
 * ExtractPageTrait
 *
 * used to get page name
 */
trait ExtractPageTrait
{

    /**
     * extractRouteName
     *
     * get page name with router name
     *
     * @param  string $name
     * @return string
     */
    private function extractRouteName(string $name): string
    {
        return substr($name, strpos($name, ".") + 1, strlen($name));
    }
}
