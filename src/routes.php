<?php
// Routes

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use app\Service\Fb;
use app\Model\User;

$app->get('/', function(Request $request, Response $response)
{
    $app_id = $this->get('settings')['fb_app']['id'];
    return $this->renderer->render($response, "index.phtml", compact('app_id'));
});

$app->get('/authorize', function(Request $request, Response $response, $args)
{
    try {
        $fb           = new Fb();
        $user_id      = $fb->getUserId();
        $access_token = $fb->getAccessToken();
        
        if ($user_id && $access_token) {
            $info = $fb->getUserInfo($access_token);
            $users = User::where('fb_id', $info['id'])->get();

            $user = $users[0];
            if (!$user->id) {
                $user->last_name = $info['last_name'];
                $user->save();
            }

            $_SESSION['fb_access_token'] = (string) $access_token;
            $_SESSION['user_id']         = $user->id;
            return $response->withJson(['status' => 'ok'], 200);
        }
    }
    catch (Exception $e) {
        $this->logger->debug($e->getMessage());
    }
});
