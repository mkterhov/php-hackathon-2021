# PHP Hackathon
This document has the purpose of summarizing the main functionalities your application managed to achieve from a technical perspective. Feel free to extend this template to meet your needs and also choose any approach you want for documenting your solution.



## Technical documentation
### Run the aplication
```
composer install && npm install
npm run migrate:db 
php artisan serve
```


### Data and Domain model
![DB Schema](/docs/images/db.png)



I used 5 entities. **Programme**: represent the events,**User**: for the admins, **Booking**: the reservations for the events, **Room**: to keep track of the rooms, and **Type**: for the type of the events
### Application architecture
###  Implementation
In terms of implementation the API allows an to Create a programme, delete a programme, view both a single programme and all of them in a list. 
The endpoint for the creation of a booking allows access to register to a programme. 

##### Functionalities
For each of the following functionalities, please tick the box if you implemented it and describe its input and output in your application:
```

[x] Create programme => POST api/programmes

example: POST http://127.0.0.1:8000/api/programmes 
body: {
    "api_token":"nMLxcTS0P05ascNfVMv6Mg85KoXrNrD8F8FyK3WUAe4HgdJeBkBCddHw1YzC",
    "user_id": 1,
    "title": "A test program",
    "type_id": 1,
    "capacity": 0,
    "start_time": "2021-04-18 21:00:00",
    "end_time": "2021-04-18 22:30:00",
    "room_id": 1
}
returns newly created programme

[x] Delete programme => DELETE api/programmes/{programme}
example: POST http://127.0.0.1:8000/api/programmes/1 

returns the programme that was deleted

[x] Book a programme => POST api/bookings
example: POST http://127.0.0.1:8000/api/bookings 
body:
{
    "name": "John Smith",
    "email": "johnsmith@email.com",
    "programme_id": 1,
    "cnp": "6210415018286"
}
returns the created booking

```

##### Business rules
**Programme**: \
    *store*: check whether api-token is provided and if it is correct, validate the inputs given in the request, check if the room requested exists, check if between the datetimes given for the event the room specified is not occupied and then proceed to creating a new Programme. \
    *delete*: delete the bookings associated. and then delete the Programme \
 **Booking**: \
    *store*: validate the inputs given in the request, check if programme exists, check if user is signed up for the programme that the request tries to register,      verify wheather there are any programmes that user has that overlap with current one, check for Programme capacity. If no errors save the new Booking\


##### Environment

| Name | Choice |
| ------ | ------ |
| Operating system (OS) |Ubuntu 20.04 |
| Database  | MySQL 8.0|
| PHP | e.g. 7.0 |
| IDE | VS Code |

### Testing
Feature Tests using fake data and manual testing with Postman 

## Feedback
In this section, please let us know what is your opinion about this experience and how we can improve it:

1. Have you ever been involved in a similar experience? If so, how was this one different?
\No, I haven't been before
2. Do you think this type of selection process is suitable for you?
3. What's your opinion about the complexity of the requirements?
4. What did you enjoy the most?
5. What was the most challenging part of this anti hackathon?
6. Do you think the time limit was suitable for the requirements?
7. Did you find the resources you were sent on your email useful?  Yes, they were helpful
8. Is there anything you would like to improve to your current implementation? Test it a bit more to check for errors I missed
9. What would you change regarding this anti hackathon?


## Problem statement
*Congratulations, you have been chosen to handle the new client that has just signed up with us.  You are part of the software engineering team that has to build a solution for the new client’s business.
Now let’s see what this business is about: the client’s idea is to build a health center platform (the building is already there) that allows the booking of sport programmes (pilates, kangoo jumps), from here referred to simply as programmes. The main difference from her competitors is that she wants to make them accessible through other applications that already have a user base, such as maybe Facebook, Strava, Suunto or any custom application that wants to encourage their users to practice sport. This means they need to be able to integrate our client’s product into their own.
The team has decided that the best solution would be a REST API that could be integrated by those other platforms and that the application does not need a dedicated frontend (no html, css, yeeey!). After an initial discussion with the client, you know that the main responsibility of the API is to allow users to register to an existing programme and allow admins to create and delete programmes.
When creating programmes, admins need to provide a time interval (starting date and time and ending date and time), a maximum number of allowed participants (users that have registered to the programme) and a room in which the programme will take place.
Programmes need to be assigned a room within the health center. Each room can facilitate one or more programme types. The list of rooms and programme types can be fixed, with no possibility to add rooms or new types in the system. The api does not need to support CRUD operations on them.
All the programmes in the health center need to fully fit inside the daily schedule. This means that the same room cannot be used at the same time for separate programmes (a.k.a two programmes cannot use the same room at the same time). Also the same user cannot register to more than one programme in the same time interval (if kangoo jumps takes place from 10 to 12, she cannot participate in pilates from 11 to 13) even if the programmes are in different rooms. You also need to make sure that a user does not register to programmes that exceed the number of allowed maximum users.
Authentication is not an issue. It’s not required for users, as they can be registered into the system only with the (valid!) CNP. A list of admins can be hardcoded in the system and each can have a random string token that they would need to send as a request header in order for the application to know that specific request was made by an admin and the api was not abused by a bad actor. (for the purpose of this exercise, we won’t focus on security, but be aware this is a bad solution, do not try in production!)
You have estimated it takes 4 weeks to build this solution. You have 2 days. Good luck!*
