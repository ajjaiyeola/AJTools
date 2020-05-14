<h1>Skill Building Tool</h1>


<h3>Problem</h3>

I noticed many college students and recent graduates found it difficult to get guidance on specific skills and tools that would be helpful for career fields they are interested in.

<h3>Solution</h3>

Using data from the Bureau of Labor Statistics, I set out to build a tool that would ask a user about their college degree, occupational interests, and industry interests, and then present the user with the following information:

<ul>
<li>Occupations that most closely match their interests.</li>
<li>Salary and compensation information about the occupation.</li>
<li>Skills and technologies used in those occupations.</li>
</ul>

Ultimately, I aimed to build a platform that would connect users with third-party vendors that will help them build on the skills they need to succeed. 

<h3>Some Implementation Specifics<h3>
  
 
<h4>responseprocessing.php</h4>


Every user is required to supply either of the following:
<ul>
  <li>Industry of interest</li>
  <li>Field of study</li>
  <li>Occupation of interest</li>
</ul>

Basic job data is already stored in the project's database. The process implemented is to match the users query with the basic data stored in the database. If a match is found, a request is then sent to the BLS API using the unique BLS job-code tied to the query result,to get back the more complex data that is then presented to the user.

In responseprocessing.php, I use a combination of SQL and PHP to check the database for an exact match for any of the data the user enters in the front-end. In a situation where an exact match is not found, I query the database for similar matches and return the closest match.

<h4>app.php</h4>

Here I use the job code returned from the database to form part of the query that is sent to the BLS API. This will then return the full data pertinent to the job code requested, giving my application the ability to present a final, user friendly report to the end-user.

<h4>page.js</h4>

This is where the different front-end validations are handled. Code to handle suggestions as user types in their answers is also implemented here.

