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
| Setting Up the Repository |                                                |  ❌ -Incomplete- ❌ |
|                           | Setting Up Dummy Project                      | ✅ Done            |
|                           | Preparing Readme                              | ✅ Done            |
|                           | Adding Symfony CLI Alternatives to Readme     | ⭕ Not Started   |
|                           | Establishing Branch & Commit Structure          | ✅ Done            |
|                           | Testing Pull Requests                         | ✅ Done            |
|                           | Verifying Connection Between Frontend & Backend | ✅ Done   |
|                           | Implementing Workflows                        | ⭕ Not Started    |
|                           | Establishing License for project               | ⭕ Not Started    |
| Setting up the application |                                       |  ❌ -Incomplete- ❌   |
|                          | Setting up Symfony framework          | ✅ Done          |
|                          | Setting up Docker environment         | ✅ Done          |
|                          | Setting up API Platform               | ✅ Done          |
|                          | Setting up Caddy                      | ⭕ Not Started   |
|                          | Setting up Mercury                    | ⭕ Not Started   |
|                          | Moving Secrets from .env              | ⭕ Not Started  |
|                          | Optimize Docker Image                 | ⭕ Not Started  |
|                          | Deal with all deprications            | ⭕ Not Started  |
| User Table              |                               |  ❌ -Incomplete- ❌ |
|                          | Implementing `Users` entity           | ✅ Done          |
|                          | Adding Necessary Fields               | ✅ Done  |
|                          | Hashing Passwords                     | ✅ Done          |
|                          | Adding Filtrations                    | ✅ Done  |
|                          | Adding Normalization Groups           | ✅ Done  |
|                          | Adding Embed                          | ⭕ Not Started  |
|                          | Adding Factory                        | ✅ Done  |
|                          | Securing Requests              | ⭕ Not Started  |
|                          | Debugging                             | ⭕ Not Started  |
|                          | Tests                             | ⭕ Not Started  |
| Community Table          |                            | ❌ -Incomplete- ❌|
|                          | Implementing `Communities` entity     | ✅ Done          |
|                          | Adding status                           | ✅ Done          |
|                          | Adding Necessary Fields               | ✅ Done  |
|                          | Making Amount of Members Change Dynamically| ✅ Done |
|                          | Make Owner Automatically Become Member| ✅ Done  |
|                          | Add Approving Members For Private & Restricted Communites  | ⭕ Not Started  |
|                          | Replace Communites with subreddits    | ⭕ Not Started  |
|                          | Change Owner to Creator               | ✅ Done  |
|                          | Adding Filtrations                    | ✅ Done  |
|                          | Adding Normalization Groups           | ✅ Done  |
|                          | Adding Embed                          | ⭕ Not Started  |
|                          | Adding Factory                        | ✅ Done  |
|                          | Securing Requests                     | ⭕ Not Started  |
|                          | Making Community subresource           | ⭕ Not Started  |
|                          | Debugging                             | ⭕ Not Started  |
|                          | Tests                             | ⭕ Not Started  |
| Membership Table (User-Commu) |                      | ❌ -Incomplete- ❌|
|                          | Implementing `Memberships` entity     | ✅ Done          |
|                          | Adding Necessary Fields               | ✅ Done  |
|                          | Adding Filtrations                    | ✅ Done  |
|                          | Adding Normalization Groups           | ✅ Done  |
|                          | Adding Embed                          | ✅ Done |
|                          | Adding Factory                        | ✅ Done  |
|                          | Securing Requests              | ⭕ Not Started  |
|                          | Debugging                             | ⭕ Not Started  |
|                          | Tests                             | ⭕ Not Started  |
| Thread (Post) Table      |                        | ❌ -Incomplete- ❌|
|                          | Implementing `Posts` entity            | ✅ Done  |
|                          | Adding status                           | ✅ Done          |
|                          | Adding diffrent type of Posts               | ✅ Done   |
|                          | Adding Necessary Fields               | ✅ Done  |
|                          | Adding Filtrations                    | ✅ Done  |
|                          | Adding Normalization Groups           | ✅ Done  |
|                          | Adding Embed                          | ✅ Done  |
|                          | Adding Factory                        | ✅ Done  |
|                          | Making Posts subresource           | ⭕ Not Started  |
|                          | Securing Requests              | ⭕ Not Started  |
|                          | Debugging                             | ⭕ Not Started  |
|                          | Tests                             | ⭕ Not Started  |
| Comment Table            |                             | ❌ -Incomplete- ❌|
|                          | Implementing `Comments` entity            | ✅ Done  |
|                          | Adding Necessary Fields               | ✅ Done  |
|                          | Adding Filtrations                    | ✅ Done  |
|                          | Adding Normalization Groups           | ✅ Done  |
|                          | Adding Embed                          | ✅ Done  |
|                          | Adding Factory                        | ✅ Done  |
|                          | Making Comments subresource           | ⭕ Not Started  |
|                          | Securing Requests                     | ⭕ Not Started  |
|                          | Debugging                             | ⭕ Not Started  |
|                          | Tests                             | ⭕ Not Started  |
| User Authentication |                            | ❌ -Incomplete- ❌|
|                          | Request Logging Mechanism      | ✅ Done |
|                          | Adding token generation        | ✅ Done |
|                          | Securing All Routes            | ⭕ Not Started|
|                          | Tests                          | ⭕ Not Started|
| File (Images) Upload |                             | ❌ -Incomplete- ❌|
|                          | Saving Files from Requests     | ⭕ Not Started|
|                          | Providing Files for Requests   | ⭕ Not Started|
|                          | Tests                          | ⭕ Not Started|

## Notes:
- Remove Carbon if not needed (
    consider creating methods for returning human version of dates '5 months ago'
)
- Consider replacing Session token with JWT
- In sec step add agent and ip to token validation
