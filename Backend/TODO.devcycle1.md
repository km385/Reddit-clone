# First Dev-Cycle Tasks:

<details>
<summary>Possible Status</summary>

    Sub tasks:
    1. Pending: [⭕ Pending]
    2. Done: [✅ Done]

    Main tasks:
    1. Incomplete :[❌ -Incomplete- ❌ ]
    2. Completed :[🎉 -Closed- 🎉 ]

</details>

| Main Task                 | Subtask                                 | Status             |
|---------------------------|-----------------------------------------| :----------------:|
| Setting Up the Repository |                                                   |  ❌ -Incomplete- ❌ |
|                           | Setting Up Dummy Project                          | ✅ Done            |
|                           | Preparing Readme                                  | ✅ Done            |
|                           | Adding Symfony CLI Alternatives to Readme         | ⭕ Pending   |
|                           | Establishing Branch & Commit Structure            | ✅ Done            |
|                           | Testing Pull Requests                             | ✅ Done            |
|                           | Verifying Connection Between Frontend & Backend   | ✅ Done   |
|                           | Implementing Workflows                            | ⭕ Pending    |
|                           | Establishing License for project                  | ✅ Done   |
| Setting up the application |                                     |  ❌ -Incomplete- ❌   |
|                          | Setting up Symfony framework          | ✅ Done         |
|                          | Setting up Docker environment         | ✅ Done         |
|                          | Setting up API Platform               | ✅ Done         |
|                          | Setting up Caddy                      | ⭕ Pending  |
|                          | Setting up Mercury                    | ⭕ Pending  |
|                          | Moving Secrets from .env              | ⭕ Pending  |
|                          | Optimize Docker Image                 | ⭕ Pending  |
|                          | Deal with all deprications            | ⭕ Pending  |
| User Table              |                                        |  ❌ -Incomplete- ❌ |
|                          | Implementing `Users` entity           | ✅ Done  |
|                          | Adding Necessary Fields               | ✅ Done  |
|                          | Hashing Passwords                     | ✅ Done  |
|                          | Adding Filtrations                    | ✅ Done  |
|                          | Adding Normalization Groups           | ✅ Done  |
|                          | Adding Embed                          | ⭕ Pending  |
|                          | Adding Factory                        | ✅ Done  |
|                          | Securing Requests                     | ✅ Done  |
|                          | Tests                                 | ⭕ Pending  |
| Community (Subreddit) Table          |                                                | 🎉 -Closed- 🎉|
|                          | Implementing `Communities` entity              | ✅ Done  |
|                          | Adding status                                  | ✅ Done  |
|                          | Adding Necessary Fields                        | ✅ Done  |
|                          | Making Amount of Members Change Dynamically    | ✅ Done  |
|                          | Make Owner Automatically Become Member         | ✅ Done  |
|                          | Replace Communites with subreddits             | ✅ Done  |
|                          | Change Owner to Creator                        | ✅ Done  |
|                          | Adding Filtrations                             | ✅ Done  |
|                          | Adding Normalization Groups                    | ✅ Done  |
|                          | Adding Factory                                 | ✅ Done  |
|                          | Securing Requests                              | ✅ Done  |
|                          | Tests                                          | ✅ Done  |
| Membership Table (User-Commu) |                      | 🎉 -Closed- 🎉|
|                          | Implementing `Memberships` entity     | ✅ Done |
|                          | Adding Necessary Fields               | ✅ Done |
|                          | Adding Filtrations                    | ✅ Done |
|                          | Adding Normalization Groups           | ✅ Done |
|                          | Adding Embed                          | ✅ Done |
|                          | Adding Factory                        | ✅ Done |
|                          | Securing Requests                     | ✅ Done |
|                          | Tests                                 | ✅ Done |
| Thread (Post) Table      |                                        | ❌ -Incomplete- ❌|
|                          | Implementing `Posts` entity            | ✅ Done |
|                          | Adding status                          | ✅ Done |
|                          | Adding diffrent type of Posts          | ✅ Done |
|                          | Adding Necessary Fields                | ✅ Done |
|                          | Adding Filtrations                     | ✅ Done |
|                          | Adding Normalization Groups            | ✅ Done |
|                          | Adding Embed                           | ✅ Done |
|                          | Adding Factory                         | ✅ Done |
|                          | Making Posts subresource               | ⭕ Pending  |
|                          | Securing Requests                      | ⭕ Pending  |
|                          | Tests                                  | ⭕ Pending  |
| Comment Table            |                                        | ❌ -Incomplete- ❌|
|                          | Implementing `Comments` entity         | ✅ Done |
|                          | Adding Necessary Fields                | ✅ Done |
|                          | Adding Filtrations                     | ✅ Done |
|                          | Adding Normalization Groups            | ✅ Done |
|                          | Adding Embed                           | ✅ Done |
|                          | Adding Factory                         | ✅ Done |
|                          | Making Comments subresource            | ⭕ Pending  |
|                          | Securing Requests                      | ⭕ Pending  |
|                          | Tests                                  | ⭕ Pending  |
| User Authentication |                            | 🎉 -Closed- 🎉|
|                          | Request Logging Mechanism      | ✅ Done |
|                          | Adding token generation        | ✅ Done |
|                          | Tests                          | ✅ Done |

