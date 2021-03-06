# Brand API

The Brand API allows you to add twitter accounts and do analytics on them. 
See how many people you have reached through your social media posts.

## Endpoints

### Authentication
| Method | URI | Body | Response |
| ------ | --- | ---- | -------- |
| POST | `/authentication/register` | `email, password, firstName, lastName` | user |   
| POST | `/authentication/login` | `email, password` | token |
| GET | `/authentication/logout` |

### Twitter
| Method | URI | Body | Response |
| ------ | --- | ---- | -------- |
| GET | `/twitter/accounts` | | accounts |
| POST | `/twitter/accounts` | `accessToken, accessTokenSecret, consumerKey, consumerSecret` | account |
| GET | `/twitter/accounts/{id}` | | account |
| PATCH | `/twitter/accounts/{id}` | `accessToken, accessTokenSecret, consumerKey, consumerSecret` | account |
| DELETE | `/twitter/accounts/{id}` |
| GET | `/twitter/accounts/{id}/statistics` | | statistics |
| GET | `/twitter/accounts/{id}/tweets` | | tweets |
| GET | `/twitter/tweets` | | tweets |
| GET | `/twitter/tweets/{id}` | | tweet |
| GET | `/twitter/tweets/{id}/statistics` | | statistics |

### Example Login
```yml
POST   /authentication/login
```
```json
body: {
  "email": "email@example.com",
  "password": "password"
}
```
```json
response: {
  "code": 200,
  "message": "Successfully logged in!",
  "data": {
    "token": "exampletoken"
  }
}
```
