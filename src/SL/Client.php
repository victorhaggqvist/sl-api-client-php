<?php
/**
 * User: Victor Häggqvist
 * Date: 9/7/15
 * Time: 12:21 AM
 */

namespace Snilius\SL;


/**
 * Wrapper for SL apis provided through Trafiklab.se
 *
 * This wrapper covers;
 * - https://www.trafiklab.se/api/sl-reseplanerare-2
 * - https://www.trafiklab.se/api/sl-platsuppslag
 *
 * @link https://github.com/victorhaggqvist/sl-api-client-php
 */
class Client {

    /**
     * Sl Platsuppslag URL endpoint
     * @var string
     */
    private $SlPlatsuppslagURL = 'https://api.sl.se/api2/typeahead.json';

    /**
     * Sl Reseplanerare 2 URL base endpoint
     * @var string
     */
    private $SlReseplanerare2URL = 'https://api.sl.se/api2/TravelplannerV2';


    /**
     * A Guzzle Client
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Api key for SL Realtidsinformation 3
     * @var string
     */
    private $slRealtidsinformation3Key;

    /**
     * Api key for SL Reseplanerare 2
     * @var string
     */
    private $slReseplanerare2key;

    /**
     * Api key for SL Platsuppslag
     * @var string
     */
    private $slPlatsuppslagKey;

    /**
     * Constructor for SL Client
     * @param string $slRealtidsinformation3 Key Api key for SL Realtidsinformation 3
     * @param string $slReseplanerare2key Api key for SL Reseplanerare 2
     * @param string $slPlatsuppslagKey Api key for SL Platsuppslag
     */
    function __construct($slRealtidsinformation3Key, $slReseplanerare2key = null, $slPlatsuppslagKey = null) {
        $this->client = new \GuzzleHttp\Client();
        $this->slRealtidsinformation3Key = $slRealtidsinformation3Key;
        $this->slReseplanerare2key = $slReseplanerare2key;
        $this->slPlatsuppslagKey = $slPlatsuppslagKey;
    }

    /**
     * SL Platsuppslag
     *
     * See https://www.trafiklab.se/api/sl-platsuppslag
     *
     * @link https://www.trafiklab.se/api/sl-platsuppslag
     * @param string $query
     * @param array $options
     * @return mixed
     */
    public function slPlatsuppslag($query, array $options = []) {
        $params = ['key' => $this->slPlatsuppslagKey, 'searchstring' => $query];
        $params = array_merge($params, $options);

        $request = $this->client->request('GET', $this->SlPlatsuppslagURL, [
            'query' => $params
        ]);

        $json = json_decode($request->getBody(), true);
        return $json['ResponseData'];
    }

    /**
     * SL Reseplanerare 2 -> Trip
     *
     * See https://www.trafiklab.se/api/sl-reseplanerare-2
     *
     * @link https://www.trafiklab.se/api/sl-reseplanerare-2
     * @param string $originId SiteID from
     * @param string $destId SiteID to
     * @param array $options Any extra options
     * @return mixed
     */
    public function slReseplanerare2Trip($originId, $destId, array $options = []) {
        $params = [
            'key' => $this->slReseplanerare2key,
            'originId' => $originId,
            'destId' => $destId
        ];
        $params = array_merge($params, $options);

        $url = $this->SlReseplanerare2URL.'/trip.json';

        $request = $this->client->request('GET', $url, [
            'query' => $params
        ]);

        $json = json_decode($request->getBody(), true);
        return $json;
    }

    /**
     * SL Reseplanerare 2 -> Geometry
     *
     * See https://www.trafiklab.se/api/sl-reseplanerare-2
     *
     * @link https://www.trafiklab.se/api/sl-reseplanerare-2
     * @param string $ref
     * @return mixed
     */
    public function slReseplanerare2Geometry($ref) {
        $url = $this->SlReseplanerare2URL.'/geometry.json';

        $params = [
            'key' => $this->slReseplanerare2key,
            'ref' => $ref
        ];

        $request = $this->client->request('GET', $url, [
            'query' => $params
        ]);

        $json = json_decode($request->getBody(), true);
        return $json;
    }

    /**
     * SL Reseplanerare 2 -> JourneyDetail
     *
     * See https://www.trafiklab.se/api/sl-reseplanerare-2
     *
     * @link https://www.trafiklab.se/api/sl-reseplanerare-2
     * @param string $ref
     * @return mixed
     */
    public function slReseplanerare2JourneyDetail($ref) {
        $url = $this->SlReseplanerare2URL.'/journeydetail.json';

        $params = [
            'key' => $this->slReseplanerare2key,
            'ref' => $ref
        ];

        $request = $this->client->request('GET', $url, [
            'query' => $params
        ]);

        $resp = $this->client->send($request);
        $json = json_decode($resp->getBody(), true);
        return $json;
    }

}
