# First Dev-Cycle Tasks:
<details><summary>Possible Status</summary>

    Sub tasks:
    1. Not Started: [⭕ Not Started]
    2. Upcoming: [🚀 Upcoming]
    3. In Progress: [⏳ In Progress]
    4. Done: [✅ Done]

    Main tasks:
    1. Incomplete :[❌ -Incomplete- ❌ ]
    2. Completed :[🎉 -Closed- 🎉 ]

</details>

| Main Task                 | Subtask                                 | Status             |
|---------------------------|-----------------------------------------| :----------------:|
| Setting Up the Repository |                                                   |  ❌ -Incomplete- ❌ |
|                           | Setting Up Dummy Project                          | ✅ Done            |
|                           | Preparing Readme                                  | ✅ Done            |
|                           | Adding Symfony CLI Alternatives to Readme         | ⭕ Not Started   |
|                           | Establishing Branch & Commit Structure            | ✅ Done            |
|                           | Testing Pull Requests                             | ✅ Done            |
|                           | Verifying Connection Between Frontend & Backend   | ✅ Done   |
|                           | Implementing Workflows                            | ⭕ Not Started    |
|                           | Establishing License for project                  | ⭕ Not Started    |
| Setting up the application |                                     |  ❌ -Incomplete- ❌   |
|                          | Setting up Symfony framework          | ✅ Done         |
|                          | Setting up Docker environment         | ✅ Done         |
|                          | Setting up API Platform               | ✅ Done         |
|                          | Setting up Caddy                      | ⭕ Not Started  |
|                          | Setting up Mercury                    | ⭕ Not Started  |
|                          | Moving Secrets from .env              | ⭕ Not Started  |
|                          | Optimize Docker Image                 | ⭕ Not Started  |
|                          | Deal with all deprications            | ⭕ Not Started  |
| User Table              |                                        |  ❌ -Incomplete- ❌ |
|                          | Implementing `Users` entity           | ✅ Done  |
|                          | Adding Necessary Fields               | ✅ Done  |
|                          | Hashing Passwords                     | ✅ Done  |
|                          | Adding Filtrations                    | ✅ Done  |
|                          | Adding Normalization Groups           | ✅ Done  |
|                          | Adding Embed                          | ⭕ Not Started  |
|                          | Adding Factory                        | ✅ Done  |
|                          | Securing Requests                     | ⭕ Not Started  |
|                          | Debugging                             | ⭕ Not Started  |
|                          | Tests                                 | ⭕ Not Started  |
| Community (Subreddit) Table          |                                                            | 🎉 -Closed- 🎉|
|                          | Implementing `Communities` entity                          | ✅ Done   |
|                          | Adding status                                              | ✅ Done   |
|                          | Adding Necessary Fields                                    | ✅ Done   |
|                          | Making Amount of Members Change Dynamically                | ✅ Done   |
|                          | Make Owner Automatically Become Member                     | ✅ Done   |
|                          | Replace Communites with subreddits                         | ✅ Done  |
|                          | Change Owner to Creator                                    | ✅ Done  |
|                          | Adding Filtrations                                         | ✅ Done  |
|                          | Adding Normalization Groups                                | ✅ Done  |
|                          | Adding Factory                                             | ✅ Done  |
|                          | Securing Requests                                          | ✅ Done  |
|                          | Debugging                                                  | ✅ Done  |
|                          | Tests                                                      | ✅ Done  |
| Membership Table (User-Commu) |                      | ❌ -Incomplete- ❌|
|                          | Implementing `Memberships` entity     | ✅ Done    |
|                          | Adding Necessary Fields               | ✅ Done    |
|                          | Adding Filtrations                    | ✅ Done    |
|                          | Adding Normalization Groups           | ✅ Done    |
|                          | Adding Embed                          | ✅ Done    |
|                          | Adding Factory                        | ✅ Done    |
|                          | Securing Requests                     | ⭕ Not Started  |
|                          | Debugging                             | ⭕ Not Started  |
|                          | Tests                                 | ⭕ Not Started  |
| Thread (Post) Table      |                                        | ❌ -Incomplete- ❌|
|                          | Implementing `Posts` entity            | ✅ Done  |
|                          | Adding status                          | ✅ Done          |
|                          | Adding diffrent type of Posts          | ✅ Done   |
|                          | Adding Necessary Fields                | ✅ Done  |
|                          | Adding Filtrations                     | ✅ Done  |
|                          | Adding Normalization Groups            | ✅ Done  |
|                          | Adding Embed                           | ✅ Done  |
|                          | Adding Factory                         | ✅ Done  |
|                          | Making Posts subresource               | ⭕ Not Started  |
|                          | Securing Requests                      | ⭕ Not Started  |
|                          | Debugging                              | ⭕ Not Started  |
|                          | Tests                                  | ⭕ Not Started  |
| Comment Table            |                                        | ❌ -Incomplete- ❌|
|                          | Implementing `Comments` entity         | ✅ Done  |
|                          | Adding Necessary Fields                | ✅ Done  |
|                          | Adding Filtrations                     | ✅ Done  |
|                          | Adding Normalization Groups            | ✅ Done  |
|                          | Adding Embed                           | ✅ Done  |
|                          | Adding Factory                         | ✅ Done  |
|                          | Making Comments subresource            | ⭕ Not Started  |
|                          | Securing Requests                      | ⭕ Not Started  |
|                          | Debugging                              | ⭕ Not Started  |
|                          | Tests                                  | ⭕ Not Started  |
| User Authentication |                            | ❌ -Incomplete- ❌|
|                          | Request Logging Mechanism      | ✅ Done |
|                          | Adding token generation        | ✅ Done |
|                          | Securing All Routes            | ⭕ Not Started|
|                          | Tests                          | ⭕ Not Started|

## Notes:
- rename modifiedAt to updatedAt
- add createdAt and modifiedAt in seconds
- make number of users a not dynamic field thats updated on members changes
- log out route, that removes given token
- boolean field to invalidate token
- split fixture into multiple stories
- add test commands to readme
    `Symfony php bin/phpunit --verbose --testdox  tests/Api/CommunityTest.php`
    `Symfony php bin/phpunit --verbose --testdox  --filter=testCommunityListHasWorkingPagination`

- To do in following steps:
    - add admin user method in factories
    - add functionality to statuses 
         - posts 
         - comments
    - karama system
    - Subreddit functionalities:
         - change from creator to moderator collection and hide creator field
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
         - favorites
    - image upload/storage system
    - notification system:
        - send notifications on karma thresholds
        - send noifications on comments, etc
    - messanging system:
        - send message if needed when user joisn subreddit
        - allow customization of the messege

##Use later:

```
   /**
     * Returns the difference in seconds between the creation date and now.
     *
     * @return int The difference in seconds
     */
    
    #[Groups(['subreddit:read'])]
    public function getCreatedAtInSeconds(): ?int
    {
        $now = new \DateTime();
        return ($now->getTimestamp() - $this->createdAt->getTimestamp());
    }
```