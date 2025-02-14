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

## Methodology

This API segregates reading and writing concerns to keep the write and the read models completely independent from each other.

The Read module has little to no abstraction, since most queries (or in this system, all of them) contain no business logic and are highly coupled with the user interface's needs.

The Write module follows the principles of the Onion Architecture, ensuring loosely coupled layers to promote adaptability and scalability.

- The Domain layer contains the business logic and enforces model invariants. It uses an ubiquitous language aligned with the assignment's requirements.
- The Infrastructure layer manages access to external dependencies, such as the MySQL database.
- The application layer orchestrates the operations, ensuring business rules (Domain layer) are being applied before persisting the data to the database (Infrastructure layer)

Additionally; 

- The `src/app/Registration` folder contains a Presentation folder, which includes controllers and request objects.

- Shared resources required for the API's functionality are located in the `src/app/Shared` folder.

## Technologies Used

| Technology used  | Reason                                 |
| ---------------- | -------------------------------------- |
| Laravel 11       | Backend PHP framework                  |
| MySQL            | Database                               |
| PHPStan          | Static code analysis                   |
| PHPUnit          | Unit, Integration and End-to-end tests |
| Mockery          | Test mocks                             |
