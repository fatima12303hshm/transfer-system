<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Transpoint Server

# Table's Values:

# User Data


INSERT INTO `users` (`id`, `name`, `qr_code`, `balance`, `created_at`, `updated_at`) VALUES
(1, 'Rayan Hashem', '12025-01-12 14:53:26.967621', 35, NULL, '2025-01-12 10:53:34'),
(2, 'Fatima Hashem', '22025-01-12 14:56:54.645548', 8, NULL, '2025-01-12 10:57:02'),
(3, 'Ali Hashem', '32025-01-12 15:11:56.566049', 10, NULL, '2025-01-12 11:12:04'),
(4, 'Nour Hashem', NULL, 10, NULL, NULL);


# Transaction Data




INSERT INTO `transactions` (`id`, `amount`, `sender_id`, `receiver_id`, `created_at`, `updated_at`) VALUES
(3, 5, 2, 1, '2025-01-11 23:45:04', '2025-01-11 23:45:04'),
(4, 5, 2, 1, '2025-01-11 23:45:30', '2025-01-11 23:45:30'),
(5, 5, 3, 1, '2025-01-11 23:48:48', '2025-01-11 23:48:48'),
(6, 1, 3, 1, '2025-01-12 00:04:36', '2025-01-12 00:04:36'),
(7, 3, 2, 1, '2025-01-12 09:12:51', '2025-01-12 09:12:51'),
(8, 3, 2, 1, '2025-01-12 09:50:52', '2025-01-12 09:50:52'),
(9, 3, 2, 1, '2025-01-12 09:57:41', '2025-01-12 09:57:41'),
(10, 2, 2, 3, '2025-01-12 10:06:22', '2025-01-12 10:06:22'),
(11, 1, 2, 3, '2025-01-12 10:07:15', '2025-01-12 10:07:15'),
(12, 1, 2, 3, '2025-01-12 10:07:21', '2025-01-12 10:07:21'),
(13, 2, 2, 3, '2025-01-12 10:18:56', '2025-01-12 10:18:56');




# API Documentation

baseURL= "http:your_domain:8000/api/"

# User Management

# Login User

Endpoint: POST /login

Description
Authenticate a user by their id.

Request: 

{
    "id":2   
}

Response:

Success (200)

{
    "status": "success",
    "message": "User Authenticated Successfully",
    "data": {
        "id": 2,
        "name": "Fatima Hashem",
        "balance": 8,
        "qr_code": "22025-01-12 14:56:54.645548"
    }
}

Validation Error (422)

{
  "success": false,
  "message": "Validation errors occurred.",
  "errors": {
    "id": ["The id field is required."]
  }
}

User Not Found (404)
json
Copy code
{
  "error": "User Not Found"
}


# Generate QR Code

Endpoint: PATCH user/generate-qr

Description
Update the QR code for the logged-in user.

Request
Headers
user_id: The ID of the authenticated user.

Body (JSON)

{
    "code":"42025-01-12 14:56:54.645548"
}

Response: 

Success (200)
{
    "status": "success",
    "message": "QR code updated successfully"
}


Validation Error (422)

{
  "success": false,
  "message": "Validation errors occurred.",
  "errors": {
    "code": ["The code field is required.", "The code has already been taken."]
  }
}

Unauthorized (401)

{
  "error": "unauthenticated"
}

# Get User Data

Endpoint: GET user/get-user-data

Description
Retrieve the logged-in user's data.

Request
Headers
user_id: The ID of the authenticated user.

Response

Success (200): 

{
    "status": "success",
    "message": "User data fetched",
    "data": {
        "id": 4,
        "name": "Nour Hashem",
        "balance": 10,
        "qr_code": "42025-01-12 14:56:54.645548"
    }
}

{
  "status": "success",
  "message": "User data fetched",
  "data": {
    "id": 1,
    "name": "John Doe",
    "balance": 10,
    "qr_code": "user-qr-code"
  }
}


Unauthorized (401)
 
{
  "error": "User not authenticated"
}


#

# Transaction Management

# Fetch User Transactions
Endpoint GET user/transactions

Description
Retrieve all transactions associated with a user, separated into sent and received transactions.

Request
Headers
user_id (required): The ID of the authenticated user.


Response
Success (200)

{
    "status": "success",
    "data": {
        "sent": [
            {
                "id": 1,
                "amount": 1,
                "sender_id": 3,
                "receiver_id": 2,
                "created_at": "2025-01-11T02:22:59.000000Z",
                "updated_at": null,
                "name": "Fatima Hashem"
            },
            {
                "id": 5,
                "amount": 5,
                "sender_id": 3,
                "receiver_id": 1,
                "created_at": "2025-01-12T01:48:48.000000Z",
                "updated_at": "2025-01-12T01:48:48.000000Z",
                "name": "Rayan Hashem"
            },
            {
                "id": 6,
                "amount": 1,
                "sender_id": 3,
                "receiver_id": 1,
                "created_at": "2025-01-12T02:04:36.000000Z",
                "updated_at": "2025-01-12T02:04:36.000000Z",
                "name": "Rayan Hashem"
            }
        ],
        "received": [
            {
                "id": 10,
                "amount": 2,
                "sender_id": 2,
                "receiver_id": 3,
                "created_at": "2025-01-12T12:06:22.000000Z",
                "updated_at": "2025-01-12T12:06:22.000000Z",
                "name": "Fatima Hashem"
            },
            {
                "id": 11,
                "amount": 1,
                "sender_id": 2,
                "receiver_id": 3,
                "created_at": "2025-01-12T12:07:15.000000Z",
                "updated_at": "2025-01-12T12:07:15.000000Z",
                "name": "Fatima Hashem"
            },
            {
                "id": 12,
                "amount": 1,
                "sender_id": 2,
                "receiver_id": 3,
                "created_at": "2025-01-12T12:07:21.000000Z",
                "updated_at": "2025-01-12T12:07:21.000000Z",
                "name": "Fatima Hashem"
            },
            {
                "id": 13,
                "amount": 2,
                "sender_id": 2,
                "receiver_id": 3,
                "created_at": "2025-01-12T12:18:56.000000Z",
                "updated_at": "2025-01-12T12:18:56.000000Z",
                "name": "Fatima Hashem"
            }
        ]
    }
}

Unauthenticated User (401)
 
{
  "error": "unauthenticated"
}

# Transfer Points

Endpoint: POST user/transfer-balance

Description
Transfer points from one user to another based on the recipient's QR code.

Request
Headers
user_id (required): The ID of the sender.
Body (JSON)

{
    "code":"42025-01-12 14:56:54.645548", 
    "amount": 6
}

Response:

Success (201):
{
    "status": "success",
    "message": "points transferred successfully"
}


Validation Error (422)

{
  "error": {
    "code": ["The code field is required.", "The selected code is invalid."],
    "amount": ["The amount must be at least 1."]
  }
}

Missing User ID (400)

{
  "error": "user id is required"
}

Unauthenticated User (401)
 
{
  "error": "unauthenticated"
}
 
Receiver Not Found (404)
 
{
  "error": "receiver not found"
}
Insufficient Balance (422)
 
{
  "error": "Insufficient balance"
}
Same User Transaction (422)
 
{
  "error": "Cannot transfer to the same user"
}
