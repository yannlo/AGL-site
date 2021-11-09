<?php 


namespace YannLo\Agl\Session;

use YannLo\Agl\Session\Exceptions\NotFoundException;
use YannLo\Agl\Session\Exceptions\ContainerException;

class Session implements SessionInterface
{
    

    public function __construct(private array $sessionData){

    }

    public function has(string $id)
    {
        return array_key_exists($id, $this->sessionData);
    }

    public function get(string $id)
    {
        
        if(!$this -> has($id)){
            
            return null;
        }

        return $this -> sessionData[$id]["value"];
    }

    public function set(string $name, mixed $value, bool $locked = false): void
    {
        $this -> sessionData[$name] = [
            "value" => $value,
            "locked" => $locked
        ];
    }

    public function unset(string $name): void
    {
        if($this -> islocked($name)) {
            throw new ContainerException($name . ' is locked');
            return;
        }

        unset($this -> sessionData[$name]);
    }

    public function clear(bool $deleteAll = false): void
    {
        if($deleteAll) {
            $this -> sessionData = [];
        }

        foreach($this -> sessionData as $name => $value)
        {
            unset($value);

            if(!$this -> isLocked($name))
            {
                unset($this -> sessionData[$name]);
            }
        }
    }

    public function isLocked(string $name): bool
    {
        if(!$this -> has($name)) {
            throw new NotFoundException($name.' not exist');
        }

        return $this -> sessionData[$name]['locked'];

    }

    public function lock(string $name): void
    {
        if(!$this -> isLocked($name)) {
            $this -> sessionData[$name]['locked'] = true;
        }
    }

    public function unlock(string $name): void
    {
        if($this -> isLocked($name)) {
            $this -> sessionData[$name]['locked'] = false;
        }
    }

    public function sessionArray(): array
    {
        return $this -> sessionData;
    }
}