# Symposium API v1

### Resources

Type                              | Resource                                                                    | Description
----------------------------------|-----------------------------------------------------------------------------|------------
[User Talks](#talk)               | [GET /api/users/:id/talk](#talks)                                           | Talks for authenticated user
[Talk](#talk)                     | [GET /api/talk/:id](#talk)                                                  | Talk information
[User Bios](#bios)                | [GET /api/users/:id/bios](#bios)                                            | Bios for authenticated user
[Bio](#bio)                       | [GET /api/bios/:id](#bio)                                                   | Bio information
[Me](#me)                         | [GET /api/me](#me)                                                          | Information about authenticated user

### General API Guidelines

**Encoding**

All data sent to and from the API should be encoded as UTF-8.

**Dates and DateTimes**

Unless specified otherwise, all Dates and DateTime strings sent to and from the
API will be sent in (? @todo);

### Authentication / Signing
@todo

### Pagination
@todo

## ERROR
@todo

## TALKS

A listing of all talks for the authenticated user.

##### REQUEST

```
GET /api/users/:id/talks
```

##### RESPONSE

```json
{
  "data": [
    {
      "type": "talks",
      "id": "d426e5f8-cf65-42bc-bb00-9da9b5606a2d",
      "attributes": {
        "title": "My great talk",
        "description": "Description of the talk",
        "created_at": "2013-11-29 15:54:41",
        "updated_at": "2015-05-31 10:48:38",
        "type": "seminar",
        "length": 45,
        "level": "intermediate",
        "outline": "Talk outline",
        "organizer_notes": "Organizer notes"
      }
    },
    {
      "type": "talks",
      "id": "d8db8693-7948-4476-b098-d22e003d8c54",
      "attributes": {
        "title": "My terrible talk",
        "description": "Description of the talk",
        "created_at": "2013-11-29 15:54:41",
        "updated_at": "2015-05-31 10:48:38",
        "type": "seminar",
        "length": 45,
        "level": "intermediate",
        "outline": "Talk outline",
        "organizer_notes": "Organizer notes"
      }
    }
  ]
}
```

### TALK

Information about a talk.

##### REQUEST

```
GET /api/talks/:id
```

##### RESPONSE

```json
{
  "data": {
    "type": "talks",
    "id": "d426e5f8-cf65-42bc-bb00-9da9b5606a2d",
    "attributes": {
      "title": "My great talk",
      "description": "Description of the talk",
      "created_at": "2013-11-29 15:54:41",
      "updated_at": "2015-05-31 10:48:38",
      "type": "seminar",
      "length": 45,
      "level": "intermediate",
      "outline": "Talk outline",
      "organizer_notes": "Organizer notes"
    }
  }
}
```

## BIOS

A listing of all bios for the authenticated user.

##### REQUEST

```
GET /api/users/:id/bios
```

##### RESPONSE

```json
{
  "data": [
    {
      "type": "bios",
      "id": "0603a7d7-63e8-4ae1-9f38-760564d2049e",
      "attributes": {
        "nickname": "Long Bio",
        "body": "I am short and I love being short and this is very long.",
        "created_at": "2015-05-31 10:48:38",
        "updated_at": "2015-05-31 10:48:38"
      }
    },
    {
      "type": "bios",
      "id": "2cb86717-cf08-499d-b6aa-f2463200f9c2",
      "attributes": {
        "nickname": "Short Bio",
        "body": "I am short.",
        "created_at": "2015-05-31 10:48:38",
        "updated_at": "2015-05-31 10:48:38"
      }
    }
  ]
}
```

## BIO

Information about a bio.

##### REQUEST

```
GET /api/bios/:id
```

##### RESPONSE

```json
{
  "data": {
    "type": "bios",
    "id": "0603a7d7-63e8-4ae1-9f38-760564d2049e",
    "attributes": {
      "nickname": "Long Bio",
      "body": "I am short and I love being short and this is very long.",
      "created_at": "2015-05-31 10:48:38",
      "updated_at": "2015-05-31 10:48:38"
    }
  }
}
```

## ME
Information about the currently authenticated user.

##### REQUEST

```
GET /api/me
```

##### RESPONSE

```json
{
  "data": {
    "type": "users",
    "id": 1,
    "attributes": {
      "email": "matt@symposiumapp.com",
      "first_name": "Matt",
      "last_name": "Stauffer",
      "created_at": "2015-05-31 10:48:38",
      "updated_at": "2015-05-31 10:48:38"
    }
  }
}
```