## Notes:

- check if amount of members decreases when user deleted
- embed user community membership
- tests user
- standarize exceptions in other state providers than user /removers done/user /persister done

- sub-resource comments  
  (visible to all; sortable by (hot) algorythm, (now) createdAt, (top) karma and filter on createdAt)
  with pagination
- sub-resource posts  
  (visible to all; sortable by (hot) algorythm, (now) createdAt, (top) karma and filter on createdAt)
  with pagination

- standardize test names to same convention
- add to readme info that you have to leave database login or you clog connection
- split readme into external files with links
- rename modifiedAt to updatedAt
- add createdAt and modifiedAt in seconds when needed 
- split fixture into multiple stories
- add test commands to readme
    `Symfony php bin/phpunit --verbose --testdox  tests/Api/CommunityTest.php`
    `Symfony php bin/phpunit --verbose --testdox  --filter=testCommunityListHasWorkingPagination`

- To do in following steps:
    - remake memebership factory, make sure results are unique
    - remake posts factory, posts should fit to existing/create new memberships
    - remake comments factory, comments should fit to existing/create new memberships and split comments into 2 factories child and parent comments
    - split factory into multiple stories so single batch of entities can be created 
    - admin users that see hidden fields
    - make post auto transfer to subcomments from parentcomments
    - move auth logic from symfony controllers to api platform
    - add rate limiter (https://github.com/IndraGunawan/api-rate-limit-bundle)
    - add admin user method in factories
    - change amount of member decrease logic from state procesorr to events
    - add functionality to statuses 
         - posts 
         - comments
    - karama system
    - Subreddit functionalities:

        - consider removing delete route from communities and tests for it to match reddit
        - add moderator collection
        - hide nsfw communities for not authorized users and with settings to no nswf
        - status:
            - hide restricted subs fro avg user
            - stop making posts for private subs
            - make approved list to invalidate above
        - mod lists 
        - approved lists
        - add rank by size
        - online users
        - user flairs
    - user functionalites:
        - add on delete event to set author/creator to null on posts, comments and communites
        - when changing password remove user access tokens except the one making the request
        - require both login and password on delete
            (doable by custom controler and operation)
        - favorites
        - get all:
         (doable by provider after adding recent activity in entity repo)
          - remove pagination and limit results to 25
          - query extension name + recent post name
          - dont allow empty nickname query
        - endpoint for checking if username is unique 
        - add to profile get: banner, avatar, bool allowedFollowers, moderatedSubreddits 
        - add sub-resource  recentActivity that is both comments and posts 
          (visible to all; sortable by (hot) algorythm, (now) createdAt, (top) karma and filter on createdAt)
        - sub-resource upvoted  
            (Owner, admin only)
            (visible to all; sortable by (hot) algorythm, (now) createdAt, (top) karma and filter on createdAt)
        - sub-resource upvoted 
            (both posts and comments)
            (Owner, admin only)
            (visible to all; sortable by (hot) algorythm, (now) createdAt, (top) karma and filter on createdAt)
        - sub-resource downvoted  
            (both posts and comments)
            (Owner, admin only)
            (visible to all; sortable by (hot) algorythm, (now) createdAt, (top) karma and filter on createdAt)
        - sub-resource hidden, saved to mechanism for saving posts  
            (both posts and comments)
            (Owner, admin only)
            (visible to all; sortable by (hot) algorythm, (now) createdAt, (top) karma and filter on createdAt)
    - post functionalities:
        - when user is null return [deleted]
        - find top by date: all time, year, month, week, day, hour
    - comments functionalities:
        - when user is null return [deleted]    
    - image upload/storage system
    - notification system:
        - send notifications on karma thresholds
        - send noifications on comments, etc
    - messanging system:
        - send message if needed when user joisn subreddit
        - allow customization of the messege
    - current activity system