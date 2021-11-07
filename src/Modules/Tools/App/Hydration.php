<?php

namespace YannLo\Agl\Modules\Tools\App;

/**
 * Hydration
 *
 * content all hydrate function
 */

trait Hydration
{

    /**
     * hydrate
     *
     * used to hydrate object
     *
     * @param  array $data
     * @return void
     */
    private function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this -> $method($value);
            }
        }
    }
}
