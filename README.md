# DocuPet Coding Challenge - Backend

## Prerequisistes

- Docker
- Docker Compose

## How To Run Me

Open a console, go to the docker directory, and execute this shell script

```shell
./up.sh
```

In order to shut the docker down, simply execute this shell script in the same directory:

```shell
./down.sh
```

## How to run the initial database migrations

Open a console, go to the docker directory, and execute this shell script

```shell
./mount-database.sh
```

## Technologies Uses

| Technology used  | Reason                                 |
| ---------------- | -------------------------------------- |
| Laravel 11       | Backend PHP framework                  |
| MySQL            | Database                               |
| PHPStan          | Static code analysis                   |
| PHPUnit          | Unit, Integration and End-to-end tests |
| Mockery          | Test mocks                             |
