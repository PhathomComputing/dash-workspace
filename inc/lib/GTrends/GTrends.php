<?php

namespace app\models\service;

class GTrends
{

    //Types of data to filter
    const TYPE_IMAGES='images';
    const TYPE_NEWS='news';
    const TYPE_GSHOPPING='froogle';
    const TYPE_YOUTUBE='youtube';

    //Format of the results
    const DATA_JSON='json';
    const DATA_ARRAY='array';
    const DATA_CSV='csv';

    //Type of region results
    const REGION_COUNTRY='COUNTRY';
    const REGION_CITY='CITY';

    //Service urls
    private $urlToken='https://trends.google.com/trends/api/explore';
    private $urlGraph='https://trends.google.com/trends/api/widgetdata/multiline/csv';
    private $urlGeo='https://trends.google.es/trends/api/widgetdata/comparedgeo/csv';
    private $urlRelated='https://trends.google.es/trends/api/widgetdata/relatedsearches/csv';
    private $backend='IZG';

    //Session and tokens
    protected $sess;
    protected $token;

    //Class parametrization
    protected $terms;
    protected $type;
    protected $category;
    protected $lang;
    protected $time;
    protected $geo;

    /**
     * Create a Google Trends Api Object
     * @param string $lang language code
     * @param GSession $gsession an already authenticated GSession
     */
    public function __construct($gsession, $lang='en-US', $token=null)
    {
        $this->sess=$gsession;
        $this->token=$token;
        $this->terms=[];
        $this->lang=$lang;
        $this->category=0;
        $this->type='';
        $this->time='today 5-y';
        $this->geo='';
    }

    /**
     * Clear the search terms
     */
    public function clearTerms()
    {
        $this->terms=[];
        return $this;
    }

    /**
     * Adds a new term to track
     * @param string $keyword Keyword to track
     * @return GTrends
     */
    public function addTerm($keyword)
    {
        $type='BROAD';
        $this->terms[]=array('keyword' => $keyword, 'geo' => '', 'time' => '', 'type' => $type);
        return $this;
    }


    /**
     * @param string $type Filters the data to TYPE_IMAGES, TYPE_NEWS, TYPE_GSHOPPING or TYPE_YOUTUBE. When empty looks for everything
     * @return GTrends
     */
    function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * id of the category to filter results
     * @param int $category
     * @return GTrends
     */
    function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Sets the language for the results
     * @param string $lang language code
     * @return GTrends
     */
    function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * The time range to filter the results, the default is today 5-y.
     * @param string $time google range time format: 'now 1-H', 'today 5-y', '2011-11-01 2017-04-18'
     * @return GTrends
     */
    function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * Sets the country to filter the results
     * @param string $geo country code
     * @return GTrends
     */
    function setGeo($geo)
    {
        $this->geo = strtoupper($geo);
        return $this;
    }


    /**
     * Gets the graph of data defining the relevance over time of the searched terms
     * @param string $datatype DATA TYPE to return: GTrends::DATA_JSON, GTrends::DATA_ARRAY, GTrends::DATA_CSV
     * @return mixed Data returned
     */
    public function getGraph($datatype='array')
    {
        $time=$this->time;
        $geo=$this->geo;
        $type=$this->type;
        $category=$this->category;

        //Get token for graph
        $tokens=$this->getTokens();
        $resolution=$tokens['graphRes'];
        $gtime=$tokens['graphTime'];
        $token=$tokens['graph'];

        //Items to search for. Must be the same used in the token request
        $items=[];
        foreach($this->terms as $t)
        {
            $geo=array('' => '');
            if (!empty($t['geo'])) $geo=array('country' => $t['geo']);

            $item=array(
                'geo' => $geo,
                'complexKeywordsRestriction' => array(
                    'keyword' => array(
                        array(
                            'type' => $t['type'],
                            'value' => $t['keyword']
                        )
                    )
                )
            );
            $items[]=$item;
        }

        //Request parameters and time
        $req=[
            'time' => $gtime,
            'resolution' => $resolution,
            'locale' => $this->lang,
            'comparisonItem' => $items,
            'requestOptions' => array(
                'property' => $type,
                'backend' => $this->backend,
                'category' => $category
            )
        ];

        //Gets the data gziped and with the authenticated curl
        $result = $this->request($this->urlGraph.'?'.'req='.urlencode(json_encode($req)).'&token='.$token.'&tz=-120'.'&hl='.$this->lang);
        return $this->parseResult($result, $datatype);

    }

    /**
     * Gets the ranking of regions where the term is trending
     * @param string $datatype DATA TYPE to return: GTrends::DATA_JSON, GTrends::DATA_ARRAY, GTrends::DATA_CSV
     * @param string $region GTrends::REGION_COUNTRY, GTrends::REGION_CITY. When there is a setGeo() defined, the country will become region
     * @return type
     */
    public function getRegions($datatype='array', $region='COUNTRY')
    {
        $time=$this->time;
        $geo=$this->geo;
        $type=$this->type;
        $category=$this->category;

        //Get token for graph
        $tokens=$this->getTokens();
        $resolution='COUNTRY';
        $token=$tokens['geomap'];

        if (!empty($this->geo)) {
            $resolution='REGION';
        }

        if ($region=='CITY') {
            $resolution='CITY';
        }

        //Items to search for. Must be the same used in the token request
        $items=[];
        foreach($this->terms as $t)
        {
            $geo=array('' => '');
            if (!empty($t['geo'])) $geo=array('country' => $t['geo']);

            $item=array(
                'complexKeywordsRestriction' => array(
                    'keyword' => array(
                        array(
                            'type' => $t['type'],
                            'value' => $t['keyword']
                        )
                    )
                ),
                'time' => $this->time
            );
            $items[]=$item;
        }

        //Request parameters and time
        $req=[
            'resolution' => $resolution,
            'locale' => $this->lang,
            'comparisonItem' => $items,
            'geo' => $geo,
            'requestOptions' => array(
                'property' => $type,
                'backend' => $this->backend,
                'category' => $category
            )
        ];

        //Gets the data gziped and with the authenticated curl
        $result=$this->request($this->urlGeo.'?'.'req='.urlencode(json_encode($req)).'&token='.$token.'&tz=-120'.'&hl='.$this->lang);
        return $this->parseResult($result, $datatype);
    }

