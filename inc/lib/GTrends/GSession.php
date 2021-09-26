<?php

namespace app\models\service;

class GSession
{

    protected $user;
    protected $pass;
    protected $cookie;
    protected $timeout;

    private $maxRedirs = 5;
    private $curlh;
	private $urlLogin='https://accounts.google.com/signin/v2/identifier?hl=en&service=alerts&continue=http%3A%2F%2Fwww.google.com%2Falerts%2Fmanage&flowName=GlifWebSignIn&flowEntry=ServiceLogin';
    private $urlAuth='https://accounts.google.com/ServiceLoginAuth';

    /**
     * Constructor for the google session
     * @param type $user Google account user
     * @param type $pass Google account password
     * @param type $cookiefile File where the session cookie will be stored
     */
    public function __construct($user, $pass, $cookiefile = 'cookies')
    {
        $timeout=30;
        $this->user = $user;
        $this->pass = $pass;
        $this->cookie = $cookiefile;
        $this->timeout = $timeout;
    }

    /**
     * Authenticates the user to the google services, this must be called before any other operation
     * @return boolean User logged in
     */
    public function authenticate()
    {
		@unlink($this->cookie);
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

        curl_setopt($ch, CURLOPT_URL, $this->urlLogin);
        $data = $this->curl_exec_follow($ch);

        $formFields = $this->getFormFields($data);
        $formFields['Email'] = $this->user;
        $formFields['Passwd'] = $this->pass;
        unset($formFields['PersistentCookie']);

        $post_string = '';
        foreach ($formFields as $key => $value)
        {
            $post_string .= $key . '=' . urlencode($value) . '&';
        }
        $post_string = substr($post_string, 0, -1);

        curl_setopt($ch, CURLOPT_URL, $this->urlAuth);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        $result = $this->curl_exec_follow($ch);

        $this->curlh=$ch;

        return true;
    }

    //curl handler to use after authentication to use the cookie
    public function getCurl()
    {
        return $this->curlh;
    }

    protected function getFormFields($data)
    {
        if (preg_match('/(<form.*?id=.?gaia_loginform.*?<\/form>)/is', $data, $matches)) {
            $inputs = $this->getInputs($matches[1]);

            return $inputs;
        } else
        {
            throw new GAlertException('Cannot authenticate, bad response from server');
        }
    }

    protected function getInputs($form)
    {
        $inputs = array();

        $elements = preg_match_all('/(<input[^>]+>)/is', $form, $matches);

        if ($elements > 0)
        {
            for ($i = 0; $i < $elements; $i++)
            {
                $el = preg_replace('/\s{2,}/', ' ', $matches[1][$i]);

                if (preg_match('/name=(?:["\'])?([^"\'\s]*)/i', $el, $name))
                {
                    $name = $name[1];
                    $value = '';

                    if (preg_match('/value=(?:["\'])?([^"\'\s]*)/i', $el, $value))
                    {
                        $value = $value[1];
                    }

                    $inputs[$name] = $value;
                }
            }
        }

        return $inputs;
    }

    protected function curl_exec_follow($ch)
    {
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        return curl_exec($ch);
    }

}
