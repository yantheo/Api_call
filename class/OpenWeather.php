<?php


class OpenWeather
{
    /**
     * @var string
     */
    private $apikey;

    public function __construct($apiKey)
    {
        $this->apikey = $apiKey;
    }

    /**
     * @param string $lat
     * @param string $lon
     * @return array
     */
    public function getForecast(string $lat, string $lon): array
    {
        $data = $this->getApi("onecall?lat={$lat}&lon={$lon}&exclude=current,minutely,hourly&appid={$this->apikey}");
        $result = [];
        foreach($data['daily'] as $day)
        {
            $result[] = [
                'temp' => $day['temp']['day'],
                'description' => $day['weather'][0]['description'],
                'date' => new DateTime('@' . $day['dt'])
            ];

        }
        return $result;
    }

    /**
     * @param string $city
     * @return array
     */
    public function getToday(string $city): array
    {
        $data = $this->getApi("weather?q={$city}&appid={$this->apikey}");
        return
            [
                'temp' => $data['main']['temp'],
                'description' => $data['weather'][0]['description'],
                'date' => new DateTime()
            ];
    }

    /**
     * @param string $attr
     * @return array|null
     */
    private function getApi(string $attr):?array
    {
        $curl = curl_init("api.openweathermap.org/data/2.5/{$attr}&lang=fr&units=metric");
        curl_setopt_array($curl,
            [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 1,
            ]
        );
        $data = curl_exec($curl);
        if($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE !== 200)){
            var_dump(curl_error($curl));
        }
        return json_decode($data, true);
    }


}