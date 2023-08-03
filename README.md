Sure! Here's a README.md file written in Markdown for the Postman documentation JSON file provided:

# Postman API Documentation

This repository contains the Postman API documentation for the project. The API provides endpoints to manage contacts, user profiles, favorites, and search records. The authentication type used in this API is bearer token.

## Endpoints

### Contacts

#### Get All Contacts

-   **Request Method**: GET

    ```
    http://127.0.0.1:8000/api/v1/contact

    ```

#### Get Single Contact

-   **Request Method**: GET
    ```
     http://127.0.0.1:8000/api/v1/contact/1
    ```

#### Create Contact

-   **Request Method**: POST

```
http://127.0.0.1:8000/api/v1/contact

```

## form data

| Arguments      | Type     | Description              |
| :------------- | :------- | :----------------------- |
| `name`         | `string` | **Required** myominnaing |
| `country_code` | `string` | **Required** 65          |
| `phone_number` | `string` | **Required** 09420797530 |

#### Update Contact

-   **Request Method**: PUT

```
http://127.0.0.1:8000/api/v1/contact/6

```

## form data

| Arguments      | Type     | Description              |
| :------------- | :------- | :----------------------- |
| `name`         | `string` | **Required** ktth        |
| `country_code` | `string` | **Required** 65          |
| `phone_number` | `string` | **Required** 09448521517 |

#### Delete Contact

-   **Request Method**: DELETE

```
http://127.0.0.1:8000/api/v1/contact/2

```

### User Profile

#### User Logout

-   **Request Method**: POST

```
http://127.0.0.1:8000/api/v1/logout

```

#### User Logout All Sessions

-   **Request Method**: POST

```
 http://127.0.0.1:8000/api/v1/logout-all

```

### Favorites

#### Add Contact to Favorites

-   **Request Method**: POST

```
 http://127.0.0.1:8000/api/v1/favorite

```

## form data

| Arguments    | Type     | Description    |
| :----------- | :------- | :------------- |
| `contaci_id` | `string` | **Required** 3 |

#### Remove Contact from Favorites

-   **Request Method**: DELETE

```
http://127.0.0.1:8000/api/v1/favorite/8

```

#### Get All Favorites

-   **Request Method**: GET

```
 http://127.0.0.1:8000/api/v1/favorite

```

### Search Records

#### Search Records by User

-   **Request Method**: GET

```
http://127.0.0.1:8000/api/v1/search-record

```

#### Search Users by Keyword

-   **Request Method**: GET

```
http://127.0.0.1:8000/api/v1/search-record/tel

```

## Base URL

The base URL for all API requests is: `http://127.0.0.1:8000/api/v1/`

## User Registration

### Endpoint: POST /register

Register a new user with the Lara Contact API.

#### Request Headers

-   Authorization: Bearer Token

#### Request Body

-   Content Type: form-data

| Key                   | Value                 |
| --------------------- | --------------------- |
| name                  | myominnaing           |
| email                 | myominnaing@gmail.com |
| password              | asdfasdf              |
| password_confirmation | asdfasdf              |

#### Example

```http
POST http://127.0.0.1:8000/api/v1/register
Content-Type: application/json
Authorization: Bearer <your_access_token>

form-data:
name: myominnaing
email: myominnaing@gmail.com
password: asdfasdf
password_confirmation: asdfasdf
```

### Response

Upon successful registration, the API will respond with a success message and the user details.

## User Login

### Endpoint: POST /login

Authenticate a user and retrieve an access token for subsequent API requests.

#### Request Headers

-   Authorization: Bearer Token

#### Request Body

-   Content Type: form-data

| Key      | Value                 |
| -------- | --------------------- |
| email    | myominnaing@gmail.com |
| password | asdfasdf              |

#### Example

```http
POST http://127.0.0.1:8000/api/v1/login
Content-Type: application/json
Authorization: Bearer <your_access_token>

form-data:
email: myominnaing@gmail.com
password: asdfasdf
```

### Response

Upon successful login, the API will respond with an access token, which can be used as a Bearer Token for authorization in subsequent requests.

## Authorization

To authorize your requests, you need to include the access token obtained during login in the `Authorization` header as follows:

```http
Authorization: Bearer <your_access_token>
```

Remember to replace `<your_access_token>` with the actual access token obtained from the login response.

Please note that these examples assume that the API is running locally at `http://127.0.0.1:8000`. Make sure to update the base URL if the API is hosted elsewhere.

Ensure to handle errors gracefully and follow any additional documentation provided by the Lara Contact API for advanced functionalities or specific error responses.

That concludes the documentation for the Lara Contact API user registration and login endpoints. Happy coding!
