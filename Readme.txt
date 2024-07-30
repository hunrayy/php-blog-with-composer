Blog API
This project is a blog API that incorporates mailing and file uploads to Cloudinary.

Features
User authentication and authorization
admin can Create, read, update, and delete blog posts
admin can Manage categories
admin can Upload images to Cloudinary
upon user registration, a welcome mail is received

Technologies Used
PHP
MySQL
Cloudinary
PHPMailer
Dotenv
composer

to make a clone of this code,
go to bash terminal and type
git clone https://github.com/hunrayy/php-blog-with-composer.git

Navigate to the project directory and type:
composer install

Create a .env file and add your configuration:

env
Copy code
DB_HOST=your_db_host
DB_USER=your_db_user
DB_PASSWORD=your_db_password
DB_NAME=your_db_name

CLOUDINARY_CLOUD_NAME=your_cloudinary_cloud_name
CLOUDINARY_API_KEY=your_cloudinary_api_key
CLOUDINARY_API_SECRET=your_cloudinary_api_secret

SMTP_HOST=your_smtp_host
SMTP_PORT=your_smtp_port
SMTP_USERNAME=your_smtp_username
SMTP_PASSWORD=your_smtp_password

Set up the database:
import data.sql into your mysql database

API Endpoints(users)

Authentication
POST /api/register.php (firstname, lastname, email, password): Register a new user upon which a welcome mail is gotten
POST /api/login.php(email, password): Login a user

Blog Posts
GET /api/getBlogs.php: Get all posts

API Endpoints(admins)
POST /api/createBlog.php($authorEmail, $noteTitle, $noteContent, $image, $noteCategory): Create a new post
GET /api/getBlogs.php: Get all blogs
GET /api/categories: Get all categories

Mailing Service
The API supports sending emails using PHPMailer. Ensure your SMTP settings are correctly configured in the .env file.

File Uploads
The API integrates with Cloudinary for image uploads. Ensure your Cloudinary credentials are set in the .env file.