<?php 


namespace YannLo\Agl\Session;

use Psr\Container\ContainerInterface;

interface SessionInterface extends ContainerInterface {
    
    /**
     * set
     * 
     * add or set session var
     *
     * @param  string $name
     * @param  mixed $value
     * @param  bool $locked
     * @return void
     */
    public function set(string $name, mixed $value, bool $locked = false): void;
       
    /**
     * unset
     * 
     * remove session variable
     *
     * @param  string $name
     * @return void
     */
    public function unset(string $name): void;
    
    /**
     * clear
     * 
     * delete all variables in session
     * @param  bool $deleteAll
     *
     * @return void
     */
    
    public function clear(bool $deleteAll = false): void;

    
    /**
     * islocked
     * 
     * verified if session var is locked
     *
     * @param  string $name
     * @return bool
     */
    public function isLocked(string $name): bool;

    /**
     * lock
     * 
     * lock session var
     *
     * @param  string $name
     * @return void
     */
    public function lock(string $name): void;

    /**
     * unlock
     * 
     * unlock session var
     *
     * @param  string $name
     * @return void
     */
    public function unlock(string $name): void;


}