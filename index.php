<?
/* Author: Takumi Adachi 
   License: MIT.
*/

// See: developers.hitbox.tv/media
// This class is copied and pasted verbatim from hitbox's api page.
class Media {
    //default api endpoint
    const apiUrl = 'http://api.hitbox.tv/';

    private function apiCall($resource,$options=array()) {

        //create stream context - timeout: 5 seconds
        $ctx = stream_context_create(array( 
            'http' => array( 
                'timeout' => 5
                ) 
            ) 
        );

        $query = (!empty($options)) ? '?'.http_build_query($options) : '';

        $apiUrl = self::apiUrl.$resource.$query;

        $this->request=$apiUrl;

        return ($response = json_decode(file_get_contents($apiUrl,0,$ctx),true)) ? $response : false;         
    }

    public function getMedia($mediaType='live',$mediaName='list') {
        //get media object
        if ($media=self::apiCall('media/'.$mediaType."/".$mediaName,array('embed' => 'true'))) {
            return ($mediaName=='list') ? $media['livestream'] : $media['livestream'][0]; 
        }
        return false;
    } 
}

// Note hitbox's cdn server is at:  http://edge.vie.hitbox.tv  
// Get a user logo example: http://edge.vie.hitbox.tv/static/img/channel/AmonAglar_542036840a97f_large.jpg  

// ************ Get all current livestreams **************
$Media = new Media;
$media = $Media->getMedia('live');
$channels = array();

// Parse large media object that hitbox gives us for the stuff we want.
foreach ($media as &$x) { // Access element of array via reference using '&'
    // What gets added/pushed example:          [1, 0, 'speedfriends', 'Super Mario']
    $x['channel']['viewers'] = $x['media_views'];
    $x['channel']['status'] = $x['media_status'];
    $x['channel']['delay'] = $x['media_live_delay'];
    $x['channel']['team_name'] = $x['team_name'];
    $x['channel']['category_name'] = $x['category_name'];
    $x['channel']['cdn'] = 'http://edge.vie.hitbox.tv';
    
    array_push($channels, $x['channel']);
}

//echo memory_get_usage() . "\n";  // ~ 900000bytes 300kb

// Output the small, parsed, valid json of all hitbox livestreams as REST.
print json_encode($channels, JSON_UNESCAPED_SLASHES); // Used to prevent escaping forward slashes. http:\\\/\\\/edge.vie.hitbox.tv --> http://edge.vie.hitbox.tv

// Deallocate Memory.
unset($Media);
unset($media);
unset($channels);

// END memory usage
//echo "\n" . memory_get_usage() . "\n";  // ~300000bytes 300kb

/* EXAMPLE OUTPUT */
/*
[
    {
        "followers": "597",
        "user_id": "623048",
        "user_name": "AmonAglar",
        "user_status": "1",
        "user_logo": "http://edge.sf.hitbox.tv/static/img/channel/AmonAglar_542036840a97f_large.jpg",
        "user_cover": null,
        "user_logo_small": "http://edge.sf.hitbox.tv/static/img/channel/AmonAglar_542036840a97f_small.jpg",
        "user_partner": null,
        "livestream_count": "1",
        "channel_link": "http://hitbox.tv/amonaglar",
        "status": "0",
        "team_name": "leagueoflegendsbulgaria",
        "category_name": "League of Legends",
        "cdn": "http://edge.vie.hitbox.tv"
    },
    {
        "followers": "68",
        "user_id": "795924",
        "user_name": "Matharl",
        "user_status": "1",
        "user_logo": "http://edge.sf.hitbox.tv/static/img/channel/Matharl_53e3335b93ad0_large.jpg",
        "user_cover": "/static/img/channel/cover_53e5097f2057d.jpg",
        "user_logo_small": "http://edge.sf.hitbox.tv/static/img/channel/Matharl_53e3335b93ad0_small.jpg",
        "user_partner": null,
        "livestream_count": "1",
        "channel_link": "http://hitbox.tv/matharl",
        "status": "0",
        "team_name": null,
        "category_name": "League of Legends",
        "cdn": "http://edge.vie.hitbox.tv"
    },
.......
*/
?>