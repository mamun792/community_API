# community_API


## Introduction
Welcome to the Community Car API! This API serves as a platform for community members to share information about car-related topics, including posts, comments, and likes.

Our API enables developers to:

- Register and authenticate users.
- Create, read, update, and delete posts.
- Upload images for posts.
- Add, view, and delete comments on posts.
- Like and unlike posts.
- Access user profiles and manage authentication tokens.

## Authentication
The Community Car API uses Laravel Passport for authentication. Passport provides a full OAuth2 server implementation for securing your API.

### Authentication Flow

1. **User Registration**: To access protected endpoints, users need to register for an account using the `/register` endpoint. This endpoint requires the user to provide a name, email, and password. Upon successful registration, the API returns an access token.

2. **User Login**: Registered users can log in to the system using the `/login` endpoint. They need to provide their email and password. Upon successful login, the API returns an access token.

3. **Access Token**: Access tokens are required to authenticate requests to protected endpoints. They should be included in the `Authorization` header of the HTTP request with the value `Bearer <access_token>`.

4. **Token Refresh**: Access tokens have a limited lifespan. When an access token expires, users can use the `/refresh` endpoint to obtain a new access token without needing to log in again.

5. **Logout**: To log out from the system and invalidate the access token, users can use the `/logout` endpoint.

### Required Headers

- `Authorization`: This header is required for accessing protected endpoints. It should contain the access token in the format `Bearer <access_token>`.

### Example Usage

```http
POST /login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "secretpassword"
}

## Endpoints
List all the endpoints available in your API along with their purpose and any required parameters.

POST /register: Register a new user.
POST /login: Log in to the system.
GET /profile: Get user profile information.
POST /refresh: Refresh authentication token.
POST /logout: Log out from the system.
GET /posts: Retrieve a list of posts.
POST /posts: Create a new post.
GET /posts/{id}: Retrieve a specific post.
PUT /posts/{id}: Update a specific post.
DELETE /posts/{id}: Delete a specific post.
POST /image: Upload an image for a post.
GET /posts/{id}/comments: Retrieve comments for a specific post.
GET /posts/{id}/likes: Retrieve likes for a specific post.
GET /comments: Retrieve a list of comments.
POST /comments: Create a new comment.
GET /comments/{id}: Retrieve a specific comment.
PUT /comments/{id}: Update a specific comment.
DELETE /comments/{id}: Delete a specific comment.
GET /likes: Retrieve a list of likes.
POST /likes: Create a new like.
GET /likes/{id}: Retrieve a specific like.
DELETE /likes/{id}: Delete a specific like

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
## Conclusion

Thank you for exploring the Community Car API! We hope that this documentation has provided you with all the information you need to get started integrating our API into your applications.

If you encounter any issues, have questions, or would like to provide feedback, please feel free to reach out to us:

- **Email**: support@communitycarapi.com
- **GitHub Issues**: [Open an issue](https://github.com/mamun792/community_API/issues)

We're continuously working to improve our API and provide the best experience for our users. Your input is invaluable to us in this process.

Happy coding!

