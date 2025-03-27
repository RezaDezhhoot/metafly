# Get started

## Meta Fly project

#### Requirements
* Docker
* * [Windows](https://docs.docker.com/desktop/setup/install/windows-install)
* * [Mac](https://docs.docker.com/desktop/setup/install/mac-install)
* * [Linux](https://docs.docker.com/desktop/setup/install/linux/)

### Run project on development mode

```bash 
cp .env.example .env
```
```bash 
docker compose -f docker-compose.local.yml up
```

### Run project on production mode
```bash 
cp .env.example .env
```
```bash 
docker compose up
```


### Details

| Admin Service | Api service    | DB            | cache |
|---------------|----------------|---------------|-------|
| Laravel v12   | Golang v1.23.1 | Postgres      | Redis |


1. Admin services will available on :8000 `(email: admin@gmail.com pass:123456789)`
2. Admin services will available on :3000
3. DB service will available on :5432
4. Redis service will available on :6389