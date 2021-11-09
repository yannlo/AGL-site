<?php


namespace YannLo\Agl\Modules\Users\Action;

use GuzzleHttp\Psr7\Response;
use YannLo\Agl\Router\Router;
use Psr\Container\ContainerInterface;
use YannLo\Agl\Modules\Users\App\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use YannLo\Agl\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use YannLo\Agl\Modules\Users\Models\UserManager;


class UserAction implements MiddlewareInterface
{
    use \YannLo\Agl\Modules\Tools\Action\ExtractPageTrait;
    use \YannLo\Agl\Modules\Tools\Action\ConnectionTrait;

    private RendererInterface $renderer;
    private Router $userRouter;

    public function __construct(
        private ContainerInterface $container,
        private UserManager $manager
    )
    { 
        $this->renderer = $container ->get(RendererInterface::class);
        $routers = $container ->get(Router::class);
        $this -> userRouter = $routers["user"];
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeName = $request ->getAttribute("routeName");
        $page = $this -> extractRouteName($routeName);

        $data ["routeParams"] = $request -> getAttribute("routeParams");
        $data["post"] = $request -> getParsedBody();
        $data["session"] = $request -> getAttribute("session");
        $data["router"] = $this -> userRouter;

        return $this -> $page($data);
    }
    
    private function login(array $data): ResponseInterface 
    {
        $data["route"] = $this -> userRouter -> getRoute('user.login');
        $session = $data['session'];
        unset($data['session']);

        if($this -> verifiedConnection(User::class, $session))
        {
            return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.index') ) -> getPath() ] );
        }

        if(!empty($data["post"]))
        {
            $email = htmlentities($data["post"]["email"]);

            try {
                $user = $this -> manager -> getOnce($email, "email");

            } catch (\InvalidArgumentException) {
                $data["error"] = "l'email saisi est incorrect ou inexistante";

                $content = $this -> renderer ->render("@User/login", $data);
                return new Response(body: $content);

            } catch (\RuntimeException) {
                $content = $this -> renderer ->render("@Error/500", $data);
                return new Response(status: 500, body: $content);
            }

            if (password_verify(htmlentities($data["post"]["password"]), $user -> password()))
            {
                $this-> createConnection($user, $session, "cni");
                return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.index') ) -> getPath() ] );
            }

            unset($data["post"]);
        }

        $content = $this -> renderer ->render("@User/login", $data);
        return new Response(body: $content);
    }

    private function signup(array $data): ResponseInterface
    {
        $data["route"] = $this -> userRouter -> getRoute('user.sign-up');
        $session = $data['session'];
        unset($data['session']);

        if($this -> verifiedConnection(User::class, $session))
        {
            return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.index') ) -> getPath() ] );
        }
        if(!empty($data["post"]))
        {
            $post = $data["post"];
            $user = new User();

            
            if($post["password"] !== $post["confirmPassword"])
            {
                
                $data["error"]= "Les mots de passe ne sont pas identiques";
                $content = $this -> renderer ->render("@User/sign-up", $data);
                return new Response(body: $content);
            }
            
            try
            {
                $this -> manager -> getOnce( htmlentities($post["email"]), "email");
                $data["error"]= "Cette email exist deja";
                $content = $this -> renderer ->render("@User/sign-up", $data);
                return new Response(body: $content);
            }
            catch (\InvalidArgumentException $e)
            {
                foreach($post as $key => $value)
                {
                    $method = "set". ucfirst($key);
                    if(method_exists($user, $method))
                    {
                        try{
                            $user-> $method (htmlentities($value));
                        }
                        catch(\InvalidArgumentException $e)
                        {
                            $data["error"]= "Invalid value to ".$key;
                            $content = $this -> renderer ->render("@User/sign-up", $data);
                            return new Response(body: $content);
    
                        }
                    }
                }

                try{
                    $this-> manager -> create($user);
                }
                catch(\RuntimeException $e)
                {
                    $content = $this -> renderer ->render("@Error/500", $data);
                    return new Response(status: 500, body: $content);
                }

                $this-> createConnection($user, $session, "cni");

                return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.index') ) -> getPath() ] );

            }    

        }


        $content = $this -> renderer ->render("@User/sign-up", $data);
        return new Response(body: $content);
    }

    private function index(array $data): ResponseInterface
    {
        $session = $data['session'];
        unset($data['session']);

        
        if(!$this -> verifiedConnection(User::class, $session))
        {
            return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.login') ) -> getPath() ] );
        }
        
        $content = $this -> renderer ->render("@User/index", $data);
        return new Response(body: $content);
    }

    private function account(array $data): ResponseInterface
    {
        $session = $data['session'];
        unset($data['session']);

        if(!$this -> verifiedConnection(User::class, $session))
        {
            return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.login') ) -> getPath() ] );
        }
        
        $data["user"] = $this -> manager->getOnce($session -> get("connect")["id"]);

        $content = $this -> renderer ->render("@User/account", $data);
        return new Response(body: $content);
    }

    private function logout(array $data): ResponseInterface
    {
        $this -> deleteConnection($data['session']);
        return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.login') ) -> getPath() ] );
    }

    private function delete(array $data): ResponseInterface
    {
        $session = $data['session'];
        unset($data['session']);

        if(!$this -> verifiedConnection(User::class, $session))
        {
            return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.login') ) -> getPath() ] );
        }
        
        if(!empty($data["post"]))
        {
            $user= $this -> manager->getOnce($session -> get("connect")["id"]);
            $post = $data["post"];

            if($post["delete"] == "Confirmer") {

                $this -> manager-> delete($user);

                $this -> deleteConnection($data['session']);

                return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.logout') ) -> getPath() ] );

            } else if($post["delete"] == "Cancel"){
                return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.account') ) -> getPath() ] );
            }

            $content = $this -> renderer ->render("@User/delete", $data);
            return new Response(body: $content);
        }

        $content = $this -> renderer ->render("@User/delete", $data);
        return new Response(body: $content);
    }

    private function update(array $data): ResponseInterface
    {
        $session = $data['session'];
        unset($data['session']);

        if(!$this -> verifiedConnection(User::class, $session))
        {
            return new Response(302,[ "location" => ( $this -> userRouter -> getRoute('user.login') ) -> getPath() ] );
        }

        if(!empty($data["post"])) {

            $post = $data["post"];

            $user = $this -> manager->getOnce($session -> get("connect")["id"]);

            if(!empty($post["LastPassword"])){

                if (!password_verify($post["lastPassword"], $user->password())) {

                    $data["error"] = "L'ancien password est erroné";
                    $content = $this -> renderer ->render("@User/update", $data);
                    return new Response(body: $content);
                    
                }

            }


        }

        $content = $this -> renderer ->render("@User/update", $data);
        return new Response(body: $content);
    }
    
}