<?php


namespace YannLo\Agl\Modules\Tools\Action;

use YannLo\Agl\Session\SessionInterface;
use YannLo\Agl\Modules\Tools\App\Account;

trait ConnectionTrait
{
        /**
     * createConnection
     * 
     * @param  Account $user
     * @param  SessionInterface $session
     * @param  string $idName
     * @return void
     */
    private function createConnection(Account $account, SessionInterface $session, string $idName): void
    {
        $session->set("connect",[
                "type" => $account::class,
                "id" => $account->$idName()
            ],
            true
        );

    }
    
    /**
     * verifiedConnection
     *
     * @param  Acccount $account
     * @param  SessionInterface $session
     * @return void
     */
    private function verifiedConnection(string $type, SessionInterface $session): bool
    {
        if($session -> has("connect"))
        {
            $connection = $session -> get("connect");
            
            if($connection["type"] === $type)
            {
                return true;
            }

        }

        return false;

    }
    
    /**
     * deleteConnection
     *
     * @param  SessionInterface $session
     * @return void
     */
    private function deleteConnection(SessionInterface $session): void
    {
        $session -> unlock("connect");
        $session -> unset("connect");

    }
}