# Contact App API

## API Reference

##` Login (Post)`

```http
 {{lara_contact_base_url}}/login?
```

## Body <small>form-data</small>

| Arguments  | Type     | Description                   |
| :--------- | :------- | :---------------------------- |
| `email`    | `string` | **Required** zawzaw@gmail.com |
| `password` | `string` | **Required** asdffdsa         |

<!--  -->

## `Register (Post)`

```http
  {{lara_contact_base_url}}/register
```

## Request Header

Accept ------------------------application/json

## Body <small>form-data</small>

| Arguments               | Type     | Description                    |
| :---------------------- | :------- | :----------------------------- |
| `name`                  | `string` | **Required** example           |
| `email`                 | `string` | **Required** example@gmail.com |
| `password`              | `string` | **Required** asdffdsa          |
| `password_confirmation` | `string` | **Required** asdffdsa          |

<!--  -->

## `Get Contacts (Get)`

```http
 {{lara_contact_base_url}}/contact
```

## `Authorization` <small>Bearer Token</small>

This request is using an authorization helper from collection [lara-contact-api](https://lara-contact.com)

<!--  -->

## `Get Single Contact (Get)`

```http
 {{lara_contact_base_url}}/contact/{id}
```

### `Authorization` <small>Bearer Token</small>

---

This request is using an authorization helper from collection [lara-contact-api](https://lara-contact.com)

<!--  -->

## `Create Contact(POST)`

```http
 {{lara_contact_base_url}}/contact
```

## `Authorization` <small>Bearer Token</small>

This request is using an authorization helper from collection [lara-contact-api](https://lara-contact.com)

| Arguments      | Type      | Description              |
| :------------- | :-------- | :----------------------- |
| `name`         | `string`  | **Required** myominnaing |
| `country_code` | `integer` | **Required** +95         |
| `phone_number` | `string`  | **Required** 09420797535 |

<!--  -->

### `Update Contact(PUT)`

```http
 {{lara_contact_base_url}}/contact/{id}
```

## `Authorization` <small>Bearer Token</small>

This request is using an authorization helper from collection [lara-contact-api](https://lara-contact.com)

## `You can update with only singe Parameter or more`

## Body <small>form-data</small>

| Arguments      | Type      | Description              |
| :------------- | :-------- | :----------------------- |
| `name`         | `string`  | **nullable** myominnaing |
| `country_code` | `integer` | **nullable** +95         |
| `phone_number` | `string`  | **nullable** 09420797535 |

<!--  -->

### `Delete Contact (DELETE)`

```http
  {{lara_contact_base_url}}/contact/{id}
```

### Get User devices (GET)

```http
  https://contact-app.mms-it.com/api/v1/user-devices
```

### `Logout (POST)`

```http
   {{lara_contact_base_url}}/logout
```

### `LogoutAll (POST)`

```http
   {{lara_contact_base_url}}/logout-all
```
