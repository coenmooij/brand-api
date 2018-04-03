# Twitter Reach API

This api calculates the reach for a given tweet. It uses Redis to cache calculated reach for two hours.

Endpoint:
```yml
GET /api/tweets/:id/reach
```

Success response:
```json
{ 
    "code": 200, 
    "message": "OK",
    "data": {
        "reach": 123
    }
}
```

##Twitter Reach UI

![screenshot](http://hmp.me/bb9d)
