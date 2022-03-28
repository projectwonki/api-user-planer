# About Requirement

i use the requirements :

PHP: php7.4 <br />
Laravel: v8.75 <br />
auth library: Laravel JWT by Tymon <br />

## About API

I build simple RESTFULL API for Users who want to make list for their plan trip. this API include User Authentication using Json Web Token (JWT) and also with some input validation. I write some simple test for these API too (you can read more details about testing at below section). The endpoints as follows:

Authentication:
- [POST] Register /api/auth/register.
- [POST] Login /api/auth/login.
- [POST] Logout /api/auth/logout.

User Plan:
- [GET] User Plan /api/user/plan.
- [GET] User Plan Detail /api/user/plan/1.
- [POST] Create Plan /api/user/plan.
- [PUT] Update Plan /api/user/plan/1.
- [DELETE] Delete Plan /api/user/plan/1.

I use cache to store user plan data list at endpoint User Plan. the cache will improve the performance to show the API response as long as there is no new data. when there is a new data, cache will be forget and the result will show a new one.

if you want to test this API in your local. please follow these steps :

1. git clone https://github.com/projectwonki/api-user-planer.git
2. input your github username & password (if success, continue to step 3, if failed, back to step 2)
3. cd {your target repo path}
4. run composer install
5. run cp .env.example .env
6. setup your .env
7. run php artisan migrate
8. run php artisan jwt:secret
9. done

I provide Postman Collection that you can find at path folder /tests.

I also provide Public IP URL (i deployed this API in my public VPS). So, you can check and test it with postman collection without testing in your local. you just only change {{trutrip_domain}} at every endpoints with this : <br />

Public IP URL : http://103.174.115.179/index.php <br />
for example : http://103.174.115.179/index.php/api/auth/register <br />

or, you can register the Public IP URL at Postman Global Environment using this setup : <br />
VARIABLE: {trutrip_domain}} <br />
INITIAL VALUE: http://103.174.115.179/index.php <br />
CURRENT VALUE: http://103.174.115.179/index.php <br />

before test, please make sure the Public IP URL registered in Global Environment at Postman.

for the Publis IP URL itself, i don't have some domain for make it easy to remember and i do not setup some secure HTTPS because the limitation of time.

i think with User Authentication (using JWT) and some validation is quitely enough to make data more secure.

## About Testing

i created some simple test for User Authentication and also for User Plan. to run the test in your local. please follow these steps:

1. run cp .env .env.testing
2. before you setup the database at .env.testing, please create some database for testing with same data from the origin database
3. setup database connection at .env.testing (make sure that this testing connection is match with your testing database)
4. run php artisan --env=testing migrate
5. run php artisan --env=testing jwt:secret
2. run composer test
