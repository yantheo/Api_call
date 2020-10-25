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
     * @throws Exception
     */
    public function getForecast(string $lat, string $lon): array
    {
        $curl = curl_init("https://api.openweathermap.org/data/2.5/onecall?lat={$lat}&lon={$lon}&exclude=current,minutely,hourly&appid={$this->apikey}&lang=fr&units=metric");
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
        $result = [];
        $data = json_decode($data, true);
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

}