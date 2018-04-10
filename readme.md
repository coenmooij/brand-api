# Brand API

The Brand API allows you to add twitter accounts and do analytics on them. 
See how many people you have reached through your social media posts.

## Endpoints

### Authentication
| Method | URI | Body | Response |
| ------ | --- | ---- | -------- |
| POST | `/authentication/register` | `email, password, firstName, lastName` | token |   
| POST | `/authentication/login` | `email, password` | token |
| GET | `/authentication/logout` |

### Twitter
| Method | URI | Body | Response |
| ------ | --- | ---- | -------- |
| GET | `/twitter/accounts` | | accounts |
| POST | `/twitter/accounts` | TODO | account |
| GET | `/twitter/accounts/{id}` | | account |
| PATCH | `/twitter/accounts/{id}` | TODO | account |
| DELETE | `/twitter/accounts/{id}` | TODO |
| GET | `/twitter/accounts/{id}/statistics` | | accountStatistics |
| GET | `/twitter/accounts/{id}/tweets` | | tweets |
| GET | `/twitter/tweets` | | tweets |
| GET | `/twitter/tweets/{id}` | | tweet |
| GET | `/twitter/tweets/{id}/statistics` | | tweetStatistics |

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
