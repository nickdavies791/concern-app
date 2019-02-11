# Concerns

An app built in Laravel to record and manage safeguarding concerns for schools.

## Installation

Clone the repo and install project dependencies:-

```bash
$ git clone https://github.com/nickdavies791/concern-app
$ npm install
$ composer install
```

## Configuration

Rename `.env.example` to `.env` and run the following command to set up the key used for encryption:-
```bash
$ php artisan key:generate
```

Open the `.env` file and configure the file to use your own information.

Run the following command to perform the initial setup:-
```bash
$ php artisan concerns:setup
``````

**Note:** You can run the commands individually. See below for the description of what each command does.

| Artisan Command              | Description                                                                   |
|------------------------------|-------------------------------------------------------------------------------|
| `php artisan concerns:setup` | Runs all commands below.                                                      |
| `php artisan migrate:fresh`  | Creates all tables in the database.                                           |
| `php artisan admin:create`   | Creates a default admin user.                                                 |
| `php artisan roles:create`   | Creates all of the roles. See [Roles and Permissions](#roles-and-permissions) |
| `php artisan tags:create`    | Creates the default tags. See [Tagging a Concern](#tagging-a-concern)         |
| `php artisan groups:create`  | Creates the default groups. See [Creating Groups](#creating-groups)           |

The default admin details are:-
```bash
Username: admin@admin.com
Password: secret
```

## Sync Data From SIMS
Concerns app allows you to sync your data directly from SIMS using the Assembly API. To sync your data, log into the application using an admin account. 

```
**Note:** Before authorising and syncing data, ensure your database does not have dummy data.
```

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

| Role ID | Role Name    | Usage                     | Documents            | Students | Concerns                                  | Comments                             | Groups                       |
|---------|--------------|---------------------------|----------------------|----------|-------------------------------------------|--------------------------------------|------------------------------|
| 1       | User         | `$user->isUser()`         | view                 | none     | none                                      | none                                 | none                         |
| 2       | Staff        | `$user->isStaff()`        | view                 | view     | view shared, view own, create, update own | view all, create, update own         | view                         |
| 3       | Safeguarding | `$user->isSafeguarding()` | view, create, delete | view     | view all, create, update all              | view all, create, update own         | view, create, update, delete |
| 4       | Admin        | `$user->isAdmin()`        | view, create, delete | sync     | view all, create, update all, delete      | view all, create, update all, delete | view, create, update, delete |

### Tagging a Concern
You can assign a concern with a specific set of tags to better understand all of your logged concerns and to help with reporting. 

The default tags are:-

 | ID | Tag                       |
|----|---------------------------|
| 1  | Domestic Abuse            |
| 2  | Sexual Abuse              |
| 3  | Neglect                   |
| 4  | Welfare                   |
| 5  | Physical Abuse            |
| 6  | Emotional Abuse           |
| 7  | Child Sexual Exploitation |
| 8  | Female Genital Mutilation |
| 9  | Bullying                  |
| 10 | Cyberbullying             |
| 11 | Injury                    |
| 12 | Mental Health             |
| 13 | Behaviour                 |

### Creating Groups

The default groups are:-

| ID | Name              |
|----|-------------------|
| 1  | All Staff         |
| 2  | Attendance        |
| 3  | Behavioural       |
| 4  | Learning Support  |
| 5  | Safeguarding      |
| 6  | Senior Leadership |
| 7  | Year Leads        |


## Notes

### Assembly Education  
This app uses the Assembly API by Assembly. [https://assembly.education](https://assembly.education) to authorise with SIMS and retrieve related data. The following data is pulled from SIMS using Assembly for this application:-

| Scope                           | Description                                                  |
|---------------------------------|--------------------------------------------------------------|
| `students.photo`                | The photo of the student                                     |
| `students.ever_in_care`         | The ever_in_care status of the student                       |
| `students.siblings`             | The siblings of the student                                  |
| `students.sen_needs`            | The SEN needs of the student                                 |
| `students.sen_provision`        | The SEN category for the student                             |
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