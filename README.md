# community_API


## Introduction
Provide a brief introduction to your API, its purpose, and what it enables developers to achieve.

## Authentication
Explain how authentication works for accessing your API endpoints. Include details about any required headers, tokens, or authentication methods.

## Endpoints
List all the endpoints available in your API along with their purpose and any required parameters.

- `USER /register`: Register a new user.
- `USER /login`: Log in to the system.
- `GET /profile`: Get user profile information.
- `USER /refresh`: Refresh authentication token.
- `USER /logout`: Log out from the system.
- `GET /posts`: Retrieve a list of posts.
- `POST /posts`: Create a new post.
- `GET /posts/{id}`: Retrieve a specific post.
- `PUT /posts/{id}`: Update a specific post.
- `DELETE /posts/{id}`: Delete a specific post.
- `POST /image`: Upload an image for a post.
- `GET /post/{id}/comments`: Retrieve comments for a specific post.
- `GET /post/{id}/likes`: Retrieve likes for a specific post.
- `GET /comments`: Retrieve a list of comments.
- `POST /comments`: Create a new comment.
- `GET /comments/{id}`: Retrieve a specific comment.
- `PUT /comments/{id}`: Update a specific comment.
- `DELETE /comments/{id}`: Delete a specific comment.
- `GET /likes`: Retrieve a list of likes.
- `POST /likes`: Create a new like.
- `GET /likes/{id}`: Retrieve a specific like.
- `DELETE /likes/{id}`: Delete a specific like.

## Request and Response Examples
POST /register
Content-Type: application/json

{
  "name": "mamhabur",
  "email": "mahababu@.com",
  "password": "secretpassword"
}
## Responce
HTTP/1.1 200 OK
Content-Type: application/json

{
  "message": "Successfully registered",
  "status_code": 200,
  "token_type": "Bearer",
  "expires_in": 3600,
  "token": "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9...",
  "user": {
    "id": 1,
    "name": mamhabur",
    "email": "mamhabur@.com",
    "created_at": "2024-03-05T12:00:00Z",
    "updated_at": "2024-03-05T12:00:00Z"
  }
}


## Error HandlingDescribe how errors are handled in your API, including status codes, error messages, and error response formats.
{
  "status": "error",
  "status_code": 500,
  "message": "Error message detailing the issue"
}



## Examples of Use
Show some examples of how developers can use your API in their applications.

## Conclusion
Wrap up your documentation with any additional information or resources that may be helpful for developers using your API.