    /**
     * Search for related queries
     * @param strimg $term The term to search for related topics
     * @param string $datatype DATA TYPE to return: GTrends::DATA_JSON, GTrends::DATA_ARRAY, GTrends::DATA_CSV
     * @return type
     */
    public function getRelated($term, $datatype='array')
    {
        $time=$this->time;
        $geo=$this->geo;
        $type=$this->type;
        $category=$this->category;

        //When the term was not added before, add it
        $found=false;
        foreach($this->terms as $t) {
            if ($t['keyword']==$term) {
                $found=true;
            }
        }
        if (!$found) $this->addTerm ($term);

        //Get token for graph
        $this->getTokens();
        $atoken=$this->findToken('RELATED_QUERIES');
        $token=$atoken->token;


        //Items to search for. Must be the same used in the token request
        $item=array();
        foreach($this->terms as $t)
        {
            $geo=array('' => '');
            if (!empty($t['geo'])) $geo=array('country' => $t['geo']);

            if ($t['keyword']==$term) {
                $item=array(
                    'complexKeywordsRestriction' => array(
                        'keyword' => array(
                            array(
                                'type' => $t['type'],
                                'value' => $t['keyword']
                            )
                        )
                    ),
                    'time' => $this->time,
                    'geo' => $geo,
                    'originalTimeRangeForExploreUrl' => $this->time                    
                );
            }

        }

        $clng=explode('-', $this->lang);
        $clng=$clng[0];
        
        //Request parameters and time
        $req=[
            'keywordType' => 'QUERY',
            'language' => $clng,
            'metric' => array('TOP', 'RISING'),
            'trendinessSettings' => array('compareTime' => $atoken->request->trendinessSettings->compareTime),
            'restriction' => $item,
            'requestOptions' => array(
                'property' => $type,
                'backend' => $this->backend,
                'category' => $category
            )
        ];

        //Gets the data gziped and with the authenticated curl
        $result=$this->request($this->urlRelated.'?'.'req='.urlencode(json_encode($req)).'&token='.$token.'&tz=-120'.'&hl='.$this->lang);


        if ($datatype=='csv') return $result;

        $res=$this->parseResult($result, 'array');
        $retTop=array();
        $retRise=array();
        $in=false;
        $inr=false;
        for($i=0; $i<count($res); $i++)
        {
            if (trim($res[$i][0])=='TOP') {
                $in=true;
                $inr=false;
            } else if (trim($res[$i][0]=='RISING')) {
                $inr=true;
                $in=false;
            } else {
                if ($in && !empty($res[$i][0])) $retTop[]=$res[$i];
                if ($inr && !empty($res[$i][0])) $retRise[]=$res[$i];
            }
        }

        $fret=array('top' => $retTop, 'rising' => $retRise);
        if ($datatype=='json') return json_encode($fret);

        return $fret;
    }

    private function refreshTerms($time, $geo)
    {
        foreach($this->terms as &$t) {
            $t['time']=$time;
            $t['geo']=$geo;
        }
    }

    private function request($url)
    {
        $ch = $this->sess->getCurl();
        curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Host: trends.google.com',
                'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: en-US;q=0.7,en;q=0.3',
                'Accept-Encoding: gzip, deflate, br',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
        ));
        return curl_exec($ch);
    }

    private function parseResult($result, $datatype)
    {
        //Return plain csv
        if ($datatype=='csv') {
            return $result;
        }

        //Parse data for array and json
        $res=array();
        $rows=explode("\n", $result);
        for($i=2; $i<count($rows); $i++) {
            $res[]=explode(',', $rows[$i]);
        }

        if ($datatype=='json') {
            return json_encode($res);
        }

        return $res;
    }

    protected function getTokens()
    {
        $this->refreshTerms($this->time, $this->geo);

        //Build url to get the token
        $url=$this->urlToken.'?'.http_build_query([
            'hl'=> $this->lang,
            'tz'=>'-120',
            'req' => '{"comparisonItem":'.json_encode($this->terms).',"category":'.$this->category.',"property":"'.$this->type.'"}',
        ]);
        //Obtains the authenticated curl and gets the data
        $ch = $this->sess->getCurl();
        curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        //Parse data and get tokens
        $result=substr($result, strpos($result, '{"widgets"'));
        $result=json_decode($result);
        $token=array(
            'graph' => $result->widgets[0]->token,
            'graphRes' => $result->widgets[0]->request->resolution,
            'graphTime' => $result->widgets[0]->request->time,
            'geomap' => $result->widgets[1]->token
        );

        $this->token=$result;

        return $token;
    }

    protected function findToken($name)
    {
        foreach($this->token->widgets as $w) {
            if ($w->id==$name || (property_exists($w, 'keywordName') && $w->keywordName==$name) ) {
                return $w;
            }
        }
        return '';
    }

}
