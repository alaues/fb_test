<?php

namespace app\Service;

class Fb
{
    /**
     * init facebook client
     * @return \Facebook\Facebook
     */
    private function initClient()
    {
        global $settings;
        return new \Facebook\Facebook(array(
            'app_id' => $settings['settings']['fb_app']['id'],
            'app_secret' => $settings['settings']['fb_app']['secret'],
            'default_graph_version' => 'v2.3'
        ));
    }
    
    /**
     * Function gets user ID
     * @global string $settings
     * @global string $log
     * @return string
     */
    public function getUserId()
    {
        global $settings, $log;
        
        $fb     = $this->initClient();
        $helper = $fb->getJavaScriptHelper();
        try {
            $sr      = $helper->getSignedRequest();
            $user_id = $sr->getUserId();
            return $user_id;
        }
        catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return null;
        }
    }
    
    /**
     * Function gets user details
     * @global string $settings
     * @global string $log
     * @param string $access_token
     * @return array|null
     */
    public function getUserInfo($access_token)
    {
        global $settings, $log;
        
        $fb = $this->initClient();
        try {
            $response = $fb->get('/me?fields=id,first_name,last_name,picture', $access_token);
            $info     = $response->getGraphUser();
            //           $picture = $info->getGraphPicture();
            
            return [
                'id' => $info->getId(),
                'first_name' => $info->getFirstName(),
                'last_name' => $info->getLastName(),
                'picture' => ''
            ];
        }
        catch (\Facebook\Exceptions\FacebookSDKException $e) {
            $log->debug($e->getMessage());
            return null;
        }
    }
    
    /**
     * Function sends accessToken, if accessToken is not long living, then it
     * exhanges for long living one
     * @return string|null
     */
    public function getAccessToken()
    {
        $fb     = $this->initClient();
        $helper = $fb->getJavaScriptHelper();
        try {
            $accessToken = $helper->getAccessToken();
            if (!$accessToken->isLongLived()) {
                $oAuth2Client = $fb->getOAuth2Client();
                $accessToken  = $oAuth2Client->getLongLivedAccessToken($accessToken);
            }
            return $accessToken;
        }
        catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return null;
        }
    }
    
}