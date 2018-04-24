<?php
/**
 * The Weather class provides the current weather forecast for the next 5 days

 */
// The Weather class
require_once 'WeatherForecast.class.php';

// Applying the api key for weather forecast
$weather = new WeatherForecast('fac158843a594816b9c82138181804');
$city    = "Helsinki";  // defautl city 
$country = "Finland";    // default country 
$days    = 5;            // default number of days  

$key     =  "AIzaSyCWhBGsbVCWsVLln2lGthSrak6zQakVBkQ"; // Api key for Google Maps Geocoding API  
if ((isset($_GET['lat']) && !empty($_GET['lat'])) && (isset($_GET['lng']) && !empty($_GET['lng'])) ) {
   $lat   =  $_GET['lat'];    
   $lng   =  $_GET['lng'];   
   
   $output=  $weather->convertlatlong_location($lat, $lng, $key); // Current lat & lng into location
   $physical_location="";  // Initialization of the physical location (City, Country)
   // Verify if the contain is not empty 
  if (isset($output) && (!empty($output))) {
  // Transfrom the string : city, country into an array 
    $physical_location = explode(",",$output['results'][0]['formatted_address']);  
    if (count($physical_location)>0){
      $country       = $physical_location[count($physical_location) -1]; 
      $city          = $physical_location[count($physical_location) -2];
    }  
  }
}
// Defines the name of the city, Country and the number of days of forecast (between 1 and 5)
//echo $city; echo $country;
$weather->setRequest($city, $country,  $days);
// Setting the us metric to false, because we are using the degree Celsius
$weather->setUSMetric(false);

?>

<html> 
    <head>
        <title>Weather Forecast</title>
        <link rel="stylesheet" href="screen.css" media="screen" />
        <script language="javascript" type="text/javascript" src="js/function.js"></script>
    </head>
    <body>
        <?php
        // API call
        $response = $weather->getLocalWeather();

        if ($weather::$has_response) {
            ?>

            <h1><?php echo $response->locality; ?></h1>
            
            <!--
            <h2>The Weather Today at <?php // echo $response->weather_now['weatherTime']; ?></h2>
            -->
            
            <div class="weather_now">
                <span style="float:right;"><img src="<?php echo $response->weather_now['weatherIcon']; ?>" /></span>
                <strong>DESCRIPTION:</strong> <?php echo $response->weather_now['weatherDesc']; ?><br />
                <strong>TEMPERATURE:</strong> <?php echo $response->weather_now['weatherTemp']; ?><br />
                <strong>WIND SPEED:</strong> <?php echo $response->weather_now['windSpeed']; ?><br />
                <strong>PRECIPITATION:</strong> <?php echo $response->weather_now['precipitation']; ?><br />
                <strong>HUMIDITY:</strong> <?php echo $response->weather_now['humidity']; ?><br />
                <strong>VISIBILITY:</strong> <?php echo $response->weather_now['visibility']; ?><br />
                <strong>PRESSURE:</strong> <?php echo $response->weather_now['pressure']; ?><br />
                <strong>CLOUD COVER:</strong> <?php echo $response->weather_now['cloudcover']; ?><br />
            </div>

            <h3>Weather Forecast</h3>

            <?php
            // Display the weather for 5 days starting from the current day
            foreach ($response->weather_forecast as $weather) { 
                ?>
                <div class="weather_forecast">
                    <div class="block block1">
                        <span class="icon"><img src="<?php echo $weather['weatherIcon']; ?>" /></span>
                    </div>
                    <div class="block block2">
                        <span class="wday"><?php echo $weather['weatherDay']; ?></span>
                        <span class="date"><?php echo $weather['weatherDate']; ?> </span>
                        <span class="desc"><?php echo $weather['weatherDesc']; ?></span>
                        <!--
                        <span class="wind">Wind: <?php echo $weather['windDirection']; ?> at <?php echo $weather['windSpeed']; ?></span>
                        -->
                    </div>
                    <div class="block block3">
                        <span class="tmax"><?php echo $weather['tempMax']; ?></span>
                        <span class="tmin"><?php echo $weather['tempMin']; ?></span>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        </br> </br>
        <p id="position"></p>
        <button onclick="getLocation()"><strong>Actualize</strong></button>
        
    </body>
</html>
