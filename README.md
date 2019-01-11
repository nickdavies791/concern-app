# Concerns

An app built in Laravel to record and manage safeguarding concerns for schools.

## Installation

Clone the repo and install project dependencies:-

```bash
$ git clone https://github.com/nickdavies791/concern-app
$ npm install
$ composer install
```

In the following file `vendor\assembly-edu\assembly-client-php\src\Assembly\Client\Configuration.php` change this section to the following:-

```php
/**
* The host
*
* @var string
*/
protected $host = 'https://api.assembly.education';
```

## Configuration
Run the following command to generate a unique application key:-
```bash
$ php artisan key:generate
```

Rename `.env.example` to `.env` and configure the file to use your own information and keys. For example:-

```php
APP_NAME= // Your school name
APP_URL= // Location you installed the app
...
```

Run the following command to import tables into your database:-
```bash
$ php artisan migrate:fresh
```
## Sync Data From SIMS
##### Default Admin Account:
```php
Username: admin@admin.com
Password: secret
```
Concerns app allows you to sync your data directly from SIMS using the Assembly API. To sync your data, log into the application using an admin account. 

**Note:** Before authorising and syncing data from SIMS, ensure your database does not have dummy data present.

#### Authorising Assembly

In Settings, select the **'Authorise'** button. Log into your Assembly account to authorise the Concerns app with your account. Once authorised, you will be redirected back to the Concerns settings page.

![Authorising Assembly](/screenshots/Authorise-Assembly.gif "Authorising Assembly")

#### Sync Staff and Students

In Settings, select the **'Sync Students'** or **'Sync Staff'** button to sync your students from SIMS to the Concerns app. The sync may take a while depending on the data stored in your SIMS.

![Syncing Students and Staff](/screenshots/Sync-Student.gif "Syncing Students and Staff")



## Features

### Including a Body Map
Staff can support their written concerns by including a body map, identifying areas on the student which show physical marks/bruises or injuries. To do this, you can select **'Include a Body Map'** when creating a new concern or updating an existing concern. Simply click on the areas that you want to highlight and each point will be recorded and numbered.

![Include a Body Map](/screenshots/Body-Map.gif "Include a Body Map")

### Roles and Permissions

The following roles exist in Concerns app:-

| Role ID | Role Name   | Usage                  | Policies             | Students | Concerns                             | Comments                             | Groups                       |
|---------|-------------|------------------------|----------------------|----------|--------------------------------------|--------------------------------------|------------------------------|
| 1       | User        | `$user->isUser()`        | view                 | none     | none                                 | none                                 | none                         |
| 2       | Contributor | `$user->isContributor()` | view                 | view     | view own, create, update own         | view all, create, update own         | view                           |
| 3       | Editor      | `$user->isEditor()`      | view, create, delete | view     | view all, create, update all         | view all, create, update own         | view, create, update, delete |
| 4       | Admin       | `$user->isAdmin()`       | view, create, delete | sync     | view all, create, update all, delete | view all, create, update all, delete | view, create, update, delete |



## Notes

### Assembly Education  
This app uses the PHP SDK for the Assembly API by Assembly. [https://github.com/assembly-edu/assembly-client-php ](https://github.com/assembly-edu/assembly-client-php) to connect to SIMS and retrieve staff and student information. The following data is pulled from SIMS using Assembly for this application:-

| Scope                         | Description                                                  |
|-------------------------------|--------------------------------------------------------------|
| `students.photo`                |  The photo of the student                                    |
| `students.basic`                | The basic student information (e.g. Forename, Surname, Year) |
| `students.middle_names`         | The middle names of students                                 |
| `students.legal_names`          | The legal names of the students                              |
| `students.former_names`         | The former names of the students                             |
| `students.upn`                  | The unique pupil numbers of the students                     |
| `students.former_upn`           | Any former unique pupil numbers of the students              |
| `students.dates`                | The start and end dates of the students                      |
| `students.dob`                  | The date of birth of the students                            |
| `students.enrolment_status`     | The enrolment status of the students                         |
| `students.pan`                  | The pupil admission number of the students                   |
| `students.mis_id`               | The unique MIS identifier for the students                   |
| `staff_members.basic`           | The basic staff information e.g. (Staff code, name, title)   |
| `staff_members.emails`          | The email address of the staff member                        |
| `staff_members.teaching_status` | The current teaching status of the staff member              |

### Themes

Argon Dashboard Theme by [@creativetim](https://twitter.com/creativetim) - [https://www.creative-tim.com/product/argon-dashboard ](https://www.creative-tim.com/product/argon-dashboard)