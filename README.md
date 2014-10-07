hitbox_api_wrapper
===========

Wrapper around hitbox's API.

Outputs the current livestreams trimmed to bare essentials. Perfect for embedding livestream and chat.

Get the livestreams from here: [http://hboxapi.herokuapp.com](http://hboxapi.herokuapp.com)

#### Example output:
```json
[
    {
        "followers": "155",
        "user_id": "994524",
        "user_name": "TheBox",
        "user_status": "1",
        "user_logo": "http://edge.sf.hitbox.tv/static/img/channel/TheBox_5404b96559e0d_large.png",
        "user_cover": "/static/img/channel/cover_5405ecaacb7ee.png",
        "user_logo_small": "http://edge.sf.hitbox.tv/static/img/channel/TheBox_5404b96559e0d_small.png",
        "user_partner": null,
        "livestream_count": "1",
        "channel_link": "http://hitbox.tv/thebox",
        "viewers": "93",
        "status": "[FR] Kin0a vs la tryhardance.",
        "delay": "0",
        "team_name": "thebox",
        "category_name": "League of Legends",
        "cdn": "http://edge.vie.hitbox.tv"
    },
......
```
